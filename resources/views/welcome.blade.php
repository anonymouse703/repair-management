<!DOCTYPE html>
<html class="dark" lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Repair Tracker Management</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=JetBrains+Mono:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
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
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "max-width": "1440px",
                        "margin-desktop": "40px",
                        "xs": "8px",
                        "md": "24px",
                        "xl": "48px",
                        "gutter": "20px",
                        "margin-mobile": "16px",
                        "base": "4px",
                        "sm": "16px",
                        "lg": "32px"
                    },
                    "fontFamily": {
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
                    "fontSize": {
                        "label-sm": ["12px", {
                            "lineHeight": "16px",
                            "letterSpacing": "0.05em",
                            "fontWeight": "500"
                        }],
                        "headline-lg-mobile": ["28px", {
                            "lineHeight": "36px",
                            "fontWeight": "700"
                        }],
                        "label-md": ["14px", {
                            "lineHeight": "16px",
                            "letterSpacing": "0.05em",
                            "fontWeight": "500"
                        }],
                        "headline-md": ["24px", {
                            "lineHeight": "32px",
                            "fontWeight": "600"
                        }],
                        "headline-lg": ["32px", {
                            "lineHeight": "40px",
                            "letterSpacing": "-0.01em",
                            "fontWeight": "600"
                        }],
                        "body-sm": ["14px", {
                            "lineHeight": "20px",
                            "fontWeight": "400"
                        }],
                        "display-lg": ["48px", {
                            "lineHeight": "56px",
                            "letterSpacing": "-0.02em",
                            "fontWeight": "700"
                        }],
                        "body-lg": ["18px", {
                            "lineHeight": "28px",
                            "fontWeight": "400"
                        }],
                        "body-md": ["16px", {
                            "lineHeight": "24px",
                            "fontWeight": "400"
                        }]
                    }
                },
            },
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
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
        }

        .glass-card {
            background: rgba(30, 41, 59, 0.4);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        input:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.4);
        }
    </style>
</head>

<body class="min-h-screen flex flex-col">
    <!-- TopNavBar -->
    <header class="bg-surface-container-lowest fixed top-0 w-full z-50">
        <div class="flex justify-between items-center w-full px-margin-desktop py-4 max-w-max-width mx-auto">
            <div class="flex items-center gap-sm">
                <span class="font-headline-md text-headline-md font-bold text-on-surface">Repair Tracker Management</span>
            </div>

            <div>
                 <a href="{{ route('filament.admin.auth.login') }}" class="bg-primary-container text-on-primary-container px-6 py-2 rounded-lg font-body-md hover:opacity-90 transition-all active:scale-95">
                    Sign In
                </a>
            </div>
        </div>
    </header>
    <main class="flex-grow pt-32 pb-xl">
        <!-- Hero Section -->
        <section class="max-w-max-width mx-auto px-margin-desktop mb-xl text-center">
            <h1 class="font-display-lg text-display-lg mb-4">Track Your Repair</h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant mb-lg">Enter your name or reference number to check status</p>
            <div class="max-w-3xl mx-auto relative">
                <div class="flex items-center bg-surface-container p-2 rounded-xl shadow-lg border border-outline-variant">
                    <span class="material-symbols-outlined text-on-surface-variant ml-4" data-icon="search">search</span>
                    <input class="bg-transparent border-none focus:ring-0 text-on-surface w-full px-4 py-3 font-body-md placeholder-on-surface-variant/50" placeholder="Enter Name or Reference # (e.g., REF-12345)" type="text">
                    <button class="bg-primary-container text-on-primary-container px-8 py-3 rounded-lg font-bold hover:brightness-110 transition-all active:scale-95">
                        Search
                    </button>
                </div>
            </div>
        </section>
        <!-- Context/Quick Stats -->
        <section class="max-w-max-width mx-auto px-margin-desktop mb-xl grid grid-cols-1 md:grid-cols-3 gap-md">
            <div class="glass-card p-md rounded-xl flex items-center gap-md">
                <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined" data-icon="smartphone">smartphone</span>
                </div>
                <div>
                    <div class="font-label-md text-label-md text-on-surface-variant">Active Mobile Repairs</div>
                    <div class="font-headline-md text-headline-md text-on-surface">142</div>
                </div>
            </div>
            <div class="glass-card p-md rounded-xl flex items-center gap-md">
                <div class="w-12 h-12 rounded-lg bg-tertiary/10 flex items-center justify-center text-tertiary">
                    <span class="material-symbols-outlined" data-icon="laptop">laptop</span>
                </div>
                <div>
                    <div class="font-label-md text-label-md text-on-surface-variant">Active Laptop Repairs</div>
                    <div class="font-headline-md text-headline-md text-on-surface">87</div>
                </div>
            </div>
            <div class="glass-card p-md rounded-xl flex items-center gap-md">
                <div class="w-12 h-12 rounded-lg bg-on-secondary-container/10 flex items-center justify-center text-on-secondary-container">
                    <span class="material-symbols-outlined" data-icon="tv">tv</span>
                </div>
                <div>
                    <div class="font-label-md text-label-md text-on-surface-variant">Active TV Repairs</div>
                    <div class="font-headline-md text-headline-md text-on-surface">34</div>
                </div>
            </div>
        </section>
        <!-- Results Section (Sample List) -->
        <section class="max-w-max-width mx-auto px-margin-desktop">
            <div class="bg-surface-container rounded-xl overflow-hidden border border-outline-variant shadow-2xl">
                <div class="px-md py-sm border-b border-outline-variant flex justify-between items-center bg-surface-container-high/50">
                    <h2 class="font-headline-md text-headline-md text-on-surface">Search Results</h2>
                    <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">Real-time status</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-highest/30">
                                <th class="px-md py-4 font-label-md text-label-md text-on-surface-variant border-b border-outline-variant">REFERENCE NO</th>
                                <th class="px-md py-4 font-label-md text-label-md text-on-surface-variant border-b border-outline-variant">OWNER</th>
                                <th class="px-md py-4 font-label-md text-label-md text-on-surface-variant border-b border-outline-variant">DEVICE TYPE</th>
                                <th class="px-md py-4 font-label-md text-label-md text-on-surface-variant border-b border-outline-variant text-center">STATUS</th>
                                <th class="px-md py-4 font-label-md text-label-md text-on-surface-variant border-b border-outline-variant text-right">ACTION</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/30">
                            <!-- Row 1 -->
                            <tr class="hover:bg-surface-container-high transition-colors">
                                <td class="px-md py-4 font-label-md text-label-md text-primary">REF-204592</td>
                                <td class="px-md py-4 font-body-md text-on-surface">Jonathan Wick</td>
                                <td class="px-md py-4">
                                    <div class="flex items-center gap-xs font-body-md">
                                        <span class="material-symbols-outlined text-on-surface-variant" data-icon="smartphone">smartphone</span>
                                        iPhone 13 Pro
                                    </div>
                                </td>
                                <td class="px-md py-4 text-center">
                                    <span class="status-pill bg-yellow-500/10 text-yellow-500 border border-yellow-500/20">In Repair</span>
                                </td>
                                <td class="px-md py-4 text-right">
                                    <button class="text-primary hover:underline font-label-md">View Details</button>
                                </td>
                            </tr>
                            <!-- Row 2 -->
                            <tr class="hover:bg-surface-container-high transition-colors">
                                <td class="px-md py-4 font-label-md text-label-md text-primary">REF-204593</td>
                                <td class="px-md py-4 font-body-md text-on-surface">Sarah Connor</td>
                                <td class="px-md py-4">
                                    <div class="flex items-center gap-xs font-body-md">
                                        <span class="material-symbols-outlined text-on-surface-variant" data-icon="laptop">laptop</span>
                                        MacBook Pro M2
                                    </div>
                                </td>
                                <td class="px-md py-4 text-center">
                                    <span class="status-pill bg-green-500/10 text-green-500 border border-green-500/20">Ready for Pickup</span>
                                </td>
                                <td class="px-md py-4 text-right">
                                    <button class="text-primary hover:underline font-label-md">View Details</button>
                                </td>
                            </tr>
                            <!-- Row 3 -->
                            <tr class="hover:bg-surface-container-high transition-colors">
                                <td class="px-md py-4 font-label-md text-label-md text-primary">REF-204594</td>
                                <td class="px-md py-4 font-body-md text-on-surface">Peter Parker</td>
                                <td class="px-md py-4">
                                    <div class="flex items-center gap-xs font-body-md">
                                        <span class="material-symbols-outlined text-on-surface-variant" data-icon="tv">tv</span>
                                        Samsung OLED 65"
                                    </div>
                                </td>
                                <td class="px-md py-4 text-center">
                                    <span class="status-pill bg-red-500/10 text-red-500 border border-red-500/20">Awaiting Parts</span>
                                </td>
                                <td class="px-md py-4 text-right">
                                    <button class="text-primary hover:underline font-label-md">View Details</button>
                                </td>
                            </tr>
                            <!-- Row 4 -->
                            <tr class="hover:bg-surface-container-high transition-colors">
                                <td class="px-md py-4 font-label-md text-label-md text-primary">REF-204595</td>
                                <td class="px-md py-4 font-body-md text-on-surface">Ellen Ripley</td>
                                <td class="px-md py-4">
                                    <div class="flex items-center gap-xs font-body-md">
                                        <span class="material-symbols-outlined text-on-surface-variant" data-icon="tablet">tablet</span>
                                        iPad Air 5
                                    </div>
                                </td>
                                <td class="px-md py-4 text-center">
                                    <span class="status-pill bg-blue-500/10 text-blue-500 border border-blue-500/20">Testing</span>
                                </td>
                                <td class="px-md py-4 text-right">
                                    <button class="text-primary hover:underline font-label-md">View Details</button>
                                </td>
                            </tr>
                            <!-- Row 5 -->
                            <tr class="hover:bg-surface-container-high transition-colors">
                                <td class="px-md py-4 font-label-md text-label-md text-primary">REF-204596</td>
                                <td class="px-md py-4 font-body-md text-on-surface">Tony Stark</td>
                                <td class="px-md py-4">
                                    <div class="flex items-center gap-xs font-body-md">
                                        <span class="material-symbols-outlined text-on-surface-variant" data-icon="computer">computer</span>
                                        Custom PC Workstation
                                    </div>
                                </td>
                                <td class="px-md py-4 text-center">
                                    <span class="status-pill bg-yellow-500/10 text-yellow-500 border border-yellow-500/20">In Repair</span>
                                </td>
                                <td class="px-md py-4 text-right">
                                    <button class="text-primary hover:underline font-label-md">View Details</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!-- CTA Section -->

    </main>
    <!-- Footer -->
    <footer class="bg-surface-container-low mt-xl">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-xl px-margin-desktop py-xl max-w-max-width mx-auto">
            <div class="space-y-md">
                <div class="flex items-center gap-xs">
                    <span class="material-symbols-outlined text-primary" data-icon="phone_in_talk">phone_in_talk</span>
                    <h4 class="font-headline-md text-headline-md font-semibold text-on-surface">Contact Sales</h4>
                </div>
                <div class="space-y-base">
                    <div class="font-label-sm text-label-sm text-on-surface-variant">CSR</div>
                    <div class="font-body-md text-body-md text-on-surface">+639262087005</div>
                    <div class="font-label-sm text-label-sm text-on-surface-variant pt-xs">CSR 1</div>
                    <div class="font-body-md text-body-md text-on-surface">+639071186618</div>
                </div>
            </div>
            <div class="space-y-md">
                <div class="flex items-center gap-xs">
                    <span class="material-symbols-outlined text-primary" data-icon="storefront">storefront</span>
                    <h4 class="font-headline-md text-headline-md font-semibold text-on-surface">Main Store</h4>
                </div>
                <div class="space-y-base">
                    <div class="font-label-sm text-label-sm text-on-surface-variant">VISIT US</div>
                    <p class="font-body-md text-body-md text-on-surface">
                        Pruok Kalubihan, <br>
                        Barangay Bajumpandan, <br>
                        Negros Oriental Philippines
                    </p>
                </div>
            </div>
            <div class="space-y-md">
                <div class="flex items-center gap-xs">
                    <span class="material-symbols-outlined text-primary" data-icon="alternate_email">alternate_email</span>
                    <h4 class="font-headline-md text-headline-md font-semibold text-on-surface">Email Support</h4>
                </div>
                <div class="space-y-base">
                    <div class="font-label-sm text-label-sm text-on-surface-variant">TECHNICAL HELP</div>
                    <a class="font-body-md text-body-md text-on-surface hover:text-primary transition-colors" href="mailto:jeromevillaver@gmail.com">jeromevillaver@gmail.com</a>
                    <div class="font-label-sm text-label-sm text-on-surface-variant pt-xs">PARTNERSHIPS</div>
                    <div class="font-body-md text-body-md text-on-surface">Annoying Mice Devs</div>
                </div>
            </div>
        </div>
        <div class="px-margin-desktop py-md max-w-max-width mx-auto flex flex-col md:flex-row justify-between items-center border-t border-outline-variant/30 text-on-surface-variant">
            <div class="font-body-sm text-body-sm">Albert Construction and Supplies</div>
            <div class="flex gap-lg font-label-md text-label-md mt-4 md:mt-0">
                <a class="hover:text-primary transition-colors" href="#">Privacy Policy</a>
                <a class="hover:text-primary transition-colors" href="#">Terms of Service</a>
            </div>
            <div class="font-body-sm text-body-sm mt-4 md:mt-0">© 2026 Payag ni Angol.</div>
        </div>
    </footer>
    <script>
        // Simple search interaction
        document.querySelector('button.bg-primary-container').addEventListener('click', function() {
            const btn = this;
            btn.classList.add('scale-95');
            setTimeout(() => {
                btn.classList.remove('scale-95');
                // Simulate refresh or results filter here
                console.log('Searching...');
            }, 100);
        });
    </script>


</body>

</html>