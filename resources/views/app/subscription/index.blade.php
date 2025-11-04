<x-layouts.app>
    <div class="py-8">
        <div class="max-w-6xl mx-auto px-6">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold bg-gradient-to-r from-white via-gray-200 to-gray-400 bg-clip-text text-transparent">Abonnement</h1>
                <p class="mt-2 text-gray-400 text-lg">Beheer je Goitom Finance plan</p>
            </div>

            @if(session('message'))
            <div class="mb-6 p-4 bg-green-500/10 border border-green-500/30 rounded-xl text-green-400">
                {{ session('message') }}
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-xl text-red-400">
                {{ session('error') }}
            </div>
            @endif

            <!-- Current Plan -->
            <div class="bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-yellow-400/20 p-8 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-2">Huidig Plan</h2>
                        <p class="text-gray-400">{{ $organization->name }}</p>
                    </div>
                    @if($organization->subscription_status === 'trial')
                    <span class="px-4 py-2 bg-blue-500/10 border border-blue-500/30 text-blue-400 rounded-xl font-semibold">
                        🎁 Trial - {{ $organization->trialDaysRemaining() }} dagen over
                    </span>
                    @elseif($organization->subscription_status === 'active')
                    <span class="px-4 py-2 bg-green-500/10 border border-green-500/30 text-green-400 rounded-xl font-semibold">
                        ✓ Actief
                    </span>
                    @else
                    <span class="px-4 py-2 bg-red-500/10 border border-red-500/30 text-red-400 rounded-xl font-semibold">
                        Verlopen
                    </span>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-4 bg-gray-800/30 rounded-xl">
                        <p class="text-sm text-gray-400 mb-1">Plan</p>
                        <p class="text-xl font-bold text-white">{{ ucfirst($organization->subscription_plan) }}</p>
                    </div>
                    <div class="p-4 bg-gray-800/30 rounded-xl">
                        <p class="text-sm text-gray-400 mb-1">Status</p>
                        <p class="text-xl font-bold text-white">{{ ucfirst($organization->subscription_status) }}</p>
                    </div>
                    <div class="p-4 bg-gray-800/30 rounded-xl">
                        <p class="text-sm text-gray-400 mb-1">Prijs</p>
                        <p class="text-xl font-bold text-white">€{{ number_format($plans[$organization->subscription_plan]['price'], 2, ',', '.') }}/maand</p>
                    </div>
                </div>

                @if($organization->subscription_status === 'active')
                <div class="mt-6 flex justify-end">
                    <form method="POST" action="{{ route('app.subscription.cancel') }}" onsubmit="return confirm('Weet je zeker dat je wilt opzeggen?')">
                        @csrf
                        <button type="submit" class="px-6 py-3 bg-red-500/20 text-red-400 border border-red-500/30 rounded-xl font-semibold hover:bg-red-500/30 transition-all">
                            Abonnement Opzeggen
                        </button>
                    </form>
                </div>
                @endif
            </div>

            <!-- Available Plans -->
            <h2 class="text-2xl font-bold text-white mb-6">Beschikbare Plannen</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($plans as $planKey => $plan)
                <div class="rounded-2xl border {{ $organization->subscription_plan === $planKey ? 'border-yellow-400/40 bg-gradient-to-br from-yellow-400/5 to-transparent' : 'border-gray-800' }} bg-gray-950 p-8 relative">
                    @if($organization->subscription_plan === $planKey)
                    <span class="absolute top-4 right-4 text-xs px-3 py-1 rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500/40">Huidig Plan</span>
                    @endif
                    
                    @if($planKey === 'pro')
                    <span class="absolute top-4 right-4 text-xs px-3 py-1 rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500/40">Populair</span>
                    @endif
                    
                    <h3 class="text-2xl font-bold text-white mb-2">{{ $plan['name'] }}</h3>
                    <p class="text-gray-400 mb-6">{{ $plan['description'] }}</p>
                    <div class="text-5xl font-extrabold text-white mb-6">€{{ number_format($plan['price'], 0) }}<span class="text-base text-gray-300">/maand</span></div>
                    
                    <ul class="text-gray-300 space-y-3 mb-8">
                        @if($planKey === 'starter')
                        <li class="flex items-center"><svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Onbeperkt facturen</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Klanten & projecten</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> BTW aangifte basis</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> PDF facturen</li>
                        @else
                        <li class="flex items-center"><svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Alles uit Starter</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> E-mail verzenden & herinneringen</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Geavanceerde BTW & correcties</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Priority support</li>
                        @endif
                    </ul>
                    
                    @if($organization->subscription_plan !== $planKey)
                        @php
                            $isDowngrade = ($organization->subscription_plan === 'pro' && $planKey === 'starter');
                            $isUpgrade = ($organization->subscription_plan === 'starter' && $planKey === 'pro');
                        @endphp
                        <a href="{{ route('app.subscription.checkout', $planKey) }}" 
                           class="inline-block w-full text-center px-6 py-3 {{ $isUpgrade ? 'bg-gradient-to-r from-yellow-400 to-yellow-600 text-gray-900' : 'bg-gray-800 border border-gray-700 text-gray-300' }} rounded-xl font-semibold shadow-lg {{ $isUpgrade ? 'shadow-yellow-400/30 hover:shadow-yellow-400/50' : '' }} transition-all">
                            {{ $isDowngrade ? 'Downgrade naar' : 'Upgrade naar' }} {{ $plan['name'] }}
                        </a>
                    @else
                    <button disabled class="w-full px-6 py-3 bg-gray-800 text-gray-500 rounded-xl font-semibold cursor-not-allowed">
                        Jouw huidig plan
                    </button>
                    @endif
                </div>
                @endforeach
            </div>

            <!-- Features Comparison -->
            <div class="mt-12 bg-gradient-to-br from-gray-900 to-gray-950 rounded-xl border border-gray-700/50 p-8">
                <h3 class="text-xl font-bold text-white mb-6">Plan Vergelijking</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-800">
                                <th class="pb-4 text-gray-400 font-semibold">Feature</th>
                                <th class="pb-4 text-center text-gray-400 font-semibold">Starter</th>
                                <th class="pb-4 text-center text-gray-400 font-semibold">Pro</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-300">
                            <tr class="border-b border-gray-800/50"><td class="py-3">Onbeperkt facturen</td><td class="text-center text-green-400">✓</td><td class="text-center text-green-400">✓</td></tr>
                            <tr class="border-b border-gray-800/50"><td class="py-3">Klanten & projecten</td><td class="text-center text-green-400">✓</td><td class="text-center text-green-400">✓</td></tr>
                            <tr class="border-b border-gray-800/50"><td class="py-3">BTW aangifte basis</td><td class="text-center text-green-400">✓</td><td class="text-center text-green-400">✓</td></tr>
                            <tr class="border-b border-gray-800/50"><td class="py-3">E-mail verzenden</td><td class="text-center text-gray-600">–</td><td class="text-center text-green-400">✓</td></tr>
                            <tr class="border-b border-gray-800/50"><td class="py-3">Automatische herinneringen</td><td class="text-center text-gray-600">–</td><td class="text-center text-green-400">✓</td></tr>
                            <tr class="border-b border-gray-800/50"><td class="py-3">Geavanceerde BTW correcties</td><td class="text-center text-gray-600">–</td><td class="text-center text-green-400">✓</td></tr>
                            <tr class="border-b border-gray-800/50"><td class="py-3">Priority support</td><td class="text-center text-gray-600">–</td><td class="text-center text-green-400">✓</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

