<?php

namespace App\Filament\Resources\RecolteResource\Pages;

use App\Filament\Resources\RecolteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRecolte extends EditRecord
{
    protected static string $resource = RecolteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
