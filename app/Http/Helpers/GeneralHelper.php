<?php

namespace App\Http\Helpers;

class GeneralHelper {
    public static function underscoresToSpace($str)
    {
        return str_replace('_', ' ', $str);
    }

    public static function getIdFromSlug($slug)
    {
        $id = null;
        preg_match('/([a-zA-Z0-9_-]+)-(\d+)/', $slug, $matches);

        if(array_key_exists(2, $matches)) {
            $id = $matches[2];
        }

        return $id;
    }
}