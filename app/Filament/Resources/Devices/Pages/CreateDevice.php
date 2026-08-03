<?php

namespace App\Filament\Resources\Devices\Pages;

use App\Enums\Device\Status;
use App\Filament\Resources\Devices\DeviceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDevice extends CreateRecord
{
    protected static string $resource = DeviceResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['status'] = Status::Active->value;

        return $data;
    }
}
