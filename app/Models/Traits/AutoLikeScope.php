<?php

namespace App\Models\Traits;

use DB;

trait AutoLikeScope
{
    public function scopeAutoLike($query)
    {
        foreach (request()->query() as $param => $value) {
            if (!in_array($param, $this->likeable) || empty($value)) {
                continue;
            }
            $query->where($param, 'like', '%' . $value . '%');
        }
        return $query;
    }
}
