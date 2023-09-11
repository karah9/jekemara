<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = [
            [
                'id' => 1,
                'nom' => 'Kayes'
            ],
            [
                'id' => 2,
                'nom' => 'Koulikoro'
            ],
            [
                'id' => 3,
                'nom' => 'Sikasso'
            ],
            [
                'id' => 4,
                'nom' => 'Segou'
            ],
            [
                'id' => 5,
                'nom' => 'Mopti'
            ],
            [
                'id' => 6,
                'nom' => 'Tombouctou'
            ],
            [
                'id' => 7,
                'nom' => 'Gao'
            ],
            [
                'id' => 8,
                'nom' => 'Kidal'
            ],

        ];
        Region::insert($regions);
    }
}
