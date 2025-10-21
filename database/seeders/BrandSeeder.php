<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            ['name' => 'Audi', 'slug' => 'audi', 'is_active' => true],
            ['name' => 'BMW', 'slug' => 'bmw', 'is_active' => true],
            ['name' => 'Mercedes-Benz', 'slug' => 'mercedes-benz', 'is_active' => true],
            ['name' => 'Volkswagen', 'slug' => 'volkswagen', 'is_active' => true],
            ['name' => 'Fiat', 'slug' => 'fiat', 'is_active' => true],
            ['name' => 'Ferrari', 'slug' => 'ferrari', 'is_active' => true],
            ['name' => 'Lamborghini', 'slug' => 'lamborghini', 'is_active' => true],
            ['name' => 'Alfa Romeo', 'slug' => 'alfa-romeo', 'is_active' => true],
            ['name' => 'Ford', 'slug' => 'ford', 'is_active' => true],
            ['name' => 'Toyota', 'slug' => 'toyota', 'is_active' => true],
            ['name' => 'Honda', 'slug' => 'honda', 'is_active' => true],
            ['name' => 'Nissan', 'slug' => 'nissan', 'is_active' => true],
            ['name' => 'Hyundai', 'slug' => 'hyundai', 'is_active' => true],
            ['name' => 'Kia', 'slug' => 'kia', 'is_active' => true],
            ['name' => 'Peugeot', 'slug' => 'peugeot', 'is_active' => true],
            ['name' => 'Renault', 'slug' => 'renault', 'is_active' => true],
            ['name' => 'Opel', 'slug' => 'opel', 'is_active' => true],
            ['name' => 'Volvo', 'slug' => 'volvo', 'is_active' => true],
            ['name' => 'Tesla', 'slug' => 'tesla', 'is_active' => true],
            ['name' => 'Porsche', 'slug' => 'porsche', 'is_active' => true],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
