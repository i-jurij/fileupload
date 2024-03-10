<?php

namespace Fileupload\Classes;

class CheckMimeType
{
   /**
     * check mimetype of file
     * @param string $filename (from $_FILES['name])
     * @param string $file_tmp_name (from $_FILES['tmp_name])
     * @param object of class Errors $err
     * @param $input - name of input
     * @param $key - key of data array of file from input into $this-Files (normalise $_FILES array)     
     * @param ?array or string $file_mimetype_from_config (from configs array)
     * @param ?array or string $file_ext_from_config from configs array
     * @return bool
     */
    function run(string $file_name, string $file_tmp_name, object $err,  $input, $key, $file_mimetype_from_config, $file_ext_from_config)
    {
        if (!empty($file_tmp_name)) {
            $mime_type = (new GetMimeType)->run($file_tmp_name);
            list($core, $ext) = explode('/', $mime_type);
            if (empty($file_mimetype_from_config)) {
                return true;
            } else {
                if (is_string($file_mimetype_from_config)) {
                    if ((!empty($core) && $file_mimetype_from_config === $core) || $file_mimetype_from_config === $mime_type) {
                        return true;
                    } else {
                        $temp_err = $err->get($input);
                        $temp_err['errors'][$key] = 'ERROR! ' . $err->errors[9] . ' File mimetype is "' . $mime_type . '", expected "' . $file_mimetype_from_config . '"';
                        $err->set($input, $temp_err);
                        return false;
                    }
                } else {
                    if (is_array($file_mimetype_from_config)) {
                        if ((!empty($core) && in_array($core, $file_mimetype_from_config)) || in_array($mime_type, $file_mimetype_from_config)) {
                            return true;
                        } else {
                            $temp_err = $err->get($input);
                            $temp_err['errors'][$key] = 'ERROR! ' . $err->errors[9] . ' File mimetype is "' . $mime_type . '", expected "' . implode('", "', $file_mimetype_from_config) . '"';
                            $err->set($input, $temp_err);
                            return false;
                        }
                    } else {
                        $temp_err = $err->get($input);
                        $temp_err['errors'][$key] = 'ERROR! ' . $err->errors[10] ;
                        $err->set($input, $temp_err);
                        return false;
                    }
                }
            }
            if (!empty($ext)) {
                if ((new CheckExtension)->run($file_name, $file_tmp_name, $err, $input, $key, $file_ext_from_config)) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }
}
