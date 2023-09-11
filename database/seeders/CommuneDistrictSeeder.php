<?php

namespace Database\Seeders;

use App\Models\Communedistrict;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommunedistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $communes = [
            [
                'id' => 1,
                'nom' => 'commune I',
                'district_id' => 1
            ],
            [
                'id' => 2,
                'nom' => 'commune II',
                'district_id' => 1
            ],
            [
                'id' => 3,
                'nom' => 'commune III',
                'district_id' => 1
            ],
            [
                'id' => 4,
                'nom' => 'commune IV',
                'district_id' => 1
            ],
            [
                'id' => 5,
                'nom' => 'commune V',
                'district_id' => 1
            ],
            [
                'id' => 6,
                'nom' => 'commune VI',
                'district_id' => 1
            ],
        ];
        Communedistrict::insert($communes);
    }
}
