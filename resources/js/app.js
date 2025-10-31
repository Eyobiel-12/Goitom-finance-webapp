import './bootstrap';

import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';

window.Chart = Chart;

// Start Alpine only once to avoid duplicate instances when other libs boot Alpine
if (!window.Alpine) {
    window.Alpine = Alpine;
    Alpine.start();
}
