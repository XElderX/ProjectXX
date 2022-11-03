<?php

namespace App\Models\Traits;

trait AutoWithScope
{
    public function scopeAutoWith($query, array $defaultWith = [])
    {
        $requestWith = explode(',', request()->input('with', ''));
        if (count($requestWith) < 1 || empty($requestWith) || $requestWith === '' || $requestWith[0] === '') {
            $requestWith = [];
        }
        $with = array_merge($defaultWith, $requestWith);
        return $query->with($with);
    }
}
