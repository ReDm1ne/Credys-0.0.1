<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class VerifyPostSize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $max = $this->getPostMaxSize();

            if ($max > 0 && $request->server('CONTENT_LENGTH') > $max) {
                Log::error('PostTooLargeException: El tamaño del contenido excede el límite máximo permitido', [
                    'content_length' => $request->server('CONTENT_LENGTH'),
                    'max_size' => $max
                ]);
                throw new PostTooLargeException;
            }

            return $next($request);
        } catch (PostTooLargeException $e) {
            // Redirigir con un mensaje de error más amigable
            return redirect()->back()->withErrors([
                'error' => 'Los archivos que intentas subir son demasiado grandes. El tamaño máximo permitido es ' . ($max / 1024 / 1024) . 'MB.'
            ]);
        }
    }

    /**
     * Determine the server 'post_max_size' as bytes.
     *
     * @return int
     */
    protected function getPostMaxSize()
    {
        if (is_numeric($postMaxSize = ini_get('post_max_size'))) {
            return (int) $postMaxSize;
        }

        $metric = strtoupper(substr($postMaxSize, -1));
        $postMaxSize = (int) $postMaxSize;

        switch ($metric) {
            case 'K':
                return $postMaxSize * 1024;
            case 'M':
                return $postMaxSize * 1024 * 1024;
            case 'G':
                return $postMaxSize * 1024 * 1024 * 1024;
            default:
                return $postMaxSize;
        }
    }
}

