import './legacy.js';
import { initTheme } from './theme.js';
import { initMotion } from './motion.js';
import { initHome, initMarquees } from './home.js';

function boot() {
    initTheme();
    initMotion();
    initHome();
    initMarquees();
}

if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot);
else boot();

// Livewire SPA navigation (wire:navigate) swaps the page body
document.addEventListener('livewire:navigated', boot);
