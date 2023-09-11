<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function getLocationAttribute()
    {
        return $this->location_type === 'region' ? $this->region : ($this->location_type === 'district' ? $this->district : 'autre');

    }
}
