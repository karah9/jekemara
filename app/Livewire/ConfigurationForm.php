<?php

namespace App\Livewire;

use App\Models\Configuration;
use App\Models\District;
use App\Models\Region;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class ConfigurationForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $configuration = Configuration::first();
        if ($configuration){
            Notification::make()
                ->title("Prémière configuration déjà effectuée")
                ->danger()
                ->send();
            $this->redirect('dashboard');
        }
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Radio::make('location_type')
                    ->label('District ou Region')
                    ->required()
                    ->reactive()
                    ->options([
                        'district' => 'District',
                        'region' => 'Region',
                    ]),
                Select::make('region')
                    ->label('Région')
                    ->options(Region::pluck('nom', 'nom'))
                    ->dehydrated(fn(\Filament\Forms\Get $get) => $get('location_type') === 'region')
                    ->disabled(fn(\Filament\Forms\Get $get) => $get('location_type') === 'district'),
                Select::make('district')
                    ->options(District::pluck('nom'))
                    ->disabled(fn(\Filament\Forms\Get $get) => $get('location_type') === 'region')
                    ->dehydrated(fn(\Filament\Forms\Get $get) => $get('location_type') === 'district'),
            ])
            ->statePath('data')
            ->model(Configuration::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $record = Configuration::create($data);

        $this->form->model($record)->saveRelationships();

        Notification::make()
            ->title("Prémière configuration de l'application")
            ->success()
            ->send();
        //$this->redirectRoute('ferme.create');
    }

    public function render(): View
    {
        return view('livewire.configuration-form');
    }
}
