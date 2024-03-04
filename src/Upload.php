<?php
//Copyright © 2024 I-Jurij (yjurij@gmail.com)
//Licensed under the Apache License, Version 2.0
namespace Fileupload;

use Fileupload\Classes\Config;
use Fileupload\Classes\NormaliseFiles;
use Fileupload\Classes\CheckDestDir;
use Fileupload\Classes\Errors;
use Fileupload\Traits\DelFilesInDir;

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

    public function execute($vars)
    {
        $this->defaultVars();
        $err = new Errors;
        //foreach $this->files for processing and get vars for inputs  
        foreach ($this->files as $input => $input_array) {
            $this->message .= 'Input "'.$input.'":<br />';
            // GET the vars for input from $vars
            if (!empty($vars[$input]) && is_array($vars[$input])) {
                //set the vars from user vars array
                
            }
            

            foreach ($input_array as $key => $file) {
                if (!empty($file['name'])) {
                    if (mb_strlen($file['name'], 'UTF-8') < 101) {
                        $name = $file['name'];
                    } else {
                        $name = mb_strimwidth($file['name'], 0, 48, "...") . mb_substr($file['name'], -48, null, 'UTF-8');
                    }
                    $this->message .= 'Name "'.$name.'":<br />';
                }
                //check errors in files array $file

                //check other

                //move_upload each file

            }
        }
    }
}
//Copyright © 2023 I-Jurij (ijurij@gmail.com)
//Licensed under the Apache License, Version 2.0
