<?php


namespace Database\Seeders;


use App\Models\Cercle;
use Illuminate\Database\Seeder;

class CercleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cercles = [
            [
                'nom' => 'Kayes',
                'region_id' => 1
            ],
            [
                'nom' => 'Bafoulabe',
                'region_id' => 1
            ],
            [
                'nom' => 'Diema',
                'region_id' => 1
            ],
            [
                'nom' => 'Kenieba',
                'region_id' => 1
            ],
            [
                'nom' => 'Kita',
                'region_id' => 1
            ],
            [
                'nom' => 'Nioro',
                'region_id' => 1
            ],
            [
                'nom' => 'Yelimane',
                'region_id' => 1
            ],
            [
                'nom' => 'Koulikoro',
                'region_id' => 2
            ],
            [
                'nom' => 'Banamba',
                'region_id' => 2
            ],
            [
                'nom' => 'Dioila',
                'region_id' => 2
            ],
            [
                'nom' => 'Kangaba',
                'region_id' => 2
            ],
            [
                'nom' => 'Kati',
                'region_id' => 2
            ],
            [
                'nom' => 'Kolokani',
                'region_id' => 2
            ],
            [
                'nom' => 'Nara',
                'region_id' => 2
            ],
            [
                'nom' => 'Sikasso',
                'region_id' => 3
            ],
            [
                'nom' => 'Bougouni',
                'region_id' => 3
            ],
            [
                'nom' => 'Kadiolo',
                'region_id' => 3
            ],
            [
                'nom' => 'Kolondieba',
                'region_id' => 3
            ],
            [
                'nom' => 'Koutiala',
                'region_id' => 3
            ],
            [
                'nom' => 'Yanfolila',
                'region_id' => 3
            ],
            [
                'nom' => 'Yorosso',
                'region_id' => 3
            ],
            [
                'nom' => 'Segou',
                'region_id' => 4
            ],
            [
                'nom' => 'Baroueli',
                'region_id' => 4
            ],
            [
                'nom' => 'Bla',
                'region_id' => 4
            ],
            [
                'nom' => 'Macina',
                'region_id' => 4
            ],
            [
                'nom' => 'Niono',
                'region_id' => 4
            ],
            [
                'nom' => 'San',
                'region_id' => 4
            ],
            [
                'nom' => 'Tominian',
                'region_id' => 4
            ],
            [
                'nom' => 'Mopti',
                'region_id' => 5
            ],
            [
                'nom' => 'Badiangara',
                'region_id' => 5
            ],
            [
                'nom' => 'Bankass',
                'region_id' => 5
            ],
            [
                'nom' => 'Djenne',
                'region_id' => 5
            ],
            [
                'nom' => 'Douentza',
                'region_id' => 5
            ],
            [
                'nom' => 'Koro',
                'region_id' => 5
            ],
            [
                'nom' => 'Tenenkou',
                'region_id' => 5
            ],
            [
                'nom' => 'Youwarou',
                'region_id' => 5
            ],
            [
                'nom' => 'Tombouctou',
                'region_id' => 6
            ],
            [
                'nom' => 'Dire',
                'region_id' => 6
            ],
            [
                'nom' => 'Goudam',
                'region_id' => 6
            ],
            [
                'nom' => 'Gourma-rarhous',
                'region_id' => 6
            ],
            [
                'nom' => 'Niafunke',
                'region_id' => 6
            ],
            [
                'nom' => 'Gao',
                'region_id' => 7
            ],
            [
                'nom' => 'Ansongo',
                'region_id' => 7
            ],
            [
                'nom' => 'Bourem',
                'region_id' => 7
            ],
            [
                'nom' => 'Menaka',
                'region_id' => 7
            ],
            [
                'nom' => 'Kidal',
                'region_id' => 8
            ],
            [
                'nom' => 'Abeibara',
                'region_id' => 8
            ],
            [
                'nom' => 'Tessalit',
                'region_id' => 8
            ],
            [
                'nom' => 'Tin-essako',
                'region_id' => 8
            ],



        ];
        Cercle::insert($cercles);
    }
}
