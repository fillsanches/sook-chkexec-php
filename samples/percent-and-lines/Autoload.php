<?php

/**
 * 
 * Loads any class present in the classes directory
 *
 * @author Fellipe Sanches <fellipes@yahoo.com.br>
 * @link https://github.com/fillsanches
 */

class Autoload {
    public function __construct() {
        spl_autoload_extensions('.php');
        spl_autoload_register(array($this, 'load'));
    }
    private function load($className) {
        $extension = spl_autoload_extensions();
        require_once (__DIR__ . '/classes/' . $className . $extension);
    }
}

$autoload = new Autoload();