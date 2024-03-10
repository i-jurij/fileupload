<?php

namespace Fileupload\Classes;

class TranslitToLat
{
    /**
     * replaces all letters with Latin ASCII
     * @param string $var
     * @return string
     */
    function run($text)
    {
        $res = iconv("UTF-8", "ASCII//TRANSLIT//IGNORE", transliterator_transliterate('Any-Latin; Latin-ASCII', $text));
        return $res;
    }
}
