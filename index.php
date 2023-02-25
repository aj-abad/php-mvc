<?php

//custom psr-4 autoloader
spl_autoload_register(
  function ($class) {
    $class_path = str_replace('\\', '/', $class);
    $file =  '' . $class_path . '.php';
    // if the file exists, require it
    if (file_exists($file)) {
      require $file;
    }
  }
);
