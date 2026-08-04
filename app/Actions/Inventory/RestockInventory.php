<?php

namespace App\Actions\Inventory;

use App\Enums\Inventory\MovementType;
use App\Models\InventoryItem;
use App\Models\InventoryMovement;
use App\Models\User;
use DomainException;
use Illuminate\Support\Facades\DB;

class RestockInventory
{
    /**
     * Add stock into inventory.
     */
    public function handle(
        InventoryItem $item,
        int $quantity,
        User $user,
        ?string $remarks = null,
    ): void {

        if ($quantity <= 0) {
            throw new DomainException(
                'Quantity must be greater than zero.'
            );
        }

        DB::transaction(function () use (
            $item,
            $quantity,
            $user,
            $remarks,
        ) {

            $before = $item->quantity;
            $after = $before + $quantity;

            $item->updateQuietly([
                'quantity' => $after,
            ]);

            InventoryMovement::create([
                'inventory_item_id' => $item->id,

                'type' => MovementType::Restock,

                'quantity' => $quantity,

                'before_quantity' => $before,

                'after_quantity' => $after,

                'remarks' => $remarks,

                'created_by' => $user->id,
            ]);
        });
    }
}
