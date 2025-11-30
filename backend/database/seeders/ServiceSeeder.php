<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'title' => 'Diseño de Rótulos Personalizados',
                'description' => 'Creamos rótulos únicos adaptados a la identidad de tu marca. Desde el concepto hasta la instalación, trabajamos contigo para crear señalización que destaque.',
                'icon' => '✏️',
                'image' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=800',
                'is_active' => true,
                'order' => 1
            ],
            [
                'title' => 'Rótulos Luminosos LED',
                'description' => 'Ilumina tu negocio con tecnología LED de última generación. Rótulos eficientes, duraderos y visibles las 24 horas del día.',
                'icon' => '💡',
                'image' => 'https://images.unsplash.com/photo-1541701494587-cb58502866ab?w=800',
                'is_active' => true,
                'order' => 2
            ],
            [
                'title' => 'Señalización Corporativa',
                'description' => 'Soluciones completas de señalización para edificios corporativos. Incluye directorio, placas de oficina, y señalización de seguridad.',
                'icon' => '🏢',
                'image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=800',
                'is_active' => true,
                'order' => 3
            ],
            [
                'title' => 'Vinilos y Adhesivos',
                'description' => 'Impresión de alta calidad en vinilo para vitrinas, vehículos y espacios interiores. Material duradero con colores vibrantes.',
                'icon' => '🎨',
                'image' => 'https://images.unsplash.com/photo-1586281380349-632531db7ed4?w=800',
                'is_active' => true,
                'order' => 4
            ],
            [
                'title' => 'Mantenimiento y Reparación',
                'description' => 'Servicio técnico especializado para mantener tus rótulos en perfecto estado. Reparaciones, limpieza y actualizaciones.',
                'icon' => '🔧',
                'image' => 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=800',
                'is_active' => true,
                'order' => 5
            ]
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
