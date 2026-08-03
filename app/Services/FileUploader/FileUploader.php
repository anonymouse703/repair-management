<?php

namespace App\Services\FileUploader;

use Illuminate\Http\UploadedFile;

class FileUploader
{
    public static function upload(string|UploadedFile $uploadedFile): Uploader
    {
        if (! $uploadedFile instanceof UploadedFile) {
            $uploadedFile = Base64Converter::fromBase64($uploadedFile);
        }
        return new Uploader($uploadedFile);
    }
}
