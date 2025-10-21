<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    protected $fillable = [
        'brand_id',
        'car_model_id',
        'title',
        'description',
        'year',
        'mileage',
        'price',
        'condition',
        'fuel_type',
        'transmission',
        'body_type',
        'color',
        'images',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'images' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function carModel(): BelongsTo
    {
        return $this->belongsTo(CarModel::class);
    }

    public function histories(): HasMany
    {
        return $this->hasMany(VehicleHistory::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeCondition($query, $condition)
    {
        return $query->where('condition', $condition);
    }

    public function scopePriceBetween($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    public function scopeYearBetween($query, $min, $max)
    {
        return $query->whereBetween('year', [$min, $max]);
    }

    public function getFormattedPriceAttribute()
    {
        return '€ ' . number_format($this->price, 0, ',', '.');
    }

    public function getMainImageAttribute()
    {
        if ($this->images && count($this->images) > 0) {
            return $this->getImageUrl($this->images[0]);
        }
        return '/images/car-placeholder.jpg';
    }

    /**
     * Ottiene l'URL corretto per un'immagine
     */
    public function getImageUrl($imagePath)
    {
        // Se è già un URL completo (http/https), restituiscilo così com'è
        if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
            return $imagePath;
        }
        
        // Se inizia con /storage/, genera URL assoluto
        if (str_starts_with($imagePath, '/storage/')) {
            return url($imagePath);
        }
        
        // Se non inizia con /, aggiungi /storage/ e genera URL assoluto
        if (!str_starts_with($imagePath, '/')) {
            return url('storage/' . $imagePath);
        }
        
        return url($imagePath);
    }

    /**
     * Ottiene tutte le immagini con URL corretti
     */
    public function getFormattedImagesAttribute()
    {
        if (!$this->images) {
            return [];
        }
        
        return array_map(function ($image) {
            return $this->getImageUrl($image);
        }, $this->images);
    }

    /**
     * Recupera la storia delle modifiche alle immagini di questo veicolo
     */
    public function getImageHistory()
    {
        return VehicleHistory::getImageHistoryForVehicle($this->id);
    }

    /**
     * Recupera tutte le immagini mai utilizzate per questo veicolo
     */
    public function getAllHistoricalImages()
    {
        return VehicleHistory::getAllImagesForVehicle($this->id);
    }
}
