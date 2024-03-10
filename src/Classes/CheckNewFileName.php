<?php

namespace Fileupload\Classes;

class CheckNewFileName
{
    public string $name;

    /**
     * set $new_file_name
     * @param string $dest_dir from configs array (where upload file will be saved)
     * @param bool $replace_old_file from configs array (replace old file in dest dir with new upload file with same name) 
     * @param string $filename (from $_FILES['name])
     * @param object of class Errors $err
     * @param $input - name of input
     * @param $key - key of data array of file from input into $this-Files (normalise $_FILES array)
     * @param ?array $new_file_name - from configs array
     * @return string or false
     */
    function run(string $dest_dir, bool $replace_old_file, string $file_name, object $err, $input, $key, $new_file_name)
    {
        if ($this->newName($file_name, $err, $input, $key, $new_file_name)) {
            // wrap aroung jpeg -> jpg
            if ((new GetExtension)->runWithPoint($file_name) === '.jpeg') {
                $ext = '.jpg';
            } else {
                $ext = (new GetExtension)->runWithPoint($file_name);
            }
            $newName = $this->name . $ext;
            //$newName = $this->name.$this->getExtWithPoint($file_name);
            if (file_exists($dest_dir . DIRECTORY_SEPARATOR . $newName)) {
                if ($replace_old_file) {
                    return $newName;
                } else {
                    $temp_err = $err->get($input);
                    $temp_err['errors'][$key] = 'ERROR! ' . $err->errors[14] . '"' . $dest_dir . '" Change $new_file_name or set $this->replace_old_file = true';
                    $err->set($input, $temp_err);
                    return false;
                }
            } else {
                return $newName;
            }
        } else {
            return false;
        }
    }

    /**
     * create sanitize name from users input, set $this->name
     * @param string $filename (from $_FILES['name])
     * @param object of class Errors $err
     * @param $input - name of input
     * @param $key - key of data array of file from input into $this-Files (normalise $_FILES array)
     * @param ?array $new_file_name - from configs array
     * @return bool
     */
    protected function newName(string $file_name, object $err, $input, $key, $new_file_name)
    {
        $sanitize = new SanitizeFileName;
        $translit = new TranslitOstSlavToLat;
        //get parts of files name
        if (!empty($file_name)) {
            $path_parts = pathinfo($file_name);
        } else {
            $temp_err = $err->get($input);
            $temp_err['errors'][$key] = 'ERROR! ' . $err->errors[13];
            $err->set($input, $temp_err);
            return false;
        }
        //sanitize filename or create filename from old filename
        if (!empty($new_file_name)) {
            $name = $this->name0($new_file_name, $path_parts['filename'], $key);
            $this->name = pathinfo($sanitize->run($translit->run($name)), PATHINFO_FILENAME);
            return true;
        } else {
            //create new file name
            $this->name = $sanitize->run($translit->run($path_parts['filename']));
            return true;
        }
    }

    protected function name0($new_file_name, $name, $key)
    {
        if (is_array($new_file_name)) {
            if (!empty($new_file_name[1]) && $new_file_name[1] === 'noindex' or $new_file_name[1] === false  or $new_file_name[1] === '') {
                $prename = (!empty($new_file_name[0])) ? $new_file_name[0] : $name;
            } elseif (!empty($new_file_name[1]) && $new_file_name[1] === 'index' or $new_file_name[1] === true) {
                $prename = (!empty($new_file_name[0])) ? $key . '_' . $new_file_name[0] : $key . '_' . $name;
            }
        } else {
            $prename = $new_file_name;
        }
        return $prename;
    }
}
