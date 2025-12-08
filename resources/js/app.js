import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Sidebar store
Alpine.store('sidebar', {
    open: window.innerWidth >= 1024, // Open by default on desktop (lg breakpoint)
    toggle() {
        this.open = !this.open;
    }
});

Alpine.start();
