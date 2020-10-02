<?php

/**
 * A class for working with script check
 *
 * @author Fellipe Sanches <fellipes@yahoo.com.br>
 * @link https://github.com/fillsanches
 */

class Chkexec
{
    private $mapped_files = array();
    private $lines_to_load = 0;
    private $lines_loaded = 0;
    private $percent = 0;
    private $execution_name;

    function __construct($execution_name) 
    {
        $this->execution_name = $execution_name;
    }

    function execution($current_line = null) 
    {
        $lines_loaded = $current_line;
        
        foreach ($this->mapped_files as $key) {
            $lines_loaded += $key['lines_loaded'];
        }        
        
        $percent = ($lines_loaded / $this->lines_to_load) * 100;
        $this->percent = round($percent);
        
        $this->lines_loaded = $lines_loaded;

        if ($this->lines_loaded > $this->lines_to_load) {
            trigger_error("There are more lines or files executed than checked. When calling the Chkexec::execution() method after a Chkexec::registerFinal() method, do not pass the __LINE__ parameter. Also check that there are no files required or included in the execution flow that are not in the mapped_files array.", E_USER_ERROR);
        } 
        return $this;
    }

    function percent()
    {
        return $this->percent;
    }

    function linesLoaded()
    {
        return $this->lines_loaded;
    }

    function linesToLoad()
    {
        return $this->lines_to_load;
    }

    function addFileToCheck($files, $ignore = null)
    {
        // transform a single string entry into an array of a single index
        !(is_array($files)) ? $files = array($files) : false;
        !(is_array($ignore)) ? $ignore = array($ignore) : false;

        foreach ($files as $file) {
            if (!in_array($file, $ignore)) { 
                $lines = count(file($file));
        
                $this->mapped_files[$file] = array(
                    'name' => $file,
                    'lines' => $lines,
                    'lines_loaded' => 0
                );

                $this->lines_to_load = null;
                foreach ($this->mapped_files as $key) {
                    $this->lines_to_load += $key['lines'];
                }
            }
        }
    }

    function listFilesToCheck($return_str = false)
    {
        if ($return_str === true) {
            foreach ($this->mapped_files as $key) {
                $files[] = $key['name'];
            }
            return implode(', ', $files);
        }
        return $this->mapped_files;
    }

    function removeFileToCheck($key)
    {
        unset($this->mapped_files[$key]);
    }

    function registerFinal($name, $current_line)
    {
        if ($this->mapped_files[$name]) {
            $this->mapped_files[$name]['lines_loaded'] += $current_line;
        }
    }
}