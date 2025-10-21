<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\CarModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modelsData = [
            'Audi' => ['A3', 'A4', 'A6', 'A8', 'Q3', 'Q5', 'Q7', 'TT', 'R8'],
            'BMW' => ['Serie 1', 'Serie 3', 'Serie 5', 'Serie 7', 'X1', 'X3', 'X5', 'X6', 'Z4'],
            'Mercedes-Benz' => ['Classe A', 'Classe C', 'Classe E', 'Classe S', 'GLA', 'GLC', 'GLE', 'SLK'],
            'Volkswagen' => ['Golf', 'Polo', 'Passat', 'Tiguan', 'Touran', 'Jetta', 'Arteon'],
            'Fiat' => ['500', 'Panda', 'Punto', 'Tipo', 'Doblò', '500X', '500L'],
            'Ferrari' => ['488', 'F8', 'Portofino', 'Roma', 'SF90', '812'],
            'Lamborghini' => ['Huracán', 'Aventador', 'Urus'],
            'Alfa Romeo' => ['Giulia', 'Stelvio', 'Giulietta', 'MiTo'],
            'Ford' => ['Fiesta', 'Focus', 'Mondeo', 'Kuga', 'EcoSport', 'Mustang'],
            'Toyota' => ['Yaris', 'Corolla', 'Camry', 'RAV4', 'Prius', 'Highlander'],
            'Honda' => ['Civic', 'Accord', 'CR-V', 'HR-V', 'Jazz'],
            'Nissan' => ['Micra', 'Qashqai', 'X-Trail', 'Juke', 'Leaf'],
            'Hyundai' => ['i10', 'i20', 'i30', 'Tucson', 'Santa Fe', 'Kona'],
            'Kia' => ['Picanto', 'Rio', 'Ceed', 'Sportage', 'Sorento', 'Stonic'],
            'Peugeot' => ['208', '308', '508', '2008', '3008', '5008'],
            'Renault' => ['Clio', 'Megane', 'Scenic', 'Captur', 'Kadjar'],
            'Opel' => ['Corsa', 'Astra', 'Insignia', 'Crossland', 'Grandland'],
            'Volvo' => ['V40', 'V60', 'V90', 'XC40', 'XC60', 'XC90'],
            'Tesla' => ['Model S', 'Model 3', 'Model X', 'Model Y'],
            'Porsche' => ['911', 'Cayenne', 'Macan', 'Panamera', 'Taycan'],
        ];

        foreach ($modelsData as $brandName => $models) {
            $brand = Brand::where('name', $brandName)->first();
            
            if ($brand) {
                foreach ($models as $modelName) {
                    CarModel::create([
                        'brand_id' => $brand->id,
                        'name' => $modelName,
                        'is_active' => true,
                    ]);
                }
            }
        }
    }
}
