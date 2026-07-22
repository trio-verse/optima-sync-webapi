<?php

namespace App\Services;

use App\Contracts\FileStorageInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;


class LocalStorageService implements FileStorageInterface
{
    protected $disk = 'public';
    public function storeImageAsWebp(UploadedFile $file, string $directory): string
    {

        $filename = uniqid() . '_' . time() . '.webp';
        $path = $directory . '/' . $filename;

        $manager = new ImageManager(new Driver());
        $encodedImage = $manager->read($file->getRealPath())->toWebp(80);
        Storage::disk($this->disk)->put($path, (string) $encodedImage);
        return $path;
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
            Storage::disk($this->disk)->delete($path);
        }

        return false;
    }
}
