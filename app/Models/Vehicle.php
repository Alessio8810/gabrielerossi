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
        // Se viene passato un array meta, estrai la stringa
        if (is_array($imagePath)) {
            $imagePath = $imagePath['url'] ?? $imagePath['original'] ?? '';
        }

        $imagePath = trim((string) $imagePath);

        if ($imagePath === '') {
            return '/images/car-placeholder.jpg';
        }

        // Se è già un URL completo (http/https) prendi l'ultima occorrenza valida
        if (strpos($imagePath, '://') !== false || filter_var($imagePath, FILTER_VALIDATE_URL)) {
            // Se ci sono più schemi (duplicazioni), prendi la sottostringa dall'ultima occorrenza di http(s)://
            if (preg_match_all('#https?://#i', $imagePath, $matches, PREG_OFFSET_CAPTURE)) {
                $last = end($matches[0]);
                $pos = $last[1];
                $imagePath = substr($imagePath, $pos);
            }

            // Codifica spazi
            return str_replace(' ', '%20', $imagePath);
        }

        // Helper per costruire URL codificando i segmenti del path
        $buildUrlFromPath = function(string $path) {
            $clean = preg_replace('#^/+#', '', $path);
            $segments = explode('/', $clean);
            $segments = array_map('rawurlencode', $segments);
            return url(implode('/', $segments));
        };

        // Se inizia con /storage/, genera URL assoluto con public
        if (str_starts_with($imagePath, '/storage/')) {
            return $buildUrlFromPath('public' . $imagePath);
        }

        // Se l'immagine è già un path che contiene 'public/storage', evita duplicazioni
        if (str_contains($imagePath, 'public/storage')) {
            return $buildUrlFromPath($imagePath);
        }

        // Se non inizia con /, aggiungi /public/storage/ e genera URL assoluto
        if (!str_starts_with($imagePath, '/')) {
            return $buildUrlFromPath('public/storage/' . ltrim($imagePath, '/'));
        }

        return $buildUrlFromPath('public' . $imagePath);
    }

    /**
     * Ottiene le immagini formattate con URL corretti
     */
    public function getFormattedImagesAttribute()
    {
        if (empty($this->images)) {
            return [];
        }

        $images = is_string($this->images) ? json_decode($this->images, true) : $this->images;
        
        if (!is_array($images)) {
            return [];
        }
        // Restituisci sempre un array di stringhe con URL (compatibile con le view che si aspettano src come stringa)
        return array_values(array_map(function($image) {
            // Se l'elemento è un array con meta (es. ['original' => ..., 'url' => ...]), estrai l'url
            if (is_array($image)) {
                if (isset($image['url']) && filter_var($image['url'], FILTER_VALIDATE_URL)) {
                    return $image['url'];
                }
                // fallback to 'original' key if present
                $image = $image['original'] ?? '';
            }

            // Normalizza stringhe vuote
            if (empty($image) || !is_string($image)) {
                return null;
            }

            // Se è già un URL completo, usalo così com'è
            if (filter_var($image, FILTER_VALIDATE_URL)) {
                return $image;
            }

            // Se l'immagine è già un path con la struttura organizzata (vehicles/ID/filename)
            if (str_starts_with($image, 'vehicles/' . $this->id . '/')) {
                return url('public/storage/' . ltrim($image, '/'));
            }

            // Se inizia già con '/storage/' evita duplicazioni
            if (str_starts_with($image, '/storage/')) {
                return url('public' . $image);
            }

            // Usa il metodo getImageUrl per compatibilità con le immagini esistenti
            return $this->getImageUrl($image);
        }, $images));
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
