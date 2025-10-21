<?php

namespace App\Livewire\Admin;

use App\Models\Brand;
use App\Models\Vehicle;
use App\Models\VehicleHistory;
use Livewire\Component;
use Livewire\WithPagination;

class VehicleManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedBrand = '';
    public $selectedCondition = '';
    public $showActiveOnly = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedBrand' => ['except' => ''],
        'selectedCondition' => ['except' => ''],
        'showActiveOnly' => ['except' => false],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedBrand()
    {
        $this->resetPage();
    }

    public function updatingSelectedCondition()
    {
        $this->resetPage();
    }

    public function updatingShowActiveOnly()
    {
        $this->resetPage();
    }

    public function toggleVehicleStatus($vehicleId)
    {
        $vehicle = Vehicle::findOrFail($vehicleId);
        $oldStatus = $vehicle->is_active;
        $vehicle->is_active = !$vehicle->is_active;
        $vehicle->save();

        // Log dell'azione
        VehicleHistory::logAction(
            $vehicleId,
            'status_changed',
            ['is_active' => $oldStatus],
            ['is_active' => $vehicle->is_active],
            'Stato modificato da admin'
        );

        session()->flash('message', 'Stato del veicolo aggiornato con successo.');
    }

    public function deleteVehicle($vehicleId)
    {
        $vehicle = Vehicle::findOrFail($vehicleId);
        
        // Log dell'azione prima di eliminare
        VehicleHistory::logAction(
            $vehicleId,
            'deleted',
            $vehicle->toArray(),
            null,
            'Veicolo eliminato da admin'
        );

        $vehicle->delete();
        session()->flash('message', 'Veicolo eliminato con successo.');
    }

    public function render()
    {
        $query = Vehicle::with(['brand', 'carModel'])
            ->when($this->search, function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhereHas('brand', function($brand) {
                      $brand->where('name', 'like', '%' . $this->search . '%');
                  })
                  ->orWhereHas('carModel', function($model) {
                      $model->where('name', 'like', '%' . $this->search . '%');
                  });
            })
            ->when($this->selectedBrand, function($q) {
                $q->where('brand_id', $this->selectedBrand);
            })
            ->when($this->selectedCondition, function($q) {
                $q->where('condition', $this->selectedCondition);
            })
            ->when($this->showActiveOnly, function($q) {
                $q->where('is_active', true);
            })
            ->orderBy('created_at', 'desc');

        $vehicles = $query->paginate(10);
        $brands = Brand::active()->orderBy('name')->get();

        return view('livewire.admin.vehicle-management', [
            'vehicles' => $vehicles,
            'brands' => $brands,
        ]);
    }
}
