<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "\n=== Database Overview ===\n\n";

// Users
$users = \App\Models\User::all();
echo "Users (" . $users->count() . "):\n";
foreach ($users as $user) {
    echo "  - {$user->name} ({$user->email}) - Role: {$user->role}\n";
}

// Districts
$districts = \App\Models\District::all();
echo "\nDistricts (" . $districts->count() . "):\n";
foreach ($districts as $district) {
    echo "  - {$district->name}\n";
}

// Farms
$farms = \App\Models\Farm::with(['district', 'manager'])->get();
echo "\nFarms (" . $farms->count() . "):\n";
foreach ($farms as $farm) {
    echo "  - {$farm->name} (District: {$farm->district->name}, Manager: {$farm->manager->name})\n";
}

// Entries
$entries = \App\Models\Entry::with('farm')->get();
echo "\nEntries (" . $entries->count() . "):\n";
foreach ($entries as $entry) {
    echo "  - Farm: {$entry->farm->name}, Date: {$entry->date}, Stock: {$entry->fish_stock}\n";
}

echo "\n=== End ===\n\n";

