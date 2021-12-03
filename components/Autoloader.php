<?php


function my_autoloader($class) {
    //помещяем все дериктории с классами в один массив
    $array_paths = array(
        '/models/',
        '/components/'
    );
    foreach ($array_paths as $path){
        $path = ROOT.$path.$class.'.php';
        if(is_file($path)){
            include_once $path;
        }
    }
}
spl_autoload_register('my_autoloader');