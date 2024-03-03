<?php
//Copyright © 2024 I-Jurij (yjurij@gmail.com)
//Licensed under the Apache License, Version 2.0
namespace Fileupload;

use Fileupload\Classes\Config;
use Fileupload\Classes\NormaliseFiles;
use Fileupload\Classes\CheckDestDir;
use Fileupload\Classes\Errors;

class Upload extends Config
{
    function __construct()
    {
        $this->files = NormaliseFiles::run();
    }

    public function issetData()
    {
        return (is_array($this->files) && !empty($this->files)) ? true : false;
    }

    public function execute($input_array, $key, $file)
    {
        $err = new Errors;
        //checking the variables set by the user dest dir and tmp dir
        if (empty($this->dest_dir)) {
            $this->error = 'ERROR!<br />' . $err->errors[0] . '<br />';
            return false;
        } else {
            // del ending lash in dir
            $this->dest_dir = rtrim($this->dest_dir, DIRECTORY_SEPARATOR);
            if (!empty($this->tmp_dir)) {
                $this->tmp_dir = rtrim($this->tmp_dir, DIRECTORY_SEPARATOR);
            }
        }
        //check error in FILES
        if ($file['error'] !== 0 && $file['error'] !== '0' && $file['error'] !== 'UPLOAD_ERR_OK') {
            if (array_key_exists($file['error'],$err->phpFileUploadErrors)) {
                $this->error = 'ERROR!<br />' . $err->phpFileUploadErrors[$file['error']];
            } else {
                $this->error = $err->errors[1] . '<br />';
            }
            return false;
        }
        // checkDestDir
        if ((new CheckDestDir)->run($this->dest_dir, $this->dir_permissions, $this->create_dir, $err) === false) {
            $this->error = 'ERROR! ' . $err->errors[6] . '<br />';
            foreach ($err->getAll() as $value) {
                $this->error .= $value . '<br />';
            }
            return false;
        }
        // checkFileSize
        if ($this->checkFileSize($file['size']) === false) {
            return false;
        }
        // checkMimeType
        if ($this->checkMimeType($file['name'], $file['tmp_name']) === false) {
            return false;
        }
        // checkExtension
        if ($this->checkExtension($file['name'], $file['tmp_name']) === false) {
            return false;
        }

        // checkNewFileName
        if ($this->checkNewFileName($input_array, $key, $file) === false) {
            return false;
        }
        // moveUpload
        if ($this->moveUpload($file['tmp_name']) === false) {
            return false;
        }
        return true;
    }
}
//Copyright © 2023 I-Jurij (ijurij@gmail.com)
//Licensed under the Apache License, Version 2.0
