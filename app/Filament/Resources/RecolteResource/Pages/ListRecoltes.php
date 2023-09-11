<?php

namespace App\Filament\Resources\RecolteResource\Pages;

use App\Filament\Resources\RecolteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRecoltes extends ListRecords
{
    protected static string $resource = RecolteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
