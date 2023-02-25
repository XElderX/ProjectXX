<?php

namespace App\Models;

use App\Models\Traits\AutoWhereScope;
use App\Models\Traits\AutoWithScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surname extends Model
{
    use HasFactory;
    use AutoWhereScope;
    use AutoWithScope;

    public const TABLE_NAME = 'surnames';

    protected $fillable = [
        'surname',
        'country_id',
        'popularity',
    ];

    protected $filtarable = ['country_id', 'popularity'];

    public function country(){
        return $this->belongsTo(Country::class);
    }

    /**
     * @return string[]
     */
    public function getFilterable(): array
    {
        return $this->filtarable;
    }
}
