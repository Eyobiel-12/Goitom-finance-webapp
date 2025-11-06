<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Goitom Finance - De moderne financiële oplossing voor Habesha freelancers</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&family=playfair-display:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
    
    <style>
        body {
            background: linear-gradient(to bottom, #0b0b0b 0%, #1a1a1a 50%, #0b0b0b 100%);
        }
        html{scroll-behavior:smooth}
        /* marquee */
        .logo-row{display:flex;align-items:center;gap:3rem;width:max-content}
        .marquee{overflow:hidden;mask-image:linear-gradient(to right,transparent,black 10%,black 90%,transparent)}
        .marquee-track{display:flex;gap:3rem;animation:marquee 24s linear infinite}
        .marquee:hover .marquee-track{animation-play-state:paused}
        @keyframes marquee{from{transform:translateX(0)}to{transform:translateX(-50%)} }

        /* 3D playground */
        .perspective-1000{perspective:1000px}
        .preserve-3d{transform-style:preserve-3d}
        .layer{position:absolute;inset:0;transform:translateZ(0)}
        .glow{filter:drop-shadow(0 20px 60px rgba(234,179,8,.25))}

        /* Feature card tilt */
        .tilt-parent{perspective:800px}
        .feature-card{transform-style:preserve-3d;will-change:transform;transition:transform .25s ease, box-shadow .25s ease}
        .feature-card:hover{box-shadow:0 20px 40px rgba(0,0,0,.35)}

        /* Magnetic buttons */
        .magnet{position:relative;will-change:transform;transition:transform .15s ease}
        .magnet:hover{transform:translateZ(0) scale(1.02)}
        
        /* Depth blur toggle */
        .blurred{filter:blur(4px)}
            </style>
    </head>
<body class="font-sans antialiased">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 bg-gray-950/90 backdrop-blur-xl border-b border-yellow-400/20">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('logo.png') }}" alt="Goitom Finance" class="h-10 rounded-lg shadow-lg object-contain">
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('app.dashboard') }}" class="px-4 py-2 text-yellow-400 hover:text-yellow-300 transition-colors">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-gray-400 hover:text-yellow-400 transition-colors">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="px-6 py-2 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all">
                            Start Gratis
                        </a>
                    @endauth
                </div>
            </div>
        </div>
                </nav>

    <!-- Hero Section -->
    <section class="min-h-screen flex items-center justify-center pt-24 pb-12 px-6 relative overflow-hidden perspective-1000" id="hero-3d">
        <!-- decorative circles -->
        <div class="pointer-events-none absolute -top-32 -left-32 w-96 h-96 rounded-full bg-yellow-500/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-40 -right-40 w-[32rem] h-[32rem] rounded-full bg-yellow-600/10 blur-3xl"></div>
        <div class="max-w-7xl mx-auto preserve-3d">
            <div class="text-center mb-12">
                <!-- Logo -->
                <div class="flex justify-center mb-8">
                    <img src="{{ asset('logo.png') }}" alt="Goitom Finance" class="h-24 rounded-lg shadow-2xl shadow-yellow-400/20 object-contain">
                </div>
                
                <h1 class="text-6xl md:text-7xl font-bold mb-6 leading-tight will-animate" data-anim="fade-up" data-delay="0.1">
                    <span class="text-white">Beheer je financiën</span>
                    <br>
                    <span class="bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent">zoals een pro</span>
                </h1>
                <p class="text-xl text-gray-400 max-w-3xl mx-auto mb-8 will-animate" data-anim="fade-up" data-delay="0.2">
                    De all-in-one oplossing voor Habesha freelancers om klanten, projecten, facturen en BTW naadloos te beheren.
                </p>
                <div class="flex items-center justify-center gap-4 flex-wrap will-animate" data-anim="fade-up" data-delay="0.3">
                    <a href="{{ route('register') }}" class="magnet group px-8 py-4 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all duration-300 flex items-center will-float">
                        Start Gratis
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </a>
                    <a href="#features" class="magnet px-8 py-4 bg-gray-900 border border-gray-700 rounded-xl font-semibold text-white hover:border-yellow-400 transition-all will-float" data-float-delay="0.15">
                        Bekijk Features
                    </a>
                </div>
            </div>

            <!-- Dashboard Preview -->
            <!-- 3D card stack -->
            <div class="mt-16 relative will-animate" data-anim="scale-in" data-delay="0.2">
                <div class="relative h-[420px] sm:h-[520px]">
                    <!-- base plate -->
                    <div class="absolute left-1/2 -translate-x-1/2 bottom-4 w-[80%] h-6 rounded-full bg-black/50 blur-2xl"></div>
                    <!-- back card -->
                    <div class="layer glow" style="transform: translateZ(-60px) rotateX(6deg)">
                        <div class="mx-auto max-w-5xl bg-gradient-to-br from-gray-900 to-gray-950 rounded-2xl p-6 border border-yellow-400/10"></div>
                    </div>
                    <!-- mid card -->
                    <div class="layer" style="transform: translateZ(-20px) rotateX(4deg)">
                        <div class="mx-auto max-w-5xl bg-gradient-to-br from-gray-900 to-gray-950 rounded-2xl p-7 border border-yellow-400/20">
                            <div class="aspect-video rounded-lg overflow-hidden border border-transparent"></div>
                        </div>
                    </div>
                    <!-- front floating widgets -->
                    <div class="layer" style="transform: translateZ(40px)"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 px-6 bg-gray-950/50">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-16">
                <span class="text-white">Alles wat je nodig hebt om</span>
                <br>
                <span class="bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent">succesvol te zijn</span>
            </h2>
            <!-- Trust / logos bar -->
            <div class="mb-16 marquee will-animate" data-anim="fade-up" data-delay="0.1">
                <div class="marquee-track">
                    <div class="logo-row">
                        <img src="https://dummyimage.com/120x40/2d2d2d/e5e7eb&text=Klarna" class="opacity-70" alt="brand" />
                        <img src="https://dummyimage.com/120x40/2d2d2d/e5e7eb&text=Stripe" class="opacity-70" alt="brand" />
                        <img src="https://dummyimage.com/120x40/2d2d2d/e5e7eb&text=Notion" class="opacity-70" alt="brand" />
                        <img src="https://dummyimage.com/120x40/2d2d2d/e5e7eb&text=Slack" class="opacity-70" alt="brand" />
                        <img src="https://dummyimage.com/120x40/2d2d2d/e5e7eb&text=Resend" class="opacity-70" alt="brand" />
                    </div>
                    <div class="logo-row">
                        <img src="https://dummyimage.com/120x40/2d2d2d/e5e7eb&text=Klarna" class="opacity-70" alt="brand" />
                        <img src="https://dummyimage.com/120x40/2d2d2d/e5e7eb&text=Stripe" class="opacity-70" alt="brand" />
                        <img src="https://dummyimage.com/120x40/2d2d2d/e5e7eb&text=Notion" class="opacity-70" alt="brand" />
                        <img src="https://dummyimage.com/120x40/2d2d2d/e5e7eb&text=Slack" class="opacity-70" alt="brand" />
                        <img src="https://dummyimage.com/120x40/2d2d2d/e5e7eb&text=Resend" class="opacity-70" alt="brand" />
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 tilt-parent">
                <!-- Feature 1 -->
                <div class="feature-card bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl p-8 border border-yellow-400/20 hover:border-yellow-400/50 transition-all">
                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Klant Management</h3>
                    <p class="text-gray-400">Bewaar alle klantgegevens op één plek. Contactinformatie, projecthistorie en meer.</p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl p-8 border border-yellow-400/20 hover:border-yellow-400/50 transition-all">
                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Professionele Facturen</h3>
                    <p class="text-gray-400">Genereer prachtige PDF facturen met je eigen branding. Verzend direct per e-mail.</p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl p-8 border border-yellow-400/20 hover:border-yellow-400/50 transition-all">
                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Project Tracking</h3>
                    <p class="text-gray-400">Houd uren en projectvoortgang bij. Zie direct wat winstgevend is.</p>
                </div>

                <!-- Feature 4 -->
                <div class="feature-card bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl p-8 border border-yellow-400/20 hover:border-yellow-400/50 transition-all">
                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Betalingen</h3>
                    <p class="text-gray-400">Track alle betalingen en blijf op de hoogte van openstaande bedragen.</p>
                </div>

                <!-- Feature 5 -->
                <div class="feature-card bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl p-8 border border-yellow-400/20 hover:border-yellow-400/50 transition-all">
                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">BTW Rapportage</h3>
                    <p class="text-gray-400">Genereer automatisch BTW rapporten. Altijd klaar voor de belastingdienst.</p>
                </div>

                <!-- Feature 6 -->
                <div class="feature-card bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl p-8 border border-yellow-400/20 hover:border-yellow-400/50 transition-all">
                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Dashboard Insights</h3>
                    <p class="text-gray-400">Real-time statistieken en inzichten om je bedrijf te laten groeien.</p>
                </div>
            </div>
            <!-- KPI counters -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-16 will-animate" data-anim="fade-up" data-delay="0.1">
                <div class="text-center p-6 rounded-xl bg-gray-900/60 border border-gray-800"><div class="text-3xl font-extrabold text-yellow-400" data-counter="2.5">0</div><div class="text-gray-400 mt-1">Miljoen omzet verwerkt</div></div>
                <div class="text-center p-6 rounded-xl bg-gray-900/60 border border-gray-800"><div class="text-3xl font-extrabold text-yellow-400" data-counter="12">0</div><div class="text-gray-400 mt-1">Gem. uur per week bespaard</div></div>
                <div class="text-center p-6 rounded-xl bg-gray-900/60 border border-gray-800"><div class="text-3xl font-extrabold text-yellow-400" data-counter="98">0</div><div class="text-gray-400 mt-1">% klanttevredenheid</div></div>
                <div class="text-center p-6 rounded-xl bg-gray-900/60 border border-gray-800"><div class="text-3xl font-extrabold text-yellow-400" data-counter="3">0</div><div class="text-gray-400 mt-1">Dagen tot eerste factuur</div></div>
            </div>
        </div>
    </section>

    <!-- Pricing -->
    <section id="pricing" class="py-24 px-6">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-16 text-white"><span class="bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent">Eerlijke prijzen</span> <span class="text-white">voor elke fase</span></h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 will-animate" data-anim="fade-up" data-delay="0.1">
                <div class="rounded-2xl border border-gray-800 bg-gray-950 p-8">
                    <h3 class="text-2xl font-bold text-white mb-2">Starter</h3>
                    <p class="text-gray-400 mb-6">Alles om te beginnen met factureren.</p>
                    <div class="text-5xl font-extrabold text-white mb-2">€15<span class="text-base text-gray-300">/maand</span></div>
                    <p class="text-sm text-blue-400 mb-6">3 dagen gratis trial</p>
                    <ul class="text-gray-300 space-y-2 mb-8">
                        <li>• Onbeperkt facturen</li>
                        <li>• Klanten & projecten</li>
                        <li>• BTW aangifte basis</li>
                    </ul>
                    <a href="{{ route('register') }}" class="magnet inline-block px-6 py-3 bg-yellow-500 text-gray-900 rounded-xl font-semibold">Start 3-daagse trial</a>
                </div>
                <div class="rounded-2xl border border-yellow-500/40 bg-gradient-to-br from-gray-900 to-gray-950 p-8 relative overflow-hidden">
                    <span class="absolute top-4 right-4 text-xs px-2 py-1 rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500/40">Populair</span>
                    <h3 class="text-2xl font-bold text-white mb-2">Pro</h3>
                    <p class="text-gray-400 mb-6">Voor serieuze ZZP'ers die willen schalen.</p>
                    <div class="text-5xl font-extrabold text-white mb-2">€22<span class="text-base text-gray-300">/maand</span></div>
                    <p class="text-sm text-blue-400 mb-6">3 dagen gratis trial</p>
                    <!-- badge removed by request -->
                    <ul class="text-gray-300 space-y-2 mb-8">
                        <li>• Alles uit Starter</li>
                        <li>• E-mail verzenden & herinneringen</li>
                        <li>• Geavanceerde BTW & correcties</li>
                    </ul>
                    <a href="{{ route('register') }}" class="magnet inline-block px-6 py-3 bg-yellow-500 text-gray-900 rounded-xl font-semibold">Probeer Pro</a>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 px-6">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                Klaar om je financiën naar het volgende niveau te tillen?
            </h2>
            <p class="text-xl text-gray-400 mb-8">
                Start vandaag nog met Goitom Finance. Geen creditcard nodig.
            </p>
            <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl font-semibold text-gray-900 shadow-lg shadow-yellow-400/30 hover:shadow-yellow-400/50 transition-all duration-300">
                Start Jouw Gratis Trial
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-8 px-6 border-t border-gray-800">
        <div class="max-w-7xl mx-auto text-center text-gray-500">
            <p>&copy; {{ date('Y') }} Goitom Finance. Alle rechten voorbehouden.</p>
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            gsap.registerPlugin(ScrollTrigger);
            const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            if (prefersReduced) return;

            // Fade-up animation helper
            gsap.utils.toArray('.will-animate').forEach((el) => {
                const type = el.dataset.anim || 'fade-up';
                const delay = parseFloat(el.dataset.delay || '0');
                const config = { opacity: 0, y: type === 'fade-up' ? 30 : 0, scale: type === 'scale-in' ? 0.95 : 1 };
                gsap.from(el, {
                    ...config,
                    duration: 0.8,
                    ease: 'power3.out',
                    delay,
                    scrollTrigger: { trigger: el, start: 'top 85%' }
                });
            });

            // Subtle float on CTAs
            gsap.utils.toArray('.will-float').forEach((btn) => {
                const d = parseFloat(btn.dataset.floatDelay || '0');
                gsap.to(btn, { y: -4, repeat: -1, yoyo: true, ease: 'sine.inOut', duration: 2.5, delay: d });
            });

            // Parallax on hero screenshot
            gsap.to('#hero-screenshot', {
                yPercent: 5,
                ease: 'none',
                scrollTrigger: { trigger: '#hero-screenshot', start: 'top bottom', scrub: 0.5 }
            });

            // Reveal feature cards on scroll
            gsap.utils.toArray('#features .bg-gradient-to-br').forEach((card, i) => {
                gsap.from(card, {
                    opacity: 0,
                    y: 20,
                    duration: 0.6,
                    delay: (i % 3) * 0.08,
                    ease: 'power2.out',
                    scrollTrigger: { trigger: card, start: 'top 88%' }
                });
            });

            // 3D tilt on feature cards
            gsap.utils.toArray('.feature-card').forEach((card) => {
                const bounds = () => card.getBoundingClientRect();
                const rot = { x: 0, y: 0 };
                const xTo = gsap.quickTo(card, 'rotateY', { duration: 0.3, ease: 'power3.out' });
                const yTo = gsap.quickTo(card, 'rotateX', { duration: 0.3, ease: 'power3.out' });
                const zTo = gsap.quickTo(card, 'translateZ', { duration: 0.3, ease: 'power3.out' });
                card.addEventListener('mousemove', (e) => {
                    const b = bounds();
                    const rx = (e.clientY - (b.top + b.height / 2)) / (b.height / 2);
                    const ry = (e.clientX - (b.left + b.width / 2)) / (b.width / 2);
                    yTo(gsap.utils.clamp(-10, 10, -rx * 12));
                    xTo(gsap.utils.clamp(-10, 10, ry * 12));
                    zTo(18);
                });
                card.addEventListener('mouseleave', () => { xTo(0); yTo(0); zTo(0); });
            });

            // Magnetic buttons
            gsap.utils.toArray('.magnet').forEach((btn) => {
                const radius = 120;
                const xTo = gsap.quickTo(btn, 'x', { duration: 0.2, ease: 'power2.out' });
                const yTo = gsap.quickTo(btn, 'y', { duration: 0.2, ease: 'power2.out' });
                const reset = () => { xTo(0); yTo(0); };
                document.addEventListener('mousemove', (e) => {
                    const b = btn.getBoundingClientRect();
                    const cx = b.left + b.width / 2;
                    const cy = b.top + b.height / 2;
                    const dx = e.clientX - cx;
                    const dy = e.clientY - cy;
                    const dist = Math.hypot(dx, dy);
                    if (dist < radius) {
                        const strength = (radius - dist) / radius;
                        xTo(dx * 0.15 * strength);
                        yTo(dy * 0.15 * strength);
                    } else {
                        reset();
                    }
                });
                btn.addEventListener('mouseleave', reset);
            });

            // coin badge removed

            // Depth-of-field blur on hero when features in view
            ScrollTrigger.create({
                trigger: '#features',
                start: 'top center',
                onEnter: () => document.getElementById('hero-3d').classList.add('blurred'),
                onLeaveBack: () => document.getElementById('hero-3d').classList.remove('blurred')
            });

            // Count up KPIs
            gsap.utils.toArray('[data-counter]').forEach((el) => {
                const end = parseFloat(el.getAttribute('data-counter'));
                const obj = { val: 0 };
                ScrollTrigger.create({
                    trigger: el,
                    start: 'top 90%',
                    once: true,
                    onEnter: () => {
                        gsap.to(obj, { val: end, duration: 1.6, ease: 'power2.out', onUpdate: () => {
                            el.textContent = (obj.val).toLocaleString('nl-NL', { maximumFractionDigits: 1 });
                        }});
                    }
                });
            });

            // 3D mouse tilt on hero stack
            const section = document.getElementById('hero-3d');
            const container = section.querySelector('.preserve-3d');
            const clamp = gsap.utils.clamp(-8, 8);
            let xTo = gsap.quickTo(container, 'rotateY', { duration: 0.6, ease: 'power3.out' });
            let yTo = gsap.quickTo(container, 'rotateX', { duration: 0.6, ease: 'power3.out' });
            section.addEventListener('mousemove', (e) => {
                const rect = section.getBoundingClientRect();
                const cx = rect.left + rect.width / 2;
                const cy = rect.top + rect.height / 2;
                const dx = (e.clientX - cx) / rect.width;
                const dy = (e.clientY - cy) / rect.height;
                xTo(clamp(dx * 20)); // rotateY
                yTo(clamp(-dy * 20)); // rotateX
            });
            section.addEventListener('mouseleave', () => { xTo(0); yTo(0); });
        });
    </script>
    </body>
</html>
