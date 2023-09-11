<?php

namespace App\Livewire\Rapport;

use App\Models\Ferme;
use Livewire\Component;

class HeaderRapport extends Component
{
    public $fermeId;
    public function mount($fermeId){
        $this->fermeId = $fermeId;
    }
    public function render()
    {
        return view('livewire.rapport.header-rapport', [
            'ferme' => Ferme::find($this->fermeId)
        ]);
    }
}
