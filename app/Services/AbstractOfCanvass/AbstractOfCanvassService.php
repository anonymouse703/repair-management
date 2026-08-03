<?php

namespace App\Services\AbstractOfCanvass;

use App\Models\AbstractOfCanvass;

class AbstractOfCanvassService
{
    public function create(array $data): AbstractOfCanvass
    {
        $suppliersPayload = $data['suppliers'] ?? [];
        unset($data['suppliers']);

        $data['field_office_id'] = auth()->user()->field_office_id;

        $canvass = AbstractOfCanvass::create($data);

        $this->syncSuppliers($canvass, $suppliersPayload);

        return $canvass;
    }

    public function update(AbstractOfCanvass $canvass, array $data): AbstractOfCanvass
    {
        $suppliersPayload = $data['suppliers'] ?? [];
        unset($data['suppliers']);

        $canvass->update($data);

        // Delete old suppliers + items, then re-insert
        $canvass->canvassSuppliers()->each(fn($s) => $s->items()->delete());
        $canvass->canvassSuppliers()->delete();

        $this->syncSuppliers($canvass, $suppliersPayload);

        return $canvass;
    }

    protected function syncSuppliers(AbstractOfCanvass $canvass, array $suppliersPayload): void
    {
        // $suppliersPayload is keyed 1, 2, 3 from the form
        foreach ($suppliersPayload as $order => $supplierData) {
            // Skip empty supplier tabs
            if (empty($supplierData['supplier_id'])) {
                continue;
            }

            $items = $supplierData['items'] ?? [];
            unset($supplierData['items']);

            $supplier = $canvass->canvassSuppliers()->create([
                'supplier_id'     => $supplierData['supplier_id'],
                'supplier_order'  => $supplierData['supplier_order'] ?? $order,
                'philgeps_no'     => $supplierData['philgeps_no'] ?? null,
                'tin_no'          => $supplierData['tin_no'] ?? null,
                'mode_of_payment' => $supplierData['mode_of_payment'] ?? null,
            ]);

            foreach ($items as $item) {
                if (empty($item['procurement_item_id'])) {
                    continue;
                }

                $supplier->items()->create([
                    'abstract_of_canvass_id'          => $canvass->id,
                    'procurement_item_id'        => $item['procurement_item_id'],
                    'brand_offered'                   => $item['brand_offered'] ?? null,
                    'price'                           => $item['price'] ?? 0,
                    'total'                           => $item['total'] ?? 0,
                ]);
            }
        }
    }
}