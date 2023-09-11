<?php

namespace App\Filament\Resources\CycleResource\Pages;

use App\Filament\Resources\CycleResource;
use App\Models\Alimentation;
use App\Models\Cycle;
use App\Models\Pdc;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateCycle extends CreateRecord
{
    protected static string $resource = CycleResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $cycle = Cycle::create([
            'nom' => '',
            'espece_id' => $data['espece_id'],
            'created_at' => $data['created_at'],
            'infrastructure_id' => $data['infrastructure_id']
        ]);
        $pdc = Pdc::create([
            'nombre' => $data['nombre'],
            'achat' => $data['achat'],
            'type' => 'charge',
            'mortalite' => $data['mortalite'],
            'remplacement' => $data['remplacement'],
            'poids_moyen' => $data['poids_moyen'],
            'created_at' => $data['created_at'],
            'cycle_id' => $cycle->id
        ]);
         Alimentation::create([
            "aliment_id" => $data['aliment_id'],
            "quantite" => round(($data['nombre'] - $data['mortalite'] + $data['remplacement'])*$data['poids_moyen']/1000 * $data['ration'] / 100, 2, PHP_ROUND_HALF_UP),
            "prix" => $data['prix'],
            "ration" => $data['ration'],
            "created_at" => $data['created_at'],
            "pdc_id" => $pdc->id
        ]);
        return $cycle;
    }


}
