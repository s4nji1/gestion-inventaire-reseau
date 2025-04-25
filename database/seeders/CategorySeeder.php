<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Switches',
                'description' => 'Network switches for connecting devices within local area networks'
            ],
            [
                'name' => 'Routers',
                'description' => 'Devices that connect multiple networks and route network traffic'
            ],
            [
                'name' => 'Access Points',
                'description' => 'Wireless access points for WiFi connectivity'
            ],
            [
                'name' => 'Servers',
                'description' => 'Computer servers for hosting applications and services'
            ],
            [
                'name' => 'Firewalls',
                'description' => 'Security devices that monitor and filter network traffic'
            ],
            [
                'name' => 'Cables',
                'description' => 'Network cables including ethernet, fiber optic, etc.'
            ],
            [
                'name' => 'UPS',
                'description' => 'Uninterruptible Power Supplies for backup power'
            ],
            [
                'name' => 'Storage',
                'description' => 'Network attached storage and storage area network devices'
            ],
            [
                'name' => 'Racks',
                'description' => 'Equipment racks and cabinets for mounting devices'
            ],
            [
                'name' => 'Other',
                'description' => 'Miscellaneous network equipment and accessories'
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
            ]);
        }
    }
}