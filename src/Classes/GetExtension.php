<?php

namespace Fileupload\Classes;

class GetExtension
{
    /**
     * @param string $filename
     * @return string file extension without a dot at the beginning
     */
    public function run($filename)
    {
        //$ext = strtolower(mb_substr(strrchr($filename, '.'), 1));
        $path_info = pathinfo($filename);
        $ext = strtolower($path_info['extension']);
        return $ext;
    }

    /**
     * @param string $filename
     * @return string file extension with a dot at the beginning
     */
    public function runWithPoint($filename)
    {
        $ext = strtolower(strrchr($filename, '.'));
        return $ext;
    }
}
