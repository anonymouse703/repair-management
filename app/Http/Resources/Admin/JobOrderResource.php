<?php

namespace App\Http\Resources\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobOrderResource extends JsonResource
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
            'reference_number' => $this->reference_number ?? '',
            'status' => $this->status?->value,
            'status_label' => $this->status?->getLabel(),
            'received_at' => $this->received_at ? Carbon::parse($this->received_at)->format('Y-m-d') : '',
            'scheduled_at' => $this->scheduled_at ? Carbon::parse($this->scheduled_at)->format('Y-m-d') : '',
            'completed_at' => $this->completed_at ? Carbon::parse($this->completed_at)->format('Y-m-d') : '',
            'released_at' => $this->released_at ? Carbon::parse($this->released_at)->format('Y-m-d') : '',
            'estimate_total' => $this->estimate_total ?? '',
            'paid_total' => $this->paid_total ?? '',
            'intake_notes' => $this->intake_notes ?? '',
            'release_notes' => $this->release_notes ?? '',
            'received_images' => $this->received_images ?? '',

            // RELATIONSHIPS
            'device' => new DeviceResource($this->whenLoaded('device')),
            'customer' => new UserResource($this->whenLoaded('customer')),
            'technician' => new UserResource($this->whenLoaded('technician')),
        ];
    }
}
