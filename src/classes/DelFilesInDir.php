<?php

namespace Fileupload\Classes;

class DelFilesInDir
{
 /**
     * delete all files into directory
     * @return string
     */
    public static function run(string $dir, bool $recursive = true)
    {
        if (!empty($dir)) {
            $dir = rtrim($dir, DIRECTORY_SEPARATOR);
            if (!is_readable($dir)) {
                return 'ERROR!<br />Not unlink files in dir "' . $dir . '", because it is not readable. <br />';
            }
            $files = array_diff(scandir($dir), array('.', '..'));
            foreach ($files as $file) {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $file) && $recursive === true) {
                    self::run($dir . DIRECTORY_SEPARATOR . $file, true);
                } else {
                    if (!unlink($dir . DIRECTORY_SEPARATOR . $file)) {
                        return 'ERROR!<br />Not unlink "' . $dir / $file . '".<br />';
                    }
                }
            }
        }
        return 'SUCCESS!<br />All files in dir "' . $dir . '" deleted.<br />';
    }
}
