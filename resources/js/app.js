import './bootstrap';
import { createApp } from "vue";
import { createPinia } from 'pinia';
import piniaPluginPersistedstate from "pinia-plugin-persistedstate";
import Router from "@/router";

import moment from "moment";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import moshaToast from "mosha-vue-toastify";
import "mosha-vue-toastify/dist/style.css";
import "vue-select/dist/vue-select.css";
import vSelect from 'vue-select';


const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);

const app = createApp({});
app.use(pinia);
app.use(Router);
app.use(moshaToast);
// app.use(Shimmer);
app.component('VueDatePicker', VueDatePicker);
// app.component("downloadExcel", JsonExcel);
app.config.globalProperties.$moment = moment;

app.mount('#app');
