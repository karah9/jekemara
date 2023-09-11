
<div>
    <button wire:click="export" class="py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Exporter</button>
    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table>
                <tbody class="text-md text-black bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
    </div>
    <x-filament::button type="submit">Submit</x-filament::button>
</div>

