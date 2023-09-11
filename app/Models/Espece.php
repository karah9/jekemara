<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Znck\Eloquent\Traits\BelongsToThrough;

class Espece extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    public function cycles(){
        return $this->hasMany(Cycle::class);
    }
}
