<?php

namespace App\Filament\Resources\JobOrders\Pages;

use App\Enums\JobOrder\Status;
use App\Filament\Resources\JobOrders\JobOrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateJobOrder extends CreateRecord
{
    protected static string $resource = JobOrderResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['status'] = Status::Received;
        return $data;
    }
}
