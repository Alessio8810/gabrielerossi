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
}
