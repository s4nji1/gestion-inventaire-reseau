<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\MaintenanceRecords;
use App\Models\Status;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;

class MaintenanceRecordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        // Get maintenance status
        $maintenanceStatus = Status::where('slug', 'maintenance')->first();
        
        if (!$maintenanceStatus) {
            return; // Skip if maintenance status doesn't exist
        }
        
        // Get equipment that is or has been in maintenance
        $equipment = Equipment::whereHas('movements', function ($query) use ($maintenanceStatus) {
            $query->where('to_status_id', $maintenanceStatus->id);
        })->orWhere('status_id', $maintenanceStatus->id)->get();
        
        // Also add some random equipment for past maintenance
        $additionalEquipment = Equipment::whereNotIn('id', $equipment->pluck('id')->toArray())
            ->inRandomOrder()->limit(5)->get();
        
        $equipment = $equipment->merge($additionalEquipment);
        
        // Maintenance types
        $maintenanceTypes = [
            'Preventive Maintenance',
            'Corrective Maintenance',
            'Repair',
            'Firmware Update',
            'Hardware Upgrade',
            'Configuration Change',
            'Cable Replacement',
            'Diagnostic Test',
            'Cleaning',
            'Security Patch'
        ];
        
        // Common issues by category
        $issuesByCategory = [
            'switches' => [
                'Port failure',
                'Overheating',
                'Configuration reset',
                'Firmware corruption',
                'Power supply failure'
            ],
            'routers' => [
                'Continuous rebooting',
                'Configuration issues',
                'Memory leak',
                'Interface malfunction',
                'Routing table corruption'
            ],
            'access-points' => [
                'Poor signal strength',
                'Connection dropouts',
                'Firmware bug',
                'Power over Ethernet issues',
                'Configuration reset'
            ],
            'servers' => [
                'Disk failure',
                'Memory errors',
                'Failed power supply',
                'Cooling issues',
                'RAID controller error'
            ],
            'default' => [
                'Hardware malfunction',
                'Software issue',
                'Configuration problem',
                'Performance degradation',
                'Connectivity issues'
            ]
        ];
        
        // Resolutions
        $resolutions = [
            'Replaced faulty component',
            'Updated firmware to latest version',
            'Reconfigured settings',
            'Cleaned internal components',
            'Replaced entire unit',
            'Applied software patch',
            'Reseated connections',
            'Reset to factory defaults and reconfigured',
            'No issues found, monitoring',
            'Sent to manufacturer for repair'
        ];
        
        foreach ($equipment as $item) {
            // Determine number of maintenance records (1-3)
            $recordCount = $faker->numberBetween(1, 3);
            
            // Get appropriate issues list based on category
            $categorySlug = $item->category->slug;
            $issues = $issuesByCategory[$categorySlug] ?? $issuesByCategory['default'];
            
            for ($i = 0; $i < $recordCount; $i++) {
                // Determine dates
                $startDate = Carbon::now()->subDays($faker->numberBetween(1, 365));
                
                // Determine status
                $status = $faker->randomElement(['completed', 'completed', 'completed', 'in_progress', 'pending']);
                
                // For completed maintenance, add end date
                $endDate = null;
                $resolutionDescription = null;
                if ($status === 'completed') {
                    $endDate = Carbon::parse($startDate)->addDays($faker->numberBetween(1, 7));
                    $resolutionDescription = $faker->randomElement($resolutions) . '. ' . $faker->sentence();
                }
                
                // Create maintenance record
                MaintenanceRecords::create([
                    'equipment_id' => $item->id,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'maintenance_type' => $faker->randomElement($maintenanceTypes),
                    'issue_description' => $faker->randomElement($issues) . '. ' . $faker->paragraph(),
                    'resolution_description' => $resolutionDescription,
                    'status' => $status,
                    'created_at' => $startDate,
                    'updated_at' => $endDate ?? $startDate,
                ]);
            }
        }
    }
}