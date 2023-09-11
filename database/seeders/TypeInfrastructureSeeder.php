<?php

namespace Database\Seeders;

use App\Models\TypeInfrastructure;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeInfrastructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        TypeInfrastructure::insert([
            [   'nom' => 'Bassin en ciment',
                'surface' => 1,
                'volume' => 0,
                'circulaire' => 0
            ],
            [   'nom' => 'Etang en terre',
                'surface' => 1,
                'volume' => 0,
                'circulaire' => 0
            ],
            [   'nom' => 'Bac hors sol',
                'surface' => 1,
                'volume' => 1,
                'circulaire' => 0
            ],
            [   'nom' => 'Cage rectangulaire',
                'surface' => 1,
                'volume' => 1,
                'circulaire' => 0
            ],
            [   'nom' => 'Cage circulaire',
                'surface' => 0,
                'volume' => 1,
                'circulaire' => 1
            ],
        ]);
    }


}
