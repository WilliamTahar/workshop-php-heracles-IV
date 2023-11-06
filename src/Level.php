<?php

namespace App;

class Level
{
    private static int $demonimateur = 1000;

    public static function calculate(int $exp): int
    {
        return ceil($exp / self::$demonimateur);
    }
}