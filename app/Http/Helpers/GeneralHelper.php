<?php

namespace App\Http\Helpers;

class GeneralHelper {
    public static function underscoresToSpace($str)
    {
        return str_replace('_', ' ', $str);
    }
}