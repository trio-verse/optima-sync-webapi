<?php

namespace App\Contracts;

use Illuminate\Http\UploadedFile;

interface FileStorageInterface
{
    /**
     * حفظ الملف وإرجاع المسار
     *
     * @param UploadedFile $file
     * @param string $directory
     * @return string
     */
    public function upload(UploadedFile $file, string $directory): string;

     /**
     * Store an image as WebP and return the stored path.
     */
    public function getUrl(string $path): string;

    /**
     * Delete a file from storage.
     */
    public function delete(?string $path): bool;
   
}
