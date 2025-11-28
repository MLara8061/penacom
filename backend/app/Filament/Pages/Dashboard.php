<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getHeading(): string
    {
        $user = auth()->user();
        $greeting = $this->getGreeting();
        
        return "{$greeting}, {$user->name}!";
    }

    public function getSubheading(): ?string
    {
        return 'Bienvenido al panel de administración de Peñacom';
    }

    protected function getGreeting(): string
    {
        $hour = now()->hour;

        if ($hour < 12) {
            return 'Buenos días';
        } elseif ($hour < 18) {
            return 'Buenas tardes';
        } else {
            return 'Buenas noches';
        }
    }
}
