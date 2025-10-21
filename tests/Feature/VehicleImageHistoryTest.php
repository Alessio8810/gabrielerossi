<?php

namespace Tests\Feature;

use App\Models\Vehicle;
use App\Models\VehicleHistory;
use App\Models\Brand;
use App\Models\CarModel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VehicleImageHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_vehicle_image_history_tracking()
    {
        // Crea un veicolo di test
        $brand = Brand::factory()->create();
        $model = CarModel::factory()->create(['brand_id' => $brand->id]);
        
        $vehicle = Vehicle::create([
            'brand_id' => $brand->id,
            'car_model_id' => $model->id,
            'title' => 'Test Vehicle',
            'year' => 2020,
            'mileage' => 50000,
            'price' => 15000,
            'condition' => 'used',
            'fuel_type' => 'gasoline',
            'transmission' => 'Manuale',
            'is_active' => true,
            'is_featured' => false,
            'images' => ['/storage/vehicles/image1.jpg', '/storage/vehicles/image2.jpg']
        ]);

        // Log della creazione
        VehicleHistory::logAction(
            $vehicle->id,
            'created',
            null,
            $vehicle->toArray(),
            'Veicolo creato con immagini iniziali'
        );

        // Simula un aggiornamento delle immagini
        $oldImages = $vehicle->images;
        $newImages = ['/storage/vehicles/image1.jpg', '/storage/vehicles/image3.jpg', '/storage/vehicles/image4.jpg'];
        
        $vehicle->update(['images' => $newImages]);

        VehicleHistory::logAction(
            $vehicle->id,
            'images_updated',
            ['images' => $oldImages],
            ['images' => $newImages],
            'Immagini modificate: rimossa image2.jpg, aggiunte image3.jpg e image4.jpg'
        );

        // Test: recupera la storia delle immagini per questo veicolo
        $imageHistory = $vehicle->getImageHistory();
        
        $this->assertCount(2, $imageHistory);
        
        // Verifica che ogni record contenga l'ID del veicolo corretto
        foreach ($imageHistory as $history) {
            $this->assertEquals($vehicle->id, $history['vehicle_id']);
        }

        // Test: recupera tutte le immagini storiche
        $allHistoricalImages = $vehicle->getAllHistoricalImages();
        
        $expectedImages = [
            '/storage/vehicles/image1.jpg',
            '/storage/vehicles/image2.jpg',
            '/storage/vehicles/image3.jpg',
            '/storage/vehicles/image4.jpg'
        ];
        
        foreach ($expectedImages as $expectedImage) {
            $this->assertContains($expectedImage, $allHistoricalImages);
        }
    }

    public function test_multiple_vehicles_image_history_separation()
    {
        $brand = Brand::factory()->create();
        $model = CarModel::factory()->create(['brand_id' => $brand->id]);
        
        // Crea due veicoli diversi
        $vehicle1 = Vehicle::factory()->create([
            'brand_id' => $brand->id,
            'car_model_id' => $model->id,
            'images' => ['/storage/vehicles/vehicle1_image1.jpg']
        ]);
        
        $vehicle2 = Vehicle::factory()->create([
            'brand_id' => $brand->id,
            'car_model_id' => $model->id,
            'images' => ['/storage/vehicles/vehicle2_image1.jpg']
        ]);

        // Log per veicolo 1
        VehicleHistory::logAction(
            $vehicle1->id,
            'created',
            null,
            $vehicle1->toArray()
        );

        // Log per veicolo 2
        VehicleHistory::logAction(
            $vehicle2->id,
            'created',
            null,
            $vehicle2->toArray()
        );

        // Verifica che ogni veicolo abbia solo la sua storia
        $vehicle1History = VehicleHistory::getImageHistoryForVehicle($vehicle1->id);
        $vehicle2History = VehicleHistory::getImageHistoryForVehicle($vehicle2->id);

        $this->assertCount(1, $vehicle1History);
        $this->assertCount(1, $vehicle2History);

        // Verifica che gli ID siano corretti
        $this->assertEquals($vehicle1->id, $vehicle1History->first()['vehicle_id']);
        $this->assertEquals($vehicle2->id, $vehicle2History->first()['vehicle_id']);

        // Verifica che le immagini siano separate correttamente
        $vehicle1Images = $vehicle1->getAllHistoricalImages();
        $vehicle2Images = $vehicle2->getAllHistoricalImages();

        $this->assertContains('/storage/vehicles/vehicle1_image1.jpg', $vehicle1Images);
        $this->assertNotContains('/storage/vehicles/vehicle2_image1.jpg', $vehicle1Images);

        $this->assertContains('/storage/vehicles/vehicle2_image1.jpg', $vehicle2Images);
        $this->assertNotContains('/storage/vehicles/vehicle1_image1.jpg', $vehicle2Images);
    }
}