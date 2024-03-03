<?php
//Copyright © 2024 I-Jurij (yjurij@gmail.com)
//Licensed under the Apache License, Version 2.0
namespace Fileupload;

use Fileupload\Classes\Config;
use Fileupload\Classes\NormaliseFiles;

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

    public function exec()
    {
        if ($this->issetData()) {
            return true;
        } else {
            return false;
        }
    }
}
//Copyright © 2023 I-Jurij (ijurij@gmail.com)
//Licensed under the Apache License, Version 2.0
