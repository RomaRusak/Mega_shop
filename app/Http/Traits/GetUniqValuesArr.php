<?php

namespace App\Http\Traits;

trait GetUniqValuesArr {
    public function getUniqValuesArr(string $distinctField, array $selectedFields)
    {
        return $this->distinct($distinctField)->get()->select($selectedFields)->toArray();
    }
}