<?php

namespace App\Models\Traits;


trait AutoWhereScope
{
    abstract protected function getFilterable();

    public function scopeAutoWhere($query)
    {
        foreach (request()->query() as $param => $value) {
            if (!$this->validParameter($param) || !isset($value)) {
                continue;
            }

            if ($this->isUUID($param)) {
                $function = 'whereHas'.substr($param, 0, -5);
                $query = $this->$function($query, $value);
            } else {
                $query->where($param, $value);
            }
        }
        return $this->dateRange($query);
    }

    private function dateRange($query)
    {
        $request = request()->query();
        if (!empty($request['from'])) {
            $from = $request['from'] . ' 00:00:00';
            $query->where('created_at', '>=', $from);
        }
        if (!empty($request['to'])) {
            $to = $request['to'] ?? now()->format('Y-m-d');
            $query->where('created_at', '<=', $to.' 23:59:59');
        }

        return $query;
    }

    /**
     * @param string $param
     * @return bool
     */
    public function validParameter(string $param): bool
    {
        return in_array($param, $this->getFilterable());
    }

    private function isUUID(string $param): bool
    {
        return strpos($param, '_uuid') !== false;
    }

}
