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
        const logoImg = sidebar?.querySelector('img');
        const logoContainer = sidebar?.querySelector('[class*="border-b"]');
        
        if (sidebar) {
            const isCollapsed = sidebar.classList.contains('w-24');
            
            if (isCollapsed) {
                // Expand
                sidebar.classList.remove('w-24');
                sidebar.classList.add('w-72');
                if (icon) icon.classList.remove('rotate-180');
                if (logoImg) logoImg.classList.remove('mx-auto', 'w-8', 'h-8');
                if (logoContainer) logoContainer.classList.add('p-6');
            } else {
                // Collapse
                sidebar.classList.remove('w-72');
                sidebar.classList.add('w-24');
                if (icon) icon.classList.add('rotate-180');
                if (logoImg) logoImg.classList.add('mx-auto', 'w-8', 'h-8');
                if (logoContainer) logoContainer.classList.remove('p-6');
            }
            
            // Hide/show text in navigation items
            const navLinks = sidebar.querySelectorAll('nav > a');
            navLinks.forEach(link => {
                const navText = link.querySelector('.nav-text');
                const navIcon = link.querySelector('svg');
                
                if (isCollapsed) {
                    // Expanding - show text
                    if (navText) navText.classList.remove('hidden');
                    link.classList.remove('justify-center');
                    link.classList.add('justify-start');
                } else {
                    // Collapsing - hide text
                    if (navText) navText.classList.add('hidden');
                    link.classList.add('justify-center');
                    link.classList.remove('justify-start');
                }
            });
            
            // Update user section if exists
            const userSection = sidebar.querySelector('#user-section');
            if (userSection) {
                const userImg = userSection.querySelector('img');
                const userName = userSection.querySelector('.text-white');
                
                if (isCollapsed) {
                    userSection.classList.remove('p-4');
                    userSection.classList.add('p-2', 'justify-center');
                    if (userImg) {
                        userImg.classList.add('w-8', 'h-8');
                        userImg.classList.remove('w-10', 'h-10');
                    }
                    if (userName) userName.classList.add('hidden');
                } else {
                    userSection.classList.add('p-4');
                    userSection.classList.remove('p-2', 'justify-center');
                    if (userImg) {
                        userImg.classList.remove('w-8', 'h-8');
                        userImg.classList.add('w-10', 'h-10');
                    }
                    if (userName) userName.classList.remove('hidden');
                }
            }
            
            // Save state
            localStorage.setItem('sidebarCollapsed', isCollapsed ? 'false' : 'true');
            
            // Call additional functions
            if (isCollapsed) {
                expandSidebar();
            } else {
                collapseSidebar();
            }
        }
    }
    
    // Additional function to handle collapsing better
    function collapseSidebar() {
        const sidebar = document.getElementById('sidebar');
        if (!sidebar) return;
        
        // Update avatar size
        const userAvatar = document.querySelector('.user-avatar');
        if (userAvatar) {
            userAvatar.classList.add('w-8', 'h-8');
            userAvatar.classList.remove('w-10', 'h-10');
        }
        
        // Hide user info
        const userInfo = document.querySelector('.user-info');
        if (userInfo) userInfo.classList.add('hidden');
        
        // Center user section
        const userSection = document.getElementById('user-section');
        if (userSection) {
            userSection.classList.add('justify-center');
            userSection.classList.remove('space-x-3');
        }
        
        // Hide user links text
        const navTexts = document.querySelectorAll('.user-links .nav-text');
        navTexts.forEach(text => text.classList.add('hidden'));
        
        // Center user links icons
        const userLinks = document.querySelectorAll('.user-links a, .user-links button');
        userLinks.forEach(link => {
            link.classList.add('justify-center');
            link.classList.remove('justify-start', 'w-full');
        });
    }
    
    function expandSidebar() {
        const sidebar = document.getElementById('sidebar');
        if (!sidebar) return;
        
        // Update avatar size
        const userAvatar = document.querySelector('.user-avatar');
        if (userAvatar) {
            userAvatar.classList.remove('w-8', 'h-8');
            userAvatar.classList.add('w-10', 'h-10');
        }
        
        // Show user info
        const userInfo = document.querySelector('.user-info');
        if (userInfo) userInfo.classList.remove('hidden');
        
        // Un-center user section
        const userSection = document.getElementById('user-section');
        if (userSection) {
            userSection.classList.remove('justify-center');
            userSection.classList.add('space-x-3');
        }
        
        // Show user links text
        const navTexts = document.querySelectorAll('.user-links .nav-text');
        navTexts.forEach(text => text.classList.remove('hidden'));
        
        // Un-center user links icons
        const userLinks = document.querySelectorAll('.user-links a, .user-links button');
        userLinks.forEach(link => {
            link.classList.remove('justify-center');
            link.classList.add('justify-start', 'w-full');
        });
    }
    
    // Check localStorage on page load
    document.addEventListener('DOMContentLoaded', function() {
        const savedState = localStorage.getItem('sidebarCollapsed');
        if (savedState === 'true') {
            // Sidebar starts expanded, so we need to collapse it
            setTimeout(() => {
                toggleSidebar();
                collapseSidebar();
            }, 100);
        }
    });
</script>

