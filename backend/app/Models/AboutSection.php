<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
    protected $table = 'about_section';
    
    protected $fillable = [
        'current_image',
        'title',
        'description',
        'highlighted_text',
        'years_experience',
        'happy_clients',
    ];

    protected $casts = [
        'years_experience' => 'integer',
        'happy_clients' => 'integer',
    ];

    // Obtener o crear la única instancia
    public static function getInstance()
    {
        return static::firstOrCreate([], [
            'current_image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=800&q=80',
            'title' => 'Líderes en Tecnología LED desde 2013',
            'description' => 'Empresa establecida en Cancún, Quintana Roo, especializada en la venta y mantenimiento de pantallas LED de última generación.',
            'highlighted_text' => 'Al adquirir nuestros productos, obtiene la más alta tecnología en pantallas LED de nuestros socios internacionales y fabricantes de componentes, ensambladas con la calidad y precisión de técnicos mexicanos.',
            'years_experience' => 12,
            'happy_clients' => 100,
        ]);
    }
}
