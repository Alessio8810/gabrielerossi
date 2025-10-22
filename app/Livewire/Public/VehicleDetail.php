<?php

namespace App\Livewire\Public;

use App\Models\Vehicle;
use Livewire\Component;

class VehicleDetail extends Component
{
    public $vehicleId;
    public $vehicle;
    public $selectedImage = 0;

    public function mount($vehicleId)
    {
        $this->vehicleId = $vehicleId;
        $this->vehicle = Vehicle::with(['brand', 'carModel'])->findOrFail($vehicleId);
    }

    public function selectImage($index)
    {
        // Assicura che l'indice sia un intero >= 0
        $index = (int) $index;

        $images = $this->vehicle->formatted_images ?? $this->vehicle->images ?? [];
        $count = is_array($images) ? count($images) : 0;

        if ($count === 0) {
            $this->selectedImage = 0;
            return;
        }

        // Clamp index nel range disponibile
        if ($index < 0) {
            $index = 0;
        }
        if ($index >= $count) {
            $index = $count - 1;
        }

        $this->selectedImage = $index;
    }

    public function render()
    {
        return view('livewire.public.vehicle-detail');
    }
}
