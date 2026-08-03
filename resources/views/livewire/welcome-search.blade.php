<div class="space-y-6">
    <section class="mb-10 rounded-3xl border border-slate-200/80 bg-white/95 p-6 shadow-sm shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-950 dark:shadow-none sm:p-8">
        <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Job Order Search</p>
                <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-900 dark:text-white sm:text-4xl">Find client items by name or reference number.</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-600 dark:text-slate-300">Search for a customer name or a job order reference. Results include device details, item services, and current job status.</p>
            </div>
        </div>

        <form wire:submit.prevent="search" class="space-y-4">
            <div class="grid gap-4 sm:grid-cols-[1fr_auto]">
                <label class="sr-only" for="query">Search query</label>
                <input
                    id="query"
                    wire:model.defer="search"
                    type="search"
                    placeholder="Enter client name or reference number"
                    class="min-w-0 flex-1 rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-slate-900 focus:ring-2 focus:ring-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:focus:border-slate-400 dark:focus:ring-slate-700"
                />

                <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Search</button>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-start">
                <label class="inline-flex cursor-pointer items-center gap-3 rounded-full border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 shadow-sm transition hover:border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
                    <input type="radio" wire:model.defer="searchBy" name="search_by" value="name" class="h-4 w-4 text-slate-900 accent-slate-900">
                    Search by client name
                </label>

                <label class="inline-flex cursor-pointer items-center gap-3 rounded-full border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 shadow-sm transition hover:border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
                    <input type="radio" wire:model.defer="searchBy" name="search_by" value="reference" class="h-4 w-4 text-slate-900 accent-slate-900">
                    Search by reference number
                </label>
            </div>
        </form>
    </section>

    <section class="space-y-6">
        @if ($searchPerformed)
            <div class="rounded-3xl border border-slate-200/80 bg-white/95 p-6 shadow-sm shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-950 dark:shadow-none">
                <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">Search results</p>
                        <p class="mt-1 text-sm text-slate-600 dark:text-slate-300">Showing results for <span class="font-semibold text-slate-900 dark:text-white">{{ $search }}</span> using <span class="font-semibold text-slate-900 dark:text-white">{{ $searchBy === 'reference' ? 'reference number' : 'client name' }}</span>.</p>
                    </div>
                    <span class="rounded-full bg-slate-100 px-3 py-2 text-sm font-medium text-slate-700 dark:bg-slate-800 dark:text-slate-200">{{ $jobOrders->count() }} result{{ $jobOrders->count() === 1 ? '' : 's' }}</span>
                </div>

                @if ($jobOrders->isEmpty())
                    <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center text-slate-600 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300">
                        No job orders were found for that search. Try a different client name or reference number.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full border-separate border-spacing-0 text-sm">
                            <thead>
                                <tr class="border-b border-slate-200/80 text-left text-xs font-semibold uppercase tracking-[0.15em] text-slate-500 dark:border-slate-800 dark:text-slate-400">
                                    <th class="px-4 py-3">Reference</th>
                                    <th class="px-4 py-3">Client</th>
                                    <th class="px-4 py-3">Device</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3">Items</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200/75 dark:divide-slate-800">
                                @foreach ($jobOrders as $jobOrder)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-900/70">
                                        <td class="px-4 py-4 align-top text-slate-900 dark:text-slate-100">
                                            <div class="font-semibold">{{ $jobOrder->reference_number }}</div>
                                            <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">Received {{ optional($jobOrder->received_at)->format('M j, Y') ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-4 py-4 align-top text-slate-900 dark:text-slate-100">
                                            <div class="font-semibold">{{ $jobOrder->customer->name }}</div>
                                            <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ $jobOrder->customer->phone ?? 'No phone' }}</div>
                                        </td>
                                        <td class="px-4 py-4 align-top text-slate-900 dark:text-slate-100">
                                            <div class="font-semibold">{{ $jobOrder->device->type ?? 'Device' }}</div>
                                            <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ $jobOrder->device->brand }} {{ $jobOrder->device->model }}</div>
                                        </td>
                                        <td class="px-4 py-4 align-top">
                                            <span class="status-badge status-{{ $jobOrder->status }}">{{ str_replace('_', ' ', ucfirst($jobOrder->status)) }}</span>
                                        </td>
                                        <td class="px-4 py-4 align-top text-slate-900 dark:text-slate-100">
                                            @if ($jobOrder->services->isEmpty())
                                                <span class="text-sm text-slate-500 dark:text-slate-400">No items added</span>
                                            @else
                                                <ul class="space-y-2">
                                                    @foreach ($jobOrder->services as $service)
                                                        <li>
                                                            <div class="font-medium">{{ $service->name }}</div>
                                                            <div class="text-xs text-slate-500 dark:text-slate-400">Qty: {{ $service->pivot->quantity }} · ₱{{ number_format($service->pivot->price, 2) }}</div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        @else
            <div class="rounded-3xl border border-slate-200/80 bg-slate-50 p-8 text-center text-slate-600 dark:border-slate-800 dark:bg-slate-950 dark:text-slate-300">
                Start a search to view job order status and client items.
            </div>
        @endif
    </section>
</div>
