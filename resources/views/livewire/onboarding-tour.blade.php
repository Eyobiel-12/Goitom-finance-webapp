<link rel="stylesheet" href="https://unpkg.com/intro.js/minified/introjs.min.css">
<script src="https://unpkg.com/intro.js/intro.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if user hasn't seen the tour yet
        const hasSeenTour = localStorage.getItem('goitom_onboarding_complete');
        
        if (!hasSeenTour) {
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
                        intro: "👋 Welkom bij Goitom Finance! Laten we je door de app leiden."
                    },
                    {
                        element: '#sidebar-navigation',
                        intro: "Hier vind je alle hoofdsecties: Dashboard, Klanten, Projecten, Facturen en meer."
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
        }
    });
</script>

