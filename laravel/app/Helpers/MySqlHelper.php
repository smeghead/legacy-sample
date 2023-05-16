<?php
declare(strict_types=1);

namespace App\Helpers;
 
class MySqlHelper
{
    public static function escapeLikeParameter(string $str): string
    {
        return str_replace(['%', '_'], ['\%', '\_'], $str);
    }
}