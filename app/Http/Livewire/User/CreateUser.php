<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;

use Hash;
use Livewire\Component;

class CreateUser extends Component implements HasForms
{
    use InteractsWithForms;
    public $firstname = '';
    public $lastname= '';
    public $matricule= '';
    public $adresse = '';
    public $sexe = '';
    public $phone= '';
    public $role= '';
    public $email= '';
    public $password= '';
    public $passwordConfirm;
    public function getFormSchema(): array
    {
        return [
            Section::make("Formulaire de creation d'utilisateur")
                ->schema([
                    TextInput::make('firstname')
                        ->label("Prénom")
                        ->reactive()
                        ->required(),
                    TextInput::make('lastname')
                        ->label("Nom")
                        ->reactive()
                        ->required(),
                    Radio::make('sexe')
                        ->options([
                            'M' => 'Masculin',
                            'F' => 'Feminin',
                        ]),
                    TextInput::make('email')
                        ->unique('users', 'email')
                        ->required(),
                    TextInput::make('matricule')
                        ->label("Matricule")
                        ->reactive(),
                    TextInput::make('phone')
                        ->label("Téléphone")
                        ->reactive()
                        ->required(),
                    TextInput::make('password')
                        ->same('passwordConfirm')
                        ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                        ->password()
                        ->label("Mot de passe")
                        ->disableAutocomplete(),
                    TextInput::make('passwordConfirm')
                        ->dehydrated(false),
                    Select::make('role')
                        ->options([
                            'admin' => 'Admin',
                            'agent' => 'Agent',
                        ]),
                    TextInput::make('adresse')
                ])
                ->columns(2)

        ];
    }


    public function save(){
        User::create($this->form->getState());
        Notification::make()
            ->title('Utilisateur a été crée')
            ->success()
            ->send();
    }
    public function render()
    {
        return view('livewire.user.create-user');
    }
}
