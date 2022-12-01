<?php
spl_autoload_register(function($class){
    $file = str_replace("\\", DIRECTORY_SEPARATOR, $class);
    $file = str_replace("Class_", "Class".DIRECTORY_SEPARATOR, $class).".php";
    if (file_exists($file))
        require $file;
});
?>