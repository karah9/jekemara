<?php

namespace App\Services;

use App\Models\Aliment;
use App\Models\Alimentation;
use App\Models\Cycle;
use App\Models\Espece;
use App\Models\Ferme;
use App\Models\Infrastructure;
use App\Models\TypeInfrastructure;

class RapportTechniqueFermeService
{
    protected $fermeRepository;
    public $cycles;
    public $infrastructure;
    public $ferme;
    public $startDate;
    public $endDate;
    public $fermeIds;
    public $totals;

    public function __construct($startDate, $endDate, $fermeIds)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->fermeIds = $fermeIds;
    }
    public function getFerme(){
        if ($this->fermeIds == 'tout'){
            return $this->ferme = Ferme::all();
        }
        else{
            $id = explode(',', $this->fermeIds);
            return $this->ferme = Ferme::whereIn('id', $id)->get();
        }
    }
    public function genererRapport()
    {
        $fermeIds = $this->getFerme()->pluck('id');
        $cycles = Cycle::whereHas('infrastructure', function ($infrastructure) use ($fermeIds) {
            $infrastructure->whereIn('ferme_id', $fermeIds);
        })->whereBetween('created_at', [$this->startDate, $this->endDate])->get();

        $infrastructures = Infrastructure::whereIn('id', $cycles->pluck('infrastructure_id'))
            ->orWhereDoesntHave('cycles')
            ->whereIn('ferme_id', $fermeIds)
            ->get();
        $groups = $infrastructures->groupBy('type_infrastructure_id');
        foreach ($groups as $k => $group) {
            // Obtenir tous les cycles pour les infrastructures des types donnés
            $cycles = Cycle::whereIn('infrastructure_id', $group->pluck('id'))
                ->with('infrastructure', 'pdcs', 'traitements', 'alimentations')
                ->get();
            // Regrouper les traitements par produit
            $traitementGrouped = $cycles->pluck('traitements')->flatten()->groupBy('produit');
//
//            // Filtrer les cycles en cours et les cycles terminés par espèce
            $cycleEnCours = $cycles->whereNull('end_at');
            $cycleEnd = $cycles->unique('infrastructure_id')->whereNotNull('end_at');
            $cycleGroups = $cycles->groupBy('espece_id');
            $especesPossibles = Espece::pluck('nom', 'id');
            $aliments = Aliment::pluck('nom', 'id');
            $cycleEnCoursGroupByEspece = $cycleEnCours->groupBy('espece_id');
            $cycleEndGroupByEspece = $cycleEnd->groupBy('espece_id');
            $duree  = [];
            $alimentation = [];
            $poissonProduit = [];
            // Créez un tableau vide pour stocker les durées
            $durees = [];

            foreach ($especesPossibles as $especeId => $especeNom) {
                // Recherchez les cycles associés à cette espèce
                $cyclesPourEspece = $cycleEndGroupByEspece->get($especeId, collect());

                // Créez un tableau vide pour stocker les durées pour cette espèce
                $dureesPourEspece = [];

                // Calculez les durées pour cette espèce
                $dureesPourEspece['moyenne'] = $cyclesPourEspece->avg('temps') ?? 0;
                $dureesPourEspece['longue'] = $cyclesPourEspece->max('temps') ?? 0;
                $dureesPourEspece['courte'] = $cyclesPourEspece->min('temps') ?? 0;

                // Stockez les durées pour cette espèce
                $duree[$especeNom] = $dureesPourEspece;
            }

// $durees contient maintenant les durées pour toutes les espèces possibles, y compris celles qui n'ont pas produit de cyclesAvec cette modification, vous obtiendrez les durées pour toutes les espèces possibles, même celles qui n'ont pas produit de cycles.






            foreach ($cycleGroups as $especeId => $cycles) {
                $espece = Espece::find($especeId)->nom;
                $alimentations = $cycles->flatMap(function ($cycle) {
                    return $cycle->alimentations;
                });
                // Obtenez toutes les espèces possibles
                $especesPossibles = Espece::all()->pluck('nom', 'id');
                foreach ($especesPossibles as $id => $especeNom) {
                    // Recherchez les cycles associés à cette espèce
                    $cyclesPourEspece = $cycleGroups->get($id, collect());
                    $quantitePoisson = 0;
                    foreach ($cyclesPourEspece as $cycle) {
                            $quantitePoisson += $cycle->poissonProduit;
                    }
                    $poissonProduit[$especeNom] = $quantitePoisson;
                }


                // Obtenez la liste de tous les aliments possibles
                $alimentsPossibles = Aliment::all();

                $alimentation = [];

                foreach ($especesPossibles as $especeId => $especeNom) {
                    // Initialisation du tableau pour cette espèce
                    $alimentation[$especeNom] = [];

                    foreach ($alimentsPossibles as $aliment) {
                        $alimentId = $aliment->id;
                        $alimentNom = $aliment->nom;

                        // Trouvez les alimentations pour cet aliment et cette espèce
                        $alimentationsPourAliment = $alimentations->where('aliment_id', $alimentId);

                        // Calculez la quantité totale ou retournez zéro si aucune alimentation n'est trouvée
                        $quantiteTotale = $alimentationsPourAliment->sum('quantite') ?? 0;

                        // Stockez les statistiques dans le tableau
                        $alimentation[$especeNom][$alimentNom] = $quantiteTotale;
                    }
                }

            }
            $poissonProduit = [];
            // Parcourez toutes les espèces possibles
            foreach ($especesPossibles as $especeId => $especeNom) {
                // Recherchez les cycles pour cette espèce
                $cyclesPourEspece = $cycles->where('espece_id', $especeId);

                // Calculez la quantité totale de poisson produite pour cette espèce en parcourant les cycles
                $quantitePoissonProduite = $cyclesPourEspece->sum(function ($cycle) {
                    return $cycle->poisson_produit; // Utilisez la relation et l'attribut défini dans le modèle Cycle
                });

                // Stockez la quantité dans le tableau résultant
                $poissonProduit[$especeNom] = $quantitePoissonProduite;
            }

            $totalVolume = 0;
            $totalSuperficie = 0;
            $total_cycle_cours_superficie = 0;
            $total_cycle_cours_volume = 0;
            $total_cycle_fin_superficie = 0;
            $total_cycle_fin_volume = 0;
            $total_cycle_cours_superficie += $cycleEnCours->sum(function ($cycle){
                return $cycle->infrastructure->superficie;
            });
            $total_cycle_fin_superficie += $cycleEnd->sum(function ($cycle){
                return $cycle->infrastructure->superficie;
            });
            $total_cycle_cours_volume += $cycleEnCours->sum(function ($cycle){
                return $cycle->infrastructure->volume;
            });
            $total_cycle_fin_volume += $cycleEnd->sum(function ($cycle){
                return $cycle->infrastructure->volume;
            });
            foreach ($group as $infrastructure) {
                if ( !$infrastructure->typeInfrastructure->volume) {
                    $totalSuperficie += $infrastructure->superficie;
                }
                else{
                    $totalVolume += $infrastructure->volume;
                }
            }
            $type_infrastructure = TypeInfrastructure::find($k)->nom;
            $this->totals[$type_infrastructure] = [
                'total_infrastructure' =>  [
                    'nombre' => $group->count(),
                    'superficie' => $totalSuperficie,
                    'volume' => $totalVolume,
                ],
                'total_cycle_cours' => [
                    'nombre' => $cycleEnCours->count(),
                    'volume' => $total_cycle_cours_volume,
                    'superficie' => $total_cycle_cours_superficie,
                ],
                'total_cycle_fin' => [
                    'nombre' => $cycleEnd->count(),
                    'volume' => $total_cycle_fin_volume,
                    'superficie' => $total_cycle_fin_superficie,
                ],
                'duree' => $duree,
                'alimentation' => $alimentation,
                'poissonProduit' => $poissonProduit,
                'traitement' => $traitementGrouped->count(),



            ];


        }

        return $this->totals;

    }

    public function getAlimentationByType($especes){
//        return $especes
    }


    public function calculateCycleTotals($cycles, $type) {
        $total_volume = 0;
        $total_superficie = 0;

        foreach ($cycles as $cycle) {
            if ($cycle->infrastructure->type === $type) {
                if (in_array($type, ['Bassin en ciment', 'Etang en terre'])) {
                    $total_superficie += $cycle->infrastructure->superficie;
                    $total_volume += $cycle->infrastructure->superficie;
                } else {
                    $total_volume += $cycle->infrastructure->volume;
                    $total_superficie += $cycle->infrastructure->volume;
                }
            }
        }

        return [
            'total_volume' => $total_volume,
            'total_superficie' => $total_superficie
        ];
    }

}
