<?php

namespace Fileupload\Classes;

use Fileupload\Classes\Errors;
use Fileupload\Classes\Messages;

class Config extends NormaliseFiles
{
    /**
     * User-defined class properties:
     */
    /**
     * files destination directory (eg 'imgs/res')
     */
    public string $dest_dir;
    /**
     *  permissions of destination directory for linux system (eg 0755)
     */
    public int $dir_permissions;
    /**
     * permissions of files in destination directory for linux system (eg 0644)
     */
    public int $file_permissions;
    /**
     * create destination directory if it not exist (true or false)
     */
    public bool $create_dir;
    /**
     * maximum size of file for upload in Bytes (eg 3*10*1024 - 30KB)
     */
    public int $file_size; //1024000; // set in CheckFileSize
    /**
     * mimetype of file for upload (eg 'image', 'text' or 'image/webp'). https://en.wikipedia.org/wiki/Media_type
     */
    public $file_mimetype;
    /**
     * extension of file for upload (eg 'bmp', 'txt', 'avi')
     */
    public $file_ext;
    /**
     * string or array ['filename, 'index'] or ['filename, 'noindex'] - where noindex for input with multiple uploads (but you must get different name for file)
     */
    public $new_file_name;
    /**
     * if file exist - replace it
     */
    public bool $replace_old_file;

    /**
     * Other properties:
     */
    /**
     * Array for saving the settings set for the class Upload
     */
    public array $config;
    /**
     * Object of class Messages extends Registry for saving the messages from the class Upload
     */
    public object $message;
    /**
     * Object of class Errors extends Registry for saving the errors from the class Upload
     */
    public object $error;

    /**
     * getting user-set variables from an array
     * @param array with user-set configs
     * @param object class Error
     * set properties
     * set errors in class Error (array(string, string, ...))
     * @return void
     */
    function __construct()
    {
        parent::__construct();
        $this->setDefaultVars();
        $this->error = new Errors;
        $this->message = new Messages;
    }

    public function listProperties()
    {
        return get_class_vars(__CLASS__);
    }

    public function setDefaultVars()
    {
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

    public function setConfigs(string $input)
    {
        $this->setDefaultVars();
        if (!empty($this->config[$input]) && is_array($this->config[$input])) {
            //set the vars from user vars array
            foreach ($this->config[$input] as $property => $value) {
                if (property_exists($this, $property)) {
                    if (gettype($this->$property) == gettype($value)) {
                        if ($property === "dest_dir") {
                            // del ending lash in dir
                            $value = rtrim($value, DIRECTORY_SEPARATOR);
                            $this->$property = $value;
                        } else {
                            $this->$property = $value;
                        }
                    } else {
                        if (($property === "file_mimetype" || $property === "file_ext" || $property === "new_file_name") &&
                            (gettype($value) == 'string' || gettype($value) == 'array')
                        ) {
                            $this->$property = $value;
                        } else {
                            $this->error->set($input, ['errors' => 'ERROR! Types mismatch. Type of "' .$property .'" is "' . gettype($this->$property) .'", but in configs array "' . gettype($value) .'"']);
                            return false;
                        }
                    }
                } else {
                    $this->error->set($input, ['errors' => 'WARNING! Property "' . $property . '" not exist.']);
                    return false;
                }
            }
        }
        return true;
    }
}
