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
    public array $files;
    public string $message = '';
    public string $error = '';
    public string $name;

    public function listProperties() {
        return get_class_vars(__CLASS__);
    } 
}
