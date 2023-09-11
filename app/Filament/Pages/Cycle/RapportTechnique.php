<?php

namespace App\Filament\Pages\Cycle;

use Filament\Pages\Page;
use Filament\Panel;
use Filament\Resources\Pages\PageRegistration;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route as RouteFacade;

class RapportTechnique extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.cycle.rapport-technique';

    public function mount(Request $request){
        dd($request);
    }

}
