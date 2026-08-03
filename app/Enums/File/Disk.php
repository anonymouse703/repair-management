<?php

namespace App\Enums\File;

use App\Enums\Traits\EnumToArray;

enum Disk: string
{
    use EnumToArray;

    case Local = 'local';
    case Public = 'public';
    case S3 = 's3';
    case S3Videos = 's3_videos';
    case S3Scraped = 's3_scraped';
    case S3Scraped2 = 's3_scraped2';
    case S3Raw = 's3_raw';
    case GoogleCloudStorage = 'gcs';

    /**
     * @param bool $valuesOnly
     * @param bool $keyValue
     * @return array<string|Disk>
     */
    public static function s3Disks(bool $valuesOnly = false, bool $keyValue = false): array
    {
        $disks = [
            self::S3,
            self::S3Videos,
            self::S3Scraped,
            self::S3Scraped2,
            self::S3Raw,
        ];

        if ($keyValue) {
            foreach ($disks as $disk) {
                $diskKeyValues[$disk->value] = $disk->label();
            }

            return $diskKeyValues;
        }

        if(!$valuesOnly) return $disks;

        $diskValues = [];
        foreach ($disks as $disk) {
            $diskValues[] = $disk->value;
        }

        return $diskValues;
    }

    public static function cloudDisks(bool $valuesOnly = false): array
    {
        $gcs = $valuesOnly ? self::GoogleCloudStorage->value : self::GoogleCloudStorage;

        return array_merge(self::s3Disks($valuesOnly), [$gcs]);
    }
}
