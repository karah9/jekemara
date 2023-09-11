<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ferme extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function infrastructures(){
        return $this->hasMany(Infrastructure::class);
    }
    public function cycles(){
        return $this->hasManyThrough(Cycle::class, Infrastructure::class);
    }

}
