<?php

namespace App\Filament\Resources\DepenseResource\Pages;

use App\Filament\Resources\DepenseResource;
use App\Models\Depense;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateDepense extends CreateRecord
{
    protected static string $resource = DepenseResource::class;

//    protected function mutateFormDataBeforeCreate(array $data): array
//    {
//        $data['user_id'] = auth()->id();
//
//        return $data;
//    }

}
