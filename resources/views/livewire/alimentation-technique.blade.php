<div>
    @foreach($this->especes as $espece)
        <tr class="border border-slate-400 font-bold uppercase">
            <td class="py-4 px-6 border border-slate-400 uppercase font-bold" rowspan="{{count($aliments) + 1}}">Quantité totale d'aliment utilisé {{$espece}}</td>
        </tr>
        @foreach($this->aliments as $aliment)
            <tr class="border border-slate-400 font-bold uppercase">
                <td class="py-4 px-6 border border-slate-400 uppercase font-bold">{{ ucfirst($aliment) }}</td>
                @foreach($this->rapports as $rapport)
                        <td class="py-4 px-6 border border-slate-400">{{ $rapport['alimentation'][$espece][$aliment] }}</td>
                @endforeach
            </tr>
        @endforeach
    @endforeach
</div>
