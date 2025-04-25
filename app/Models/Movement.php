<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'equipment_id',
        'type',
        'from_status_id',
        'to_status_id',
        'notes',
    ];

    /**
     * Get the equipment that owns the movement.
     */
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    /**
     * Get the source status of the movement.
     */
    public function fromStatus()
    {
        return $this->belongsTo(Status::class, 'from_status_id');
    }

    /**
     * Get the destination status of the movement.
     */
    public function toStatus()
    {
        return $this->belongsTo(Status::class, 'to_status_id');
    }
}
