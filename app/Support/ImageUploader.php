<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;

/**
 * Stores every uploaded image as WebP under public/{dir}.
 * Returns the public-relative path (e.g. "image/builder/169xxx.webp").
 */
class ImageUploader
{
    public static function store(UploadedFile $file, string $dir, int $quality = 82): string
    {
        $targetDir = public_path($dir);
        if (!is_dir($targetDir)) {
            @mkdir($targetDir, 0775, true);
        }

        $name = time() . '_' . substr(md5($file->getClientOriginalName() . microtime()), 0, 8) . '.webp';
        $dest = $targetDir . DIRECTORY_SEPARATOR . $name;

        $src = self::createImage($file);

        // If we cannot decode it (or GD/WebP missing), fall back to moving the original file.
        if (!$src) {
            $fallback = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move($targetDir, $fallback);
            return $dir . '/' . $fallback;
        }

        // preserve transparency
        imagepalettetotruecolor($src);
        imagealphablending($src, true);
        imagesavealpha($src, true);

        imagewebp($src, $dest, $quality);
        imagedestroy($src);

        return $dir . '/' . $name;
    }

    private static function createImage(UploadedFile $file)
    {
        if (!function_exists('imagewebp')) {
            return null;
        }

        $path = $file->getRealPath();
        $type = @exif_imagetype($path) ?: null;

        switch ($type) {
            case IMAGETYPE_JPEG: return @imagecreatefromjpeg($path);
            case IMAGETYPE_PNG:  return @imagecreatefrompng($path);
            case IMAGETYPE_GIF:  return @imagecreatefromgif($path);
            case IMAGETYPE_WEBP: return @imagecreatefromwebp($path);
            case IMAGETYPE_BMP:  return function_exists('imagecreatefrombmp') ? @imagecreatefrombmp($path) : null;
            default:             return null;
        }
    }
}
