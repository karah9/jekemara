<?php

namespace App\Filament\Resources\InfrastructureResource\Pages;

use App\Filament\Resources\InfrastructureResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInfrastructures extends ListRecords
{
    protected static string $resource = InfrastructureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
