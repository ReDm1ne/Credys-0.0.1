<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class VerifyStorageSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:verify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica y configura los directorios de almacenamiento para imágenes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Verificando configuración de almacenamiento...');

        // Verificar si existe el enlace simbólico
        if (!file_exists(public_path('storage'))) {
            $this->info('Creando enlace simbólico para el almacenamiento...');
            Artisan::call('storage:link');
            $this->info('Enlace simbólico creado correctamente.');
        } else {
            $this->info('El enlace simbólico ya existe.');
        }

        // Verificar y crear directorios para imágenes
        $directories = [
            'foto_clientes',
            'identificacion_frente_clientes',
            'identificacion_reverso_clientes',
            'comprobante_domicilio_clientes',
            'acta_de_nacimiento_clientes',
            'curp_clientes',
            'comprobante_ingresos_clientes',
            'fachada_casa_clientes',
            'fachada_negocio_clientes',
            'conyuge_fotos',
            'conyuge_identificacions'
        ];

        foreach ($directories as $directory) {
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
                $this->info("Directorio '{$directory}' creado.");
            } else {
                $this->info("Directorio '{$directory}' ya existe.");
            }

            // Verificar permisos
            $path = storage_path('app/public/' . $directory);
            if (file_exists($path) && !is_writable($path)) {
                $this->warn("El directorio '{$directory}' no tiene permisos de escritura. Intentando corregir...");
                chmod($path, 0755);
                if (is_writable($path)) {
                    $this->info("Permisos corregidos para '{$directory}'.");
                } else {
                    $this->error("No se pudieron corregir los permisos para '{$directory}'. Por favor, ajuste los permisos manualmente.");
                }
            }
        }

        $this->info('Verificación de almacenamiento completada.');
        return Command::SUCCESS;
    }
}
