<?php

namespace App\Filament\Resources\PdcResource\Pages;

use App\Filament\Resources\PdcResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPdcs extends ListRecords
{
    protected static string $resource = PdcResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
