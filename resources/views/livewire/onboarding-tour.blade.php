<div>
<style>
    .introjs-overlay {
        background: rgba(0, 0, 0, 0.92) !important;
        backdrop-filter: blur(8px);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .introjs-tooltip {
        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%) !important;
        border: 2px solid #d4af37 !important;
        border-radius: 20px !important;
        box-shadow: 0 25px 50px -12px rgba(212, 175, 55, 0.25),
                    0 0 100px rgba(212, 175, 55, 0.1) !important;
        padding: 30px !important;
        max-width: 450px !important;
        animation: tooltip-pop 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    
    @keyframes tooltip-pop {
        0% {
            opacity: 0;
            transform: scale(0.8) translateY(20px);
        }
        100% {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }
    
    .introjs-tooltip-header {
        padding-bottom: 20px !important;
        border-bottom: 1px solid rgba(212, 175, 55, 0.2) !important;
        margin-bottom: 20px !important;
    }
    
    .introjs-tooltip-title {
        color: #d4af37 !important;
        font-size: 24px !important;
        font-weight: 700 !important;
        margin-bottom: 0 !important;
        text-shadow: 0 0 20px rgba(212, 175, 55, 0.3);
    }
    
    .introjs-tooltiptext {
        color: #e5e7eb !important;
        font-size: 16px !important;
        line-height: 1.8 !important;
        padding: 0 !important;
    }
    
    .introjs-tooltiptext strong {
        color: #d4af37;
        font-weight: 600;
    }
    
    .introjs-tooltip-footer {
        margin-top: 30px !important;
        padding-top: 20px !important;
        border-top: 1px solid rgba(212, 175, 55, 0.2) !important;
    }
    
    .introjs-button {
        background: linear-gradient(135deg, #d4af37 0%, #b8941e 100%) !important;
        color: #1a1a1a !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 12px 28px !important;
        font-weight: 600 !important;
        font-size: 15px !important;
        cursor: pointer !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.4) !important;
    }
    
    .introjs-button:hover {
        transform: translateY(-2px) scale(1.02) !important;
        box-shadow: 0 8px 25px rgba(212, 175, 55, 0.6) !important;
    }
    
    .introjs-button:active {
        transform: translateY(0) scale(0.98) !important;
    }
    
    .introjs-prevbutton {
        background: rgba(45, 45, 45, 0.8) !important;
        color: #ffffff !important;
        border: 1px solid #666 !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
    }
    
    .introjs-prevbutton:hover {
        background: rgba(55, 55, 55, 0.9) !important;
        border-color: #888 !important;
    }
    
    .introjs-skipbutton {
        color: #9ca3af !important;
        font-weight: 500 !important;
        transition: all 0.3s ease !important;
    }
    
    .introjs-skipbutton:hover {
        color: #d4af37 !important;
        transform: translateX(-3px);
    }
    
    .introjs-progress {
        background: rgba(45, 45, 45, 0.6) !important;
        height: 6px !important;
        border-radius: 10px !important;
        overflow: hidden !important;
        margin-top: 15px !important;
    }
    
    .introjs-progressbar {
        background: linear-gradient(90deg, #d4af37 0%, #f4d03f 100%) !important;
        height: 100% !important;
        border-radius: 10px !important;
        transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
        box-shadow: 0 0 15px rgba(212, 175, 55, 0.6);
    }
    
    .introjs-bullets {
        margin-top: 20px !important;
    }
    
    .introjs-bullets ul li {
        margin: 0 8px !important;
    }
    
    .introjs-bullets ul li a {
        width: 12px !important;
        height: 12px !important;
        background: rgba(156, 163, 175, 0.3) !important;
        border-radius: 50% !important;
        transition: all 0.3s ease !important;
    }
    
    .introjs-bullets ul li a:hover {
        background: rgba(212, 175, 55, 0.5) !important;
        transform: scale(1.2);
    }
    
    .introjs-bullets ul li a.active {
        background: #d4af37 !important;
        box-shadow: 0 0 15px rgba(212, 175, 55, 0.6);
        transform: scale(1.3);
    }
    
    .introjs-helperLayer {
        box-shadow: 
            0 0 0 2px #d4af37,
            0 0 0 5000px rgba(0, 0, 0, 0.85),
            0 0 50px rgba(212, 175, 55, 0.4) !important;
        border-radius: 16px !important;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    
    .introjs-helperNumberLayer {
        background: linear-gradient(135deg, #d4af37 0%, #b8941e 100%) !important;
        color: #1a1a1a !important;
        border: none !important;
        box-shadow: 0 8px 25px rgba(212, 175, 55, 0.5) !important;
        font-weight: 700 !important;
        width: 36px !important;
        height: 36px !important;
        line-height: 36px !important;
        font-size: 18px !important;
    }
    
    /* Custom emoji icons for steps */
    .intro-icon {
        font-size: 48px;
        display: block;
        text-align: center;
        margin-bottom: 20px;
        animation: bounce 2s infinite;
    }
    
    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }
    
    .intro-feature-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin: 20px 0;
    }
    
    .intro-feature-item {
        background: rgba(212, 175, 55, 0.1);
        border: 1px solid rgba(212, 175, 55, 0.3);
        border-radius: 12px;
        padding: 15px;
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .intro-feature-item:hover {
        background: rgba(212, 175, 55, 0.2);
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(212, 175, 55, 0.2);
    }
    
    .intro-feature-icon {
        font-size: 32px;
        margin-bottom: 8px;
        display: block;
    }
    
    .intro-feature-label {
        font-size: 13px;
        color: #e5e7eb;
        font-weight: 500;
    }
</style>

<!-- Intro.js Library -->
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
                    steps: [
                        {
                            title: '👋 Welkom bij Goitom Finance!',
                            intro: `
                                <div class="intro-icon">🎉</div>
                                <p>Je bent <strong>succesvol geregistreerd</strong>! We zijn super blij dat je er bent.</p>
                                <p>Laat ons je in slechts een paar stappen door de app leiden, zodat je meteen kunt beginnen.</p>
                                <p style="margin-top: 20px; font-size: 14px; color: #9ca3af;">⏱️ Dit duurt minder dan 30 seconden</p>
                            `
                        },
                        {
                            element: document.querySelector('[href*="dashboard"]') || '#sidebar-navigation',
                            title: '📊 Je Dashboard',
                            intro: `
                                <p>Dit is je <strong>persoonlijke dashboard</strong> — je commandocentrum!</p>
                                <p>Hier zie je in één oogopslag:</p>
                                <div class="intro-feature-grid">
                                    <div class="intro-feature-item">
                                        <span class="intro-feature-icon">👥</span>
                                        <span class="intro-feature-label">Totaal Klanten</span>
                                    </div>
                                    <div class="intro-feature-item">
                                        <span class="intro-feature-icon">💼</span>
                                        <span class="intro-feature-label">Actieve Projecten</span>
                                    </div>
                                    <div class="intro-feature-item">
                                        <span class="intro-feature-icon">📄</span>
                                        <span class="intro-feature-label">Openstaande Facturen</span>
                                    </div>
                                    <div class="intro-feature-item">
                                        <span class="intro-feature-icon">💰</span>
                                        <span class="intro-feature-label">Totale Omzet</span>
                                    </div>
                                </div>
                                <p style="margin-top: 15px;">Je financiële overzicht, altijd up-to-date! ✨</p>
                            `
                        },
                        {
                            element: document.querySelector('[href*="clients"]'),
                            title: '👥 Klanten Beheer',
                            intro: `
                                <div class="intro-icon">🤝</div>
                                <p>Beheer al je klanten op één plek!</p>
                                <p>✅ Voeg nieuwe klanten toe<br>
                                   ✅ Bewaar contactgegevens<br>
                                   ✅ Bekijk klantgeschiedenis<br>
                                   ✅ Exporteer klantgegevens</p>
                                <p style="margin-top: 15px; padding: 12px; background: rgba(212, 175, 55, 0.1); border-radius: 8px; font-size: 14px;">
                                    💡 <strong>Pro tip:</strong> Begin met het toevoegen van je eerste klant!
                                </p>
                            `
                        },
                        {
                            element: document.querySelector('[href*="projects"]'),
                            title: '💼 Projecten Tracking',
                            intro: `
                                <div class="intro-icon">🚀</div>
                                <p>Houd al je projecten bij met:</p>
                                <p>📋 Project details & beschrijvingen<br>
                                   ⏱️ Urenregistratie<br>
                                   💵 Uurtarieven & budgetten<br>
                                   📊 Voortgang tracking</p>
                                <p style="margin-top: 15px;">Koppel projecten aan klanten en genereer automatisch facturen!</p>
                            `
                        },
                        {
                            element: document.querySelector('[href*="invoices"]'),
                            title: '📄 Professionele Facturen',
                            intro: `
                                <div class="intro-icon">💎</div>
                                <p>Maak <strong>professionele facturen</strong> in een handomdraai:</p>
                                <p>✨ Mooie PDF templates<br>
                                   📧 Verstuur direct per email<br>
                                   💰 Automatische BTW berekening<br>
                                   📊 Betalingsstatus tracking</p>
                                <p style="margin-top: 15px; padding: 12px; background: rgba(76, 175, 80, 0.1); border: 1px solid rgba(76, 175, 80, 0.3); border-radius: 8px;">
                                    🎨 Pas je factuur layout aan naar jouw huisstijl!
                                </p>
                            `
                        },
                        {
                            element: document.querySelector('[href*="btw"]'),
                            title: '🧾 BTW Administratie',
                            intro: `
                                <div class="intro-icon">📊</div>
                                <p>Houd je BTW overzicht bij:</p>
                                <p>📥 BTW Aftrek registreren<br>
                                   📤 BTW Aangiftes maken<br>
                                   💼 Belastingdienst klaar<br>
                                   📈 Automatische berekeningen</p>
                                <p style="margin-top: 15px;">Perfect voor freelancers en ZZP'ers! 🇳🇱</p>
                            `
                        },
                        {
                            element: document.querySelector('#user-section') || document.querySelector('[x-data]'),
                            title: '⚙️ Jouw Profiel',
                            intro: `
                                <div class="intro-icon">👤</div>
                                <p>Hier vind je:</p>
                                <p>🔧 <strong>Profiel instellingen</strong><br>
                                   🏢 <strong>Organisatie gegevens</strong><br>
                                   🎨 <strong>PDF templates</strong><br>
                                   🚪 <strong>Uitloggen</strong></p>
                                <p style="margin-top: 15px;">Pas je gegevens aan wanneer je maar wilt!</p>
                            `
                        },
                        {
                            title: '🎉 Je bent klaar om te starten!',
                            intro: `
                                <div class="intro-icon">🚀</div>
                                <p style="font-size: 18px; margin-bottom: 20px;">
                                    <strong>Welkom in de Goitom Finance familie!</strong>
                                </p>
                                
                                <div style="background: linear-gradient(135deg, rgba(212, 175, 55, 0.1), rgba(212, 175, 55, 0.05)); border: 1px solid rgba(212, 175, 55, 0.3); border-radius: 12px; padding: 20px; margin: 20px 0;">
                                    <p style="font-size: 16px; margin-bottom: 15px;">💡 <strong>Aanbevolen eerste stappen:</strong></p>
                                    <p style="font-size: 14px; line-height: 2;">
                                        1️⃣ Voeg je eerste klant toe<br>
                                        2️⃣ Maak een project aan<br>
                                        3️⃣ Genereer je eerste factuur<br>
                                        4️⃣ Configureer je PDF template
                                    </p>
                                </div>
                                
                                <p style="margin-top: 20px; font-size: 15px; color: #9ca3af;">
                                    Heb je vragen? We staan altijd voor je klaar! 💬
                                </p>
                                
                                <p style="margin-top: 25px; font-size: 18px; text-align: center;">
                                    <strong>Veel succes! ✨</strong>
                                </p>
                            `
                        }
                    ],
                    tooltipPosition: 'auto',
                    showProgress: true,
                    showBullets: true,
                    showStepNumbers: false,
                    exitOnOverlayClick: false,
                    disableInteraction: false,
                    dontShowAgain: false,
                    nextLabel: 'Volgende →',
                    prevLabel: '← Vorige',
                    skipLabel: 'Overslaan',
                    doneLabel: 'Start! 🚀',
                    tooltipClass: 'customTooltip',
                })
                .oncomplete(function() {
                    localStorage.setItem('goitom_onboarding_complete', 'true');
                    // Optional: Show a success message
                    showCompletionMessage();
                })
                .onexit(function() {
                    localStorage.setItem('goitom_onboarding_complete', 'true');
                })
                .onchange(function(targetElement) {
                    // Scroll to element smoothly if needed
                    if (targetElement) {
                        targetElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                })
                .start();
            }, 1200); // 1.2 second delay for smooth experience
        }
    });
    
    function showCompletionMessage() {
        // Create a beautiful completion notification
        const notification = document.createElement('div');
        notification.innerHTML = `
            <div style="position: fixed; top: 20px; right: 20px; z-index: 99999; 
                        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); 
                        border: 2px solid #d4af37; border-radius: 16px; padding: 20px 30px; 
                        box-shadow: 0 25px 50px -12px rgba(212, 175, 55, 0.5);
                        animation: slideIn 0.5s ease-out;">
                <p style="color: #d4af37; font-size: 20px; font-weight: 700; margin: 0 0 10px 0;">
                    🎉 Klaar!
                </p>
                <p style="color: #e5e7eb; font-size: 14px; margin: 0;">
                    Je kunt nu aan de slag met Goitom Finance!
                </p>
            </div>
        `;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.5s ease-in';
            setTimeout(() => notification.remove(), 500);
        }, 3000);
    }
</script>

<style>
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
</style>
</div>
