<?php

namespace Fileupload\Classes;

class Config
{
    // user-defined class properties
    public string $dest_dir = '';
    public int $dir_permissions = 755;
    public int $file_permissions = 644;
    public bool $create_dir = false;
    public int $file_size; //1024000; // set in CheckFileSize
    public $file_mimetype = '';
    public $file_ext = '';
    public $new_file_name = ''; //string or array ['filename, 'index'] or ['filename, 'noindex'] - where noindex for input with multiple uploads (but you must get different name for file)
    public bool $replace_old_file = false;
    public string $tmp_dir = '';
    // other properties
    protected array $files;
    protected string $message = '';
    protected string $error = '';
    protected string $name;
    protected array $phpFileUploadErrors = array(
        0 => 'Success! The file uploaded.',
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
        3 => 'The uploaded file was only partially uploaded.',
        4 => 'No file was uploaded.',
        6 => 'Missing a temporary folder.',
        7 => 'Failed to write file to disk.',
        8 => 'A PHP extension stopped the file upload.',
    );
    public array $errors = [
        0 => 'Define the destination directory.',
        1 => 'UNKNOWN ERROR!',
        2 => 'Directory is not writable and chmod return false.',
        3 => 'This is file, not directory.',
        4 => 'Failed to create directory.',
        5 => 'Directory does not exist and cannot be created because $this->create_dir = false.',
        6 => '$this->dest_dir is empty for class Upload.',
        7 => '"size" from $_FILES is empty.',
        8 => 'Size is too large.',
        9 => 'Wrong mimetype.',
        10 => 'Wrong $this->file_mimetype, must be empty, string or array.',
        11 => 'Wrong extension.',
        12 => 'Wrong type in input data "file_ext", must be empty, string or array.',
        13 => 'Value "name" from $_FILES is empty.',
        14 => 'A file with that name exists in the directory.',
        15 => 'Possible file upload attack.'
    ];

    public static function listProperties() {
        return get_class_vars(__CLASS__);
    } 
}
