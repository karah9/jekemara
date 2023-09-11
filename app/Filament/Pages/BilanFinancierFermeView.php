<?php

namespace App\Filament\Pages;

use App\Models\Aliment;
use App\Models\Espece;
use App\Services\BilanFinancierFermeService;
use App\Services\RapportTechniqueFermeService;
use Filament\Pages\Page;
use Illuminate\Http\Request;

class BilanFinancierFermeView extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.bilan-financier-ferme-view';

    public $fermeIds;
    public $especes;
    public $aliments;
    public $startDate;
    public $endDate;
    public $rapports;
    public $nombres;
    public $alimentation;

    public function mount(Request $request){
        $this->fermeIds = $request->fermeIds;
        $this->startDate = $request->startDate;
        $this->endDate = $request->endDate;
        $this->especes = Espece::all()->pluck('nom');
        $this->aliments = Aliment::all()->pluck('nom');
        $rapportTechnique = new BilanFinancierFermeService($this->startDate, $this->endDate, $this->fermeIds);
        $this->rapports = $rapportTechnique->genererRapport();
        //dd($this->rapports);

    }
}
