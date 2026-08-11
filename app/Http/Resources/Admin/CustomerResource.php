<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'name' => $this->name ?? '',
            'email' => $this->email ?? '',
            'phone' => $this->phone ?? '',
            'company' => $this->company ?? '',
            'address' => $this->address ?? '',
            'preferred_contact' => $this->preferred_contact ?? '',
            'active' => $this->active ?? '',

            // RELATIONSHIPS
            // 'transactions' => TransactionResource::collection($this->whenLoaded('transactions')),
        ];
    }
}
