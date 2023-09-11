<?php

namespace App\Filament\Resources\PdcResource\Pages;

use App\Filament\Resources\PdcResource;
use App\Models\Aliment;
use App\Models\Cycle;
use App\Models\Infrastructure;
use Closure;
use DateTime;
use Filament\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Pages\EditRecord;

class EditPdc extends EditRecord
{
    protected static string $resource = PdcResource::class;
    protected static string $view = 'filament.pages.edit-pdc';
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
