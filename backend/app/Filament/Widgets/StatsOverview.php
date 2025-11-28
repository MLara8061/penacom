<?php

namespace App\Filament\Widgets;

use App\Models\Contact;
use App\Models\PortfolioItem;
use App\Models\Service;
use App\Models\Testimonial;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Obtener contactos del mes actual
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $contactsThisMonth = Contact::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();
        
        // Obtener contactos del mes anterior para comparación
        $lastMonth = now()->subMonth();
        $contactsLastMonth = Contact::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();
        
        // Calcular diferencia porcentual
        $contactsDiff = $contactsLastMonth > 0 
            ? (($contactsThisMonth - $contactsLastMonth) / $contactsLastMonth) * 100 
            : 0;
        
        // Obtener promedio de calificaciones
        $avgRating = Testimonial::where('is_active', true)->avg('rating') ?? 0;
        
        return [
            Stat::make('Total de Contactos', Contact::count())
                ->description('Todas las consultas recibidas')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('success'),
                
            Stat::make('Nuevos Leads Este Mes', $contactsThisMonth)
                ->description(
                    $contactsDiff > 0 
                        ? sprintf('+%.0f%% vs mes anterior', $contactsDiff)
                        : sprintf('%.0f%% vs mes anterior', $contactsDiff)
                )
                ->descriptionIcon($contactsDiff > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($contactsDiff > 0 ? 'success' : 'danger'),
                
            Stat::make('Proyectos en Portafolio', PortfolioItem::count())
                ->description('Total de trabajos realizados')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('info'),
                
            Stat::make('Calificación Promedio', number_format($avgRating, 1) . ' / 5.0')
                ->description('Basado en testimonios activos')
                ->descriptionIcon('heroicon-m-star')
                ->color($avgRating >= 4.5 ? 'success' : ($avgRating >= 4 ? 'warning' : 'danger')),
        ];
    }
}
