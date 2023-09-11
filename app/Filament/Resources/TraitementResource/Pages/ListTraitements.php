<?php

namespace App\Filament\Resources\TraitementResource\Pages;

use App\Filament\Resources\TraitementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTraitements extends ListRecords
{
    protected static string $resource = TraitementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
