<div class="hidden lg:block">
    <button onclick="toggleSidebar()" class="fixed top-4 left-4 z-50 p-2 bg-gray-950 border-2 border-yellow-400/30 rounded-xl text-yellow-400 hover:bg-yellow-400/10 hover:border-yellow-400/50 transition-all shadow-lg">
        <svg id="sidebar-toggle-icon" class="w-6 h-6 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
        </svg>
    </button>
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const icon = document.getElementById('sidebar-toggle-icon');
        const mainContent = document.getElementById('main-content');
        
        if (sidebar) {
            sidebar.classList.toggle('w-72');
            sidebar.classList.toggle('w-24');
            
            // Update icon
            if (icon) {
                icon.classList.toggle('rotate-180');
            }
            
            // Hide/show text in navigation items
            const navTexts = sidebar.querySelectorAll('.nav-text');
            navTexts.forEach(text => {
                text.classList.toggle('hidden');
            });
            
            // Center icons when collapsed
            const navLinks = sidebar.querySelectorAll('nav > a');
            navLinks.forEach(link => {
                link.classList.toggle('justify-center');
            });
        }
    }
    
    // Check localStorage on page load
    document.addEventListener('DOMContentLoaded', function() {
        const savedState = localStorage.getItem('sidebarCollapsed');
        if (savedState === 'true') {
            toggleSidebar();
        }
    });
</script>

