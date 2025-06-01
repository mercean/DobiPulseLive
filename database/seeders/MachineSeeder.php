<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Machine;


class MachineSeeder extends Seeder
{
    public function run()
    {
        $types = ['washer', 'dryer'];

        foreach ($types as $type) {
            for ($i = 1; $i <= 6; $i++) {
                Machine::create([
                    'type' => $type,
                    'location' => 'Level ' . ceil($i / 2), // You can customize
                    'status' => 'available',
                ]);
            }
        }
    }
}
