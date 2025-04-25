<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'name' => 'Available',
                'color' => '#10b981', // green
                'description' => 'Equipment is available and operational'
            ],
            [
                'name' => 'In Use',
                'color' => '#3b82f6', // blue
                'description' => 'Equipment is currently in use'
            ],
            [
                'name' => 'Maintenance',
                'color' => '#f59e0b', // amber
                'description' => 'Equipment is under maintenance'
            ],
            [
                'name' => 'Defective',
                'color' => '#ef4444', // red
                'description' => 'Equipment is defective and needs repair'
            ],
            [
                'name' => 'Reserved',
                'color' => '#8b5cf6', // purple
                'description' => 'Equipment is reserved for future use'
            ],
            [
                'name' => 'Obsolete',
                'color' => '#6b7280', // gray
                'description' => 'Equipment is outdated and scheduled for replacement'
            ],
            [
                'name' => 'Loaned',
                'color' => '#0ea5e9', // sky blue
                'description' => 'Equipment is temporarily loaned out'
            ],
            [
                'name' => 'Disposed',
                'color' => '#4b5563', // dark gray
                'description' => 'Equipment has been disposed or recycled'
            ],
        ];

        foreach ($statuses as $status) {
            Status::create([
                'name' => $status['name'],
                'slug' => Str::slug($status['name']),
                'color' => $status['color'],
                'description' => $status['description'],
            ]);
        }
    }
}