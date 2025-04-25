<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRecords extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'equipment_id',
        'start_date',
        'end_date',
        'maintenance_type',
        'issue_description',
        'resolution_description',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the equipment that owns the maintenance record.
     */
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}