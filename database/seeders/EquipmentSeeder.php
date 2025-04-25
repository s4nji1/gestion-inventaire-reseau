<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\Category;
use App\Models\Status;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        // Get category and status IDs
        $categoryIds = Category::pluck('id')->toArray();
        $statusIds = Status::pluck('id')->toArray();
        
        // Sample equipment data
        $equipmentData = [
            // Switches
            [
                'name' => 'Core Switch Building A',
                'brand' => 'Cisco',
                'model' => 'Catalyst 9300',
                'serial_number' => 'FOC' . $faker->unique()->regexify('[A-Z0-9]{8}'),
                'mac_address' => $faker->macAddress(),
                'category_id' => Category::where('slug', 'switches')->first()->id,
                'notes' => 'Main switch for Building A, installed ' . $faker->date(),
            ],
            [
                'name' => 'Access Switch Floor 2',
                'brand' => 'HP',
                'model' => 'Aruba 2930F',
                'serial_number' => 'SG' . $faker->unique()->regexify('[A-Z0-9]{10}'),
                'mac_address' => $faker->macAddress(),
                'category_id' => Category::where('slug', 'switches')->first()->id,
                'notes' => '48-port PoE switch for classrooms',
            ],
            
            // Routers
            [
                'name' => 'Main Router',
                'brand' => 'Juniper',
                'model' => 'MX240',
                'serial_number' => 'JN' . $faker->unique()->regexify('[A-Z0-9]{10}'),
                'mac_address' => $faker->macAddress(),
                'category_id' => Category::where('slug', 'routers')->first()->id,
                'notes' => 'Campus internet router',
            ],
            [
                'name' => 'Department Router',
                'brand' => 'Cisco',
                'model' => '4331',
                'serial_number' => 'FTX' . $faker->unique()->regexify('[A-Z0-9]{8}'),
                'mac_address' => $faker->macAddress(),
                'category_id' => Category::where('slug', 'routers')->first()->id,
                'notes' => 'Engineering department router',
            ],
            
            // Access Points
            [
                'name' => 'Library AP 1',
                'brand' => 'Ubiquiti',
                'model' => 'UniFi AP Pro',
                'serial_number' => $faker->unique()->regexify('[A-Z0-9]{12}'),
                'mac_address' => $faker->macAddress(),
                'category_id' => Category::where('slug', 'access-points')->first()->id,
                'notes' => 'Located near main entrance',
            ],
            [
                'name' => 'Lecture Hall AP',
                'brand' => 'Aruba',
                'model' => 'AP-505',
                'serial_number' => $faker->unique()->regexify('[A-Z0-9]{12}'),
                'mac_address' => $faker->macAddress(),
                'category_id' => Category::where('slug', 'access-points')->first()->id,
                'notes' => 'High-density coverage for lecture hall',
            ],
            
            // Servers
            [
                'name' => 'Database Server',
                'brand' => 'Dell',
                'model' => 'PowerEdge R740',
                'serial_number' => $faker->unique()->regexify('[A-Z0-9]{7}'),
                'mac_address' => $faker->macAddress(),
                'category_id' => Category::where('slug', 'servers')->first()->id,
                'notes' => 'Primary database server',
            ],
            [
                'name' => 'Web Server',
                'brand' => 'HP',
                'model' => 'ProLiant DL380 Gen10',
                'serial_number' => $faker->unique()->regexify('[A-Z0-9]{10}'),
                'mac_address' => $faker->macAddress(),
                'category_id' => Category::where('slug', 'servers')->first()->id,
                'notes' => 'Web applications and CMS',
            ],
            
            // Firewalls
            [
                'name' => 'Main Firewall',
                'brand' => 'Fortinet',
                'model' => 'FortiGate 100F',
                'serial_number' => 'FGT' . $faker->unique()->regexify('[A-Z0-9]{8}'),
                'mac_address' => $faker->macAddress(),
                'category_id' => Category::where('slug', 'firewalls')->first()->id,
                'notes' => 'Primary perimeter firewall',
            ],
            
            // Storage
            [
                'name' => 'Research Data Storage',
                'brand' => 'NetApp',
                'model' => 'FAS8300',
                'serial_number' => $faker->unique()->regexify('[A-Z0-9]{12}'),
                'mac_address' => $faker->macAddress(),
                'category_id' => Category::where('slug', 'storage')->first()->id,
                'notes' => 'Storage for research department data',
            ],
        ];
        
        // Insert equipment with random status
        foreach ($equipmentData as $data) {
            // Assign a random status (but favoring 'Available' and 'In Use')
            $statusSlug = $faker->randomElement(['available', 'available', 'in-use', 'in-use', 'maintenance', 'defective', 'reserved', 'loaned']);
            $status = Status::where('slug', $statusSlug)->first();
            
            Equipment::create([
                'name' => $data['name'],
                'brand' => $data['brand'],
                'model' => $data['model'],
                'serial_number' => $data['serial_number'],
                'mac_address' => $data['mac_address'],
                'category_id' => $data['category_id'],
                'status_id' => $status->id,
                'notes' => $data['notes'],
            ]);
        }
        
        // Create some additional random equipment
        for ($i = 0; $i < 15; $i++) {
            $category = Category::find($faker->randomElement($categoryIds));
            $categoryName = $category->name;
            
            // Generate appropriate model names based on category
            switch ($category->slug) {
                case 'switches':
                    $brands = ['Cisco', 'HP', 'Juniper', 'Aruba', 'Dell'];
                    $models = ['Catalyst 3850', 'Nexus 9300', 'EX4300', '2930F', 'N3248TE-ON'];
                    break;
                case 'routers':
                    $brands = ['Cisco', 'Juniper', 'Mikrotik', 'Fortinet', 'Palo Alto'];
                    $models = ['ISR 4431', 'MX204', 'CCR1036', 'FortiGate 100F', 'PA-3220'];
                    break;
                case 'access-points':
                    $brands = ['Cisco', 'Ubiquiti', 'Aruba', 'Ruckus', 'TP-Link'];
                    $models = ['Aironet 2800', 'UAP-AC-Pro', 'AP-515', 'R720', 'EAP245'];
                    break;
                case 'servers':
                    $brands = ['Dell', 'HP', 'Lenovo', 'Supermicro', 'IBM'];
                    $models = ['PowerEdge R640', 'ProLiant DL360', 'ThinkSystem SR650', 'SuperServer 1029P', 'Power System S922'];
                    break;
                default:
                    $brands = ['HP', 'Dell', 'Cisco', 'IBM', 'Lenovo'];
                    $models = ['X' . $faker->randomNumber(3), 'Pro ' . $faker->randomNumber(4), 'Series ' . $faker->randomLetter() . $faker->randomNumber(2)];
            }
            
            // Assign a random status (but favoring 'Available' and 'In Use')
            $statusSlug = $faker->randomElement(['available', 'available', 'in-use', 'in-use', 'maintenance', 'defective', 'reserved', 'loaned']);
            $status = Status::where('slug', $statusSlug)->first();
            
            Equipment::create([
                'name' => $categoryName . ' ' . $faker->randomNumber(2),
                'brand' => $faker->randomElement($brands),
                'model' => $faker->randomElement($models),
                'serial_number' => $faker->unique()->regexify('[A-Z0-9]{10}'),
                'mac_address' => $faker->boolean(80) ? $faker->macAddress() : null, 
                'category_id' => $category->id,
                'status_id' => $status->id,
                'notes' => $faker->boolean(70) ? $faker->sentence(6) : null,
            ]);
        }
    }
}