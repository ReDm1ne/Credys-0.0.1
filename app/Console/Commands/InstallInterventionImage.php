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
    protected $description = 'Instala y configura Intervention Image v2.7 para el procesamiento de imágenes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Instalando Intervention Image v2.7...');

        // Ejecutar composer require con versión específica
        $this->info('Ejecutando: composer require intervention/image:^2.7');
        exec('composer require intervention/image:^2.7');

        // Publicar el proveedor de servicios
        $this->info('Publicando el proveedor de servicios...');
        Artisan::call('vendor:publish', [
            '--provider' => 'Intervention\Image\ImageServiceProviderLaravelRecent'
        ]);

        // Limpiar la caché
        $this->info('Limpiando la caché...');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');

        // Crear enlace simbólico para el almacenamiento
        $this->info('Creando enlace simbólico para el almacenamiento...');
        Artisan::call('storage:link');

        $this->info('Intervention Image v2.7 ha sido instalado y configurado correctamente.');
        $this->info('Las imágenes se guardarán en storage/app/public/ y serán accesibles a través de /storage/');

        return Command::SUCCESS;
    }
}
