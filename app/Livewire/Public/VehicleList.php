<?php

namespace App\Livewire\Public;

use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Vehicle;
use Livewire\Component;
use Livewire\WithPagination;

class VehicleList extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedBrand = '';
    public $selectedModel = '';
    public $selectedCondition = '';
    public $minPrice = '';
    public $maxPrice = '';
    public $minYear = '';
    public $maxYear = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedBrand' => ['except' => ''],
        'selectedModel' => ['except' => ''],
        'selectedCondition' => ['except' => ''],
        'minPrice' => ['except' => ''],
        'maxPrice' => ['except' => ''],
        'minYear' => ['except' => ''],
        'maxYear' => ['except' => ''],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectedBrand()
    {
        $this->selectedModel = '';
        $this->resetPage();
    }

    public function updatingSelectedModel()
    {
        $this->resetPage();
    }

    public function updatingSelectedCondition()
    {
        $this->resetPage();
    }

    public function updatingMinPrice()
    {
        $this->resetPage();
    }

    public function updatingMaxPrice()
    {
        $this->resetPage();
    }

    public function updatingMinYear()
    {
        $this->resetPage();
    }

    public function updatingMaxYear()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->selectedBrand = '';
        $this->selectedModel = '';
        $this->selectedCondition = '';
        $this->minPrice = '';
        $this->maxPrice = '';
        $this->minYear = '';
        $this->maxYear = '';
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $query = Vehicle::with(['brand', 'carModel'])
            ->active()
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
            ->when($this->selectedModel, function($q) {
                $q->where('car_model_id', $this->selectedModel);
            })
            ->when($this->selectedCondition, function($q) {
                $q->where('condition', $this->selectedCondition);
            })
            ->when($this->minPrice, function($q) {
                $q->where('price', '>=', $this->minPrice);
            })
            ->when($this->maxPrice, function($q) {
                $q->where('price', '<=', $this->maxPrice);
            })
            ->when($this->minYear, function($q) {
                $q->where('year', '>=', $this->minYear);
            })
            ->when($this->maxYear, function($q) {
                $q->where('year', '<=', $this->maxYear);
            })
            ->orderBy($this->sortBy, $this->sortDirection);

        $vehicles = $query->paginate(12);
        $brands = Brand::active()->orderBy('name')->get();
        $carModels = $this->selectedBrand ? 
            CarModel::where('brand_id', $this->selectedBrand)->active()->orderBy('name')->get() : 
            collect();

        return view('livewire.public.vehicle-list', [
            'vehicles' => $vehicles,
            'brands' => $brands,
            'carModels' => $carModels,
        ]);
    }
}
