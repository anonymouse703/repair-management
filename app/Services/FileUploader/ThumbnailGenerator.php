<?php

namespace App\Services\FileUploader;

use App\Models\File;
use Exception;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ThumbnailGenerator
{
    protected string $fileDir = 'images/thumbnails';

    public function __construct(protected File $file)
    {
        $this->fileDir = app()->environment() . '/' . $this->fileDir;
    }

    public function generate(int $width, int $height): bool
    {
        try {
            $name = pathinfo($this->file->path, PATHINFO_FILENAME);

            $image = Storage::disk($this->file->disk)->get($this->file->path);
            $manager = new ImageManager(new Driver());
            $thumbnail = $manager->read($image)->scale($width, $height);
            $path = $this->fileDir . '/' . $name . '_thumb.png';
            Storage::disk(config('filesystems.default'))->put($path, (string) $thumbnail->encode(), 'public');

            $this->file->thumbnail_path = $path;
            $this->file->save();
        } catch (Exception $e) {
            report($e);
            return false;
        }

        return true;
    }
}
