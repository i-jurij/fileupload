<?php

namespace Fileupload\Classes;

class PrintInfo
{
    public function printInfo(array $info){
        if (!empty($info) && is_array($info)) {
            print '<div style="background-color:WhiteSmoke; margin:1rem;padding:1rem;">';
            foreach ($info as $input => $value) {
                print '<p style="color:black;"><b>Input "' . $input .'"</b>:</p>';
                if (key_exists('filesname', $value)) {
                    foreach ($value['filesname'] as $key => $filename) {
                        //print filename
                        if (!empty($filename)) {
                            if (mb_strlen($filename, 'UTF-8') < 101) {
                                $name = $filename;
                            } else {
                                $name = mb_strimwidth($filename, 0, 48, "...") . mb_substr($filename, -48, null, 'UTF-8');
                            }
                            print '<p style="color:black;">File "'.$name.'": ';
                        }
                        //print error for file with name $filename
                        if (!empty($value['errors']) && !empty($value['errors'][$key])) {
                            print '<span style="color:red;">' . $value['errors'][$key] .'</span></p>';
                        } elseif (!empty($value['upload']) && !empty($value['upload'][$key])) {
                            print 'UPLOADED.</p>';
                        }
                        
                    }
                } elseif (key_exists('errors', $value) && is_string($value['errors'])) {
                    //print configs error
                    print '<p style="color:red;">' . $value['errors'] . '</p>';
                }
                
            }
            print "</div>";
        }
    }
}
