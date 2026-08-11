<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'model' => $this->model ?? '',
            'serial_number' => $this->serial_number ?? '',
            'imei' => $this->imei ?? '',
            'status' => $this->status ?? '',
            'notes' => $this->notes ?? '',

            // RELATIONSHIPS
            'deviceType' => new DeviceTypeResource($this->whenLoaded('type')),
            'customer' => new UserResource($this->whenLoaded('customer')),
            'brand' => new BrandResource($this->whenLoaded('brand')),
            // 'transactions' => TransactionResource::collection($this->whenLoaded('transactions')),
        ];
    }
}
