<?php

namespace Fileupload\Classes;

class CheckNewFileName
{
    /**
     * set $this->new_file_name
     * @param array $input_array - array of all files from input
     * @param int $key - key of file in $input_array
     * @param array $file (a file array from $_FILES['input])
     * @return bool
     */
    protected function checkNewFileName($input_array, $key, $file)
    {
        if ($this->newName($input_array, $key, $file)) {
            // wrap aroung jpeg -> jpg
            if ($this->getExtWithPoint($file['name']) === '.jpeg') {
                $ext = '.jpg';
            } else {
                $ext = $this->getExtWithPoint($file['name']);
            }
            $newName = $this->name . $ext;
            //$newName = $this->name.$this->getExtWithPoint($file['name']);
            if (file_exists($this->dest_dir . DIRECTORY_SEPARATOR . $newName)) {
                if ($this->replace_old_file) {
                    $this->new_file_name = $newName;
                    return true;
                } else {
                    $this->error = 'ERROR!<br />
                                        Change $this->new_file_name for upload class in model or set $this->replace_old_file = true,<br />
                                        because ' . $this->errors[14] . '<br />
                                        File: "' . $newName . '", dir: "' . $this->dest_dir . '".<br />';
                    return false;
                }
            } else {
                $this->new_file_name = $newName;
                return true;
            }
        } else {
            return false;
        }
    }
}
