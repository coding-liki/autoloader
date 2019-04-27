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
        "codingliki/php-mvc/src"
    ];
    $auto_replace =[
        "Symfony\\Component\\DependencyInjection\\" => "",
        "Psr\\Container\\" =>  ""
    ];
    foreach ($auto_replace as $key => $value) {
        # code...
        $class = str_replace($key, $value, $class);
    }
    $class_file_name = str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
    //echo "file name is '$class_file_name'\n";

    /** Пробегаем по директориям и загружаем файл при нахождении */
    foreach ($directories as $dir) {
        $file_path = $root.$dir.DIRECTORY_SEPARATOR.$class_file_name;
        $file_path = $dir;

        if ($dir != "" and $dir != "/") {
            $file_path .= DIRECTORY_SEPARATOR;
        }

        $file_path .= $class_file_name;

        //echo "try find `$file_path`\n";

        if (file_exists($file_path)) {
            //echo "found it\n";
            require_once $file_path;
            return true;
        }
    }
    return false;
});
