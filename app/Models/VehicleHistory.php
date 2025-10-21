<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class VehicleHistory extends Model
{
    protected $fillable = [
        'vehicle_id',
        'action',
        'old_data',
        'new_data',
        'user_name',
        'notes',
    ];

    protected $casts = [
        'old_data' => 'array',
        'new_data' => 'array',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public static function logAction($vehicleId, $action, $oldData = null, $newData = null, $notes = null)
    {
        return static::create([
            'vehicle_id' => $vehicleId,
            'action' => $action,
            'old_data' => $oldData,
            'new_data' => $newData,
            'user_name' => Auth::check() ? Auth::user()->name : 'System',
            'notes' => $notes,
        ]);
    }

    /**
     * Recupera la storia delle immagini per un veicolo specifico
     */
    public static function getImageHistoryForVehicle($vehicleId)
    {
        return static::where('vehicle_id', $vehicleId)
            ->whereNotNull('old_data')
            ->orWhereNotNull('new_data')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($history) {
                return [
                    'id' => $history->id,
                    'vehicle_id' => $history->vehicle_id,
                    'action' => $history->action,
                    'old_images' => $history->old_data['images'] ?? [],
                    'new_images' => $history->new_data['images'] ?? [],
                    'user_name' => $history->user_name,
                    'date' => $history->created_at->format('d/m/Y H:i'),
                    'notes' => $history->notes,
                ];
            });
    }

    /**
     * Recupera tutte le immagini mai utilizzate per un veicolo
     */
    public static function getAllImagesForVehicle($vehicleId)
    {
        $histories = static::where('vehicle_id', $vehicleId)->get();
        $allImages = [];

        foreach ($histories as $history) {
            if (isset($history->old_data['images'])) {
                $allImages = array_merge($allImages, $history->old_data['images']);
            }
            if (isset($history->new_data['images'])) {
                $allImages = array_merge($allImages, $history->new_data['images']);
            }
        }

        return array_unique($allImages);
    }
}
