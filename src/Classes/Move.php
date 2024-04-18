<?php

namespace Fileupload\Classes;

/**
 * @param string $file_tmp_name (from $_FILES['tmp_name])
 * @param string $dest_dir      (files destination directory from configs array),
 * @param ?array $new_file_name from configs array
 * @param object of class Errors $err
 * @param object of class Messages $mes,
 * @param $input            - name of input
 * @param $key              - key of data array of file from input into $this-files (normalise $_FILES array)
 * @param $file_permissions for the file being created (from configs array)
 */
class Move
{
    public function run(string $file_tmp_name, string $dest_dir, string $new_file_name, object $err, object $mes, $input, $key, $file_permissions)
    {
        if (move_uploaded_file($file_tmp_name, $dest_dir.DIRECTORY_SEPARATOR.$new_file_name)) {
            clearstatcache();
            $fileperms_for_uploaded_file = fileperms($dest_dir.DIRECTORY_SEPARATOR.$new_file_name);
            if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN'
                && $file_permissions !== substr(sprintf('%o', $fileperms_for_uploaded_file), -4)) {
                chmod($dest_dir.DIRECTORY_SEPARATOR.$new_file_name, $file_permissions);
            }
            $temp_var = $mes->get($input);
            $temp_var['uploaded'][$key] = 'UPLOADED to: "'.$dest_dir.DIRECTORY_SEPARATOR.$new_file_name.'".';
            $mes->set($input, $temp_var);

            return true;
        } else {
            $temp_err = $err->get($input);
            $temp_err['errors'][$key] = 'ERROR! '.$err->errors[15];
            $err->set($input, $temp_err);

            return false;
        }
    }
}
