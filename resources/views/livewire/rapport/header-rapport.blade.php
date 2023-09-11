<div>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th class="p-1">Nom de la ferme</th>
            <th class="p-1">Prénom & nom du proprietaire</th>
            <th class="p-1">Adresse & contact</th>
            <th class="p-1">geolocalisation</th>
        </tr>
        </thead>
        <tbody>
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <td class="py-4 px-6">{{$ferme->nom}}</td>
            <td class="py-4 px-6">{{$ferme->fullname}}</td>
            <td class="py-4 px-6">{{session('location_type')}} de : {{session('location_name')}} <br>Cercle : {{$ferme->cercle}} Commune : {{$ferme->commune}}
                <br> {{$ferme->phone . ' ' .  $ferme->email}}
            </td>
            <td class="py-4 px-6">{{$ferme->longitude. ' ' .$ferme->latitude}}</td>
        </tbody>
    </table>
</div>
