<?php

namespace Fileupload\Classes;

class CheckExtension
{
    /**
     * @param string $filename (from $_FILES['name])
     * @param string $file_tmp_name (from $_FILES['tmp_name])
     * @param array or string $file_ext_from_config from configs array 
     * @param object of class Errors $err
     * @param $input - name of input
     * @param $key - key of data array of file from input into $this-Files (normalise $_FILES array)
     * @return bool
     */
    function run(string $file_name, string $file_tmp_name, object $err, $input, $key, $file_ext_from_config)
    {
        if (empty($file_ext_from_config)) {
            return true;
        } else {
            $ext = (new GetExtension)->run($file_name);
            $ext_with_point = (new GetExtension)->runWithPoint($file_name);
            $mime_type = (new GetMimeType)->run($file_tmp_name);
            // crutch for jpg
            if (($mime_type === "image/jpeg" or $mime_type === "image/pjpeg") && $ext === 'jpg') {
                $r = true;
            } else {
                if ((new MimeToExtension)->run($mime_type) === $ext) {
                    $r = true;
                } else {
                    $r = false;
                }
            }
            if ($r) {
                if (is_string($file_ext_from_config) && ($ext === $file_ext_from_config || $ext_with_point === $file_ext_from_config)) {
                    return true;
                } elseif (is_array($file_ext_from_config)) {
                    if (in_array($ext, $file_ext_from_config) || in_array($ext_with_point, $file_ext_from_config)) {
                        return true;
                    } else {                       
                        $temp_err = $err->get($input);
                        $temp_err['errors'][$key] = 'ERROR! ' . $err->errors[11] . ' File ext is "' . $ext . '", expected "' . implode('", "', $file_ext_from_config) . '"';
                        $err->set($input, $temp_err);
                        return false;
                    }
                } else {
                    $temp_err = $err->get($input);
                    $temp_err['errors'][$key] = 'ERROR! ' . $err->errors[12];
                    $err->set($input, $temp_err);
                    return false;
                }
            } else {
                $temp_err = $err->get($input);
                $temp_err['errors'][$key] = 'ERROR! ' . $err->errors[11] . '" ' . $ext . '", because mimetype of uploaded file is: "' . $mime_type . '".';
                $err->set($input, $temp_err);
                return false;
            }
        }
    }
}
