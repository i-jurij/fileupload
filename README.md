## PHP library for single or multiple file uploads.

HTML inputs must be next formats:   
a) for single file   
``` <input type="file" name="name" > ```   
b) for files array        
``` <input type="file" name="names[]" > ```  
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



 