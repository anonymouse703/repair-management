<?php

namespace App\Actions\Inventory;

use App\Enums\Inventory\MovementType;
use App\Models\InventoryItem;
use App\Models\InventoryMovement;
use App\Models\JobOrder;
use App\Models\JobOrderInventory;
use DomainException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UseInventoryForJobOrder
{
    /**
     * Assign inventory to a Job Order.
     */
    public function handle(
        JobOrder $jobOrder,
        InventoryItem $item,
        int $quantity,
        ?string $notes = null,
    ): JobOrderInventory {

        $user = Auth::user();

        if (! $user) {
            throw new DomainException('User is not authenticated.');
        }

        if ($quantity <= 0) {
            throw new DomainException(
                'Quantity must be greater than zero.'
            );
        }

        if (! $item->category->isConsumable()) {
            throw new DomainException(
                'Only consumable inventory can be used on a Job Order.'
            );
        }

        if ($item->quantity < $quantity) {
            throw new DomainException(
                'Not enough stock available.'
            );
        }

        return DB::transaction(function () use (
            $jobOrder,
            $item,
            $quantity,
            $notes,
            $user,
        ) {

            $before = $item->quantity;
            $after = $before - $quantity;

            /*
            |--------------------------------------------------------------------------
            | Record Part Usage
            |--------------------------------------------------------------------------
            */

            $usage = JobOrderInventory::create([
                'job_order_id'      => $jobOrder->id,
                'inventory_item_id' => $item->id,
                'technician_id'     => $user->id,
                'quantity'          => $quantity,
                'cost_at_time'      => $item->cost,
                'price_at_time'     => $item->price,
                'notes'             => $notes,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Deduct Stock
            |--------------------------------------------------------------------------
            */

            $item->updateQuietly([
                'quantity' => $after,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Record Inventory Movement
            |--------------------------------------------------------------------------
            */

            $movement = InventoryMovement::create([
                'inventory_item_id' => $item->id,
                'type'              => MovementType::Consume,
                'quantity'          => $quantity,
                'before_quantity'   => $before,
                'after_quantity'    => $after,
                'remarks'           => sprintf(
                    'Used for Job Order %s',
                    $jobOrder->reference_number,
                ),
                'created_by' => $user->id,
            ]);

            $movement->reference()->associate($jobOrder);
            $movement->save();

            return $usage;
        });
    }
}