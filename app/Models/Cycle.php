<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\DB;
use Znck\Eloquent\Traits\BelongsToThrough;

class Cycle extends Model
{
    use BelongsToThrough;
    use HasFactory;
    protected $guarded = [];
    protected $with = ['firstPdc', 'lastPdc'];
//    public function ferme(){
//        return $this->belongsToThrough(Ferme::class, Infrastructure::class,
//            'cycle.id',
//            '');
//    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($cycle) {
            // Get the count of cycles for the same infrastructure
            $count = Cycle::where('infrastructure_id', $cycle->infrastructure_id)->count();

            // Generate the "nom" attribute based on infrastructure name and cycle count
            $infrastructureName = $cycle->infrastructure->nom;
            $cycle->nom = "{$infrastructureName} Cycle " . ($count + 1);
        });
    }

    public function espece()
    {
        return $this->belongsTo(Espece::class);
    }

    public function infrastructure(){
        return $this->belongsTo(Infrastructure::class);
    }
    public function ferme(){
        return $this->belongsToThrough(Ferme::class, Infrastructure::class);
    }
    public function pdcs(){
        return $this->hasMany(Pdc::class);
    }
    public function recoltes(){
        return $this->hasMany(Recolte::class);
    }
    public function traitements(){
        return $this->hasMany(Traitement::class);
    }
    public function depenses(){
        return $this->hasMany(Depense::class);
    }
    public function alimentations() : HasManyThrough
    {
        return $this->hasManyThrough(Alimentation::class, Pdc::class);
    }
    public function firstPdc()
    {
        return $this->hasOne(Pdc::class)->withoutGlobalScopes()->oldest();
    }

    public function lastPdc()
    {
        return $this->hasOne(Pdc::class)->withoutGlobalScopes()->latest();
    }

    public function scopeRecoltesOfType($query, array $type)
    {
        return $query->whereHas('recoltes', function ($query) use ($type) {
            $query->whereIn('type', $type);
        });
    }
    public function scopeOfEspece($query, $espece)
    {
        return $query->where('espece', $espece);
    }

    public function getVentesAttribute()
    {
        return $this->recoltes->where('type', 'vente');
    }

    public function getDonsAttribute()
    {
        return $this->recoltes->where('type', 'don');
    }

    public function getAutoconsommationsAttribute()
    {
        return $this->recoltes->where('type', 'autoconsommation');
    }

    public function getRankAttribute()
    {
        // Récupérer l'infrastructure associée au cycle
        $infrastructure = $this->infrastructure;

        // Compter les cycles associés à l'infrastructure, en filtrant pour n'inclure que les cycles avec des ID inférieurs ou égaux à l'ID du cycle actuel
        $rank = $infrastructure->cycles()
            ->where('id', '<=', $this->id)
            ->count();

        return $rank;
    }

    public function getTempsAttribute()
    {
        if ($this->end_at){
            $lastDate = new \DateTime($this->end_at);
            $jour = (new \DateTime($this->created_at))->diff($lastDate);
            return  round($jour->y*12 + $jour->m + $jour->d/30, 1);
        }
        $lastDate = new \DateTime($this->pdcs->last()->created_at);
        $jour = (new \DateTime($this->created_at))->diff($lastDate);
        return  round($jour->y*12 + $jour->m + $jour->d/30, 1);
    }
    public function getPoissonProduitAttribute()
    {
        return  $this->pdcs->last()->biomasse;
    }

    public function getTotalChargeAttribute()
    {
        $achatInitial = ($this->firstPdc->nombre + $this->firstPdc->remplacement) * $this->firstPdc->achat;
        $coutTotalAlevins = $achatInitial + $this->pdcs->sum('remplacement') * $this->pdcs->sum('achat');

        $totalCharges = $coutTotalAlevins +
            $this->alimentations->sum('montant') +
            $this->traitements->sum('prix') +
            $this->depenses->sum('prix');

        return $totalCharges;
    }
    public function getPrixRevientKgAttribute()
    {


        return ceil($this->totalCharge / $this->lastPdc->biomasse);
    }









}
