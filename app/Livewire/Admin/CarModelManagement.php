<?php

namespace App\Livewire\Admin;

use App\Models\Brand;
use App\Models\CarModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class CarModelManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $filterBrand = '';
    public $confirmingModelDeletion = false;
    public $modelToDelete = null;
    public $deleteError = '';

    protected $queryString = ['search', 'filterBrand'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterBrand()
    {
        $this->resetPage();
    }

    public function confirmDelete($modelId)
    {
        $model = CarModel::withCount('vehicles')->find($modelId);
        
        if ($model && $model->vehicles_count > 0) {
            $this->deleteError = "Impossibile eliminare questo modello perché ha {$model->vehicles_count} veicoli associati. Elimina prima i veicoli.";
            $this->confirmingModelDeletion = true;
            $this->modelToDelete = null;
        } else {
            $this->deleteError = '';
            $this->modelToDelete = $modelId;
            $this->confirmingModelDeletion = true;
        }
    }

    public function deleteModel()
    {
        if ($this->modelToDelete) {
            $model = CarModel::withCount('vehicles')->find($this->modelToDelete);
            
            if ($model && $model->vehicles_count === 0) {
                $model->delete();
                session()->flash('success', 'Modello eliminato con successo.');
            }
        }

        $this->confirmingModelDeletion = false;
        $this->modelToDelete = null;
        $this->deleteError = '';
    }

    public function cancelDelete()
    {
        $this->confirmingModelDeletion = false;
        $this->modelToDelete = null;
        $this->deleteError = '';
    }

    public function render()
    {
        $models = CarModel::query()
            ->with('brand')
            ->withCount('vehicles')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhereHas('brand', function ($brandQuery) {
                          $brandQuery->where('name', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->when($this->filterBrand, function ($query) {
                $query->where('brand_id', $this->filterBrand);
            })
            ->latest()
            ->paginate(20);

        $brands = Brand::active()->orderBy('name')->get();

        return view('livewire.admin.car-model-management', [
            'models' => $models,
            'brands' => $brands,
        ]);
    }
}
