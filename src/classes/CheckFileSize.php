<?php

namespace Fileupload\Classes;

class CheckFileSize
{
    /**
     * check size of upload file
     * @param int $size_of_file from normalize $_FILES
     * @param int $filesize_from_config
     * @param object $err from class Errors
     * @param $input - name of input
     * @param $key - key of data array of file from input into $this-Files (normalise $_FILES array)
     * @return bool
     */
    function run(int $size_of_file, int $filesize_from_config, object $err, $input, $key)
    {
        if (!empty($size_of_file)) {
            if ($size_of_file <= $filesize_from_config) {
                return true;
            } else {
                $temp_err = $err->get($input);
                $temp_err['errors'][$key] = 'ERROR! ' . $err->errors[8];
                $err->set($input, $temp_err);
                return false;
            }
        } else {
            $temp_err = $err->get($input);
            $temp_err['errors'][$key] = 'ERROR! ' . $err->errors[7];
            $err->set($input, $temp_err);
            return false;
        }
    }
}
