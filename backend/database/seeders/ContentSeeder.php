<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HeroSection;
use App\Models\AboutSection;
use App\Models\PortfolioItem;
use App\Models\Testimonial;
use App\Models\SiteSetting;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // Hero Sections - 3 banners del slider
        HeroSection::create([
            'title' => 'Soluciones <span class="text-highlight">Digitales</span> Innovadoras',
            'subtitle' => 'Transformamos tu visión en realidad con tecnología de vanguardia',
            'description' => null,
            'button_text' => 'Comenzar Ahora',
            'button_link' => '#contacto',
            'background_image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1920&q=80',
            'is_active' => true,
            'order' => 1,
        ]);

        HeroSection::create([
            'title' => 'Desarrollo Web <span class="text-highlight">Profesional</span>',
            'subtitle' => 'Creamos experiencias digitales excepcionales que impulsan tu negocio',
            'description' => null,
            'button_text' => 'Ver Servicios',
            'button_link' => '#servicios',
            'background_image' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=1920&q=80',
            'is_active' => true,
            'order' => 2,
        ]);

        HeroSection::create([
            'title' => 'Consultoría <span class="text-highlight">Estratégica</span>',
            'subtitle' => 'Optimiza tus procesos con nuestro equipo de expertos',
            'description' => null,
            'button_text' => 'Agendar Consulta',
            'button_link' => '#contacto',
            'background_image' => 'https://images.unsplash.com/photo-1531297484001-80022131f5a1?w=1920&q=80',
            'is_active' => true,
            'order' => 3,
        ]);

        // About Section
        AboutSection::create([
            'current_image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=800&q=80',
            'title' => 'Líderes en Tecnología LED desde 2013',
            'description' => 'Empresa establecida en Cancún, Quintana Roo, especializada en la venta y mantenimiento de pantallas LED de última generación. Durante más de una década, hemos llevado a nuestros clientes el avance y la vanguardia en tecnología LED.',
            'years_experience' => 12,
            'happy_clients' => 100,
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
