<?php

namespace App\Livewire\Admin;

use App\Models\Brand;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class BrandManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $confirmingBrandDeletion = false;
    public $brandToDelete = null;
    public $deleteError = '';

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleStatus($brandId)
    {
        $brand = Brand::find($brandId);
        if ($brand) {
            $brand->is_active = !$brand->is_active;
            $brand->save();
            session()->flash('success', 'Stato del marchio aggiornato.');
        }
    }

    public function confirmDelete($brandId)
    {
        $brand = Brand::withCount('vehicles')->find($brandId);
        
        if ($brand && $brand->vehicles_count > 0) {
            $this->deleteError = "Impossibile eliminare questo marchio perché ha {$brand->vehicles_count} veicoli associati. Elimina prima i veicoli.";
            $this->confirmingBrandDeletion = true;
            $this->brandToDelete = null;
        } else {
            $this->deleteError = '';
            $this->brandToDelete = $brandId;
            $this->confirmingBrandDeletion = true;
        }
    }

    public function deleteBrand()
    {
        if ($this->brandToDelete) {
            $brand = Brand::withCount('vehicles')->find($this->brandToDelete);
            
            if ($brand && $brand->vehicles_count === 0) {
                $brand->delete();
                session()->flash('success', 'Marchio eliminato con successo.');
            }
        }

        $this->confirmingBrandDeletion = false;
        $this->brandToDelete = null;
        $this->deleteError = '';
    }

    public function cancelDelete()
    {
        $this->confirmingBrandDeletion = false;
        $this->brandToDelete = null;
        $this->deleteError = '';
    }

    public function render()
    {
        $brands = Brand::query()
            ->withCount('vehicles')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('slug', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(15);

        return view('livewire.admin.brand-management', [
            'brands' => $brands,
        ]);
    }
}
