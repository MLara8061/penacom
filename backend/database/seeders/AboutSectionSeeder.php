<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AboutSection;

class AboutSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AboutSection::firstOrCreate([], [
            'current_image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=800&q=80',
            'title' => 'Líderes en Tecnología LED desde 2013',
            'description' => 'Empresa establecida en Cancún, Quintana Roo, especializada en la venta y mantenimiento de pantallas LED de última generación. Durante más de una década, hemos llevado a nuestros clientes el avance y la vanguardia en tecnología LED.',
            'highlighted_text' => 'Al adquirir nuestros productos, obtiene la más alta tecnología en pantallas LED de nuestros socios internacionales y fabricantes de componentes, ensambladas con la calidad y precisión de técnicos mexicanos.',
            'years_experience' => 12,
            'happy_clients' => 100,
        ]);
    }
}
