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
        // Use real districts from Gilgit-Baltistan
        $districts = [
            'Gilgit',
            'Skardu',
            'Kharmang',
            'Ghanche',
            'Astore',
            'Diamer',
            'Ghizer',
            'Nagar',
            'Shigar',
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
