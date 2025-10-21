<?php

namespace App\Livewire\Admin;

use App\Models\Vehicle;
use App\Models\Brand;
use App\Models\VehicleHistory;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public function render()
    {
        // Statistiche principali
        $totalVehicles = Vehicle::count();
        $activeVehicles = Vehicle::where('is_active', true)->count();
        $featuredVehicles = Vehicle::where('is_featured', true)->count();
        $totalInventoryValue = Vehicle::where('is_active', true)->sum('price');
        
        // Veicoli per condizione
        $newVehicles = Vehicle::where('condition', 'new')->count();
        $usedVehicles = Vehicle::where('condition', 'used')->count();
        
        // Top 5 brand per numero di veicoli
        $topBrands = Vehicle::select('brand_id', DB::raw('count(*) as total'))
            ->with('brand')
            ->groupBy('brand_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        
        // Ultimi 5 veicoli aggiunti
        $recentVehicles = Vehicle::with(['brand', 'carModel'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Attività recenti (ultimi 10 log)
        $recentActivities = VehicleHistory::with('vehicle')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Veicoli per fascia di prezzo
        $priceRanges = [
            '0-10k' => Vehicle::where('price', '<', 10000)->count(),
            '10k-20k' => Vehicle::whereBetween('price', [10000, 20000])->count(),
            '20k-30k' => Vehicle::whereBetween('price', [20000, 30000])->count(),
            '30k-50k' => Vehicle::whereBetween('price', [30000, 50000])->count(),
            '50k+' => Vehicle::where('price', '>=', 50000)->count(),
        ];

        return view('livewire.admin.dashboard', [
            'totalVehicles' => $totalVehicles,
            'activeVehicles' => $activeVehicles,
            'featuredVehicles' => $featuredVehicles,
            'totalInventoryValue' => $totalInventoryValue,
            'newVehicles' => $newVehicles,
            'usedVehicles' => $usedVehicles,
            'topBrands' => $topBrands,
            'recentVehicles' => $recentVehicles,
            'recentActivities' => $recentActivities,
            'priceRanges' => $priceRanges,
        ]);
    }
}
