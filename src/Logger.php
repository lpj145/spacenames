<?php
namespace Spacenames;

class Logger
{
    public static function message(string $message)
    {
        if (defined('DEBUG_MODE') && DEBUG_MODE) {
            echo $message.PHP_EOL;
        }
    }
}
