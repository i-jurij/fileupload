<?php

namespace Fileupload\Classes;
use Fileupload\Classes\CheckCreateDir;

class CheckDestDir
{
 public function run($dest_dir, $dir_permissions, $create_dir, $err){
    if (!is_string($dest_dir)) {
        return false;
    }
    if ((new CheckCreateDir)->run($dest_dir, $dir_permissions, $create_dir, $err) === true) {
        return true;
    } else {
        return false;
    }
 }
}
