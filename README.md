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

Сообщения о перемещении файлов и ошибках записываются в `array $this->info`:   
Messages about file movement фтв errors are written to `array $this->info`:       
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

### CLEAR FOLDER - all files will be deleted in a directory specified by user   
`print '<br />' . Fileupload\Classes\DelFilesInDir::run('folder_for_cleaning');`   




 