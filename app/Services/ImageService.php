<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ImageService
{
    /**
     * Optimiza y guarda una imagen
     *
     * @param UploadedFile $file
     * @param string $path
     * @param int $width
     * @param int $quality
     * @return string|null
     */
    public function optimizeAndSave(UploadedFile $file, string $path, int $width = 1200, int $quality = 80)
    {
        try {
            // Crear un nombre único para el archivo
            $filename = Str::random(20) . '.' . 'jpg';
            $fullPath = $path . '/' . $filename;

            // Crear la carpeta si no existe
            if (!Storage::disk('public')->exists($path)) {
                Log::info("Creando directorio: {$path}");
                Storage::disk('public')->makeDirectory($path);
            }

            // Verificar que el directorio sea escribible
            $storagePath = storage_path('app/public/' . $path);
            if (!is_writable($storagePath)) {
                Log::warning("El directorio {$storagePath} no tiene permisos de escritura. Intentando corregir...");
                chmod($storagePath, 0755);
                if (!is_writable($storagePath)) {
                    throw new \Exception("El directorio {$path} no tiene permisos de escritura.");
                }
            }

            // Obtener la extensión original
            $extension = strtolower($file->getClientOriginalExtension());

            // Verificar si es un archivo PDF
            if ($extension === 'pdf') {
                // Para PDFs, simplemente guardar sin comprimir
                $pdfPath = $file->storeAs($path, $filename, 'public');
                Log::info("PDF guardado en: {$pdfPath}");
                return basename($pdfPath);
            }

            // Para imágenes, optimizar
            // Verificar que el archivo sea una imagen válida
            if (!$file->isValid()) {
                throw new \Exception("El archivo no es válido.");
            }

            // Leer la imagen usando la versión 2.7 de Intervention Image
            try {
                $image = Image::make($file);

                // Redimensionar la imagen si es más grande que el ancho especificado
                if ($image->width() > $width) {
                    $image->resize($width, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }

                // Guardar la imagen optimizada con la calidad especificada
                $image->save(storage_path('app/public/' . $fullPath), $quality);

                Log::info('Imagen optimizada y guardada', [
                    'original_size' => $file->getSize(),
                    'new_size' => filesize(storage_path('app/public/' . $fullPath)),
                    'path' => $fullPath
                ]);

                return $filename;
            } catch (\Exception $e) {
                Log::error("Error al procesar la imagen: " . $e->getMessage());
                // Intentar guardar la imagen sin procesar
                $rawPath = $file->storeAs($path, $filename, 'public');
                Log::info("Imagen guardada sin procesar en: {$rawPath}");
                return basename($rawPath);
            }
        } catch (\Exception $e) {
            Log::error('Error al optimizar imagen: ' . $e->getMessage(), [
                'file' => $file->getClientOriginalName(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Intentar guardar la imagen sin procesar como último recurso
            try {
                $rawPath = $file->storeAs($path, $filename ?? Str::random(20) . '.jpg', 'public');
                Log::info("Imagen guardada sin procesar como último recurso en: {$rawPath}");
                return basename($rawPath);
            } catch (\Exception $innerException) {
                Log::error('Error al guardar imagen sin procesar: ' . $innerException->getMessage());
                return null;
            }
        }
    }
}
