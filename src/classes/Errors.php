<?php

namespace Fileupload\Classes;

class Errors extends Registry
{
    public array $phpFileUploadErrors = array(
        0 => 'Success! The file uploaded.',
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
        3 => 'The uploaded file was only partially uploaded.',
        4 => 'No file was uploaded.',
        6 => 'Missing a temporary folder.',
        7 => 'Failed to write file to disk.',
        8 => 'A PHP extension stopped the file upload.',
    );
    public array $errors = [
        0 => 'Define the destination directory.',
        1 => 'UNKNOWN ERROR!',
        2 => 'Directory is not writable and chmod return false.',
        3 => 'This is file, not directory.',
        4 => 'Failed to create directory.',
        5 => 'Directory does not exist and cannot be created because set "create_dir = false".',
        6 => '"dest_dir" is empty for class Upload.',
        7 => '"size" from $_FILES is empty.',
        8 => 'Size of file is too large.',
        9 => 'Wrong mimetype.',
        10 => 'Wrong "file_mimetype", must be empty, string or array.',
        11 => 'Wrong extension.',
        12 => 'Wrong type in input data "file_ext", must be empty, string or array.',
        13 => 'Value "name" from $_FILES is empty.',
        14 => 'A file with that name exists in the directory.',
        15 => 'Possible file upload attack.',
        16 => 'ERROR! No deleted files in dir, because dir is not readable.'
    ]; 
}
