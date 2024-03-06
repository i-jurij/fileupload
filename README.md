## PHP library for single or multiple file uploads.
Require PHP >= 8.1.0   

### Install


### Usage
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
`public string $tmp_dir` - temporary directory for file upload, eg for original files before processing (eg 'imgs/temp');   
`public int $file_size` - maximum size of file for upload in Bytes (eg 3*10*1024 - 30KB);   
`public $file_mimetype` - mimetype of file for upload (eg 'image', 'text' or 'image/webp');   
`public $file_ext` - extension of file for upload (eg 'bmp', 'txt', 'avi');   
`public $new_file_name` - string or array [$filename, 'index'] or [$filename, 'noindex'] - where noindex for input with multiple uploads (but you must get different name for file);   
`public bool $replace_old_file` - if file exist - replace it;   

### Default variables value   
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

Сообщения о перемещении файлов или ошибках записываются в `array $this->messages`:   
Messages about file movement or errors are written to `array $this->messages`:       
```
[$name of input => [
    'filenames' => [
        0 => $filename0, 1 => $filename1, ...
    ],
    'config' => $error_in_config,
    'errors' => [
        0 => $error_for_filename0, 1 => $error_for_filename1, ...
    ]
]] 
```    

### CLEAR FOLDER - all files will be deleted in a directory specified by user   
`print '<br />' . Fileupload\Classes\DelFilesInDir::run('folder_for_cleaning');`   




 