<?php

namespace Fileupload\Classes;

class Config
{
    // user-defined class properties
    public string $dest_dir;
    public int $dir_permissions;
    public int $file_permissions;
    public bool $create_dir;
    public int $file_size; //1024000; // set in CheckFileSize
    public $file_mimetype;
    public $file_ext;
    public $new_file_name; //string or array ['filename, 'index'] or ['filename, 'noindex'] - where noindex for input with multiple uploads (but you must get different name for file)
    public bool $replace_old_file;
    // other properties
    public array $files;
    public array $message;
    public array $error;
    public string $name;

    public function listProperties() {
        return get_class_vars(__CLASS__);
    } 

    public function defaultVars() {
        $this->message = [];
        $this->error = [];
        $this->dest_dir = 'upload_files';
        $this->dir_permissions = 0755;
        $this->file_permissions = 0644;
        $this->create_dir = true;
        $this->file_size = 1024000;
        $this->file_mimetype = '';
        $this->file_ext = '';
        $this->new_file_name = '';
        $this->replace_old_file = true;
    }
}
