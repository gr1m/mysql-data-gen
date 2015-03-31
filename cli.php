<?php

function __autoload($class_name)
{
    if (strpos($class_name, 'MY') === 0) {
        include __DIR__ . "/includes/MyDataTypes/{$class_name}.class.php";
    } else {
        include __DIR__ . "/includes/{$class_name}.class.php";
    }
}

$app = new App();
$app->main();
