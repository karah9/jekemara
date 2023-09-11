<?php

namespace App\Filament\Resources\TraitementResource\Pages;

use App\Filament\Resources\TraitementResource;
use App\Models\Cycle;
use App\Models\Traitement;
use Filament\Actions;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateTraitement extends CreateRecord
{
    protected static string $resource = TraitementResource::class;
    protected function beforeCreate(): void
    {
        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->body('Changes to the post have been saved.')
            ->actions([
                Action::make('view')
                    ->button(),
                Action::make('undo')
                    ->color('gray')
                ])
            ->send();
//        $this->halt();
    }

}
