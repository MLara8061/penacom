<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutImageHistory extends Model
{
    protected $table = 'about_image_history';
    
    protected $fillable = [
        'image_path',
        'used_at',
    ];

    protected $casts = [
        'used_at' => 'datetime',
    ];

    // Agregar nueva imagen al historial
    public static function addToHistory(string $imagePath)
    {
        // Crear nuevo registro
        static::create([
            'image_path' => $imagePath,
            'used_at' => now(),
        ]);

        // Mantener solo las últimas 5 imágenes
        $count = static::count();
        if ($count > 5) {
            static::orderBy('used_at', 'asc')
                ->limit($count - 5)
                ->delete();
        }
    }

    // Obtener últimas 5 imágenes
    public static function getRecent()
    {
        return static::orderBy('used_at', 'desc')->limit(5)->get();
    }
}
