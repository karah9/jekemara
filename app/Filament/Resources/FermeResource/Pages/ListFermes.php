<?php

namespace App\Filament\Resources\FermeResource\Pages;

use App\Filament\Resources\FermeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFermes extends ListRecords
{
    protected static string $resource = FermeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
