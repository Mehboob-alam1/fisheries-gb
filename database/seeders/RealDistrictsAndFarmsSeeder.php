<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Farm;
use Illuminate\Database\Seeder;

class RealDistrictsAndFarmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districtsAndFarms = [
            'Gilgit' => [
                'Model Trout Farm Kargah Gilgit',
                'Trout Hatchery Kargah',
                'Trout Hatchery Nalter',
                'Bargain Trout Hatchery',
                'Trout Hatchery Ghoru Juglot',
            ],
            'Skardu' => [
                'Carp Farm Banji Gilgit',
                'Trout Hatchery Hosho',
                'Sundus Bio-Diversity Trout Hatchery',
            ],
            'Kharmang' => [
                'Manthoka Fish Farm',
            ],
            'Ghanche' => [
                'Trout Hatchery Barah',
                'Trout Hatchery Sogha',
                'Snow Trout Hatchery Sogha',
                'Trout Park Mandig Saltoro Ghanche',
            ],
            'Astore' => [
                'Trout Hatchery Kharbay',
            ],
            'Diamer' => [
                'Trout Hatchery Bulusiber',
                'Muthkay Parashing Fish Farm',
                'Trout Hatchery Darel',
                'Brown Trout Hatchery Chilas',
                'Trout Hatchery Khanbari',
                'Ronai Carp Fish Farm',
            ],
            'Ghizer' => [
                'Demo Trout Hatchery Derani Sherqillah',
                'Model Trout Hatchery Sherqillah',
                'Model Trout Farm Attash Yasin',
                'Brown Trout Hatchery Khutim Khalti',
            ],
            'Nagar' => [
                'Thol Mascot Trout Hatchery Nagar',
            ],
            'Shigar' => [
                'Nialsho Trout Hatchery',
            ],
        ];

        foreach ($districtsAndFarms as $districtName => $farms) {
            // Create or get district
            $district = District::firstOrCreate(['name' => $districtName]);

            // Create farms for this district
            foreach ($farms as $farmName) {
                Farm::firstOrCreate(
                    [
                        'district_id' => $district->id,
                        'name' => $farmName,
                    ],
                    [
                        'district_id' => $district->id,
                        'name' => $farmName,
                        'manager_id' => null, // Will be assigned when manager is created
                        'location' => null,
                    ]
                );
            }
        }

        $totalDistricts = count($districtsAndFarms);
        $totalFarms = array_sum(array_map('count', $districtsAndFarms));

        $this->command->info("Created {$totalDistricts} districts with {$totalFarms} farms.");
    }
}
