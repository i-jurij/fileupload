<?php

namespace Fileupload\Classes;

class MimeToExtension extends MimeTypeExtensionArray
{
    /**
     * @param string $mime mimetype of file
     * @return string or false
     */
    public function run($mime)
    {
        return isset($this->mime_map[$mime]) === true ? $this->mime_map[$mime] : false;
    }
}
