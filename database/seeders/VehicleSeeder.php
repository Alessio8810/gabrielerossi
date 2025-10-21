<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Mappatura brand -> query Unsplash per immagini specifiche
     */
    private function getBrandImageQueries($brandName, $modelName)
    {
        $brandLower = strtolower($brandName);
        $modelLower = strtolower($modelName);
        
        // Query specifiche per combinazioni brand + model comuni
        $queries = [
            // BMW
            'bmw-serie 3' => 'bmw-3-series',
            'bmw-serie 5' => 'bmw-5-series',
            'bmw-x5' => 'bmw-x5-suv',
            'bmw-x3' => 'bmw-x3',
            'bmw-m3' => 'bmw-m3-sports',
            
            // Mercedes
            'mercedes-benz-classe c' => 'mercedes-c-class',
            'mercedes-benz-classe e' => 'mercedes-e-class',
            'mercedes-benz-gle' => 'mercedes-gle-suv',
            'mercedes-benz-classe a' => 'mercedes-a-class',
            'mercedes-benz-gla' => 'mercedes-gla',
            
            // Audi
            'audi-a4' => 'audi-a4-sedan',
            'audi-a6' => 'audi-a6',
            'audi-q5' => 'audi-q5-suv',
            'audi-q3' => 'audi-q3',
            'audi-a3' => 'audi-a3-sportback',
            
            // Volkswagen
            'volkswagen-golf' => 'volkswagen-golf',
            'volkswagen-passat' => 'volkswagen-passat',
            'volkswagen-tiguan' => 'vw-tiguan-suv',
            'volkswagen-polo' => 'vw-polo',
            'volkswagen-t-roc' => 'volkswagen-troc',
            
            // Ford
            'ford-focus' => 'ford-focus',
            'ford-fiesta' => 'ford-fiesta',
            'ford-kuga' => 'ford-kuga-suv',
            'ford-puma' => 'ford-puma',
            'ford-mustang' => 'ford-mustang',
            
            // Toyota
            'toyota-corolla' => 'toyota-corolla',
            'toyota-yaris' => 'toyota-yaris',
            'toyota-rav4' => 'toyota-rav4-suv',
            'toyota-camry' => 'toyota-camry',
            'toyota-highlander' => 'toyota-highlander',
            
            // Renault
            'renault-clio' => 'renault-clio',
            'renault-megane' => 'renault-megane',
            'renault-captur' => 'renault-captur',
            'renault-kadjar' => 'renault-kadjar',
            
            // Peugeot
            'peugeot-208' => 'peugeot-208',
            'peugeot-308' => 'peugeot-308',
            'peugeot-3008' => 'peugeot-3008-suv',
            'peugeot-2008' => 'peugeot-2008',
            
            // Fiat
            'fiat-500' => 'fiat-500',
            'fiat-panda' => 'fiat-panda',
            'fiat-tipo' => 'fiat-tipo',
            'fiat-500x' => 'fiat-500x',
            
            // Tesla
            'tesla-model 3' => 'tesla-model-3',
            'tesla-model s' => 'tesla-model-s',
            'tesla-model x' => 'tesla-model-x',
            'tesla-model y' => 'tesla-model-y',
        ];
        
        $key = $brandLower . '-' . $modelLower;
        
        if (isset($queries[$key])) {
            return $queries[$key];
        }
        
        // Fallback generico per brand
        return strtolower(str_replace(' ', '-', $brandName)) . '-car';
    }

    /**
     * Pool di immagini reali di auto da Unsplash
     */
    private function getCarImagePool()
    {
        return [
            // Auto moderne sportive e di lusso
            "https://images.unsplash.com/photo-1494976388531-d1058494cdd8?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1583121274602-3e2820c69888?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1552519507-da3b142c6e3d?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1514316454349-750a7fd3da3a?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1525609004556-c46c7d6cf023?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1542362567-b07e54358753?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1550355291-bbee04a92027?w=800&h=600&fit=crop",
            
            // SUV e veicoli familiari
            "https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1581540222194-0def2dda95b8?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1549399542-7e3f8b79c341?w=800&h=600&fit=crop",
            
            // Auto classiche ed eleganti
            "https://images.unsplash.com/photo-1502877338535-766e1452684a?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1485463611174-f302f6a5c1c9?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1511919884226-fd3cad34687c?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1486496146582-9ffcd0b2b2b7?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1534518380074-e0cd35d32c08?w=800&h=600&fit=crop",
            
            // Auto compatte e moderne
            "https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1570294646112-27ce4f174a6d?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1546614042-7df3c24c9e5d?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1571607388263-1044f9ea01dd?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1605559424843-9e4c228bf1c2?w=800&h=600&fit=crop",
            
            // Auto premium e berline
            "https://images.unsplash.com/photo-1489824904134-891ab64532f1?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1600705722520-64e8f3b9c0bb?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1563337239-ab59e2e03917?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1555215695-3004980ad54e?w=800&h=600&fit=crop",
            
            // Auto elettriche e moderne
            "https://images.unsplash.com/photo-1560958089-b8a1929cea89?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1536700503339-1e4b06520771?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1617814076367-b759c7d7e738?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1554744512-d6c603f27c54?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1600804931749-2da4ce26c869?w=800&h=600&fit=crop",
            
            // Sportive e cabriolet
            "https://images.unsplash.com/photo-1583267746897-c96538b99213?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1546768292-fb12f6c92568?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1580273916550-e323be2ae537?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1552519507-da3b142c6e3d?w=800&h=600&fit=crop",
            "https://images.unsplash.com/photo-1553440569-bcc63803a83d?w=800&h=600&fit=crop",
        ];
    }

    /**
     * Genera URL immagini per una specifica auto
     */
    private function getCarImages($brandName, $modelName, $index = 0)
    {
        $pool = $this->getCarImagePool();
        $poolSize = count($pool);
        
        // Usa un offset basato sull'index per avere varietà
        $offset = ($index * 4) % $poolSize;
        
        $images = [];
        for ($i = 0; $i < 4; $i++) {
            $imageIndex = ($offset + $i) % $poolSize;
            $images[] = $pool[$imageIndex];
        }
        
        return $images;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carModels = CarModel::with('brand')->get();
        
        $fuelTypes = ['gasoline', 'diesel', 'electric', 'hybrid'];
        $transmissions = ['Manuale', 'Automatico', 'Semiautomatico'];
        $bodyTypes = ['Berlina', 'Station Wagon', 'SUV', 'Coupé', 'Cabriolet', 'Hatchback'];
        $colors = ['Bianco', 'Nero', 'Grigio', 'Rosso', 'Blu', 'Argento', 'Verde'];
        $conditions = ['new', 'used'];

        $vehicleIndex = 0;

        foreach ($carModels as $model) {
            // Creiamo 2-5 veicoli per ogni modello
            $vehicleCount = rand(2, 5);
            
            for ($i = 0; $i < $vehicleCount; $i++) {
                $condition = $conditions[array_rand($conditions)];
                $year = $condition === 'new' ? rand(2023, 2025) : rand(2015, 2022);
                $mileage = $condition === 'new' ? rand(0, 100) : rand(10000, 150000);
                $basePrice = rand(15000, 80000);
                
                // Aggiustiamo il prezzo in base all'anno e chilometraggio
                if ($condition === 'used') {
                    $ageDiscount = (2025 - $year) * 0.1;
                    $mileageDiscount = ($mileage / 100000) * 0.2;
                    $basePrice = $basePrice * (1 - $ageDiscount - $mileageDiscount);
                }

                Vehicle::create([
                    'brand_id' => $model->brand->id,
                    'car_model_id' => $model->id,
                    'title' => $model->brand->name . ' ' . $model->name . ' ' . $year,
                    'description' => 'Bellissima ' . $model->brand->name . ' ' . $model->name . ' in ottime condizioni. Veicolo ben tenuto e sempre tagliadato.',
                    'year' => $year,
                    'mileage' => $mileage,
                    'price' => round($basePrice, 2),
                    'condition' => $condition,
                    'fuel_type' => $fuelTypes[array_rand($fuelTypes)],
                    'transmission' => $transmissions[array_rand($transmissions)],
                    'body_type' => $bodyTypes[array_rand($bodyTypes)],
                    'color' => $colors[array_rand($colors)],
                    'images' => $this->getCarImages($model->brand->name, $model->name, $vehicleIndex),
                    'is_active' => rand(0, 10) > 1, // 90% attivi
                    'is_featured' => rand(0, 10) > 7, // 30% in evidenza
                ]);
                
                $vehicleIndex++;
            }
        }
    }
}
