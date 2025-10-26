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
        
        // Only show tour for newly registered users or if explicitly reset
        if ((!hasSeenTour || showTour) || localStorage.getItem('show_onboarding_tour') === 'true') {
            localStorage.removeItem('show_onboarding_tour'); // Clear flag
            
            // Delay to ensure page is fully loaded
            setTimeout(function() {
                // Start the onboarding tour
                introJs().setOptions({
                    tooltipPosition: 'bottom',
                    showProgress: true,
                    showBullets: true,
                    showStepNumbers: false,
                    exitOnOverlayClick: true,
                    disableInteraction: true,
                })
                .setOptions({
                    steps: [
                        {
                            intro: "👋 Welkom bij Goitom Finance!<br><br>Laten we je door de app leiden."
                        },
                        {
                            element: '#sidebar-navigation',
                            intro: "Hier vind je alle hoofdsecties:<br><br>📊 Dashboard<br>👥 Klanten<br>💼 Projecten<br>📄 Facturen"
                        },
                        {
                            element: '#user-section',
                            intro: "Klik hier voor je profielinstellingen en om uit te loggen."
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
            }, 500); // 500ms delay
        }
    });
</script>
</div>
