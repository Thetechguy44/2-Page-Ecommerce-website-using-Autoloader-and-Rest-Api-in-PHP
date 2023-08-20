<?php
// Autoloader.php

namespace Autoloader;

class Autoloader
{
   public static function register()
{
    spl_autoload_register(function ($class) {
        // Convert namespace separators to directory separators
        $classFilePath = str_replace('\\', DIRECTORY_SEPARATOR, $class);
        
        // Construct the full path to the class file
        $fullPath = __DIR__ . DIRECTORY_SEPARATOR . '../classes/' . DIRECTORY_SEPARATOR . $classFilePath . '.php';

        // Require the class file if it exists
        if (file_exists($fullPath)) {
            require_once $fullPath;
        }
    });
}

}

Autoloader::register();
