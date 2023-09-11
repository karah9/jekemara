<x-filament-panels::page>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 py-5 border-collapse border border-slate-400 rounded-md">
         <tbody class="text-md text-black bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr class="border border-slate-400 font-bold uppercase">
            <td colspan="3" class="py-4 px-6 border border-slate-400">#</td>
            @foreach($rapports as $r => $rapport)
                <td class="py-4 px-6 border border-slate-400">{{$r}}</td>
            @endforeach
        </tr>
        <tr class="border border-slate-400 font-bold uppercase">
            <td class="py-4 px-6 border border-slate-400 uppercase font-bold"  colspan="3">Nombre Total</td>
            @foreach($rapports as  $k => $v)
                <td class="py-4 px-6 border border-slate-400">{{$rapports[$k]['total_infrastructure']['nombre'] }}</td>
            @endforeach
        </tr>
        <tr class="border border-slate-400 font-bold uppercase">
            <td class="py-4 px-6 border border-slate-400 uppercase font-bold"  colspan="3">Superficie en Eau</td>
            @foreach($rapports as  $k => $v)
                <td class="py-4 px-6 border border-slate-400">{{$rapports[$k]['total_infrastructure']['superficie'] }}</td>
            @endforeach
        </tr>
        <tr class="border border-slate-400 font-bold uppercase">
            <td class="py-4 px-6 border border-slate-400 uppercase font-bold"  colspan="3">Superficie en volume</td>
            @foreach($rapports as  $k => $v)
                <td class="py-4 px-6 border border-slate-400">{{$rapports[$k]['total_infrastructure']['volume'] }}</td>
            @endforeach
        </tr>
        <tr class="border border-slate-400 font-bold uppercase">
            <td rowspan="3" colspan="2" class="py-4 px-6 border border-slate-400 uppercase font-bold">Infrastructures en cours de cycle</td>
            <td class="py-4 px-6 border border-slate-400 uppercase font-bold">Nombre Total</td>
            @foreach($rapports as  $k => $v)
                <td class="py-4 px-6 border border-slate-400">{{$rapports[$k]['total_cycle_cours']['nombre'] }}</td>
            @endforeach
        </tr>
        <tr class="border border-slate-400 font-bold uppercase">
            <td class="py-4 px-6 border border-slate-400 uppercase font-bold">Volume totale en eau</td>
            @foreach($rapports as  $k => $v)
                <td class="py-4 px-6 border border-slate-400">{{$rapports[$k]['total_cycle_cours']['volume'] }}</td>
            @endforeach
        </tr>
        <tr class="border border-slate-400 font-bold uppercase">
            <td class="py-4 px-6 border border-slate-400 uppercase font-bold">Superficie totale en eau</td>
            @foreach($rapports as  $k => $v)
                <td class="py-4 px-6 border border-slate-400">{{$rapports[$k]['total_cycle_cours']['superficie'] }}</td>
            @endforeach
        </tr>
        <tr class="border border-slate-400 font-bold uppercase">
            <td rowspan="3" colspan="2" class="py-4 px-6 border border-slate-400 uppercase font-bold">Infrastructures ayant bouclé un cycle</td>
            <td class="py-4 px-6 border border-slate-400 uppercase font-bold">Nombre Total</td>
            @foreach($rapports as  $k => $v)
                <td class="py-4 px-6 border border-slate-400">{{$rapports[$k]['total_cycle_fin']['nombre'] }}</td>
            @endforeach
        </tr>
        <tr class="border border-slate-400 font-bold uppercase">
            <td class="py-4 px-6 border border-slate-400 uppercase font-bold">Volume totale en eau</td>
            @foreach($rapports as  $k => $v)
                <td class="py-4 px-6 border border-slate-400">{{$rapports[$k]['total_cycle_fin']['volume'] }}</td>
            @endforeach
        </tr>
        <tr class="border border-slate-400 font-bold uppercase">
            <td class="py-4 px-6 border border-slate-400 uppercase font-bold">Superficie totale en eau</td>
            @foreach($rapports as  $k => $v)
                <td class="py-4 px-6 border border-slate-400">{{$rapports[$k]['total_cycle_fin']['superficie'] }}</td>
            @endforeach
        </tr>
            @foreach($this->especes as $espece)
                <tr class="border border-slate-400 font-bold uppercase">
                    @if($loop->first)
                        <td rowspan="3" colspan="2" class="py-4 px-6 border border-slate-400 uppercase font-bold">Durée longue par cycle bouclé</td>
                    @endif
                    <td class="py-4 px-6 border border-slate-400 uppercase font-bold">{{ ucfirst($espece) }}</td>
                    @foreach($rapports as $rapport)
                        <td class="py-4 px-6 border border-slate-400">{{ $rapport['duree'][$espece]['longue'] }}</td>
                    @endforeach
                </tr>
            @endforeach
            @foreach($this->especes as $espece)
                <tr class="border border-slate-400 font-bold uppercase">
                    @if($loop->first)
                        <td rowspan="3" colspan="2" class="py-4 px-6 border border-slate-400 uppercase font-bold">Durée moyenne par cycle bouclé</td>
                    @endif
                    <td class="py-4 px-6 border border-slate-400 uppercase font-bold">{{ ucfirst($espece) }}</td>
                    @foreach($rapports as $rapport)
                        <td class="py-4 px-6 border border-slate-400">{{ $rapport['duree'][$espece]['moyenne'] }}</td>
                    @endforeach
                </tr>
            @endforeach
            @foreach($this->especes as $espece)
                <tr class="border border-slate-400 font-bold uppercase">
                    @if($loop->first)
                        <td rowspan="3" colspan="2" class="py-4 px-6 border border-slate-400 uppercase font-bold">Durée courte par cycle bouclé</td>
                    @endif
                    <td class="py-4 px-6 border border-slate-400 uppercase font-bold">{{ ucfirst($espece) }}</td>
                    @foreach($rapports as $rapport)
                        <td class="py-4 px-6 border border-slate-400">{{ $rapport['duree'][$espece]['courte'] }}</td>
                    @endforeach
                </tr>
            @endforeach
            <tr class="border border-slate-400 font-bold uppercase">
                <td colspan="2" class="py-4 px-6 border border-slate-400 uppercase font-bold">Traitement Sanitaire éffectué</td>
                <td class="py-4 px-6 border border-slate-400 uppercase font-bold">Nombre total</td>
                @foreach($rapports as  $k => $v)
                    <td class="py-4 px-6 border border-slate-400">{{$rapports[$k]['traitement'] }}</td>
                @endforeach
            </tr>
            <tr class="border border-slate-400 font-bold uppercase">
                <td class="py-4 px-6 border border-slate-400 uppercase font-bold" rowspan="{{count($aliments) * count($especes) + count($especes)+ 1}}">Quantité totale d'aliment utilisé</td>
            </tr>
            @foreach($this->especes as $espece)

                <tr class="border border-slate-400 font-bold uppercase">
                    <td class="py-4 px-6 border border-slate-400 uppercase font-bold" rowspan="{{count($aliments) + 1}}"> {{$espece}}</td>
                </tr>
                @foreach($this->aliments as $aliment)
                    <tr class="border border-slate-400 font-bold uppercase">
                        <td class="py-4 px-6 border border-slate-400 uppercase font-bold">{{ ucfirst($aliment) }}</td>
                        @foreach($this->rapports as $rapport)
                            @if(!$rapport['alimentation'])

                            @else
                                <td class="py-4 px-6 border border-slate-400">{{ $rapport['alimentation'][$espece][$aliment] }}</td>
                            @endif

                        @endforeach
                    </tr>
                @endforeach
            @endforeach
            @foreach($this->especes as $espece)
                <tr class="border border-slate-400 font-bold uppercase">
                    @if($loop->first)
                        <td rowspan="{{count($this->especes)}}" class="py-4 px-6 border border-slate-400 uppercase font-bold ">Quantite de poisson produit</td>
                    @endif

                    <td class="py-4 px-6 border border-slate-400 uppercase font-bold">{{ ucfirst($espece) }}</td>
                    @foreach($this->rapports as $rapport)
                        @if(!$rapport['poissonProduit'])

                        @else
                            <td class="py-4 px-6 border border-slate-400">{{ $rapport['poissonProduit'][$espece] }}</td>
                        @endif

                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</x-filament-panels::page>
