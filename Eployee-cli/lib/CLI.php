<?php

namespace Lib;

class CLI
{
    public static function write($message)
    {
        echo $message . PHP_EOL;
    }

    public static function read($prompt = "> ")
    {
        self::write($prompt, false);
        return trim(fgets(STDIN));
    }

    public static function clear()
    {
        system('clear || cls');
    }

    public static function pause()
    {
        self::read("Press Enter to continue...");
    }
}