import './bootstrap';
import './theme';
import './masks';
import 'flowbite';

import Sortable from 'sortablejs';
window.Sortable = Sortable;

import Chart from 'chart.js/auto';
window.Chart = Chart;

import IMask from 'imask';
window.IMask = IMask;

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import collapse from '@alpinejs/collapse';

// Alpine Initialization
if (!window.Alpine) {
    window.Alpine = Alpine;
    Alpine.plugin(focus);
    Alpine.plugin(collapse);
    Alpine.start();
}

// Global Toast Helper
window.toast = (message, type = 'success') => {
    window.dispatchEvent(new CustomEvent('notify', {
        detail: { message, type }
    }));
};
