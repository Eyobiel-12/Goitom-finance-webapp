<div>
<style>
    .introjs-overlay {
        background: rgba(0, 0, 0, 0.8) !important;
    }
    .introjs-tooltip {
        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%) !important;
        border: 1px solid #d4af37 !important;
    }
    .introjs-tooltip-title {
        color: #d4af37 !important;
    }
    .introjs-tooltiptext {
        color: #ffffff !important;
    }
    .introjs-button {
        background: linear-gradient(135deg, #d4af37 0%, #b8941e 100%) !important;
        color: #1a1a1a !important;
        border: none !important;
        border-radius: 8px !important;
        padding: 10px 20px !important;
        font-weight: 600 !important;
    }
    .introjs-button:hover {
        transform: scale(1.05) !important;
    }
    .introjs-prevbutton {
        background: #2d2d2d !important;
        color: #ffffff !important;
        border: 1px solid #666 !important;
    }
    .introjs-skipbutton {
        color: #d4af37 !important;
    }
    .introjs-progressbar {
        background: #d4af37 !important;
    }
    .introjs-bullets ul li a.active {
        background: #d4af37 !important;
    }
</style>

<link rel="stylesheet" href="https://unpkg.com/intro.js/minified/introjs.min.css">
<script src="https://unpkg.com/intro.js/intro.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if user hasn't seen the tour yet
        const hasSeenTour = localStorage.getItem('goitom_onboarding_complete');
        
        // Check if server wants to show tour (newly registered user)
        const showTour = @json(session('show_onboarding_tour', false));
        
        // Only show tour if user hasn't seen it before AND server wants to show it
        if (!hasSeenTour && showTour) {
            // Delay to ensure page is fully loaded
            setTimeout(function() {
                // Start the onboarding tour
                introJs().setOptions({
                    tooltipPosition: 'bottom',
                    showProgress: true,
                    showBullets: true,
                    showStepNumbers: false,
                    exitOnOverlayClick: true,
                    disableInteraction: false,
                    dontShowAgain: true,
                })
                .setOptions({
                    steps: [
                        {
                            intro: "👋 Welkom bij Goitom Finance!<br><br>Je bent succesvol geregistreerd. Laten we je door de app leiden."
                        },
                        {
                            element: '#sidebar-navigation',
                            intro: "Hier vind je alle hoofdsecties:<br><br>📊 Dashboard - Overzicht van je financiën<br>👥 Klanten - Beheer je klanten<br>💼 Projecten - Houd je projecten bij<br>📄 Facturen - Genereer professionele facturen<br><br>Klik op een sectie om te starten."
                        },
                        {
                            element: '#user-section',
                            intro: "Klik hier voor je profielinstellingen, organisatie-instellingen en om uit te loggen.<br><br>Je kunt hier ook je profiel en wachtwoord aanpassen."
                        },
                        {
                            intro: "✅ Je bent nu klaar om te starten!<br><br>💡 Tip: Start met het toevoegen van je eerste klant en maak vervolgens een project aan.<br><br>Veel succes met Goitom Finance!"
                        },
                    ]
                })
                .oncomplete(function() {
                    localStorage.setItem('goitom_onboarding_complete', 'true');
                })
                .onexit(function() {
                    localStorage.setItem('goitom_onboarding_complete', 'true');
                })
                .start();
            }, 1000); // 1 second delay to ensure everything is loaded
        }
    });
</script>
</div>
