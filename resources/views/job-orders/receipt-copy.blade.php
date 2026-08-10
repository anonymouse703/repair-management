{{-- ============================================================
    RECEIPT COPY

    Variables:
    - $jobOrder
    - $copyType
    - $settings
============================================================ --}}

<div class="receipt-copy">

    {{-- ========================================================
        HEADER
    ========================================================= --}}

    <table class="header-table">
        <tr>

            <td class="shop-info">

                <div class="shop-name">
                    {{ $settings['shop_name'] ?? 'Repair Shop' }}
                </div>

                <div class="shop-details">

                    @if (!empty($settings['business_registration_name']))
                        {{ $settings['business_registration_name'] }}<br>
                    @endif

                    @if (!empty($settings['address']))
                        {{ $settings['address'] }}<br>
                    @endif

                    @if (!empty($settings['contact_number_1']))
                        {{ $settings['contact_number_1'] }}
                    @endif

                    @if (!empty($settings['contact_number_2']))
                        | {{ $settings['contact_number_2'] }}
                    @endif

                    @if (
                        !empty($settings['email']) &&
                        ($settings['receipt_show_email'] ?? true)
                    )
                        <br>
                        {{ $settings['email'] }}
                    @endif

                    @if (
                        !empty($settings['tin']) &&
                        ($settings['receipt_show_tin'] ?? true)
                    )
                        <br>
                        TIN: {{ $settings['tin'] }}
                    @endif

                    @if (!empty($settings['business_registration_number']))
                        <br>
                        Reg. No.: {{ $settings['business_registration_number'] }}
                    @endif

                </div>

            </td>


            <td class="copy-label">

                <div class="copy-label-box">
                    {{ $copyType }}
                </div>

                <div class="jo-number">
                    {{ $jobOrder->reference_number }}
                </div>

            </td>

        </tr>
    </table>


    {{-- ========================================================
        CUSTOMER / DEVICE INFORMATION
    ========================================================= --}}

    <table class="info-table">

        <tr>

            <td class="label">
                Customer:
            </td>

            <td class="value">
                {{ $jobOrder->customer?->name ?? '-' }}
            </td>

            <td class="label">
                Date:
            </td>

            <td class="value">
                {{ $jobOrder->received_at?->format('M d, Y h:i A') ?? '-' }}
            </td>

        </tr>


        <tr>

            <td class="label">
                Contact:
            </td>

            <td class="value">
                {{ $jobOrder->customer?->phone ?? '-' }}
            </td>

            <td class="label">
                Status:
            </td>

            <td class="value">
                {{ $jobOrder->status?->getLabel() ?? '-' }}
            </td>

        </tr>


        <tr>

            <td class="label">
                Device:
            </td>

            <td class="value">

                {{ $jobOrder->device?->brand?->name ?? '' }}

                {{ $jobOrder->device?->model ?? '' }}

            </td>

            <td class="label">
                Technician:
            </td>

            <td class="value">
                {{ $jobOrder->technician?->name ?? 'Unassigned' }}
            </td>

        </tr>

    </table>


    {{-- ========================================================
        INTAKE NOTES
    ========================================================= --}}

    @if (!empty($jobOrder->intake_notes))

        <div class="section-title">
            Intake Notes
        </div>

        <div class="notes">
            {{ $jobOrder->intake_notes }}
        </div>

    @endif


    {{-- ========================================================
        SERVICES
    ========================================================= --}}

    <div class="section-title">
        Services
    </div>

    <table class="items-table">

        <thead>

            <tr>

                <th style="width: 55%;">
                    Service
                </th>

                <th style="width: 15%;" class="text-center">
                    Qty
                </th>

                <th style="width: 15%;" class="text-right">
                    Price
                </th>

                <th style="width: 15%;" class="text-right">
                    Total
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse ($jobOrder->services as $service)

                @php

                    $quantity = (int) (
                        $service->pivot->quantity ?? 1
                    );

                    $price = (float) (
                        $service->pivot->price
                        ?? $service->price
                        ?? 0
                    );

                    $total = $quantity * $price;

                @endphp

                <tr>

                    <td>
                        {{ $service->name }}
                    </td>

                    <td class="text-center">
                        {{ $quantity }}
                    </td>

                    <td class="text-right">
                        ₱{{ number_format($price, 2) }}
                    </td>

                    <td class="text-right">
                        ₱{{ number_format($total, 2) }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="4" class="text-center muted">
                        No services added.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- ========================================================
        PARTS USED
    ========================================================= --}}

    <div class="section-title">
        Parts Used
    </div>

    <table class="items-table">

        <thead>

            <tr>

                <th style="width: 40%;">
                    Part
                </th>

                <th style="width: 15%;" class="text-center">
                    Qty
                </th>

                <th style="width: 20%;" class="text-right">
                    Price
                </th>

                <th style="width: 25%;" class="text-right">
                    Total
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse ($jobOrder->inventoryUsages as $usage)

                @php

                    $quantity = (int) $usage->quantity;

                    $price = (float) $usage->price_at_time;

                    $total = $quantity * $price;

                @endphp

                <tr>

                    <td>
                        {{ $usage->inventoryItem?->name ?? '-' }}
                    </td>

                    <td class="text-center">
                        {{ $quantity }}
                    </td>

                    <td class="text-right">
                        ₱{{ number_format($price, 2) }}
                    </td>

                    <td class="text-right">
                        ₱{{ number_format($total, 2) }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="4" class="text-center muted">
                        No parts used.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- ========================================================
        PAYMENT SUMMARY
    ========================================================= --}}

    <div class="section-title">
        Payment Summary
    </div>

    <table class="totals-table">

        <tr>

            <td>
                Estimated Total:
            </td>

            <td class="text-right">
                ₱{{ number_format((float) $jobOrder->estimate_total, 2) }}
            </td>

        </tr>


        <tr>

            <td>
                Paid:
            </td>

            <td class="text-right">
                ₱{{ number_format((float) $jobOrder->paid_total, 2) }}
            </td>

        </tr>


        <tr class="total">

            <td>
                Balance:
            </td>

            <td class="text-right">
                ₱{{ number_format($jobOrder->balanceDue(), 2) }}
            </td>

        </tr>

    </table>


    {{-- ========================================================
        PAYMENT HISTORY
    ========================================================= --}}

    @if ($jobOrder->payments->isNotEmpty())

        <div class="section-title">
            Payments
        </div>

        <table class="items-table">

            <thead>

                <tr>

                    <th>
                        Date
                    </th>

                    <th>
                        Method
                    </th>

                    <th class="text-right">
                        Amount
                    </th>

                </tr>

            </thead>


            <tbody>

                @foreach ($jobOrder->payments as $payment)

                    <tr>

                        <td>
                            {{ $payment->created_at?->format('M d, Y h:i A') ?? '-' }}
                        </td>

                        <td>
                            {{ $payment->method ?? '-' }}
                        </td>

                        <td class="text-right">
                            ₱{{ number_format((float) $payment->amount, 2) }}
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    @endif


    {{-- ========================================================
        RELEASE NOTES
    ========================================================= --}}

    @if (!empty($jobOrder->release_notes))

        <div class="section-title">
            Release Notes
        </div>

        <div class="notes">
            {{ $jobOrder->release_notes }}
        </div>

    @endif


    {{-- ========================================================
        SIGNATURES
    ========================================================= --}}

    <table class="signature-table">

        <tr>

            <td>

                <div class="signature-space"></div>

                <div class="signature-line">
                    Customer Signature
                </div>

            </td>


            <td>

                <div class="signature-space"></div>

                <div class="signature-line">
                    Authorized Staff
                </div>

            </td>

        </tr>


        <tr>

            <td colspan="2">

                <div class="receipt-footer">

                    {{ $settings['receipt_terms']
                        ?? 'Please present this Job Order when claiming your device.'
                    }}

                </div>

            </td>

        </tr>


        @if (!empty($settings['receipt_footer']))

            <tr>

                <td colspan="2">

                    <div class="receipt-footer">
                        {{ $settings['receipt_footer'] }}
                    </div>

                </td>

            </tr>

        @endif

    </table>

</div>