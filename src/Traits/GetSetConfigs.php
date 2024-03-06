<?php

namespace Fileupload\Traits;

trait GetSetConfigs
{
    public bool $conf;
    /**
     * getting user-set variables from an array
     * @param array with user-set configs
     * @param object class Error
     * set properties
     * set errors in class Error (array(string, string, ...))
     * @return void
     */
    function getSetConfigs(string $name_of_input, object $err)
    {
        $this->defaultVars();
        $this->conf = true;
        if (!empty($this->config[$name_of_input]) && is_array($this->config[$name_of_input])) {
            //set the vars from user vars array
            foreach ($this->config[$name_of_input] as $property => $value) {
                if (property_exists($this, $property)) {
                    if (gettype($this->$property) == gettype($value)) {
                        if ($property === "dest_dir") {
                            // del ending lash in dir
                            $value = rtrim($value, DIRECTORY_SEPARATOR);
                            $this->$property = $value;
                        } else {
                            $this->$property = $value;
                        }
                    } else {
                        if (($property === "file_mimetype" || $property === "file_ext" || $property === "new_file_name") &&
                            (gettype($value) == 'string' || gettype($value) == 'array')
                        ) {
                            $this->$property = $value;
                        } else {
                            $err->set($name_of_input, ['config' => 'ERROR! Types mismatch. Type of "' . $property . '" is "' . gettype($this->$property) . '", but in configs array type is - "' . gettype($value) . '"']);
                            $this->conf = false;
                        }
                    }
                } else {
                    $err->set($name_of_input, ['config' => 'WARNING! Property "' . $property . '" not exist.']);
                    $this->conf = false;
                }
            }
        }
    }
}
