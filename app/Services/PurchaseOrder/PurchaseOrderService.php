<?php

namespace App\Services\PurchaseOrder;

use App\Models\AbstractOfCanvass;
use App\Models\Department;
use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PurchaseOrderService
{
    public function generate(AbstractOfCanvass $aoc, array $data): PurchaseOrder
    {
        return DB::transaction(function () use ($aoc, $data) {

            //  Get awarded supplier
            $awardedSupplier = $aoc->awardedSupplier();

            if (! $awardedSupplier) {
                throw new \Exception('No awarded supplier found.');
            }

            $supplier = $awardedSupplier->supplier;
            $procurement = $aoc->procurement;

            //  Resolve users (ONLY prepared + created)
            $accountingHeadId = Department::where('code', 'ACCTG')->value('head_id');
            $createdUser = auth()->user();

            if (! $accountingHeadId || ! $createdUser) {
                throw new \Exception('Required user data not found.');
            }

            $preparedUser = \App\Models\User::find($accountingHeadId);

            // Create Purchase Order (DRAFT ONLY)
            $po = PurchaseOrder::create([
                'procurement_id' => $procurement->id,
                'abstract_of_canvass_supplier_id' => $awardedSupplier->id,

                // Supplier snapshot
                'supplier_id' => $supplier?->id,
                'supplier_name' => $supplier?->name ?? 'N/A',
                'supplier_address' => $supplier?->address ?? null,
                'supplier_tin' => $supplier?->tin_no ?? null,
                'supplier_contact' => $supplier?->contact_no ?? null,

                // PO details
                'po_date' => now(),
                'place_of_delivery' => $data['place_of_delivery'] ?? 'TBD',
                'delivery_days' => $data['delivery_days'] ?? null,
                'delivery_term' => $data['delivery_term'] ?? null,
                'payment_term' => $data['payment_term'] ?? null,
                'mode_of_procurement' => $aoc->mode_of_procurement,

                //  ONLY prepared + created here
                'prepared_by' => $preparedUser?->id,
                'prepared_by_name' => $preparedUser?->name,
                'prepared_by_position' => $preparedUser?->position ?? null,

                'created_by' => $createdUser->id,
                'created_by_name' => $createdUser->name,

                // Status
                'status' => 'draft',
            ]);

            //  Attach PO Items
            $aocItems = $aoc->items()
                ->where('abstract_of_canvass_supplier_id', $awardedSupplier->id)
                ->get();

            $totalAmount = 0;

            foreach ($aocItems as $item) {
                $po->items()->create([
                    'procurement_item_id' => $item->procurement_item_id,
                    'unit' => $item->procurementItem->unit,
                    'description' => $item->procurementItem->description,
                    'quantity' => $item->procurementItem->qty,
                    'unit_cost' => $item->price,
                    'amount' => $item->total,
                ]);

                $totalAmount += $item->total;
            }

            // 6️⃣ Update total
            $po->update([
                'total_amount' => $totalAmount,
            ]);

            return $po;
        });
    }
}