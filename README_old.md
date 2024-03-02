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
$upload = new Upload;   
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

### Big working example   
In index.php.   

Steps for execute:      
install composer to php-server,    
put the class directory into domains catalog on web server,   
into class directory run the command `composer install` for create a vendor folder with an autoloader file,   
open your site in browser.
