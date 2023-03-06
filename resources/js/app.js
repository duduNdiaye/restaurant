import './bootstrap';
import '../css/app.css';
import { SetupCalendar, Calendar, DatePicker } from 'v-calendar';
import { ObserveVisibility } from 'vue-observe-visibility'
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import 'select2/dist/css/select2.css';
import $ from 'jquery' // Importation de jQuery

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';
window.$ = window.jQuery = $ // Déclaration de jQuery comme variable globale
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App,
           props) })
            .use(plugin)
            .use(SetupCalendar, {})
            .component('Calendar', Calendar)
            .component('DatePicker', DatePicker)
            .use(ZiggyVue, Ziggy)
            .use(ObserveVisibility)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
