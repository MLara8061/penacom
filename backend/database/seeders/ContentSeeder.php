<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HeroSection;
use App\Models\PortfolioItem;
use App\Models\Testimonial;
use App\Models\SiteSetting;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // Hero Section
        HeroSection::create([
            'title' => 'Soluciones Integrales en Comunicación Visual',
            'subtitle' => 'Peña Comunicación Visual',
            'description' => 'Más de 10 años transformando espacios con señalización profesional',
            'button_text' => 'Solicitar Cotización',
            'button_link' => '#contacto',
            'is_active' => true,
            'order' => 1,
        ]);

        // Portfolio Items
        PortfolioItem::create([
            'title' => 'Señalización Centro Comercial Plaza Mayor',
            'description' => 'Proyecto integral de señalización para centro comercial',
            'category' => 'Señalización Digital LED',
            'client' => 'Plaza Mayor',
            'image' => '/images/portfolio/plaza-mayor.jpg',
            'completed_date' => '2024-06-15',
            'featured' => true,
            'order' => 1,
        ]);

        PortfolioItem::create([
            'title' => 'Rótulos Hotel Paraíso',
            'description' => 'Diseño y fabricación de rótulos iluminados',
            'category' => 'Rótulos',
            'client' => 'Hotel Paraíso',
            'image' => '/images/portfolio/hotel.jpg',
            'completed_date' => '2024-05-20',
            'featured' => true,
            'order' => 2,
        ]);

        PortfolioItem::create([
            'title' => 'Viniles Decorativos Oficina Corporativa',
            'description' => 'Viniles decorativos para oficinas',
            'category' => 'Viniles',
            'client' => 'Tech Corp',
            'image' => '/images/portfolio/viniles.jpg',
            'completed_date' => '2024-04-10',
            'featured' => false,
            'order' => 3,
        ]);

        // Testimonials
        Testimonial::create([
            'client_name' => 'María González',
            'client_company' => 'Plaza Mayor',
            'client_position' => 'Gerente de Operaciones',
            'testimonial' => 'Excelente servicio y calidad en la señalización de nuestro centro comercial. Muy profesionales y puntuales.',
            'rating' => 5,
            'is_featured' => true,
            'is_active' => true,
        ]);

        Testimonial::create([
            'client_name' => 'Carlos Ramírez',
            'client_company' => 'Hotel Paraíso',
            'client_position' => 'Director General',
            'testimonial' => 'Los rótulos quedaron espectaculares. Superaron nuestras expectativas y el tiempo de entrega fue muy bueno.',
            'rating' => 5,
            'is_featured' => true,
            'is_active' => true,
        ]);

        Testimonial::create([
            'client_name' => 'Ana Martínez',
            'client_company' => 'Tech Corp',
            'client_position' => 'Jefe de Recursos Humanos',
            'testimonial' => 'Los viniles transformaron completamente nuestra oficina. Muy satisfechos con el resultado.',
            'rating' => 5,
            'is_featured' => false,
            'is_active' => true,
        ]);

        // Site Settings
        $settings = [
            // General
            ['key' => 'site_name', 'value' => 'Peña Comunicación Visual', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Soluciones Integrales en Comunicación Visual', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Expertos en señalización, rótulos, viniles y más', 'type' => 'textarea', 'group' => 'general'],
            
            // Contact
            ['key' => 'phone', 'value' => '+52 999 123 4567', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'email', 'value' => 'contacto@penacomvisual.com', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'whatsapp', 'value' => '5219991234567', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'address', 'value' => 'Calle 60 #123, Centro, Mérida, Yucatán', 'type' => 'textarea', 'group' => 'contact'],
            ['key' => 'hours', 'value' => 'Lunes a Viernes: 9:00 AM - 6:00 PM\nSábado: 9:00 AM - 2:00 PM', 'type' => 'textarea', 'group' => 'contact'],
            
            // Social Media
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/penacomvisual', 'type' => 'text', 'group' => 'social'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/penacomvisual', 'type' => 'text', 'group' => 'social'],
            ['key' => 'twitter_url', 'value' => '', 'type' => 'text', 'group' => 'social'],
            ['key' => 'linkedin_url', 'value' => '', 'type' => 'text', 'group' => 'social'],
            
            // SEO
            ['key' => 'meta_keywords', 'value' => 'señalización, rótulos, viniles, comunicación visual, Mérida', 'type' => 'textarea', 'group' => 'seo'],
            ['key' => 'google_analytics', 'value' => '', 'type' => 'text', 'group' => 'seo'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::create($setting);
        }
    }
}
