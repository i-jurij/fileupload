<?php

// Copyright © 2024 I-Jurij (yjurij@gmail.com)
// Licensed under the Apache License, Version 2.0

namespace Fileupload;

use Fileupload\Classes\CheckCreateDestDir;
use Fileupload\Classes\CheckExtension;
use Fileupload\Classes\CheckFileSize;
use Fileupload\Classes\CheckMimeType;
use Fileupload\Classes\CheckNewFileName;
use Fileupload\Classes\Config;
use Fileupload\Classes\Move;
use Fileupload\Classes\PrintInfo;

class Upload extends Config
{
    use Traits\CheckNoErrorInFiles;
    /**
     * array for all class messages and errors.
     */
    public array $info = [];

    /**
     * check if isset data in $this->files after normalize $_FILES.
     *
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
     * check errors for each upload file.
     */
    public function upload()
    {
        foreach ($this->files as $input => $input_array) {
            if ($this->setConfigs($input)) {
                $this->message->set($input, []);
                // check dest_dir
                if (!(new CheckCreateDestDir())->run($this->dest_dir, $this->dir_permissions, $this->create_dir, $this->error, $input)) {
                    continue;
                }
                foreach ($input_array as $key => $file) {
                    if (!empty($file['name'])) {
                        $temp_var = $this->message->get($input);
                        $temp_var['filesname'][$key] = $file['name'];
                        $this->message->set($input, $temp_var);
                    }
                    if ($this->checkNoErrorInFiles($input, $key, $file)) {
                        if (!(new CheckFileSize())->run($file['size'], $this->file_size, $this->error, $input, $key)) {
                            continue;
                        }
                        if (!(new CheckMimeType())->run($file['name'], $file['tmp_name'], $this->error, $input, $key, $this->file_mimetype, $this->file_ext)) {
                            continue;
                        }
                        if (!(new CheckExtension())->run($file['name'], $file['tmp_name'], $this->error, $input, $key, $this->file_ext)) {
                            continue;
                        }
                        $checkname = (new CheckNewFileName())->run($this->dest_dir, $this->replace_old_file, $file['name'], $this->error, $input, $key, $this->new_file_name);
                        if (is_string($checkname)) {
                            if (!(new Move())->run($file['tmp_name'], $this->dest_dir, $checkname, $this->error, $this->message, $input, $key, $this->file_permissions)) {
                                continue;
                            }
                        } else {
                            continue;
                        }
                    }
                }
            }
        }
        $this->info = array_merge_recursive($this->message->getAll(), $this->error->getAll());

        return true;
    }

    /**
     * all messages and errors to string.
     */
    public function infoToString()
    {
        return (new PrintInfo())->infoToString($this->info);
    }

    /**
     * print all messages and errors in html.
     */
    public function printInfo()
    {
        return (new PrintInfo())->printInfo($this->info);
    }
}
