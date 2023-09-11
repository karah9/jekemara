<?php

namespace App\Livewire\Rapport;

use App\Models\Cycle;
use Illuminate\Http\Request;
use Livewire\Component;


class RapportTechnique extends Component
{
    public $cycle;
    public function mount(Request $request){
        $cycleId = $request->cycle_id;
        $this->cycle = Cycle::whereId($cycleId)->with( 'pdcs', 'traitements', 'depenses', 'recoltes')->first();
    }
    public function render()
    {
        return view('livewire.rapport.rapport-technique');
    }
}
