<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageHistory extends Model
{
    protected $table = 'image_history';
    
    protected $fillable = [
        'url',
        'context',
        'uploaded_by',
        'usage_count',
        'last_used_at',
    ];

    protected $casts = [
        'usage_count' => 'integer',
        'last_used_at' => 'datetime',
    ];

    public static function addToHistory(string $url, ?string $context = null): void
    {
        $existing = self::where('url', $url)->first();
        
        if ($existing) {
            $existing->increment('usage_count');
            $existing->update(['last_used_at' => now()]);
        } else {
            self::create([
                'url' => $url,
                'context' => $context,
                'usage_count' => 1,
                'last_used_at' => now(),
            ]);
        }
    }

    public static function getRecentByContext(?string $context = null, int $limit = 10): array
    {
        $query = self::orderBy('last_used_at', 'desc');
        
        if ($context) {
            $query->where('context', $context);
        }
        
        return $query->limit($limit)->pluck('url')->toArray();
    }
}
