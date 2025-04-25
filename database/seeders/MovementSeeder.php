<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\Movement;
use App\Models\Status;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;

class MovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        // Get all equipment
        $equipment = Equipment::all();
        
        // Get all statuses
        $statuses = Status::all();
        $statusMap = [];
        foreach ($statuses as $status) {
            $statusMap[$status->slug] = $status->id;
        }
        
        // Initial entry movements for all equipment
        foreach ($equipment as $item) {
            // Initial entry - always creating this movement
            Movement::create([
                'equipment_id' => $item->id,
                'type' => 'entry',
                'from_status_id' => null, // Initial entry has no source status
                'to_status_id' => $item->status_id,
                'notes' => 'Initial entry into inventory',
                'created_at' => Carbon::now()->subDays($faker->numberBetween(60, 120)),
                'updated_at' => Carbon::now()->subDays($faker->numberBetween(60, 120)),
            ]);
            
            // Possibly add 0-3 more movement records for each equipment
            $movementCount = $faker->numberBetween(0, 3);
            $lastStatusId = $item->status_id;
            $lastDate = Carbon::now()->subDays($faker->numberBetween(30, 60));
            
            for ($i = 0; $i < $movementCount; $i++) {
                // Select a new status that's different from the last
                $newStatusId = $lastStatusId;
                while ($newStatusId === $lastStatusId) {
                    $newStatusId = $faker->randomElement($statuses)->id;
                }
                
                // Determine movement type based on status
                $newStatus = $statuses->find($newStatusId);
                $type = 'exit'; // Default type
                
                if ($newStatus->slug === 'maintenance') {
                    $type = 'maintenance';
                } elseif (in_array($newStatus->slug, ['available', 'in-use', 'reserved', 'loaned'])) {
                    $type = 'entry';
                }
                
                // Create movement record
                $currentDate = Carbon::parse($lastDate)->addDays($faker->numberBetween(1, 15));
                
                Movement::create([
                    'equipment_id' => $item->id,
                    'type' => $type,
                    'from_status_id' => $lastStatusId,
                    'to_status_id' => $newStatusId,
                    'notes' => $faker->sentence(),
                    'created_at' => $currentDate,
                    'updated_at' => $currentDate,
                ]);
                
                $lastStatusId = $newStatusId;
                $lastDate = $currentDate;
            }
            
            // Update the equipment with the final status if it doesn't match
            if ($item->status_id !== $lastStatusId) {
                $item->status_id = $lastStatusId;
                $item->save();
            }
        }
    }
}