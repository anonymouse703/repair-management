<?php

namespace App\Services\File;

use Illuminate\Http\UploadedFile;
use Illuminate\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

class SecureImageUploadService
{
    /**
     * Allowed mime types.
     */
    protected array $allowedMimeTypes = [
        'image/jpeg',
        'image/png',
        'image/webp',
    ];

    /**
     * Maximum upload size (5 MB).
     */
    protected int $maxSize = 5 * 1024 * 1024;

    /**
     * Maximum accepted dimensions.
     */
    protected int $maxWidth = 8000;

    protected int $maxHeight = 8000;

    public function __construct(
        protected ImageManager $images,
    ) {}

    /**
     * Validate, sanitize and store an uploaded image.
     */
    public function store(
        UploadedFile $file,
        string $directory = 'job-order-images',
        string $disk = 'public',
    ): string {

        $this->validate($file);

        try {
            $image = $this->images
                ->fromUpload($file);

        } catch (Throwable) {
            throw new RuntimeException(
                'The uploaded file is not a valid image.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Remove metadata and resize
        |--------------------------------------------------------------------------
        */

        if (
            $image->width() > 1920 ||
            $image->height() > 1920
        ) {
            $image->scaleDown(
                width: 1920,
                height: 1920,
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Encode to remove EXIF / metadata
        |--------------------------------------------------------------------------
        */

        $extension = match ($this->mime($file)) {

            'image/png' => 'png',

            'image/webp' => 'webp',

            default => 'jpg',

        };

        $filename = Str::uuid().'.'.$extension;

        $path = trim($directory, '/').'/'.$filename;

        Storage::disk($disk)->put(
            $path,
            (string) $image->encodeByExtension(
                $extension,
                quality: 85,
            )
        );

        return $path;
    }

    /**
     * Validate uploaded image.
     */
    protected function validate(
        UploadedFile $file,
    ): void {

        if (! $file->isValid()) {
            throw new RuntimeException('Upload failed.');
        }

        if ($file->getSize() > $this->maxSize) {
            throw new RuntimeException(
                'Maximum upload size is 5 MB.'
            );
        }

        $mime = $this->mime($file);

        if (! in_array(
            $mime,
            $this->allowedMimeTypes,
            true,
        )) {
            throw new RuntimeException(
                'Unsupported image type.'
            );
        }

        $size = @getimagesize(
            $file->getRealPath(),
        );

        if (! $size) {
            throw new RuntimeException(
                'Invalid image.'
            );
        }

        if (
            $size[0] > $this->maxWidth ||
            $size[1] > $this->maxHeight
        ) {
            throw new RuntimeException(
                'Image dimensions are too large.'
            );
        }
    }

    /**
     * Determine the real MIME type.
     */
    protected function mime(
        UploadedFile $file,
    ): string {

        return (new \finfo(FILEINFO_MIME_TYPE))
            ->file($file->getRealPath());
    }
}