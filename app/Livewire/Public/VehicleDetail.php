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
        $this->selectedImage = $index;
    }

    public function render()
    {
        return view('livewire.public.vehicle-detail');
    }
}
