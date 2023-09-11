<?php

namespace App\Http\Livewire\Ferme;

use App\Models\Cercle;
use App\Models\Communecercle;
use App\Models\Communedistrict;
use App\Models\Configuration;
use App\Models\Ferme;
use App\Models\Region;
use App\Models\User;
use Closure;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Arr;
use Livewire\Component;
use Session;

class CreateFerme extends Component implements HasForms
{
    use InteractsWithForms;
    public $location_type;
    public $location_name;
    public $nom = '';
    public $email = '';
    public $firstname = '';
    public $lastname = '';
    public $zone = '';
    public $pays = 'Mali';
    public $cercle = '';
    public $region = '';
    public $district = 'Bamako';
    public $phone = '';
    public $commune = '';
    public $localite = '';
    public $longitude = '';
    public $latitude = '';
    public $quartier = '';
    public $ville = '';
    /**
     * @var \Filament\Forms\ComponentContainer|\Illuminate\Contracts\View\View|mixed|null
     */


    public function mount(){
        $this->form->fill([

        ]);
    }

    public function getFormSchema(): array
    {
        return [
            Section::make('Formulaire de creation de la ferme')
                ->schema([
                    TextInput::make('nom')
                        ->label("Nom de la ferme")
                        ->unique()
                        ->required(),
                    TextInput::make('firstname')
                        ->label("Prénom du proprietaire")
                        ->unique()
                        ->required(),
                    TextInput::make('lastname')
                        ->label("Nom du proprietaire")
                        ->unique()
                        ->required(),
                    TextInput::make('phone')
                        ->label('Telephone')
                        ->mask(fn (TextInput\Mask $mask) => $mask->pattern('+{223} 00-00-00-00'))
                        ->required(),
                    TextInput::make('email')
                        ->nullable(),
                    TextInput::make('pays')
                        ->default('Mali')
                        ->disabled()
                        ->required(),
                    Select::make('cercle')
                        ->label('Cercle')
                        ->hidden(Session::get('location_type')  !== 'region')
                        ->reactive()
                        ->options(Cercle::whereHas('region', function ($query) {
                            $query->where('nom', Session::get('location_name'));
                        })->pluck('nom', 'nom'))
                        ->searchable(),
                    Select::make('commune')
                        ->hidden(Session::get('location_type')  !== 'region')
                        ->options(fn (\Filament\Forms\Get $get) => Communecercle::whereHas('cercle', function ($query) use ($get) {
                            $query->where('nom', $get('cercle'));
                        })->pluck('nom', 'nom'))
                        ->label('Commune'),
                    Select::make('commune')
                        ->hidden(Session::get('location_type')  !== 'district')
                        ->options(Communedistrict::pluck('nom', 'nom'))
                        ->label('Commune'),
                    TextInput::make('ville')
                        ->label('Ville / Village / Quartier'),
                    TextInput::make('longitude'),
                    TextInput::make('latitude'),
                ])
                ->columns(3)
        ];
    }


    public function save(){
        Ferme::Create($this->form->getState());
        Notification::make()
            ->title('Profile a été mise a jour')
            ->success()
            ->send();
        $this->redirectRoute('infrastructure.create');
    }

//    public function setAdresse(array $data): ?string{
//        $notNullData = Arr::whereNotNull($data);
//        return implode(', ', $notNullData);
//    }
    public function submit(){
        dd($this->form->getState());
        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => 'Save the information?',
            'icon'        => 'question',
            'accept'      => [
                'label'  => 'Yes, save it',
                'method' => 'save',
                'params' => 'Saved',
            ],
            'reject' => [
                'label'  => 'No, cancel',
                'method' => 'cancel',
            ],
        ]);

    }
    public function render()
    {
        return view('livewire.ferme.create-ferme');
    }
}
