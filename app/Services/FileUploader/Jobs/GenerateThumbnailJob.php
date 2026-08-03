<?php

namespace App\Services\FileUploader\Jobs;

use App\Models\File;
use App\Services\FileUploader\ThumbnailGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateThumbnailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected File $file, protected int $width, protected int $height)
    {
    }

    public function handle(): void
    {
        (new ThumbnailGenerator($this->file))->generate($this->width, $this->height);
    }
}
