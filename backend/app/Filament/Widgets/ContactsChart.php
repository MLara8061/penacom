<?php

namespace App\Filament\Widgets;

use App\Models\Contact;
use Filament\Widgets\ChartWidget;

class ContactsChart extends ChartWidget
{
    protected static ?string $heading = 'Contactos de los Últimos 30 Días';
    
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        // Obtener datos de los últimos 30 días
        $data = [];
        $labels = [];
        
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $count = Contact::whereDate('created_at', $date->toDateString())->count();
            
            $data[] = $count;
            $labels[] = $date->format('d/m');
        }
        
        return [
            'datasets' => [
                [
                    'label' => 'Contactos',
                    'data' => $data,
                    'fill' => 'start',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => 'rgb(59, 130, 246)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
    
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
        ];
    }
}
