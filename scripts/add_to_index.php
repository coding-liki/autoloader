<?php

$path = __DIR__."/../../../../index.php";

$str = <<<PHP

require_once "vendor/CodingLiki/Autoloader/autoloader.php";

PHP;
if(!file_exists($path)){
    file_put_contents($path, "<?php\n$str");
} else {
    $index_contents = file_get_contents($path);
    $index_parts = explode('<?php', $index_contents);
    // array_shift($index_parts);
    // array_unshift($index_parts, $str);
    
    $index_parts[1] = $str.$index_parts[1];
    $index_contents = implode('<?php', $index_parts);
    var_dump($index_parts);
    file_put_contents($path, $index_contents);
}


