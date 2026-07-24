<?php

namespace App\Services;

use App\Contracts\FileStorageInterface;
use App\Enums\enMediaMimeTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Str;


class FileStorageService implements FileStorageInterface
{
    protected string $disk;

    public function __construct(string $disk = 'public')
    {
        $this->disk = $disk;
    }

    public function isImage(UploadedFile $file): bool
    {
        return in_array($file->getMimeType(), enMediaMimeTypes::imageTypes(), true);
    }

    /**
     * return the path of the file
     * store the file in database and in the disk
     * @param UploadedFile $file
     * @param Model $model
     * @param string $fileType
     * @param string $directory
     * @param bool $isSingle
     * @return bool|string
     */
    public function upload(UploadedFile $file, Model $model, string $fileType, string $directory = "uploads", bool $isSingle = false): string
    {
        // 1. Determine storage path & handle WebP conversion for photos
        if ($this->isImage($file)) {
            $path = $this->uploadAndConvertToWebp($file, $directory);
            $mimeType = 'image/webp';
        } else {
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;

            $path = $file->storeAs($directory, $fileName, $this->disk);
            $mimeType = $file->getClientMimeType();
        }

        // delete the existing attachment file first in 1-to-1 relations
        if ($isSingle) {
            $existing = $model->attachments()->where('file_type', $fileType)->first();
            if ($existing) {
                $this->delete($path);
            }
        }

        // 3. Create and return the new attachment
        $model->attachments()->create([
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $fileType,
            'mime_type' => $mimeType,
            'size' => $file->getSize(),
        ]);
        return $path;
    }

    // get the full file url
    public function getUrl(string $path): string
    {
        return Storage::url($path);
    }

    // delete the file from the disk
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

    protected function uploadAndConvertToWebp(UploadedFile $file, string $directory): string
    {
        $maxWidth = 1200;
        $quality = 80;
        $fileName = Str::uuid() . "." . 'webp';
        $fullPath = trim($directory, '/') . "/" . $fileName;

        $encodedImage = Image::fromUpload($file)->scale($maxWidth)->toWebp()->quality($quality);

        Storage::disk($this->disk)->put($fullPath, $encodedImage->toBytes());

        return $fullPath;
    }
}
