<?php

namespace Fileupload\Traits;

trait GetSetConfigs
{
    /**
     * getting user-set variables from an array
     * @param array with user-set configs
     * @param object class Error
     * set properties
     * set errors in class Error (array(string, string, ...))
     * @return bool
     */
    function getSetConfigs(string $name_of_input, object $err) {
        if (!empty($this->config[$name_of_input]) && is_array($this->config[$name_of_input])) {
            //set the vars from user vars array
            foreach ($this->config[$name_of_input] as $property => $value) {
                if (property_exists($this, $property)) {
                    if (($property === "file_mimetype" || $property === "file_ext" || $property === "new_file_name") &&
                        (gettype($value) == 'string' || gettype($value) == 'array')
                    ) {
                        $this->$property = $value;
                    } elseif (gettype($this->$property) == gettype($value)) {
                        $this->$property = $value;
                    } else {
                        $err->set($name_of_input, ['config' => 'ERROR! Types mismatch. Type of "'. $property .'" is "' . gettype($this->$property) . '", but in configs array type is - "' . gettype($value) . '"']);
                        return false;
                    }
                } else {
                    $err->set($name_of_input, ['config' => 'WARNING! Property "'. $property .'" not exist.']);
                    return false;
                }
            }
            return true;
        } else {
            return true;
        }
    }
}
