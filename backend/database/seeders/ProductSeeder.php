<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Sector Hotelero',
                'description' => 'Soluciones LED especializadas para hoteles y resorts. Iluminación de áreas comunes, habitaciones y exteriores con tecnología de bajo consumo y alta durabilidad.',
                'category' => 'Hospitalidad',
                'icon' => '🏨',
                'is_active' => true,
                'order' => 1
            ],
            [
                'name' => 'Sector Restaurantero',
                'description' => 'Iluminación LED profesional para restaurantes y bares. Crea ambientes únicos con control de temperatura de color y sistemas de dimeo inteligente.',
                'category' => 'Alimentos y Bebidas',
                'icon' => '🍽️',
                'is_active' => true,
                'order' => 2
            ],
            [
                'name' => 'Sector Residencial',
                'description' => 'Soluciones LED para hogares modernos. Iluminación inteligente, eficiente y con diseños elegantes para cada espacio de tu casa.',
                'category' => 'Residencial',
                'icon' => '🏠',
                'is_active' => true,
                'order' => 3
            ],
            [
                'name' => 'Sector Comercial',
                'description' => 'Iluminación LED para oficinas, tiendas y espacios comerciales. Mejora la productividad y reduce costos energéticos con nuestras soluciones inteligentes.',
                'category' => 'Comercial',
                'icon' => '🏢',
                'is_active' => true,
                'order' => 4
            ],
            [
                'name' => 'Sector Industrial',
                'description' => 'Iluminación LED de alta potencia para fábricas y almacenes. Resistente, eficiente y diseñada para operar en condiciones extremas.',
                'category' => 'Industrial',
                'icon' => '🏭',
                'is_active' => true,
                'order' => 5
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
