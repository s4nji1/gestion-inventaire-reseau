<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'color',
        'description',
    ];

    /**
     * Get the equipment for the status.
     */
    public function equipment()
    {
        return $this->hasMany(Equipment::class);
    }

    /**
     * Get the movements with this status as the source.
     */
    public function fromMovements()
    {
        return $this->hasMany(Movement::class, 'from_status_id');
    }

    /**
     * Get the movements with this status as the destination.
     */
    public function toMovements()
    {
        return $this->hasMany(Movement::class, 'to_status_id');
    }
}