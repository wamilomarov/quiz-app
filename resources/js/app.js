
import { createApp, h } from 'vue'
import {createInertiaApp, Link} from '@inertiajs/inertia-vue3'
import Nav from "./Shared/Nav";
import {BootstrapVue3} from "bootstrap-vue-3";
import AppLayout from "./Layouts/AppLayout";

createInertiaApp({
    resolve: name => require(`./Pages/${name}`),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(Link)
            .use(AppLayout)
            .use(BootstrapVue3)
            .mount(el)
    },
})
