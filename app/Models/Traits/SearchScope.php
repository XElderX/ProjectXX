<?php

namespace App\Models\Traits;

trait SearchScope
{
    public function scopeSearch($query)
    {
        if (empty($this->likeable)) {
            return $query;
        }

        $search = request()->get('search');
        if (empty($search)) {
            return $query;
        }
        if (count($this->likeable) === 1) {
            $query->where($this->likeable[0], 'like', '%' . $search . '%');
            return $query;
        }

        $likeableArray = $this->likeable;
        $query->where(function ($q) use ($likeableArray, $search) {
            $q->where($likeableArray[0], 'like', '%' . $search . '%');
            unset($likeableArray[0]);

            foreach ($likeableArray as $likeable) {
                $q->orWhere($likeable, 'like', '%' . $search . '%');
            }
        });

        return $query;
    }
}
