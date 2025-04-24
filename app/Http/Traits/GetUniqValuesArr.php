<?php

namespace App\Http\Traits;

trait GetUniqValuesArr {
    public function getUniqValuesArr($field)
    {
        return $this->distinct($field)->pluck($field);
    }
}