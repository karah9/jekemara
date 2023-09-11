<?php

namespace App\Filament\Resources\FermeResource\Pages;

use App\Filament\Resources\FermeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFerme extends CreateRecord
{
    protected static string $resource = FermeResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
