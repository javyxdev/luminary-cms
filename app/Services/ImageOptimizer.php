<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * Optimizes uploaded images using PHP GD (built-in en XAMPP).
 *
 * - Convierte raster images a WebP (fallback a JPEG si WebP no está disponible)
 * - Redimensiona si el ancho supera $maxWidth (preserva ratio)
 * - SVG y GIF se almacenan sin modificación
 * - Si GD no puede procesar el archivo, almacena el original como fallback
 *
 * Uso:
 *   $path = ImageOptimizer::store($request->file('image'), 'djs');
 *   $path = ImageOptimizer::store($request->file('image'), 'events', maxWidth: 1920, quality: 85);
 */
class ImageOptimizer
{
    /**
     * Optimiza y almacena un archivo de imagen subido.
     *
     * @param UploadedFile $file       Archivo subido
     * @param string       $directory  Subdirectorio en storage/public ('djs', 'events', etc.)
     * @param int          $maxWidth   Ancho máximo en píxeles. 0 = no redimensionar.
     * @param int          $quality    Calidad de salida 1–100 (para WebP y JPEG)
     * @return string                  Ruta relativa dentro del disco public
     */
    public static function store(
        UploadedFile $file,
        string $directory,
        int $maxWidth = 1920,
        int $quality  = 82
    ): string {
        $extension = strtolower($file->getClientOriginalExtension());

        // SVG y GIF no son procesables con GD → guardar tal cual
        if (in_array($extension, ['svg', 'gif'])) {
            return $file->store($directory, 'public');
        }

        // Formato de salida: WebP si está disponible, JPEG como fallback
        $useWebP     = function_exists('imagewebp');
        $outExt      = $useWebP ? 'webp' : 'jpg';
        $filename    = Str::uuid() . '.' . $outExt;
        $storagePath = $directory . '/' . $filename;
        $fullPath    = storage_path('app/public/' . $storagePath);

        // Crear directorio si no existe
        $dir = dirname($fullPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        // Cargar imagen fuente con GD
        $source = self::loadImage($file->getRealPath(), $extension);

        if (!$source) {
            // GD no puede procesarlo → almacenar original sin optimizar
            return $file->store($directory, 'public');
        }

        // Asegurar modo truecolor (necesario para PNG con transparencia)
        imagepalettetotruecolor($source);

        // Redimensionar solo si supera el ancho máximo
        $origW = imagesx($source);
        $origH = imagesy($source);

        if ($maxWidth > 0 && $origW > $maxWidth) {
            $newH   = (int) round($origH * ($maxWidth / $origW));
            $canvas = imagecreatetruecolor($maxWidth, $newH);

            // Preservar canal alfa (transparencia PNG)
            imagealphablending($canvas, false);
            imagesavealpha($canvas, true);

            imagecopyresampled($canvas, $source, 0, 0, 0, 0, $maxWidth, $newH, $origW, $origH);
            imagedestroy($source);
            $source = $canvas;
        }

        // Guardar imagen optimizada
        if ($useWebP) {
            imagewebp($source, $fullPath, $quality);
        } else {
            imagejpeg($source, $fullPath, $quality);
        }

        imagedestroy($source);

        return $storagePath;
    }

    // ── Privado ─────────────────────────────────────────────────────

    private static function loadImage(string $path, string $extension)
    {
        return match ($extension) {
            'jpg', 'jpeg' => @imagecreatefromjpeg($path),
            'png'         => @imagecreatefrompng($path),
            'webp'        => @imagecreatefromwebp($path),
            default       => false,
        };
    }
}
