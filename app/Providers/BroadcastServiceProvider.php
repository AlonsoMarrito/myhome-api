<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // ❌ BORRA O COMENTA ESTA LÍNEA:
        // Broadcast::routes();

        // ✅ AGREGA ESTA LÍNEA:
        // Esto le dice a Laravel: "Usa la configuración de API, y agrega el prefijo /api"
        Broadcast::routes(['middleware' => ['api']]); 

        require base_path('routes/channels.php');
    }
}