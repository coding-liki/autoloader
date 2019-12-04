<?php

/** Регистрируем Автозагрузчик классов
 */
spl_autoload_register(function ($class) {
    /** Берём ROOT, объявленный в index файле */
    /** TODO:
     * Убрать за ненадобностью
     */
    $include_file_f = function($file){
        if (file_exists($file)) {
            require_once $file;
            return true;
        }
        return false;
    };
    $root = "./";


    /** Список директорий, в которых нужно искать класс*/
    $directories = [
        "",
        "src",
        "vendor",
        "codingliki/php-mvc/src"
    ];
    $auto_replace =[
        "Symfony\\Component\\DependencyInjection\\" => "",
        "Psr\\Container\\" =>  ""
    ];

    foreach ($auto_replace as $key => $value) {
        $class = str_replace($key, $value, $class);
    }

    $class_file_name = str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
    $vendorClassName =  explode(DIRECTORY_SEPARATOR, $class_file_name);
    $vendorClassName = $vendorClassName[0].DIRECTORY_SEPARATOR.$vendorClassName[1];
    // $vne
    /** Пробегаем по директориям и загружаем файл при нахождении */
    foreach ($directories as $dir) {
        
        $file_path = $root.$dir.DIRECTORY_SEPARATOR.$class_file_name;
        
        if ($dir != "" and $dir != "/") {
            $dir .= DIRECTORY_SEPARATOR;
        }
        $file_path = $dir;
        $file_path .= $class_file_name;

        if(!$include_file_f($file_path)){
            $file_path = $dir;
            $file_path .= str_replace("_", DIRECTORY_SEPARATOR,$class_file_name);
            if (!$include_file_f($file_path)) {
                $file_path = str_replace($vendorClassName.DIRECTORY_SEPARATOR, $vendorClassName.DIRECTORY_SEPARATOR."src".DIRECTORY_SEPARATOR,$file_path);
                if (!$include_file_f($file_path)) {
                } else {
                    return true;
                }                
            } else {
                return true;
            }
        } else {
            return true;
        }
    }
    return false;
});

