<?php

namespace Fileupload\Classes;

class Move
{
    protected function move(string $file_tmp_name)
    {
        if (move_uploaded_file($file_tmp_name, $dir . DIRECTORY_SEPARATOR . $this->new_file_name)) {
            chmod($dir . DIRECTORY_SEPARATOR . $this->new_file_name, $this->file_permissions);
            $this->message .= 'File is uploaded to: "' . $dir . DIRECTORY_SEPARATOR . $this->new_file_name . '".<br />';
            return true;
        } else {
            $this->error = 'ERROR!<br />' . $this->errors[15] . '<br />';
            return false;
        }
    }
}
