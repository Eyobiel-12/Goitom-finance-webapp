import './bootstrap';

import Alpine from 'alpinejs';

// Start Alpine only once to avoid "multiple instances of Alpine" warnings
if (!window.Alpine) {
    window.Alpine = Alpine;
    window.Alpine.start();
}
