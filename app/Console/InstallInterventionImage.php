<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InstallInterventionImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:intervention-image';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Instala y configura Intervention Image para el procesamiento de imágenes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Instalando Intervention Image...');

        // Ejecutar composer require
        $this->info('Ejecutando: composer require intervention/image');
        exec('composer require intervention/image');

        // Publicar el proveedor de servicios
        $this->info('Publicando el proveedor de servicios...');
        Artisan::call('vendor:publish', [
            '--provider' => 'Intervention\Image\ImageServiceProviderLaravelRecent'
        ]);

        // Limpiar la caché
        $this->info('Limpiando la caché...');
        Artisan::call('optimize:clear');

        $this->info('Intervention Image ha sido instalado y configurado correctamente.');
        $this->info('Ahora puedes usar el servicio ImageService para optimizar imágenes automáticamente.');

        return Command::SUCCESS;
    }
}

