<?php

namespace App\Filament\Resources\FermeResource\Pages;

use App\Filament\Resources\FermeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFerme extends EditRecord
{
    protected static string $resource = FermeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
