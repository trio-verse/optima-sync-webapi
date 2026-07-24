<?php

namespace App\Services;

use App\Contracts\FileStorageInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Image;


class FileStorageService implements FileStorageInterface
{
    protected $disk = 'public';

    protected array $imageMimeTypes = [
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/webp',
    ];

    public function isImage(UploadedFile $file): bool
    {
        return in_array($file->getMimeType(), $this->imageMimeTypes, true);
    }

    public function upload(UploadedFile $file, string $directory): string
    {
        if ($this->isImage($file)) {
            $maxWidth = 1200;
            $quality = 80;
            $filename = uniqid() . '_' . time() . '.webp';
            $path = $directory . '/' . $filename;

            $image = Image::fromUpload($file);
            $image->scale(width: $maxWidth)
                ->toWebp()
                ->quality($quality);

            Storage::disk($this->disk)->put($path, $image->toBytes());

            return $path;
        }

        return $file->store($directory, $this->disk);
    }

    public function getUrl(string $path): string
    {
        return Storage::disk($this->disk)->url($path);
    }

    public function delete(?string $path): bool
    {
       if (!$path) {
            return false;
        }

        if (Storage::disk($this->disk)->exists($path)) {
            return Storage::disk($this->disk)->delete($path);
        }

        return false;
    }
}
