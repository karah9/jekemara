<?php

namespace App\Filament\Resources\InfrastructureResource\Pages;

use App\Filament\Resources\InfrastructureResource;
use App\Models\Infrastructure;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateInfrastructure extends CreateRecord
{
    protected static string $resource = InfrastructureResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array

    {
        if ($this->data['typeInfrastructure']->surface){
            if ($this->data['typeInfrastructure']->volume)
            {
                $data['volume'] =  $data['longueur'] * $data['largeur'] * $data['profondeur'] * $data['niveau'] / 100;
            }else{
                $data['superficie'] =  $data['longueur'] * $data['largeur'];
            }
        }
        if ($this->data['typeInfrastructure']->circulaire){
                $data['volume'] =   ($data['diametre']/2) * ($data['diametre']/2) * $data['profondeur'] * 3.14 * $data['niveau']/100;
        }
        return $data;
    }
}
