<?php

namespace Fileupload\Classes;

class PrintInfo
{
    protected string $all_info = '';

    public function infoToString(array $info)
    {
        if (!empty($info) && is_array($info)) {
            foreach ($info as $input => $value) {
                $this->all_info .= '<b>Input "'.$input.'"</b>:<br>';
                if (key_exists('filesname', $value)) {
                    foreach ($value['filesname'] as $key => $filename) {
                        if (!empty($filename)) {
                            if (mb_strlen($filename, 'UTF-8') < 101) {
                                $name = $filename;
                            } else {
                                $name = mb_strimwidth($filename, 0, 48, '...').mb_substr($filename, -48, null, 'UTF-8');
                            }
                            $this->all_info .= 'File "'.$name.'": ';
                        }
                        // print error for file with name $filename
                        if (!empty($value['errors']) && !empty($value['errors'][$key])) {
                            $this->all_info .= $value['errors'][$key].'<br>';
                        } elseif (!empty($value['uploaded']) && !empty($value['uploaded'][$key])) {
                            $this->all_info .= $value['uploaded'][$key].'<br>';
                        }
                    }
                } elseif (key_exists('errors', $value) && is_string($value['errors'])) {
                    // print configs error
                    $this->all_info .= $value['errors'].'<br>';
                }
            }
        }

        return $this->all_info;
    }

    public function printInfo(array $info)
    {
        if (!empty($info) && is_array($info)) {
            echo '<div style="background-color:WhiteSmoke; margin:1rem;padding:1rem;">';
            foreach ($info as $input => $value) {
                echo '<p style="color:black;"><b>Input "'.$input.'"</b>:</p>';
                if (key_exists('filesname', $value)) {
                    foreach ($value['filesname'] as $key => $filename) {
                        // print filename
                        if (!empty($filename)) {
                            if (mb_strlen($filename, 'UTF-8') < 101) {
                                $name = $filename;
                            } else {
                                $name = mb_strimwidth($filename, 0, 48, '...').mb_substr($filename, -48, null, 'UTF-8');
                            }
                            echo '<p style="color:black;">File "'.$name.'": ';
                        }
                        // print error for file with name $filename
                        if (!empty($value['errors']) && !empty($value['errors'][$key])) {
                            echo '<span style="color:red;">'.$value['errors'][$key].'</span></p>';
                        } elseif (!empty($value['uploaded']) && !empty($value['uploaded'][$key])) {
                            echo $value['uploaded'][$key].'</p>';
                        }
                    }
                } elseif (key_exists('errors', $value) && is_string($value['errors'])) {
                    // print configs error
                    echo '<p style="color:red;">'.$value['errors'].'</p>';
                }
            }
            echo '</div>';
        }
    }
}
