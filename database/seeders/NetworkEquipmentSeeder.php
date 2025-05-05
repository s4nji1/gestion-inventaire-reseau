<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Status;
use App\Models\Equipment;
use Illuminate\Support\Str;

class NetworkEquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create or find statuses
        $availableStatus = Status::firstOrCreate(
            ['slug' => 'available'],
            [
                'name' => 'Available',
                'color' => '#10b981',
                'description' => 'Equipment is available for use'
            ]
        );

        // Create categories
        $ethernetCableCategory = Category::firstOrCreate(
            ['slug' => 'ethernet-cables'],
            [
                'name' => 'Ethernet Cables',
                'description' => 'Copper Ethernet cables for network connectivity'
            ]
        );

        $singlemodeFiberCategory = Category::firstOrCreate(
            ['slug' => 'singlemode-fiber'],
            [
                'name' => 'Singlemode Fiber Optic Cables',
                'description' => 'OS2 Singlemode fiber optic patch cables'
            ]
        );

        $multimodeFiberCategory = Category::firstOrCreate(
            ['slug' => 'multimode-fiber'],
            [
                'name' => 'Multimode Fiber Optic Cables',
                'description' => 'OM3 Multimode fiber optic patch cables'
            ]
        );

        $sfpModuleCategory = Category::firstOrCreate(
            ['slug' => 'sfp-modules'],
            [
                'name' => 'SFP/SFP+ Modules',
                'description' => 'Small form-factor pluggable transceiver modules'
            ]
        );

        $switchCategory = Category::firstOrCreate(
            ['slug' => 'switches'],
            [
                'name' => 'Network Switches',
                'description' => 'Cisco Catalyst Switches for network infrastructure'
            ]
        );

        $accessPointCategory = Category::firstOrCreate(
            ['slug' => 'access-points'],
            [
                'name' => 'Wireless Access Points',
                'description' => 'Cisco WiFi access points for wireless connectivity'
            ]
        );

        // Ethernet Cables
        $ethernetCables = [
            [
                'name' => 'Câble Ethernet CAT6 UTP - 1m',
                'brand' => 'Generic',
                'model' => 'CAT6 UTP',
                'notes' => 'Type: Cuivre, Longueur: 1 mètre, Remarques: RJ45 mâle/mâle'
            ],
            [
                'name' => 'Câble Ethernet CAT6 UTP - 3m',
                'brand' => 'Generic',
                'model' => 'CAT6 UTP',
                'notes' => 'Type: Cuivre, Longueur: 3 mètres, Remarques: RJ45 mâle/mâle'
            ],
            [
                'name' => 'Câble Ethernet CAT6 UTP - 5m',
                'brand' => 'Generic',
                'model' => 'CAT6 UTP',
                'notes' => 'Type: Cuivre, Longueur: 5 mètres, Remarques: RJ45 mâle/mâle'
            ],
            [
                'name' => 'Câble Ethernet CAT6 UTP - 10m',
                'brand' => 'Generic',
                'model' => 'CAT6 UTP',
                'notes' => 'Type: Cuivre, Longueur: 10 mètres, Remarques: RJ45 mâle/mâle'
            ]
        ];

        // Singlemode Fiber Cables
        $singlemodeFibers = [
            [
                'name' => 'Jarretière Fibre Optique Monomode - 1m',
                'brand' => 'Generic',
                'model' => 'OS2',
                'notes' => 'Type: OS2, Longueur: 1 mètre, Remarques: LC/LC, duplex, 9/125 µm'
            ],
            [
                'name' => 'Jarretière Fibre Optique Monomode - 3m',
                'brand' => 'Generic',
                'model' => 'OS2',
                'notes' => 'Type: OS2, Longueur: 3 mètres, Remarques: LC/LC, duplex, 9/125 µm'
            ],
            [
                'name' => 'Jarretière Fibre Optique Monomode - 5m',
                'brand' => 'Generic',
                'model' => 'OS2',
                'notes' => 'Type: OS2, Longueur: 5 mètres, Remarques: LC/LC, duplex, 9/125 µm'
            ],
            [
                'name' => 'Jarretière Fibre Optique Monomode - 10m',
                'brand' => 'Generic',
                'model' => 'OS2',
                'notes' => 'Type: OS2, Longueur: 10 mètres, Remarques: LC/LC, duplex, 9/125 µm'
            ]
        ];

        // Multimode Fiber Cables
        $multimodeFibers = [
            [
                'name' => 'Jarretière Fibre Optique Multimode - 1m',
                'brand' => 'Generic',
                'model' => 'OM3',
                'notes' => 'Type: OM3, Longueur: 1 mètre, Remarques: LC/LC, duplex, 50/125 µm'
            ],
            [
                'name' => 'Jarretière Fibre Optique Multimode - 3m',
                'brand' => 'Generic',
                'model' => 'OM3',
                'notes' => 'Type: OM3, Longueur: 3 mètres, Remarques: LC/LC, duplex, 50/125 µm'
            ],
            [
                'name' => 'Jarretière Fibre Optique Multimode - 5m',
                'brand' => 'Generic',
                'model' => 'OM3',
                'notes' => 'Type: OM3, Longueur: 5 mètres, Remarques: LC/LC, duplex, 50/125 µm'
            ],
            [
                'name' => 'Jarretière Fibre Optique Multimode - 10m',
                'brand' => 'Generic',
                'model' => 'OM3',
                'notes' => 'Type: OM3, Longueur: 10 mètres, Remarques: LC/LC, duplex, 50/125 µm'
            ]
        ];

        // SFP Modules
        $sfpModules = [
            [
                'name' => 'Module SFP Cisco GLC-LH-SM',
                'brand' => 'Cisco',
                'model' => 'GLC-LH-SM',
                'notes' => 'Type: 1G, Débit: 1 Gbps, Portée: 10 km, Fibre: Monomode'
            ],
            [
                'name' => 'Module SFP Cisco GLC-SX-MM',
                'brand' => 'Cisco',
                'model' => 'GLC-SX-MM',
                'notes' => 'Type: 1G, Débit: 1 Gbps, Portée: 550 m, Fibre: Multimode'
            ],
            [
                'name' => 'Module SFP+ Cisco SFP-10G-LR',
                'brand' => 'Cisco',
                'model' => 'SFP-10G-LR',
                'notes' => 'Type: 10G, Débit: 10 Gbps, Portée: 10 km, Fibre: Monomode'
            ],
            [
                'name' => 'Module SFP+ Cisco SFP-10G-SR',
                'brand' => 'Cisco',
                'model' => 'SFP-10G-SR',
                'notes' => 'Type: 10G, Débit: 10 Gbps, Portée: 300 m, Fibre: Multimode'
            ]
        ];

        // Switches
        $switches = [
            [
                'name' => 'Switch Cisco Catalyst 9200 24 ports',
                'brand' => 'Cisco',
                'model' => 'Catalyst 9200',
                'notes' => 'Famille: Catalyst 9200, Ports: 24'
            ],
            [
                'name' => 'Switch Cisco Catalyst 9200 48 ports',
                'brand' => 'Cisco',
                'model' => 'Catalyst 9200',
                'notes' => 'Famille: Catalyst 9200, Ports: 48'
            ],
            [
                'name' => 'Switch Cisco Catalyst 9300 24 ports',
                'brand' => 'Cisco',
                'model' => 'Catalyst 9300',
                'notes' => 'Famille: Catalyst 9300, Ports: 24'
            ],
            [
                'name' => 'Switch Cisco Catalyst 9300 48 ports',
                'brand' => 'Cisco',
                'model' => 'Catalyst 9300',
                'notes' => 'Famille: Catalyst 9300, Ports: 48'
            ],
            [
                'name' => 'Switch Cisco Catalyst 9500 24 ports',
                'brand' => 'Cisco',
                'model' => 'Catalyst 9500',
                'notes' => 'Famille: Catalyst 9500, Ports: 24'
            ],
            [
                'name' => 'Switch Cisco Catalyst 9500 48 ports',
                'brand' => 'Cisco',
                'model' => 'Catalyst 9500',
                'notes' => 'Famille: Catalyst 9500, Ports: 48'
            ]
        ];

        // Access Points
        $accessPoints = [
            [
                'name' => 'Point d\'accès Cisco C9130AXI-E',
                'brand' => 'Cisco',
                'model' => 'C9130AXI-E',
                'notes' => 'Usage: Indoor, Type: Wi-Fi 6, Remarques: Intérieur, antennes intégrées'
            ],
            [
                'name' => 'Point d\'accès Cisco C9124AXE-E',
                'brand' => 'Cisco',
                'model' => 'C9124AXE-E',
                'notes' => 'Usage: Outdoor, Type: Wi-Fi 6, Remarques: Extérieur, antennes externes'
            ],
            [
                'name' => 'Point d\'accès Cisco C9115AXI-E',
                'brand' => 'Cisco',
                'model' => 'C9115AXI-E',
                'notes' => 'Usage: Indoor, Type: Wi-Fi 6, Remarques: Compact, antennes internes'
            ],
            [
                'name' => 'Point d\'accès Cisco AIR-AP2802I-E-K9',
                'brand' => 'Cisco',
                'model' => 'AIR-AP2802I-E-K9',
                'notes' => 'Usage: Indoor, Type: Wi-Fi 5, Remarques: Wave 2, antennes internes, haut débit'
            ]
        ];

        // Add equipment function
        $addEquipment = function($items, $category, $status) {
            foreach ($items as $index => $item) {
                // Check if equipment with this name already exists
                $existingEquipment = Equipment::where('name', $item['name'])->first();
                if (!$existingEquipment) {
                    // Generate a unique serial number
                    $serialPrefix = strtoupper(substr($category->slug, 0, 3));
                    $serialNumber = $serialPrefix . '-' . str_pad($index + 1, 5, '0', STR_PAD_LEFT);
                    
                    // Create the equipment
                    $equipment = Equipment::create([
                        'name' => $item['name'],
                        'brand' => $item['brand'],
                        'model' => $item['model'],
                        'serial_number' => $serialNumber,
                        'category_id' => $category->id,
                        'status_id' => $status->id,
                        'notes' => $item['notes']
                    ]);
                    
                    // Create an initial movement for the equipment
                    \App\Models\Movement::create([
                        'equipment_id' => $equipment->id,
                        'type' => 'entry',
                        'from_status_id' => null,
                        'to_status_id' => $status->id,
                        'notes' => 'Initial entry of equipment',
                    ]);
                }
            }
        };

        // Add all equipment
        $addEquipment($ethernetCables, $ethernetCableCategory, $availableStatus);
        $addEquipment($singlemodeFibers, $singlemodeFiberCategory, $availableStatus);
        $addEquipment($multimodeFibers, $multimodeFiberCategory, $availableStatus);
        $addEquipment($sfpModules, $sfpModuleCategory, $availableStatus);
        $addEquipment($switches, $switchCategory, $availableStatus);
        $addEquipment($accessPoints, $accessPointCategory, $availableStatus);
    }
}