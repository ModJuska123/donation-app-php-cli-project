<?php

use App\Main\InputHandler;
use App\Main\View;

function autoload($class): void{
    $exploded = explode('\\', $class);
    $currentFile = str_replace('index.php', '', __FILE__);
    $exploded[0] = 'App';
    $filePath = $currentFile.implode('/', $exploded).'.php';

    if(file_exists($filePath)){
        require_once($filePath);
    }
}

if(isset($argv)){
    spl_autoload_register('autoload');
    $file = $argv[0];
    unset($argv[0]);

    if(count($argv) > 0){
        $argumentResolver = (new InputHandler($argv))->resolve();
        $controllerClass = $argumentResolver->findArguments('controller')->getValue() . 'Controller';
        $method = $argumentResolver->findArguments('method')->getValue();
        $controllerClass = 'App\\Controllers\\' .  $controllerClass; 

        if(!class_exists($controllerClass)){
            View::writeLine('Controller '. $controllerClass. ' does not exist', 'error');
            die();
        }
        if(!method_exists($controllerClass, $method)){
            View::writeLine('Method '. $method . ' does not exist', 'error');
            die();
        }
        $controller = new $controllerClass();
        $controller->$method($argumentResolver);
        exit();
    }
}