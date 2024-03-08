<?php

namespace Fileupload\Classes;

/**
 * check if $_FILES exists and set $this->files as normalize $_FILES
 * @return bool
 */
class NormaliseFiles
{
    public array $files;

    function __construct()
    {
        $this->files = [];
        if (isset($_FILES)) {
            foreach ($_FILES as $input => $file) {
                if (!is_array($file['name'])) {
                    if (!empty($file['name'])) {
                        $file['name'] = SanitizeFileName::run($file['name']);
                        $this->files[$input][] = $file;
                        continue;
                    }
                }
                if (!empty($file['name'])) {
                    foreach ($file['name'] as $idx => $name) {
                        $sanitize_name = SanitizeFileName::run($name);
                        $this->files[$input][$idx] = [
                            'name' => $sanitize_name,
                            'type' => $file['type'][$idx],
                            'tmp_name' => $file['tmp_name'][$idx],
                            'error' => $file['error'][$idx],
                            'size' => $file['size'][$idx]
                        ];
                    }
                }
            }
            return true;
        } else {
            return false;
        }
    }
}
