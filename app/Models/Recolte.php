<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Znck\Eloquent\Traits\BelongsToThrough;

class Recolte extends Model
{
    use BelongsToThrough;
    protected $guarded = [];
    use HasFactory;

    public function cycle(){
        return $this->belongsTo(Cycle::class);
    }
    public function infrastructure(){
        return $this->belongsToThrough(Infrastructure::class, Cycle::class, 'recolte.id', '');
    }

}
