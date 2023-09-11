<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Znck\Eloquent\Traits\BelongsToThrough;

class Infrastructure extends Model
{
    use BelongsToThrough;
    use HasFactory;
    protected $guarded = [];
    protected $with = ['typeInfrastructure'];
    public function ferme(){
        return $this->belongsTo(Ferme::class)->withDefault();
    }
    public function cycles(){
        return $this->hasMany(Cycle::class);
    }
    public function pdcs(){
        return $this->hasManyThrough(Pdc::class, Cycle::class);
    }
    public function depenses(){
        return $this->hasManyThrough(Depense::class, Cycle::class);
    }
    public function recoltes(){
        return $this->hasManyThrough(Recolte::class, Cycle::class);
    }
    public function traitements(){
        return $this->hasManyThrough(Traitement::class, Cycle::class);
    }
    public function user(){
        return $this->belongsToThrough(User::class, Ferme::class);
    }
    public function typeInfrastructure()
    {
        return $this->belongsTo(TypeInfrastructure::class);
    }

    public function scopeWhereCycleFin($query){
        return $query->with('user')->whereDoesntHave('cycles', function ($query) {
            $query->whereNull('end_at');
        });
//        $query->whereHas('user', function($user){
//                    return $user->whereUserId(auth()->id());
//                })
//              ->whereNotIn('id', Cycle::whereFin(0)->get()->pluck('infrastructure_id'));
    }
    public function scopeWhereCycleEnCours($query){
        $query->with('user')->whereHas('cycles', function ($cycle){
            return $cycle->whereNull('end_at');
        });
//        $query->whereHas('user', function($user){
//            return $user->whereUserId(auth()->id());
//        })
//            ->whereHas('cycles', function ($cycle){
//                return $cycle->whereFin(0);
//            });
    }


    public function scopeCurrentFerme($query){
        $query->withWhereHas('ferme', function ($query){
            $query->where('id', 1);
        });
    }

}
