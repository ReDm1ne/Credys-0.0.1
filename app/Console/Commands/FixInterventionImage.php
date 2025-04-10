<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class FixInterventionImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:intervention-image';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Corrige la instalación de Intervention Image';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Corrigiendo la instalación de Intervention Image...');

        // Verificar si Intervention Image está instalado
        if (!class_exists('Intervention\Image\Facades\Image')) {
            $this->error('Intervention Image no está instalado. Instalando...');
            exec('composer require intervention/image:^2.7');
        } else {
            $this->info('Intervention Image ya está instalado.');
        }

        // Publicar la configuración
        $this->info('Publicando la configuración...');
        Artisan::call('vendor:publish', [
            '--provider' => 'Intervention\Image\ImageServiceProviderLaravelRecent'
        ]);

        // Limpiar la caché
        $this->info('Limpiando la caché...');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');

        $this->info('Verificando la instalación...');
        try {
            // Intentar crear una instancia de Image para verificar que funciona
            $image = \Intervention\Image\Facades\Image::canvas(100, 100, '#fff');
            $this->info('Intervention Image está funcionando correctamente.');
        } catch (\Exception $e) {
            $this->error('Error al verificar Intervention Image: ' . $e->getMessage());
            $this->info('Intentando reinstalar...');
            exec('composer remove intervention/image');
            exec('composer require intervention/image:^2.7');
            Artisan::call('vendor:publish', [
                '--provider' => 'Intervention\Image\ImageServiceProviderLaravelRecent'
            ]);
        }

        $this->info('Proceso completado.');
        return Command::SUCCESS;
    }
}
