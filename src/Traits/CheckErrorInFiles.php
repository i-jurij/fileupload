<?php

namespace Fileupload\Traits;

trait CheckErrorInFiles
{
    /**
     * @param $input - name of input
     * @param $key - key of data array of file from input into $this-Files (normalise $_FILES array)
     * @param array $file - data array of file from input into $this-Files (normalise $_FILES array)
     * @return bool
     */
    public function checkNoErrorInFiles($input,  $key, array $file) {
        if ($file['error'] !== 0 && $file['error'] !== '0' && $file['error'] !== 'UPLOAD_ERR_OK') {
            if (array_key_exists($file['error'], $this->error->phpFileUploadErrors)) {
                $temp_err = $this->error->get($input);
                $temp_err['errors'][$key] = 'ERROR! ' . $this->error->phpFileUploadErrors[$file['error']];
                $this->error->set($input, $temp_err);
            } else {
                $temp_err = $this->error->get($input);
                $temp_err['errors'][$key] = $this->error->errors[1];
                $this->error->set($input, $temp_err);
            }
            return false;
        } else {
            return true;
        }
    }
}
