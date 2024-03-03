<?php

namespace Fileupload\Classes;
    /**
     * check if dir exists, writable, if not - create dir
     * @param string $dir
     * @param int $dir_permissions - permissions for dir
     * @param bool $create - create dir if not exists
     * @param object $err - object of class Errors
     * @return true or object
     */
class CheckCreateDir
{
    public function run(string $dir, int $dir_permissions, bool $create, object $err){
        if (file_exists($dir)) {
            if (is_dir($dir)) {
                if (is_writable($dir)) {
                    return true;
                } else {
                    if (chmod($dir, $dir_permissions)) {
                        return true;
                    } else {
                        $err->set('ERROR! Dir "' . $dir . '": ' . $err->errors[2] . '<br />');
                        return false;
                    }
                }
            } else {
                $err->set('ERROR! Dir "' . $dir . '": ' . $err->errors[3] . '<br />');
                return false;
            }
        } else {
            # create dir if $create_dir = true or message - dir not exists
            if ($create) {
                if (mkdir($dir, $dir_permissions, true)) {
                    return true;
                } else {
                    $err->set('ERROR! Dir "' . $dir . '": ' . $err->errors[4] . '<br />');
                    return false;
                }
            } else {
                $err->set('ERROR! Dir "' . $dir . '": ' . $err->errors[5] . '<br />');
                return false;
            }
        }
    }
}
