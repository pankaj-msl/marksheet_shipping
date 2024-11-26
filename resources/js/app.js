import './bootstrap';
import '../css/app.css';
import '../css/gradient.css'
import "vue-toastification/dist/index.css";
import './marksheetImports.js';

import { createApp, h } from 'vue';
import { createInertiaApp, Head, Link } from '@inertiajs/vue3';
import VueApexCharts from 'vue3-apexcharts';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import vuetify from './vuetify';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import '@mdi/font/css/materialdesignicons.css';
import Toast from "vue-toastification";


const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(vuetify)
            .use(Toast)
            .component('Head', Head)
            .component('Link', Link)
            .use(VueApexCharts)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
