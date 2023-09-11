<?php

namespace App\Livewire\Rapport;

use App\Models\Infrastructure;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class Rapport extends Component implements HasForms
{
    use InteractsWithForms;
    public ?array $data = [];
    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('infrastructure_id')
                    ->options(Infrastructure::pluck('nom', 'id'))
            ])
            ->statePath('data');
    }
    public function submit(){

    }

    public function render()
    {
        return view('livewire.rapport.rapport');
    }
}
