/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// donut chart
import Donut from 'vue-css-donut-chart';
import 'vue-css-donut-chart/dist/vcdonut.css';

//confirm dialog
import VueConfirmDialog from 'vue-confirm-dialog'

//date-time picker
import VueDatetimePickerJs from 'vue-date-time-picker-js';

//data-table
import DataTable from 'laravel-vue-datatable';


//==============================


//uses


//chart donut
Vue.use(Donut);

//vue-confirm-dialog
Vue.use(VueConfirmDialog);

//date-time-picker
Vue.use(VueDatetimePickerJs,
    {
        name:'date-picker',
        props: {
            inputFormat: 'YYYY-MM-DD HH:mm',
            format: 'YYYY-MM-DD HH:mm',
            editable: true,
            inputClass: 'form-control border',
            placeholder: 'Introduce una fecha',
            altFormat: 'YYYY-MM-DD HH:mm',
            color: '#4d4dff',
            autoSubmit: false,
            //...
            //... And whatever you want to set as default
            //...
        }
    });

//data-table
Vue.use(DataTable);



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('home', require('./components/home/Home.vue').default);

Vue.component('fichero-create', require('./components/Fichero/FicheroCreate.vue').default);
Vue.component('fichero-miniatura', require('./components/Fichero/FicheroMiniatura.vue').default);

Vue.component('iconizador', require('./components/Icono/Iconizador.vue').default);

Vue.component('buscador', require('./components/Buscador/Buscador.vue').default);

Vue.component('gif-loading', require('./components/Gif/GifLoading.vue').default);

Vue.component('chart-donut', require('./components/grafico/ChartDonut.vue').default);

Vue.component('log', require('./components/log/Log.vue').default);



//confirm dialog
Vue.component('vue-confirm-dialog', VueConfirmDialog.default)

//date-time picker
Vue.component('date-picker', VueDatetimePickerJs);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
