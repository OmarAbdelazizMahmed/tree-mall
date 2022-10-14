import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import Icons from '@/Components/Icons.vue';
import InstantSearch from 'vue-instantsearch/vue3/es';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

import Swal from 'sweetalert2/dist/sweetalert2.js';
window.Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    },
});




createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
        const vueApp =  createApp({ render: () => h(app, props) });
            vueApp.config.globalProperties.$filters = {
                formatCurrency: (value) => {
                    console.log(value);
                    return value.toLocaleString('en-EG', {
                        style: 'currency',
                        currency: 'EGP',
                    });
                }
            };
            vueApp.use(plugin)
                .use(ZiggyVue, Ziggy)
                .use(InstantSearch)
                .component('icon', Icons)
                .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
