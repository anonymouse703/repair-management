<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'username' => $this->username ?? '',
            'email' => $this->email ?? '',
            'mobile' => $this->mobile ?? '',
            'address' => $this->address ?? '',
            'role' => $this->role ?? '',
            'is_active' => $this->is_active ?? '',

            // RELATIONSHIPS
            // 'transactions' => TransactionResource::collection($this->whenLoaded('transactions')),
        ];
    }
}
