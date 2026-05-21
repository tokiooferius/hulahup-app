<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'canteen_id',
        'name',
        'category',
        'price',
        'description',
        'image_url',
        'rating',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'rating' => 'decimal:1',
    ];

    /**
     * Get the canteen this menu belongs to
     */
    public function canteen()
    {
        return $this->belongsTo(Canteen::class);
    }
}
