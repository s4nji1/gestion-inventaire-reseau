<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'equipment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'brand',
        'model',
        'serial_number',
        'mac_address',
        'category_id',
        'status_id',
        'notes',
    ];

    /**
     * Get the category that owns the equipment.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the status that owns the equipment.
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * Get the movements for the equipment.
     */
    public function movements()
    {
        return $this->hasMany(Movement::class);
    }

    /**
     * Get the maintenance records for the equipment.
     */
    public function maintenanceRecords()
    {
        return $this->hasMany(MaintenanceRecords::class);
    }
}