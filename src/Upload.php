<?php
//Copyright © 2024 I-Jurij (yjurij@gmail.com)
//Licensed under the Apache License, Version 2.0
namespace Fileupload;

use Fileupload\Classes\Config;
use Fileupload\Classes\NormaliseFiles;
use Fileupload\Classes\CheckDestDir;
use Fileupload\Classes\Errors;
use Fileupload\Classes\Messages;

class Upload extends Config
{
    use Traits\GetSetConfigs;

    public array $config = [];

    /**
     * normalize $_FILES
     */
    function __construct()
    {
        $this->files = NormaliseFiles::run();
        //print '<pre>'; print_r($this->files); print '</pre>';
    }

    /**
     * check if isset data in $this->files after normalize $_FILES
     * @return bool
     */
    public function issetData()
    {
        return (is_array($this->files) && !empty($this->files)) ? true : false;
    }

    /**
     * set default vars from class Config
     * init object from class Error extends class Registry for errors saving
     * foreach $this->files (normalized $_FILES array) for processing and get configs for inputs  
     * check errors for each upload file 
     * 
     */
    public function execute()
    {
        $mes = new Messages;
        $err = new Errors;
        foreach ($this->files as $input => $input_array) {
            $mes->set($input, []);
            $this->getSetConfigs($input, $err);
            //print '<pre>'; print_r($this); print '</pre>'; 
            //print '<pre>'; print_r($err); print '</pre>'; 
            print $this->dest_dir;

            foreach ($input_array as $key => $file) {
                if (!empty($file['name'])) {
                    $temp_var = $mes->get($input);
                    $temp_var['filesname'][$key] = $file['name'];
                    $mes->set($input, $temp_var);
                }
                if ($this->conf) {
                    //check errors in files array $file

                    //check other

                    //move_upload each file
                }
            }
        }
        $this->error = $err->getAll();
        $this->message = array_merge_recursive($mes->getAll(), $this->error);
        return true;
    }
}
//Copyright © 2023 I-Jurij (ijurij@gmail.com)
//Licensed under the Apache License, Version 2.0
