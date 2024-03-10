## PHP library for single or multiple file uploads.
Require PHP >= 8.1.0   

Example of usage is file "index.php" into root folder of this package.

### Install
```
composer require ijurij/fileupload
```   
or put into "composer.json" next text:    
from packagist.org 
```
   "require": {
        "ijurij/fileupload": "1.0.*"
    }
```   
or from github.com
```
	"repositories": [
		{
			"type": "git",
			"url": "https://github.com/i-jurij/fileupload"
		}
	],
	"require": {
		"i-jurij/fileupload": "dev-main"
	}
```   

### Usage

#### 1. Init
```
	use Fileupload\Upload;
	$new_load = new Upload();
```
#### 2. Set vars for upload
```
$new_load->config = [
		'picture' => [],
		'file' => 	[
			'dest_dir' => 'test/upload_text', // where upload file will be saved
			'create_dir' => true, //create destination dir
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
			'file_size' => 1 * 1000 * 1024, //1MB
			'file_mimetype' => ['image/jpeg', 'image/pjpeg', 'image/png', 'image/webp'],
			'file_ext' => ['.jpg', '.jpeg', '.png', '.webp'],
			'new_file_name' => ['zzz', 'index'], // ['', 'noindex'], 'new_filename' (!!! Don't do that: ['name', 'noindex'] - because you set the same name for all pictures!)
			'replace_old_file' => true
		]
	];
```
#### 3. Execute
```
$new_load->upload();
```
#### 4. Print info
```
/* print '<pre>'; print_r($new_load->info); print '</pre>'; */
$new_load->printInfo();
```
#### 5. Clear folder if you need it and print result message
```
print Fileupload\Classes\DelFilesInDir::run('folder_for_cleaning');
```

### Example
```
<?php
	use Fileupload\Upload;
	$new_load = new Upload();
	$new_load->config = ['pictures' => [
			'dest_dir' => 'upload_pictures/',
			'file_size' => 1 * 1000 * 1024, //1MB
			'file_mimetype' => ['image/jpeg', 'image/pjpeg', 'image/png', 'image/webp'],
			'file_ext' => ['.jpg', '.jpeg', '.png', '.webp'],
			'new_file_name' => ['zzz', 'index'], // ['', 'noindex'], 'new_filename' (!!! Don't do that: ['name', 'noindex'] - because you set the same name for all pictures!)
			'replace_old_file' => true
		]
	];

if ($new_load->issetData()) {
	?>
		$new_load->upload();
		$new_load->printInfo();
        // other files processing here 
        print Fileupload\Classes\DelFilesInDir::run('folder_for_cleaning');
	} else { 
        // print html form here
    }
```

### HTML form info
HTML inputs must be next formats:   
a) for single file   
``` <input type="file" name="file" > ```   
b) for files array        
``` <input type="file" name="pictures[]" > ```  

### Variables that the user can define:   
`public string $dest_dir` - files destination directory (eg 'imgs/res');   
`public int $dir_permissions` - permissions of destination directory for linux system (eg 0755);   
`public int $file_permissions` - permissions of files in destination directory for linux system (eg 0644);   
`public bool $create_dir` - create destination directory if it not exist (true or false);    
`public int $file_size` - maximum size of file for upload in Bytes (eg 3*10*1024 - 30KB);   
`public $file_mimetype` - mimetype of file for upload (eg 'image', 'text' or 'image/webp');   
`public $file_ext` - extension of file for upload (eg 'bmp', 'txt', 'avi');   
`public $new_file_name` - for single file upload: string 'new_filename' or array ['name', 'noindex'],   
for multiple uploads: array a) [$filename, 'index'] or b) ['', 'noindex']. But you must get different name for file in b) case, 
don't do that ['name', 'noindex'] for multiple uploads because you set the same name for all pictures!;   
`public bool $replace_old_file` - if file exist - replace it;   

Если переменные не были установлены - используются значения по умолчанию из класса Config. 
If the variables have not been set, the default values from the Config class are used. 
```
	$vars = [
		'file' => 	[	'dest_dir' => 'upload_files',
						'create_dir' => true,
						'tmp_dir' => 'tmp_file',
		],
		'picture' => 	[] //default value are used
	];
```   

#### Default variables value   
```
    public function defaultVars() {
        $this->dest_dir = 'upload_files';
        $this->tmp_dir = 'tmp_fileupload';
        $this->create_dir = true;
        $this->dir_permissions = 0755;
        $this->replace_old_file = true;
        $this->file_permissions = 0644;
        $this->file_size = 1024000;
        $this->file_mimetype = ''; //any
        $this->file_ext = ''; //any
        $this->new_file_name = ''; //any
        $this->message = [];
        $this->error = '';
    }
```   

### Result messages   
Имена перемещенных файлов записываются в объект класса Messages `$this->messages`:   
Name of moved file are written to `$this->messages`:   
```
[$name of input => [
    'filenames' => [
        0 => $filename0, 1 => $filename1, ...
    ], ...
]]
```   
Сообщения об ошибках записываются в объект класса Errors `$this->errors`:   
Messages about errors are written to `$this->errors`:   
```
[   $name of input => ['errors' => $error_in_config],
    $name of input => [
    'errors' => [0 => $error_for_filename0, 1 => $error_for_filename1, ...]
    ]
]
```     
Данные из `$this->messages` и `$this->errors` записываются в `array $this->info`:   
Data from`$this->messages` and `$this->errors` are written to `array $this->info`:       
```
[$name of input => [
    'filenames' => [
        0 => $filename0, 1 => $filename1, ...
    ],
    'errors' => [
        0 => $error_for_filename0, 1 => $error_for_filename1, ...
    ]
]] 
```    

Вывести все сообщения и ошибки в html-коде: `$this->printInfo()`   
Print all messages and errors in html: `$this->printInfo()`  




 