require('./bootstrap');

// Import modules...
import { createApp, h} from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import VueApexCharts from "vue3-apexcharts";
//primevue
import PrimeVue from 'primevue/config';
import 'primevue/resources/themes/saga-blue/theme.css'       //theme
import 'primevue/resources/primevue.min.css'                 //core css
import 'primeicons/primeicons.css' 
import ToastService from 'primevue/toastservice';
import ConfirmationService from 'primevue/confirmationservice';


const el = document.getElementById('app');

createApp({
    render: () =>
        h(InertiaApp, {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: (name) => require(`./Pages/${name}`).default,
        }),
}).use(VueApexCharts)
  .use(PrimeVue)
  .use(ToastService)
  .use(ConfirmationService)
    .mixin({ methods: { route } })
    .use(InertiaPlugin)
    .mount(el);

InertiaProgress.init({ color: '#4B5563' });
