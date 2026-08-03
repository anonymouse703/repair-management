<?php

namespace App\Services\FileUploader\Facades;

use App\Services\FileUploader\Uploader;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Uploader upload(UploadedFile $uploadedFile)
 *
 * @see \App\Services\FileUploader\FileUploader
 */
class FileUploader extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'file_uploader';
    }
}
