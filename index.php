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
	<meta name="author" content="i-jurij">
</head>

<body style="width:100%;">

	<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');

	require_once __DIR__ . '/vendor/autoload.php';

	use Fileupload\Upload;

	$new_load = new Upload();

	//set vars for each inputs from form if you need it (array('name_of_input' => [vars]))
	$new_load->config = [
		'picture' => 	[],
		'file' => 	[
			'dest_dir' => 'upload_text', // where upload file will be saved
			'create_dir' => 123, //create destination dir
			'dir_permissions' => 0777, // permissions for dest dir
			'file_size' => 3 * 100 * 1024, //300KB - size for upload files = MAX_FILE_SIZE from html
			'file_permissions' => 0666, // permissions for the file being created
			'file_mimetype' => ['text/php', 'text/x-php', 'text/html'], // allowed mime-types for upload file
			'file_ext' => ['.php', 'html'], // allowed extension for upload file
			'new_file_name' => '', // new name of upload file
			'replace_old_file' => false // replace old file in dest dir with new upload file with same name
		],
		'pictures' => [
			'dest_dir' => 'upload_pictures/',
			//'create_dir' => true, the same as "file"
			//'dir_permissions' => 0777, the same as "file"
			//'file_permissions' => 0666, the same as "file"
			'file_size' => 1 * 1000 * 1024, //1MB
			'file_mimetype' => ['image/jpeg', 'image/pjpeg', 'image/png', 'image/webp'],
			'file_ext' => ['.jpg', '.jpeg', '.png', '.webp'],
			'new_file_name' => ['zzz', 'index'], // ['', 'noindex'], 'new_filename'
			'replace_old_file' => true
		]
	];

	if ($new_load->issetData()) {
	?>
		<p><a href="javascript:history.back()">Back</a></p>
		<?php
		print '<pre>';
		print_r($new_load->files);
		if ($new_load->execute()) {
			print_r($new_load->message);
		}
		print '</pre>';
		//
		// some command for processing a file located in a dest_dir
		//
		//CLEAR FOLDER - all files will be deleted in a directory specified by user
		//print '<br />' . Fileupload\Classes\DelFilesInDir::run('upload_pictures');
	} else {
		?>
		<form method="post" action="" enctype="multipart/form-data" id="upload_test" style="width:100%;">
			<div style="max-width:360px;margin:20px auto;">
				<p>
					<label>File <small>(.php, .html, < 300KB)</small>:<br />
								<input type="hidden" name="MAX_FILE_SIZE" value="307200" />
								<input type="file" name="file" accept=".php, .html, text/html, text/php, text/x-php" required>
					</label>
				</p>
				<p>
					<label>Picture <small>(jpg, png, webp, < 1MB)</small>:<br />
								<input type="hidden" name="MAX_FILE_SIZE" value="1024000" />
								<input type="file" name="picture" accept=".jpg, .jpeg, .png, .webp, image/jpeg, image/pjpeg, image/png, image/webp">
					</label>
				</p>
				<p>
					<label>Multiple files <small>(jpg, png, webp, < 1MB)</small>:<br />
								<input type="hidden" name="MAX_FILE_SIZE" value="1024000" />
								<input type="file" multiple="multiple" name="pictures[]" accept=".jpg, .jpeg, .png, .webp, image/jpeg, image/pjpeg, image/png, image/webp">
								<!--<input type="file" name="pictures[]" />
								<input type="file" name="pictures[]" /> -->
					</label>
				</p>
			</div>
			<div style="max-width:360px;margin:20px auto;">
				<button type="submit" form="upload_test">Upload</button>
				<button type="reset" form="upload_test">Reset</button>
			</div>
		</form>
	<?php
	}
	?>
</body>

</html>