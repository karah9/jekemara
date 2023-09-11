<?php

namespace App\Filament\Resources\PdcResource\Pages;

use App\Filament\Resources\PdcResource;
use App\Models\Alimentation;
use App\Models\Pdc;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePdc extends CreateRecord
{
    protected static string $resource = PdcResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $datas = $this->data;
        $pdc = Pdc::create([
            'echant' => $data['echant'],
            'nombre' => $datas['lastPdc']->nombre - $data['mortalite'] + $data['remplacement'],
            'achat' => $data['achat'] ?? 0,
            'mortalite' => $data['mortalite'],
            'remplacement' => $data['remplacement'],
            'poids_moyen' => $data['poids_moyen'],
            'prise_poids' => $data['poids_moyen'] - $datas['lastPdc']->poids_moyen,
            'created_at' => $data['created_at'],
            'cycle_id' => $data['cycle_id']
        ]);
        $datas['lastPdc']->alimentation->update([
            'jour' => date_diff($datas['lastPdc']->created_at, new \DateTime($data['created_at']))->format('%R%a'),
        ]);

        if ($data['ration'] == 0){

            $datas['cycle']->update([
                'end_at' => $data['created_at']
            ]);
            Notification::make()
                ->title('Vous avez Mis fin au cycle')
                ->success()
                ->send();
        }
        else{

            Alimentation::create([
                "aliment_id" => $data['aliment_id'],
                "quantite" => $datas['quantite'],
                "prix" => $data['prix'],
                "ration" => $data['ration'],
                "created_at" => $data['created_at'],
                "pdc_id" => $pdc->id
            ]);
        }
        return $pdc;
    }
}
