<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;


    public function communedistricts(){
        return $this->hasMany(Communedistrict::class);
    }
}
