<?php

namespace App\Actions\Inventory;

use App\Enums\Inventory\MovementType;
use App\Models\InventoryItem;
use App\Models\InventoryMovement;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class AdjustInventory
{
    /**
     * Adjust inventory to the actual stock count.
     */
    public function handle(
        InventoryItem $item,
        int $newQuantity,
        User $user,
        ?string $remarks = null,
    ): void {

        if ($newQuantity < 0) {
            throw new InvalidArgumentException(
                'Quantity cannot be negative.'
            );
        }

        DB::transaction(function () use (
            $item,
            $newQuantity,
            $user,
            $remarks,
        ) {

            $before = $item->quantity;

            if ($before === $newQuantity) {
                return;
            }

            InventoryMovement::create([
                'inventory_item_id' => $item->id,

                'type' => MovementType::Adjustment,

                'quantity' => abs($newQuantity - $before),

                'before_quantity' => $before,

                'after_quantity' => $newQuantity,

                'remarks' => $remarks,

                'created_by' => $user->id,
            ]);

            $item->updateQuietly([
                'quantity' => $newQuantity,
            ]);
        });
    }
}
