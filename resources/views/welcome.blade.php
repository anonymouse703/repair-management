<!DOCTYPE html>
<html class="dark" lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Repair Tracker Management</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap"
        rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "tertiary-fixed-dim": "#7bd0ff",
                        "tertiary": "#7bd0ff",
                        "surface-bright": "#2c3a4c",
                        "outline-variant": "#434655",
                        "on-primary-fixed": "#00174b",
                        "on-tertiary-fixed-variant": "#004c69",
                        "error": "#ffb4ab",
                        "secondary-fixed-dim": "#bec6e0",
                        "surface": "#051424",
                        "on-error": "#690005",
                        "on-surface-variant": "#c3c6d7",
                        "inverse-on-surface": "#233143",
                        "on-tertiary-fixed": "#001e2c",
                        "on-error-container": "#ffdad6",
                        "background": "#051424",
                        "inverse-surface": "#d4e4fa",
                        "secondary-container": "#3f465c",
                        "tertiary-fixed": "#c4e7ff",
                        "error-container": "#93000a",
                        "on-primary-fixed-variant": "#003ea8",
                        "tertiary-container": "#00759f",
                        "primary-fixed": "#dbe1ff",
                        "primary": "#b4c5ff",
                        "primary-fixed-dim": "#b4c5ff",
                        "surface-container-lowest": "#010f1f",
                        "on-secondary": "#283044",
                        "on-primary-container": "#eeefff",
                        "on-primary": "#002a78",
                        "on-secondary-fixed": "#131b2e",
                        "inverse-primary": "#0053db",
                        "secondary-fixed": "#dae2fd",
                        "secondary": "#bec6e0",
                        "on-secondary-container": "#adb4ce",
                        "outline": "#8d90a0",
                        "on-tertiary-container": "#e1f2ff",
                        "on-background": "#d4e4fa",
                        "on-secondary-fixed-variant": "#3f465c",
                        "surface-container-low": "#0d1c2d",
                        "surface-container-highest": "#273647",
                        "on-tertiary": "#00354a",
                        "surface-tint": "#b4c5ff",
                        "on-surface": "#d4e4fa",
                        "surface-dim": "#051424",
                        "surface-variant": "#273647",
                        "surface-container": "#122131",
                        "surface-container-high": "#1c2b3c",
                        "primary-container": "#2563eb"
                    },
                    borderRadius: {
                        DEFAULT: "0.125rem",
                        lg: "0.25rem",
                        xl: "0.5rem",
                        full: "0.75rem"
                    },
                    spacing: {
                        "max-width": "1440px",
                        "margin-desktop": "40px",
                        xs: "8px",
                        md: "24px",
                        xl: "48px",
                        gutter: "20px",
                        "margin-mobile": "16px",
                        base: "4px",
                        sm: "16px",
                        lg: "32px"
                    },
                    fontFamily: {
                        "label-sm": ["JetBrains Mono"],
                        "headline-lg-mobile": ["Inter"],
                        "label-md": ["JetBrains Mono"],
                        "headline-md": ["Inter"],
                        "headline-lg": ["Inter"],
                        "body-sm": ["Inter"],
                        "display-lg": ["Inter"],
                        "body-lg": ["Inter"],
                        "body-md": ["Inter"]
                    },
                    fontSize: {
                        "label-sm": ["12px", {
                            lineHeight: "16px",
                            letterSpacing: "0.05em",
                            fontWeight: "500"
                        }],
                        "headline-lg-mobile": ["28px", {
                            lineHeight: "36px",
                            fontWeight: "700"
                        }],
                        "label-md": ["14px", {
                            lineHeight: "16px",
                            letterSpacing: "0.05em",
                            fontWeight: "500"
                        }],
                        "headline-md": ["24px", {
                            lineHeight: "32px",
                            fontWeight: "600"
                        }],
                        "headline-lg": ["32px", {
                            lineHeight: "40px",
                            letterSpacing: "-0.01em",
                            fontWeight: "600"
                        }],
                        "body-sm": ["14px", {
                            lineHeight: "20px",
                            fontWeight: "400"
                        }],
                        "display-lg": ["48px", {
                            lineHeight: "56px",
                            letterSpacing: "-0.02em",
                            fontWeight: "700"
                        }],
                        "body-lg": ["18px", {
                            lineHeight: "28px",
                            fontWeight: "400"
                        }],
                        "body-md": ["16px", {
                            lineHeight: "24px",
                            fontWeight: "400"
                        }]
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #051424;
            color: #d4e4fa;
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .glass-card {
            background: rgba(30, 41, 59, 0.4);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        input:focus,
        select:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.4);
        }
    </style>
</head>

<body class="min-h-screen flex flex-col">

    <header class="bg-surface-container-lowest fixed top-0 w-full z-50">
        <div class="flex justify-between items-center w-full px-margin-desktop py-4 max-w-max-width mx-auto">

            <div class="flex items-center gap-sm">
                <span class="font-headline-md text-headline-md font-bold text-on-surface">
                    Repair Tracker Management
                </span>
            </div>

            <div>
                <a
                    href="{{ route('filament.admin.auth.login') }}"
                    class="bg-primary-container text-on-primary-container px-6 py-2 rounded-lg font-body-md hover:opacity-90 transition-all active:scale-95">
                    Sign In
                </a>
            </div>

        </div>
    </header>


    <main class="flex-grow pt-32 pb-xl">

        {{-- Hero / Search --}}
        <section class="max-w-max-width mx-auto px-margin-desktop mb-xl text-center">

            <h1 class="font-display-lg text-display-lg mb-4">
                Track Your Repair
            </h1>

            <p class="font-body-lg text-body-lg text-on-surface-variant mb-lg">
                Search using your Job Order Reference or Customer Name
            </p>

            <form id="searchForm" class="max-w-4xl mx-auto">

                <div class="bg-surface-container p-3 rounded-xl shadow-lg border border-outline-variant">

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">

                        {{-- Search Type --}}
                        <div>
                            <label
                                for="searchType"
                                class="sr-only">
                                Search By
                            </label>

                            <select
                                id="searchType"
                                name="type"
                                class="w-full rounded-lg bg-surface-container-high border border-outline-variant text-on-surface px-4 py-3">
                                <option value="reference">
                                    JO Reference
                                </option>

                                <option value="customer">
                                    Customer Name
                                </option>
                            </select>
                        </div>


                        {{-- Search Query --}}
                        <div class="md:col-span-2">

                            <label
                                for="searchQuery"
                                class="sr-only">
                                Search
                            </label>

                            <div class="relative">

                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">
                                    search
                                </span>

                                <input
                                    id="searchQuery"
                                    name="query"
                                    type="text"
                                    autocomplete="off"
                                    placeholder="Enter JO-000001"
                                    class="w-full rounded-lg bg-transparent border border-outline-variant text-on-surface pl-12 pr-4 py-3 placeholder:text-on-surface-variant">

                            </div>

                        </div>


                        {{-- Search Button --}}
                        <div>

                            <button
                                id="searchButton"
                                type="submit"
                                class="w-full bg-primary-container text-on-primary-container px-8 py-3 rounded-lg font-bold hover:brightness-110 transition-all active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span id="searchButtonText">
                                    Search
                                </span>
                            </button>

                        </div>

                    </div>

                </div>

            </form>


            {{-- Error --}}
            <div
                id="searchError"
                class="hidden max-w-4xl mx-auto mt-4 bg-error-container text-on-error-container rounded-lg px-4 py-3 text-sm text-left"></div>

        </section>


        {{-- Quick Stats --}}
        <section class="max-w-max-width mx-auto px-margin-desktop mb-xl grid grid-cols-1 md:grid-cols-3 gap-md">

            {{-- Active Mobile Repairs --}}
            <div class="glass-card p-md rounded-xl flex items-center gap-md">

                <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined">
                        smartphone
                    </span>
                </div>

                <div>
                    <div class="font-label-md text-label-md text-on-surface-variant">
                        Active Mobile Repairs
                    </div>

                    <div class="font-headline-md text-headline-md text-on-surface">
                        {{ number_format($activeMobileRepairs) }}
                    </div>
                </div>

            </div>


            {{-- Active Laptop Repairs --}}
            <div class="glass-card p-md rounded-xl flex items-center gap-md">

                <div class="w-12 h-12 rounded-lg bg-tertiary/10 flex items-center justify-center text-tertiary">
                    <span class="material-symbols-outlined">
                        laptop
                    </span>
                </div>

                <div>
                    <div class="font-label-md text-label-md text-on-surface-variant">
                        Active Laptop Repairs
                    </div>

                    <div class="font-headline-md text-headline-md text-on-surface">
                        {{ number_format($activeLaptopRepairs) }}
                    </div>
                </div>

            </div>


            {{-- Active TV Repairs --}}
            <div class="glass-card p-md rounded-xl flex items-center gap-md">

                <div class="w-12 h-12 rounded-lg bg-on-secondary-container/10 flex items-center justify-center text-on-secondary-container">
                    <span class="material-symbols-outlined">
                        tv
                    </span>
                </div>

                <div>
                    <div class="font-label-md text-label-md text-on-surface-variant">
                        Active TV Repairs
                    </div>

                    <div class="font-headline-md text-headline-md text-on-surface">
                        {{ number_format($activeTvRepairs) }}
                    </div>
                </div>

            </div>

        </section>


        {{-- Results --}}
        <section class="max-w-max-width mx-auto px-margin-desktop">

            <div
                id="resultsContainer"
                class="space-y-6">

                <div class="bg-surface-container rounded-xl overflow-hidden border border-outline-variant shadow-2xl">

                    <div class="px-md py-sm border-b border-outline-variant flex justify-between items-center bg-surface-container-high/50">

                        <h2 class="font-headline-md text-headline-md text-on-surface">
                            Search Results
                        </h2>

                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">
                            Real-time status
                        </span>

                    </div>

                    <div class="py-20 text-center text-on-surface-variant">

                        <span class="material-symbols-outlined text-5xl mb-4">
                            search
                        </span>

                        <p>
                            Search for a Job Order to view its details.
                        </p>

                    </div>

                </div>

            </div>

        </section>

    </main>


    {{-- Footer --}}
    <footer class="bg-surface-container-low mt-xl">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-xl px-margin-desktop py-xl max-w-max-width mx-auto">

            <div class="space-y-md">

                <div class="flex items-center gap-xs">

                    <span class="material-symbols-outlined text-primary">
                        phone_in_talk
                    </span>

                    <h4 class="font-headline-md text-headline-md font-semibold text-on-surface">
                        Contact Sales
                    </h4>

                </div>

                <div class="space-y-base">

                    <div class="font-label-sm text-label-sm text-on-surface-variant">
                        CSR
                    </div>

                    <div class="font-body-md text-body-md text-on-surface">
                        +639262087005
                    </div>

                    <div class="font-label-sm text-label-sm text-on-surface-variant pt-xs">
                        CSR 1
                    </div>

                    <div class="font-body-md text-body-md text-on-surface">
                        +639071186618
                    </div>

                </div>

            </div>


            <div class="space-y-md">

                <div class="flex items-center gap-xs">

                    <span class="material-symbols-outlined text-primary">
                        storefront
                    </span>

                    <h4 class="font-headline-md text-headline-md font-semibold text-on-surface">
                        Main Store
                    </h4>

                </div>

                <div class="space-y-base">

                    <div class="font-label-sm text-label-sm text-on-surface-variant">
                        VISIT US
                    </div>

                    <p class="font-body-md text-body-md text-on-surface">
                        Pruok Kalubihan, <br>
                        Barangay Bajumpandan, <br>
                        Negros Oriental Philippines
                    </p>

                </div>

            </div>


            <div class="space-y-md">

                <div class="flex items-center gap-xs">

                    <span class="material-symbols-outlined text-primary">
                        alternate_email
                    </span>

                    <h4 class="font-headline-md text-headline-md font-semibold text-on-surface">
                        Email Support
                    </h4>

                </div>

                <div class="space-y-base">

                    <div class="font-label-sm text-label-sm text-on-surface-variant">
                        TECHNICAL HELP
                    </div>

                    <a
                        class="font-body-md text-body-md text-on-surface hover:text-primary transition-colors"
                        href="mailto:jeromevillaver@gmail.com">
                        jeromevillaver@gmail.com
                    </a>

                    <div class="font-label-sm text-label-sm text-on-surface-variant pt-xs">
                        PARTNERSHIPS
                    </div>

                    <div class="font-body-md text-body-md text-on-surface">
                        Annoying Mice Devs
                    </div>

                </div>

            </div>

        </div>


        <div class="px-margin-desktop py-md max-w-max-width mx-auto flex flex-col md:flex-row justify-between items-center border-t border-outline-variant/30 text-on-surface-variant">

            <div class="font-body-sm text-body-sm">
                Albert Construction and Supplies
            </div>

            <div class="flex gap-lg font-label-md text-label-md mt-4 md:mt-0">

                <a
                    class="hover:text-primary transition-colors"
                    href="#">
                    Privacy Policy
                </a>

                <a
                    class="hover:text-primary transition-colors"
                    href="#">
                    Terms of Service
                </a>

            </div>

            <div class="font-body-sm text-body-sm mt-4 md:mt-0">
                © 2026 Payag ni Angol.
            </div>

        </div>

    </footer>


    <script>
        const form = document.getElementById('searchForm');
        const searchType = document.getElementById('searchType');
        const searchQuery = document.getElementById('searchQuery');
        const searchButton = document.getElementById('searchButton');
        const searchButtonText = document.getElementById('searchButtonText');
        const searchError = document.getElementById('searchError');
        const resultsContainer = document.getElementById('resultsContainer');


        /*
        |--------------------------------------------------------------------------
        | Search Type
        |--------------------------------------------------------------------------
        */

        searchType.addEventListener('change', function() {

            if (this.value === 'reference') {

                searchQuery.placeholder = 'Enter JO-000001';

            } else {

                searchQuery.placeholder = 'Enter Customer Name';

            }

            searchQuery.value = '';
            searchQuery.focus();

            clearSearchError();

        });


        /*
        |--------------------------------------------------------------------------
        | Submit Search
        |--------------------------------------------------------------------------
        */

        form.addEventListener('submit', async function(event) {

            event.preventDefault();

            clearSearchError();

            const type = searchType.value;
            const query = searchQuery.value.trim();


            if (!query) {

                showSearchError(
                    type === 'reference' ?
                    'Please enter a Job Order reference number.' :
                    'Please enter a customer name.'
                );

                searchQuery.focus();

                return;
            }


            setLoading(true);


            resultsContainer.innerHTML = `
            <div class="bg-surface-container rounded-xl border border-outline-variant shadow-2xl">

                <div class="px-md py-sm border-b border-outline-variant bg-surface-container-high/50">

                    <h2 class="font-headline-md text-headline-md text-on-surface">
                        Search Results
                    </h2>

                </div>

                <div class="py-20 text-center text-on-surface-variant">

                    <span class="material-symbols-outlined text-4xl animate-spin">
                        progress_activity
                    </span>

                    <p class="mt-4">
                        Searching...
                    </p>

                </div>

            </div>
        `;


            try {

                const params = new URLSearchParams({
                    type: type,
                    query: query
                });


                const response = await fetch(
                    `{{ route('job-orders.search') }}?${params.toString()}`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }
                );


                const data = await response.json();


                if (!response.ok) {

                    throw new Error(
                        data.message ?? 'Unable to search Job Orders.'
                    );

                }


                if (type === 'reference') {

                    renderReferenceResult(data.data);

                } else {

                    renderCustomerResults(data.data ?? []);

                }


            } catch (error) {

                resultsContainer.innerHTML = '';

                showSearchError(
                    error.message ?? 'Unable to search Job Orders.'
                );

            } finally {

                setLoading(false);

            }

        });


        /*
        |--------------------------------------------------------------------------
        | Reference Result
        |--------------------------------------------------------------------------
        */

        function renderReferenceResult(jobOrder) {

            if (!jobOrder) {

                showNoResults();

                return;

            }

            resultsContainer.innerHTML = `
            <div class="mb-4">

                <h2 class="font-headline-md text-headline-md text-on-surface">
                    Search Result
                </h2>

                <p class="text-sm text-on-surface-variant mt-1">
                    Job Order matching your reference number
                </p>

            </div>

            ${jobOrderCard(jobOrder)}
        `;

        }


        /*
        |--------------------------------------------------------------------------
        | Customer Results
        |--------------------------------------------------------------------------
        */

        function renderCustomerResults(jobOrders) {

            if (!jobOrders.length) {

                showNoResults();

                return;

            }


            resultsContainer.innerHTML = `
            <div class="mb-4">

                <h2 class="font-headline-md text-headline-md text-on-surface">
                    Search Results
                </h2>

                <p class="text-sm text-on-surface-variant mt-1">
                    ${jobOrders.length} Job Order${jobOrders.length === 1 ? '' : 's'} found
                </p>

            </div>

            <div class="space-y-6">
                ${jobOrders.map(jobOrder => jobOrderCard(jobOrder)).join('')}
            </div>
        `;

        }


        /*
        |--------------------------------------------------------------------------
        | Job Order Card
        |--------------------------------------------------------------------------
        */

        function jobOrderCard(jobOrder) {

            const images = Array.isArray(jobOrder.received_images) ?
                jobOrder.received_images :
                [];


            const image = images.length ?
                images[0] :
                null;


            const imageUrl = image ?
                normalizeImageUrl(image) :
                null;


            const customerName =
                jobOrder.customer?.name ??
                jobOrder.customer?.full_name ??
                '—';


            const technicianName =
                jobOrder.technician?.name ??
                jobOrder.technician?.full_name ??
                'Not Assigned';


            const deviceName = [
                    jobOrder.device?.brand?.name,
                    jobOrder.device?.brand,
                    jobOrder.device?.model
                ]
                .filter(Boolean)
                .join(' ') ||
                jobOrder.device?.name ||
                '—';


            const status = formatStatus(jobOrder.status);


            return `
            <article class="glass-card rounded-xl overflow-hidden shadow-2xl">

                <div class="grid grid-cols-1 md:grid-cols-3">

                    {{-- Image --}}
                    <div class="min-h-[280px] md:min-h-[360px] bg-surface-container-high">

                        ${
                            imageUrl
                                ? `
                                    <img
                                        src="${escapeHtml(imageUrl)}"
                                        alt="${escapeHtml(deviceName)}"
                                        class="w-full h-full min-h-[280px] md:min-h-[360px] object-cover"
                                        loading="lazy"
                                        onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');"
                                    >

                                    <div class="hidden w-full h-full min-h-[280px] md:min-h-[360px] items-center justify-center text-on-surface-variant">
                                        <div class="text-center p-6">

                                            <span class="material-symbols-outlined text-5xl">
                                                image_not_supported
                                            </span>

                                            <p class="mt-2">
                                                Image unavailable
                                            </p>

                                        </div>
                                    </div>
                                `
                                : `
                                    <div class="w-full h-full min-h-[280px] md:min-h-[360px] flex items-center justify-center text-on-surface-variant">

                                        <div class="text-center p-6">

                                            <span class="material-symbols-outlined text-6xl">
                                                devices
                                            </span>

                                            <p class="mt-3">
                                                No device image
                                            </p>

                                        </div>

                                    </div>
                                `
                        }

                    </div>


                    {{-- Details --}}
                    <div class="md:col-span-2 p-6 md:p-8">

                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">

                            <div>

                                <p class="font-label-sm text-label-sm text-on-surface-variant uppercase">
                                    Job Order
                                </p>

                                <h3 class="text-3xl font-bold text-primary mt-1">
                                    ${escapeHtml(jobOrder.reference_number ?? '—')}
                                </h3>

                            </div>


                            <span class="status-pill bg-primary/10 text-primary border border-primary/20">
                                ${escapeHtml(status)}
                            </span>

                        </div>


                        {{-- Customer --}}
                        <div class="mt-7">

                            <p class="font-label-sm text-label-sm text-on-surface-variant uppercase">
                                Customer
                            </p>

                            <p class="mt-1 text-lg font-semibold text-on-surface">
                                ${escapeHtml(customerName)}
                            </p>

                        </div>


                        {{-- Device / Technician --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">

                            <div>

                                <p class="font-label-sm text-label-sm text-on-surface-variant uppercase">
                                    Device
                                </p>

                                <div class="flex items-center gap-2 mt-1">

                                    <span class="material-symbols-outlined text-primary">
                                        devices
                                    </span>

                                    <p class="text-lg text-on-surface">
                                        ${escapeHtml(deviceName)}
                                    </p>

                                </div>

                            </div>


                            <div>

                                <p class="font-label-sm text-label-sm text-on-surface-variant uppercase">
                                    Technician
                                </p>

                                <div class="flex items-center gap-2 mt-1">

                                    <span class="material-symbols-outlined text-primary">
                                        engineering
                                    </span>

                                    <p class="text-lg text-on-surface">
                                        ${escapeHtml(technicianName)}
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- Dates --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">

                            <div>

                                <p class="font-label-sm text-label-sm text-on-surface-variant uppercase">
                                    Received
                                </p>

                                <p class="mt-1 text-on-surface">
                                    ${escapeHtml(jobOrder.received_at ?? '—')}
                                </p>

                            </div>


                            <div>

                                <p class="font-label-sm text-label-sm text-on-surface-variant uppercase">
                                    Scheduled
                                </p>

                                <p class="mt-1 text-on-surface">
                                    ${escapeHtml(jobOrder.scheduled_at ?? '—')}
                                </p>

                            </div>

                        </div>


                        {{-- Financial Summary --}}
                        <div class="border-t border-outline-variant mt-7 pt-6">

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

                                <div>

                                    <p class="font-label-sm text-label-sm text-on-surface-variant uppercase">
                                        Estimate
                                    </p>

                                    <p class="mt-1 text-xl font-bold text-on-surface">
                                        ₱${formatMoney(jobOrder.estimate_total)}
                                    </p>

                                </div>


                                <div>

                                    <p class="font-label-sm text-label-sm text-on-surface-variant uppercase">
                                        Paid
                                    </p>

                                    <p class="mt-1 text-xl font-bold text-green-400">
                                        ₱${formatMoney(jobOrder.paid_total)}
                                    </p>

                                </div>


                                <div>

                                    <p class="font-label-sm text-label-sm text-on-surface-variant uppercase">
                                        Balance
                                    </p>

                                    <p class="mt-1 text-xl font-bold text-red-400">
                                        ₱${formatMoney(jobOrder.balance_due)}
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- Notes --}}
                        ${
                            jobOrder.intake_notes
                                ? `
                                    <div class="border-t border-outline-variant mt-7 pt-6">

                                        <p class="font-label-sm text-label-sm text-on-surface-variant uppercase">
                                            Intake Notes
                                        </p>

                                        <p class="mt-2 text-on-surface whitespace-pre-line">
                                            ${escapeHtml(jobOrder.intake_notes)}
                                        </p>

                                    </div>
                                `
                                : ''
                        }


                        {{-- Release information --}}
                        ${
                            jobOrder.released_at
                                ? `
                                    <div class="border-t border-outline-variant mt-7 pt-6">

                                        <div class="flex items-center gap-2 text-green-400">

                                            <span class="material-symbols-outlined">
                                                check_circle
                                            </span>

                                            <p class="font-semibold">
                                                Device Released
                                            </p>

                                        </div>

                                        <p class="mt-1 text-sm text-on-surface-variant">
                                            ${escapeHtml(jobOrder.released_at)}
                                        </p>

                                    </div>
                                `
                                : ''
                        }

                    </div>

                </div>

            </article>
        `;

        }


        /*
        |--------------------------------------------------------------------------
        | Empty State
        |--------------------------------------------------------------------------
        */

        function showNoResults() {

            resultsContainer.innerHTML = `
            <div class="bg-surface-container rounded-xl border border-outline-variant shadow-2xl">

                <div class="py-20 text-center text-on-surface-variant">

                    <span class="material-symbols-outlined text-6xl">
                        search_off
                    </span>

                    <h2 class="text-xl font-semibold text-on-surface mt-4">
                        No Job Orders Found
                    </h2>

                    <p class="mt-2">
                        Try another reference number or customer name.
                    </p>

                </div>

            </div>
        `;

        }


        /*
        |--------------------------------------------------------------------------
        | Search Error
        |--------------------------------------------------------------------------
        */

        function showSearchError(message) {

            searchError.textContent = message;
            searchError.classList.remove('hidden');

        }


        function clearSearchError() {

            searchError.textContent = '';
            searchError.classList.add('hidden');

        }


        /*
        |--------------------------------------------------------------------------
        | Loading
        |--------------------------------------------------------------------------
        */

        function setLoading(loading) {

            searchButton.disabled = loading;

            searchButtonText.textContent =
                loading ?
                'Searching...' :
                'Search';

        }


        /*
        |--------------------------------------------------------------------------
        | Image URL
        |--------------------------------------------------------------------------
        */

        function normalizeImageUrl(image) {

            if (!image) {
                return null;
            }


            // Already an absolute URL.
            if (
                image.startsWith('http://') ||
                image.startsWith('https://') ||
                image.startsWith('//')
            ) {
                return image;
            }


            // Storage::url() usually returns /storage/...
            if (image.startsWith('/')) {
                return image;
            }


            // If the API returns a storage path.
            return `/storage/${image}`;

        }


        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */

        function formatStatus(status) {

            if (!status) {
                return 'Unknown';
            }


            if (typeof status === 'object' && status.value) {
                status = status.value;
            }


            return String(status)
                .replaceAll('_', ' ')
                .replace(/\w/g, character => character.toUpperCase());

        }


        /*
        |--------------------------------------------------------------------------
        | Money
        |--------------------------------------------------------------------------
        */

        function formatMoney(value) {

            const amount = Number(value ?? 0);

            return amount.toLocaleString('en-PH', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

        }


        /*
        |--------------------------------------------------------------------------
        | HTML Escape
        |--------------------------------------------------------------------------
        */

        function escapeHtml(value) {

            if (value === null || value === undefined) {
                return '';
            }


            return String(value)
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');

        }
    </script>

</body>

</html>