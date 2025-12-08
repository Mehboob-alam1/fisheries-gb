<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;

class DistrictsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            'Gilgit',
            'Skardu',
            'Hunza',
            'Nagar',
            'Ghizer',
            'Diamer',
            'Astore',
            'Ghanche',
            'Shigar',
            'Kharmang',
        ];

        foreach ($districts as $districtName) {
            District::firstOrCreate(
                ['name' => $districtName],
                ['name' => $districtName]
            );
        }

        $this->command->info('Created ' . count($districts) . ' districts.');
    }
}
