@php
    $coutTotalAlevins = $achatInitial + $pdcRemplacement * $pdcRemplacementAchat;
    $totalCharges = $coutTotalAlevins +  $cycle->alimentations->sum('montant') + $cycle->traitements->sum('prix') + $cycle->depenses->sum('prix');
@endphp

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
    </tbody>
    </table>
    <table>
        <tbody class="text-md text-black bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr class="border border-slate-400">
            <td class="py-4 px-6 uppercase font-bold">
                Espece
            </td>
            <td class="py-4 px-6  border border-slate-400">
                {{$cycle->espece->nom}}
            </td>
        </tr>
        <tr class="border border-slate-400">
            <td class="py-4 px-6 uppercase font-bold">
                Nombre total d'alevins
            </td>
            <td class="py-4 px-6  border border-slate-400">
                {{$cycle->firstPdc->nombre + $cycle->firstPdc->remplacement + $pdcRemplacement }}
            </td>
        </tr>
        <tr class="border border-slate-400">
            <td class="py-4 px-6 uppercase font-bold">
                Prix de revient moyen des alevins
            </td>
            <td class="py-4 px-6  border border-slate-400">
                {{ceil(($achatInitial + $pdcRemplacement * $pdcRemplacementAchat) /  ($cycle->firstPdc->nombre + $cycle->firstPdc->remplacement + $pdcRemplacement))}}
            </td>
        </tr>
        <tr class="border border-slate-400">
            <td class="py-4 px-6 uppercase font-bold">
                Cout total des d'alevins
            </td>
            <td class="py-4 px-6  border border-slate-400">
                {{$achatInitial + $pdcRemplacement * $pdcRemplacementAchat }}
            </td>
        </tr>
        </tbody>
    </table>
    <table>
        <tbody>
        @foreach($alimentations as $k => $alimentation)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="py-4 px-6">
                    {{\App\Models\Aliment::find($k)->nom}}
                </td>
                <td class="py-4 px-6">
                    {{$alimentation->sum('montant')}}
                </td>
            </tr>
        @endforeach
        <tr>
            <td class="py-4 px-6">Cout total</td>
            <td class="py-4 px-6">{{ceil($cycle->alimentations->sum('montant'))}} FCFA</td>
        </tr>
        </tbody>
    </table>
    </table>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 py-5">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="py-3 px-6">
                Nom du produit
            </th>
            <th scope="col" class="py-3 px-6">
                Date
            </th>
            <th scope="col" class="py-3 px-6">
                Cout
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
                <td class="py-4 px-6">
                    {{$traitement->prix}}
                </td>
            </tr>
        @endforeach
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="py-4 px-6">
                    Cout total
                </td>
                <td colspan="2" class="py-4 px-6 text-center">
                    {{$cycle->traitements->sum('prix')}}
                </td>
            </tr>
        </tbody>
    </table>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 py-5">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="py-3 px-6">
                Description
            </th>
            <th scope="col" class="py-3 px-6">
                Date
            </th>
            <th scope="col" class="py-3 px-6">
                Cout
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($cycle->depenses as $depense)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="py-4 px-6">
                    {{$depense->produit}}
                </td>
                <td class="py-4 px-6">
                    {{$depense->created_at->format('d-m-Y')}}
                </td>
                <td class="py-4 px-6">
                    {{$depense->prix}}
                </td>
            </tr>
        @endforeach
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <td class="py-4 px-6">
                Cout total
            </td>
            <td colspan="2" class="py-4 px-6 text-center">
                {{$cycle->depenses->sum('prix')}}
            </td>
        </tr>
        </tbody>
    </table>
    <table>
        <tbody class="text-md text-black bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr class="border border-slate-400">
            <td class="py-4 px-6 uppercase font-bold">
                Total des charges
            </td>
            <td class="py-4 px-6  border border-slate-400">
                {{$totalCharges}}
            </td>
        </tr>
        <tr class="border border-slate-400">
            <td class="py-4 px-6 uppercase font-bold">
                Quantité totale de poisson produit (en Kg)
            </td>
            <td class="py-4 px-6  border border-slate-400">
                {{round($cycle->lastPdc->biomasse)}} Kg

            </td>
        </tr>
        <tr class="border border-slate-400">
            <td class="py-4 px-6 uppercase font-bold">
                Prix de revient du Kg
            </td>
            <td class="py-4 px-6  border border-slate-400">
                {{ceil($totalCharges / $cycle->lastPdc->biomasse)}} FCFA
            </td>
        </tr>
        </tbody>
    </table>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 py-5">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="py-3 px-6">
                Ventes
            </th>
            <th scope="col" class="py-3 px-6">
                Don
            </th>
            <th scope="col" class="py-3 px-6">
                Autoconsommation
            </th>
        </tr>
        </thead>
        <tbody>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="py-4 px-6">
                    {{$cycle->recoltes->where('type', 'vente')->sum('montant')}}
                </td>
                <td class="py-4 px-6">
                    {{$cycle->recoltes->where('type', 'don')->sum('montant')}}
                </td>
                <td class="py-4 px-6">
                    {{$cycle->recoltes->where('type', 'autoconsommation')->sum('montant')}}
                </td>
            </tr>
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <td class="py-4 px-6">
                Recette total
            </td>
            <td colspan="2" class="py-4 px-6 text-center">
                {{$cycle->recoltes->sum('montant')}}
            </td>
        </tr>
        </tbody>
    </table>
</x-filament-panels::page>
