<?php

namespace App\Main;

class View
{
    static public function writeLine(string $line, string $type = 'none'): void{
        echo match ($type) {
            'error'   => "\033[31m$line \033[0m" . PHP_EOL,
            'success' => "\033[32m$line \033[0m" . PHP_EOL,
            'warning' => "\033[33m$line \033[0m" . PHP_EOL,
            'info'    => "\033[36m$line \033[0m" . PHP_EOL,
            default => $line . PHP_EOL,
        };
    }

}