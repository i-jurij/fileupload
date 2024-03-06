<?php

namespace Fileupload\Traits;

trait CheckErrorInFiles
{
    /**
     * @param $input - name of input
     * @param $key - key of data array of file from input into $this-Files (normalise $_FILES array)
     * @param array $file - data array of file from input into $this-Files (normalise $_FILES array)
     * @param object $err of class Error extends class Registry
     * @return bool
     */
    public function checkErrorInFiles($input,  $key, array $file, object $err) {
        if ($file['error'] !== 0 && $file['error'] !== '0' && $file['error'] !== 'UPLOAD_ERR_OK') {
            if (array_key_exists($file['error'], $err->phpFileUploadErrors)) {
                $temp_err = $err->get($input);
                $temp_err['errors'][$key] = 'ERROR!<br />' . $err->phpFileUploadErrors[$file['error']];
                $err->set($input, $temp_err);
            } else {
                $temp_err = $err->get($input);
                $temp_err['errors'][$key] = $err->errors[1];
                $err->set($input, $temp_err);
            }
            return false;
        }
        return true;
    }
}
