<x-filament-panels::page>
    <livewire:rapport.header-rapport :fermeId="$cycle->infrastructure->ferme->id"/>
    <table>
        <tbody class="text-md text-black bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr class="border border-slate-400">
            <td class="py-4 px-6 uppercase font-bold">
                Nom de l'infrastructure
            </td>
            <td class="py-4 px-6  border border-slate-400">
                {{$cycle->infrastructure->nom}}
            </td>
        </tr>
        <tr class="border border-slate-400">
            <td class="py-4 px-6 uppercase font-bold">
                Type d'infrastructure
            </td>
            <td class="py-4 px-6  border border-slate-400">
                {{$cycle->infrastructure->typeInfrastructure->nom}}
            </td>
        </tr>
        <tr class="border border-slate-400">
            <td class="py-4 px-6 uppercase font-bold">
                Superficie ou volume
            </td>
            <td class="py-4 px-6  border border-slate-400">
                {{$cycle->infrastructure->superficie ?? $cycle->infrastructure->volume}}
            </td>
        </tr>
        <tr class="border border-slate-400">
            <td class="py-4 px-6 uppercase font-bold">
                Le rang du cycle pour cette infrastructure
            </td>
            <td class="py-4 px-6  border border-slate-400">
                {{$cycle->rank}}
            </td>
        </tr>
        <tr class="border border-slate-400">
            <td class="py-4 px-6 uppercase font-bold">
                Date de la mise en charge
            </td>
            <td class="py-4 px-6  border border-slate-400">
                {{$cycle->created_at}}
            </td>
        </tr>
        <tr class="border border-slate-400">
            <td class="py-4 px-6 uppercase font-bold  border border-slate-400">
                Nombre total d'alevins
            </td>
            <td class="py-4 px-6  border border-slate-400">
                {{$lastPdc->survivant}}
            </td>
        </tr>
        <tr class="border border-slate-400">
            <td class="py-4 px-6 uppercase font-bold border border-slate-400">
                La densite
            </td>
            <td class="py-4 px-6 border border-slate-400 border border-slate-400">

            </td>
        </tr>
        <tr class="border border-slate-400">
            <td class="py-4 px-6 uppercase font-bold border border-slate-400">
                Poids Moyen à la charge
            </td>
            <td class="py-4 px-6 border border-slate-400 border border-slate-400">
                {{$cycle->firstPdc->poids_moyen}}
            </td>
        </tr>
        <tr class="border border-slate-400">
            <td class="py-4 px-6 uppercase font-bold border border-slate-400">
                Poids Moyen courant
            </td>
            <td class="py-4 px-6 border border-slate-400 border border-slate-400">
                {{$cycle->lastPdc->poids_moyen}}
            </td>
        </tr>
        <tr class="border border-slate-400">
            <td class="py-4 px-6 uppercase font-bold border border-slate-400">
                Biomasse Produite
            </td>
            <td class="py-4 px-6 border border-slate-400 border border-slate-400">
                {{$cycle->lastPdc->biomasse}}
            </td>
        </tr>
        <tr class="border border-slate-400">
            <td class="py-4 px-6 uppercase font-bold border border-slate-400">
                Durée du cycle en mois
            </td>
            <td class="py-4 px-6 border border-slate-400 border border-slate-400">
                {{$cycle->temps}}
            </td>
        </tr>
        <tr class="border border-slate-400">
            <td class="py-4 px-6 uppercase font-bold border border-slate-400">
                Nombre de pêches de controles
            </td>
            <td class="py-4 px-6 border border-slate-400 border border-slate-400">
                {{$cycle->pdcs->count()}}
            </td>
        </tr>
        <tr class="border border-slate-400">
            <td class="py-4 px-6 uppercase font-bold border border-slate-400">
                Prise de poids moyen par pêche de contrôle
            </td>
            <td class="py-4 px-6 border border-slate-400 border border-slate-400">
                {{$cycle->pdcs->avg('prise_poids')}}
            </td>
        </tr>
        <tr class="border border-slate-400">
            <td class="py-4 px-6 uppercase font-bold border border-slate-400">
                Prise de poids total
            </td>
            <td class="py-4 px-6 border border-slate-400 border border-slate-400">
                {{$cycle->pdcs->sum('prise_poids')}}
            </td>
        </tr>
        </tbody>
    </table>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 py-5">--}}
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="py-3 px-6">
                Nom de l'aliment
            </th>
            <th scope="col" class="py-3 px-6">
                Quantite en Kg
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($alimentations as $k => $alimentation)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="py-4 px-6">
                    {{\App\Models\Aliment::find($k)->nom}}
                </td>
                <td class="py-4 px-6">
                    {{$alimentation->sum('produit')}} Kg
                </td>
            </tr>
        @endforeach
        <tr>
            <td class="py-4 px-6">La quantité Total d'aliments</td>
            <td class="py-4 px-6">{{ceil($cycle->alimentations->sum('produit'))}} Kg</td>
        </tr>
        </tbody>
    </table>
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 py-5">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="py-3 px-6">
                            Nom du produit ou depense
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Date
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cycle->traitements as $traitement)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="py-4 px-6">
                                {{$traitement->produit}}
                            </td>
                            <td class="py-4 px-6">
                                {{$traitement->created_at->format('d-m-Y')}}
                            </td>
                        </tr>
                    @endforeach
                    @foreach($cycle->depenses as $depense)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="py-4 px-6">
                                {{$depense->description}}
                            </td>
                            <td class="py-4 px-6">
                                {{$depense->created_at->format('d-m-Y')}}
                            </td>
                        </tr>
                    @endforeach
                    <tr class="text-lg font-bold text-red-600">
                        <td class="py-4 px-6">
                            La quantité d'aliment pour produire 1 Kg de poisson
                        </td>
                        <td class="py-4 px-6">
                            {{round($cycle->lastPdc->biomasse / $cycle->alimentations->sum('produit'))}} Kg
                        </td>
                    </tr>
                    </tbody>
                </table>
</x-filament-panels::page>
