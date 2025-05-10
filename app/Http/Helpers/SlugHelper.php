<?php

namespace App\Http\Helpers;

class SlugHelper {
    public static function createSlug(string $name, string $allowedCharaPattern)
    {
        $slug = strtolower(str_replace(' ', '_', $name));
        return $slug = preg_replace($allowedCharaPattern, '', $slug);
    }
}