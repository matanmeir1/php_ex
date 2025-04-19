<?php

class Logger 
{
    public static function logMessage($message, $print = false) {
        $timestamp = date('Y-m-d H:i:s');
        $line = "[$timestamp] $message" . PHP_EOL;
        file_put_contents('logs/app.log', $line, FILE_APPEND);

        if ($print) {
            echo $message . "<br>";
        }
    }
}

