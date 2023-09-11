<?php

namespace Database\Seeders;

use App\Models\Aliment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlimentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Aliment::insert([
           ['nom' => 'Sabalagnon'],
           ['nom' => 'Skretting 1,2mm'],
           ['nom' => 'Skretting 1,8mm'],
           ['nom' => 'Skretting 2mm'],
           ['nom' => 'Skretting 4mm'],
           ['nom' => 'Autre'],
        ]);
    }
}
