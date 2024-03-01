## PHP class for single or multiple file uploads.

HTML inputs must be next formats:   
a) for single file   
``` <input type="file" name="name" > ```   
b) for files array        
``` <input type="file" name="names[]" > ```  
### Variables that the user can define:   
`public string $dest_dir` - files destination directory;   
`public int $dir_permissions` - permissions of files destination directory;   
`public int $file_permissions` - permissions of files in destination directory;   
`public bool $create_dir` - create destination directory if it not exist;  
`public int $file_size` - maximum size of file for upload;   
`public $file_mimetype` - mimetype of file for upload;   
`public $file_ext` - extension of file for upload;   
`public $new_file_name` - string or array ['filename, 'index'] or ['filename, 'noindex'] - where noindex for input with multiple uploads (but you must get different name for file);   
`public bool $replace_old_file`;   
`public string $tmp_dir` - temporary directory for file upload (eg for original files before processing);   
    
### Steps   
1. `$this __construct` normalise $_FILES_array:
   
`$this->files = ['input_name_for_single_upload' =>
[0 => ['name', 'full_path', 'type', 'tmp_name', 'error', 'size']]`,    
`$this->files = ['input_name_for multiple_uploads' => [0 => ['name', 'full_path', 'type', 'tmp_name', 'error', 'size'],   1 => ['name', 'full_path', 'type', 'tmp_name', 'error', 'size'] ]]`   

2. `$this->isset_data()`: check if `$this->files` not empty (this means in $_FILES is also not empty)    
therefore, after creating an instance of the class and checking the existence of the input data, there are always two foreach, and then   
`$this->execute($input, $key, $file)`    

3. `$this->execute():`   
a) check input data: `$this->dest_dir required`;   
b) check error: in $_FILES;   
c) check_dest_dir: `$this->create_dir` default false, `$this->dir_permissions` default 0755;   
d) check_file_size: if user not set `$this->file_size` - default 1024000B (1MB), set in bytes eg 2*100*1024 (200KB);      
e) check_mime_type: if user not set `$this->file_mimetype` - default any, string or array, `'audio'` or `['image/bmp', 'audio', 'video']`,
if user set full mimetype eg `imge/bmp` - the class also check the extension;   
f) check_extension: if user not set `$this->file_ext` - default any, string or array, eg `'jpg'`, `['.png', '.webp', 'jpeg']`;    
g) check_new_file_name: use `$this->translit_ostslav_to_lat` or `$this->translit_to_lat`;   
h) move_upload: upload file to dir (dir = tmp dir if user set `$this->processing` or `$this->tmp_dir`, else - dir = dest dir);

### Small example
```
<?php   
$upload = new FIUP\File_upload;   
if ($upload->isset_data()) {   
	foreach ($load->files as $input => $input_array) {   
 			print 'Input "'.$input.'":<br />';   
			// SET THE VARS   
			if ($input === 'file') {
				$load->propeties = '';
			}
			// PROCESSING DATA  
			foreach ($input_array as $key => $file) {   
				print 'Name "'.$file['name'].'":<br />';    
				if ($load->execute($input, $key, $file) && !empty($load->message)) {   
					print $load->message; print '<br />';  
				} else {   
					if (!empty($load->error)) {
						print $load->error; print '<br />';
					}      
					continue;   
				}   
			}   
	}   
}
```
____   

### Big working example (index.php in the same folder as class folder) :
```
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <title>Upload</title>
  <meta name="description" content="Class Upload file">
  <META NAME="keywords" CONTENT="Class Upload file">
  <meta HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8">
  <meta HTTP-EQUIV="Content-language" CONTENT="ru-RU">
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
  <meta name="author" content="i-jurij" >
</head>
  <body style="width:100%;">
<?php
define ('APPROOT', __DIR__);
//Loading Librarie
spl_autoload_extensions(".php");
spl_autoload_register();
// class declaration
$load = new Fiup\File_upload;
// if not empty data from $_FILES
if ($load->isset_data()) {
?>
	<p><a href="javascript:history.back()" >Back</a></p>
<?php
	foreach ($load->files as $input => $input_array) {
		//print_r($input_array); print '<br />';
		print 'Input "'.$input.'":<br />';

		foreach ($input_array as $key => $file) {
			if (!empty($file['name'])) {
				if (mb_strlen($file['name'], 'UTF-8') < 101) {
					$name = $file['name'];
				} else {
					$name = mb_strimwidth($file['name'], 0, 48, "...") . mb_substr($file['name'], -48, null, 'UTF-8');
				}
				print 'Name "'.$name.'":<br />';
			}
			// SET the vars for class
			$load->create_dir = true; // let create dest dir if not exists
			if ($input === 'file') {
				$load->dest_dir = 'upload_files'; // where upload file after postprocessing
				$load->tmp_dir = ''; // temporary dir for upload file before postprocessing
				$load->dir_permissions = 0777; // permissions for dest dir
				$load->file_size = 3*100*1024; //300KB - size for upload files = MAX_FILE_SIZE from html
				$load->file_permissions = 0666; // permissions for the file being created
				$load->file_mimetype = ['text/php', 'text/x-php', 'text/html']; // allowed mime-types for upload file
				$load->file_ext = ['.php', 'html']; // allowed extension for upload file
				$load->new_file_name = ''; // new name of upload file, string 'filename' or array ['filename, 'noindex'] - where noindex
							      for input with multiple uploads (but you must get different name for file)
				$load->replace_old_file = false; // replace old file in dest dir with new upload file with same name
			}
			if ($input === 'picture') {
				$load->default_vars();
				$load->dest_dir = 'upload_files';
				$load->file_size = 1*1000*1024; //1MB
				$load->file_mimetype = ['image/jpeg', 'image/pjpeg', 'image/png', 'image/webp'];
				$load->file_ext = ['.jpg', '.jpeg', '.png', '.webp'];
			}
			if ($input === 'pictures') {
				$load->default_vars();
				$load->dest_dir = 'upload_files';
				$load->tmp_dir = 'tmp';
				$load->dir_permissions = 0777;
				$load->file_permissions = 0666;
				$load->file_size = 1*1000*1024; //1MB
				$load->file_mimetype = ['image/jpeg', 'image/pjpeg', 'image/png', 'image/webp'];
				$load->file_ext = ['.jpg', '.jpeg', '.png', '.webp'];
				$load->new_file_name = ['zzz', 'index']; // ['', 'noindex'], 'new_filename'
				$load->replace_old_file = true;
			}
			// PROCESSING DATA
			if ($load->execute($input_array, $key, $file)) {
				if (!empty($load->message)) { print $load->message; print '<br />'; }
			} else {
				if (!empty($load->error)) { print $load->error; print '<br />'; }
				continue;
			}
			//
			// some command for processing a file located in a tmp_dir or dest_dir
			//
		}
	}
	//CLEAR FOLDER - file will be deleted in a directory specified by user
	if (!$load->del_files_in_dir('tmp')) {
		if (!empty($load->error)) { print $load->error; print '<br />'; }
	}
} else {
?>
	<form method="post" action="" enctype="multipart/form-data" id="upload_test" style="width:100%;">
		<div style="max-width:360px;margin:20px auto;">
	       	<p >
		        <label >File <small>(.php, .html, < 300KB)</small>:<br />
		           	<input type="hidden" name="MAX_FILE_SIZE" value="307200" />
					<input type="file" name="file" accept=".php, .html, text/html, text/php, text/x-php" required>
		        </label>
		    </p>
		    <p >
		        <label >File <small>(jpg, png, webp, < 1MB)</small>:<br />
		            <input type="hidden" name="MAX_FILE_SIZE" value="1024000" />
		            <input type="file" name="picture" accept=".jpg, .jpeg, .png, .webp, image/jpeg, image/pjpeg, image/png, image/webp">
		        </label>
		    </p>
		    <p >
		        <label >Multiple files <small>(jpg, png, webp, < 1MB)</small>:<br />
		            <input type="hidden" name="MAX_FILE_SIZE" value="1024000" />
		            <input type="file" multiple="multiple" name="pictures[]" accept=".jpg, .jpeg, .png, .webp, image/jpeg, image/pjpeg, image/png, image/webp">
		          	<!--<input type="file" name="pictures[]" />
					<input type="file" name="pictures[]" /> -->
				</label>
		    </p>
	    </div>
	    <div style="max-width:360px;margin:20px auto;">
	        <button type="submit" form="upload_test">Upload</button>
	        <button type="reset" form="upload_test" >Reset</button>
	    </div>
  	</form>
<?php

}
?>
  </body>
</html>
```
