<?php

namespace App\Livewire\Admin;

use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Vehicle;
use App\Models\VehicleHistory;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class VehicleForm extends Component
{
    use WithFileUploads;

    public $vehicleId;
    public $title;
    public $description;
    public $brand_id;
    public $car_model_id;
    public $year;
    public $mileage;
    public $price;
    public $condition = 'used';
    public $fuel_type = 'gasoline';
    public $transmission = 'Manuale';
    public $body_type;
    public $color;
    public $is_active = true;
    public $is_featured = false;
    public $images = [];
    public $newImages = [];

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'brand_id' => 'required|exists:brands,id',
        'car_model_id' => 'required|exists:car_models,id',
        'year' => 'required|integer|min:1990|max:2030',
        'mileage' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0',
        'condition' => 'required|in:new,used',
        'fuel_type' => 'required|in:gasoline,diesel,electric,hybrid',
        'transmission' => 'required|string',
        'body_type' => 'nullable|string',
        'color' => 'nullable|string',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'newImages.*' => 'image|max:2048', // 2MB Max
    ];

    public function mount($vehicleId = null)
    {
        if ($vehicleId) {
            $this->vehicleId = $vehicleId;
            $this->loadVehicle();
        }
    }

    public function loadVehicle()
    {
        $vehicle = Vehicle::findOrFail($this->vehicleId);
        
        $this->title = $vehicle->title;
        $this->description = $vehicle->description;
        $this->brand_id = $vehicle->brand_id;
        $this->car_model_id = $vehicle->car_model_id;
        $this->year = $vehicle->year;
        $this->mileage = $vehicle->mileage;
        $this->price = $vehicle->price;
        $this->condition = $vehicle->condition;
        $this->fuel_type = $vehicle->fuel_type;
        $this->transmission = $vehicle->transmission;
        $this->body_type = $vehicle->body_type;
        $this->color = $vehicle->color;
        $this->is_active = $vehicle->is_active;
        $this->is_featured = $vehicle->is_featured;
        $this->images = $vehicle->images ?? [];
    }

    public function updatedBrandId()
    {
        $this->car_model_id = '';
    }

    public function getFormattedImagesProperty()
    {
        if (!$this->images) {
            return [];
        }
        
        // Se stiamo modificando un veicolo esistente, usa il metodo del modello
        if ($this->vehicleId) {
            $vehicle = Vehicle::find($this->vehicleId);
            if ($vehicle) {
                return array_map([$vehicle, 'getImageUrl'], $this->images);
            }
        }
        
        // Altrimenti formatta manualmente
        return array_map(function ($image) {
            // Se è già un URL completo (incluso quelli con public/storage), restituiscilo così com'è
            if (filter_var($image, FILTER_VALIDATE_URL)) {
                return $image;
            }
            // Se inizia con /storage/, genera URL assoluto con public
            if (str_starts_with($image, '/storage/')) {
                return url('public' . $image);
            }
            // Altrimenti aggiungi /public/storage/ e genera URL assoluto
            return url('public/storage/' . ltrim($image, '/'));
        }, $this->images);
    }

    public function removeImage($index)
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
    }

    public function removeNewImage($index)
    {
        unset($this->newImages[$index]);
        $this->newImages = array_values($this->newImages);
    }

    /**
     * Carica le immagini per un veicolo specifico con struttura cartelle organizzata
     */
    private function uploadImagesForVehicle($vehicleId)
    {
        $uploadedImages = [];
        
        foreach ($this->newImages as $index => $image) {
            // Genera nome file descrittivo: vehicleId_timestamp_index.extension
            $extension = $image->getClientOriginalExtension();
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $fileName = $vehicleId . '_' . $originalName . '_' . time() . '_' . $index . '.' . $extension;
            
            // Percorso cartella: vehicles/vehicleId/
            $folderPath = 'vehicles/' . $vehicleId;
            
            // Salva il file nella cartella specifica del veicolo
            $path = $image->storeAs($folderPath, $fileName, 'public');
            
            // Salva il path relativo (es. vehicles/{id}/{file}) nel DB. La risoluzione a URL assoluto
            // viene fatta dal model tramite getImageUrl() / formatted_images
            $uploadedImages[] = $path;
        }
        
        return $uploadedImages;
    }

    public function save()
    {
        $this->validate();

        // Prepara i dati del veicolo senza immagini
        $vehicleData = [
            'title' => $this->title,
            'description' => $this->description,
            'brand_id' => $this->brand_id,
            'car_model_id' => $this->car_model_id,
            'year' => $this->year,
            'mileage' => $this->mileage,
            'price' => $this->price,
            'condition' => $this->condition,
            'fuel_type' => $this->fuel_type,
            'transmission' => $this->transmission,
            'body_type' => $this->body_type,
            'color' => $this->color,
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
            'images' => $this->images, // Immagini esistenti per ora
        ];

        if ($this->vehicleId) {
            // Update existing vehicle
            $vehicle = Vehicle::findOrFail($this->vehicleId);
            $oldData = $vehicle->toArray();
            $oldImages = $vehicle->images ?? [];
            
            $vehicle->update($vehicleData);
            
            // Handle new image uploads for existing vehicle
            $uploadedImages = $this->uploadImagesForVehicle($vehicle->id);
            $allImages = array_merge($this->images, $uploadedImages);
            
            // Update vehicle with new images
            $vehicle->update(['images' => $allImages]);

            // Verifica se le immagini sono cambiate
            $imagesChanged = json_encode($oldImages) !== json_encode($allImages);

            // Log generale per tutte le modifiche
            VehicleHistory::logAction(
                $this->vehicleId,
                'updated',
                $oldData,
                array_merge($vehicleData, ['images' => $allImages]),
                'Veicolo aggiornato da admin'
            );

            // Log specifico per le immagini se sono cambiate
            if ($imagesChanged) {
                VehicleHistory::logAction(
                    $this->vehicleId,
                    'images_updated',
                    ['images' => $oldImages],
                    ['images' => $allImages],
                    sprintf('Immagini modificate: da %d a %d immagini', count($oldImages), count($allImages))
                );
            }

            session()->flash('message', 'Veicolo aggiornato con successo.');
        } else {
            // Create new vehicle first without images
            $vehicle = Vehicle::create($vehicleData);
            
            // Now handle image uploads with the vehicle ID
            $uploadedImages = $this->uploadImagesForVehicle($vehicle->id);
            $allImages = array_merge($this->images, $uploadedImages);
            
            // Update vehicle with images
            $vehicle->update(['images' => $allImages]);

            VehicleHistory::logAction(
                $vehicle->id,
                'created',
                null,
                array_merge($vehicleData, ['images' => $allImages]),
                'Veicolo creato da admin'
            );

            // Log specifico per le immagini iniziali
            if (!empty($allImages)) {
                VehicleHistory::logAction(
                    $vehicle->id,
                    'images_added',
                    ['images' => []],
                    ['images' => $allImages],
                    sprintf('Aggiunte %d immagini iniziali', count($allImages))
                );
            }

            session()->flash('message', 'Veicolo creato con successo.');
        }

        return redirect()->route('admin.vehicles');
    }

    public function render()
    {
        $brands = Brand::active()->orderBy('name')->get();
        $carModels = $this->brand_id ? CarModel::where('brand_id', $this->brand_id)->active()->orderBy('name')->get() : collect();

        return view('livewire.admin.vehicle-form', [
            'brands' => $brands,
            'carModels' => $carModels,
        ]);
    }
}
