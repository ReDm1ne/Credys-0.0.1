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
                Storage::disk('public')->makeDirectory($path);
            }

            // Obtener la extensión original
            $extension = strtolower($file->getClientOriginalExtension());

            // Verificar si es un archivo PDF
            if ($extension === 'pdf') {
                // Para PDFs, simplemente guardar sin comprimir
                $pdfPath = $file->storeAs($path, $filename, 'public');
                return basename($pdfPath);
            }

            // Para imágenes, optimizar
            $image = Image::make($file);

            // Redimensionar la imagen si es más grande que el ancho especificado
            if ($image->width() > $width) {
                $image->resize($width, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }

            // Guardar la imagen optimizada
            $image->save(storage_path('app/public/' . $fullPath), $quality);

            Log::info('Imagen optimizada y guardada', [
                'original_size' => $file->getSize(),
                'new_size' => filesize(storage_path('app/public/' . $fullPath)),
                'path' => $fullPath
            ]);

            return $filename;
        } catch (\Exception $e) {
            Log::error('Error al optimizar imagen: ' . $e->getMessage(), [
                'file' => $file->getClientOriginalName(),
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }
}

