<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommuneCercle extends Model
{
    use HasFactory;
    public function cercle(){
        return $this->belongsTo(Cercle::class);
    }
}
