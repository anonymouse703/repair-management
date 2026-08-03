<?php

namespace App\Actions\Customer;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use DomainException;

class MergeCustomer
{
    /**
     * Merge one customer into another.
     *
     * All devices and job orders belonging to the source customer
     * will be transferred to the target customer.
     */
    public function handle(
        Customer $source,
        Customer $target,
        bool $deleteSource = true,
    ): Customer {
        if ($source->is($target)) {
            throw new DomainException(
                'You cannot merge a customer into itself.'
            );
        }

        DB::transaction(function () use (
            $source,
            $target,
            $deleteSource,
        ) {

            /*
            |--------------------------------------------------------------------------
            | Transfer Devices
            |--------------------------------------------------------------------------
            */

            $source->devices()->update([
                'customer_id' => $target->id,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Transfer Job Orders
            |--------------------------------------------------------------------------
            */

            $source->jobOrders()->update([
                'customer_id' => $target->id,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Delete old customer
            |--------------------------------------------------------------------------
            */

            if ($deleteSource) {
                $source->delete();
            }
        });

        return $target->fresh();
    }
}