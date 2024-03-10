<?php

namespace Fileupload\Classes;

class GetMimeType
{
    /**
     * get mimetype of file
     * @param string $file
     * @return string or false
     */
    function run(string $file)
    {
        $mtype = false;
        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mtype = finfo_file($finfo, $file);
            finfo_close($finfo);
        } elseif (function_exists('mime_content_type')) {
            $mtype = mime_content_type($file);
        }
        return $mtype;
    }
}
