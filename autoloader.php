<?php

/** Регистрируем Автозагрузчик классов
 */
spl_autoload_register(function ($class) {
    /** Берём ROOT, объявленный в index файле */
    /** TODO:
     * Убрать за ненадобностью
     */
    $root = "./";


    /** Список директорий, в которых нужно искать класс*/
    $directories = [
        "",
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

    /** Пробегаем по директориям и загружаем файл при нахождении */
    foreach ($directories as $dir) {
        $file_path = $root.$dir.DIRECTORY_SEPARATOR.$class_file_name;
        
        if ($dir != "" and $dir != "/") {
            $dir .= DIRECTORY_SEPARATOR;
        }
        $file_path = $dir;
        $file_path .= $class_file_name;

        if (file_exists($file_path)) {
            require_once $file_path;
            return true;
        }

        $file_path = $dir;
        $file_path .= str_replace("_", DIRECTORY_SEPARATOR,$class_file_name);
        if (file_exists($file_path)) {
            require_once $file_path;
            return true;
        }
    }
    return false;
});

