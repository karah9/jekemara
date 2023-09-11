<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pdc extends Model
{
    use HasFactory;
    protected $guarded = [];
    use \Znck\Eloquent\Traits\BelongsToThrough;


    protected static function booted(): void
    {
        static::addGlobalScope('ancient', function (Builder $builder) {
            $builder->where('type', '!=', 'charge');
        });
    }

    public function cycle(){
        return $this->belongsTo(Cycle::class);
    }

    public function infrastructure(){
        return $this->belongsToThrough(Infrastructure::class, Cycle::class);
    }

    public function alimentation(){
        return $this->hasOne(Alimentation::class);
    }

    public function scopeWithoutCharge($query)
    {
        $query->whereType('pdc');
    }



}


