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

//uses

//chart donut
Vue.use(Donut);

//vue-confirm-dialog
Vue.use(VueConfirmDialog)


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

Vue.component('fichero-create', require('./components/Fichero/FicheroCreate.vue').default);
Vue.component('fichero-miniatura', require('./components/Fichero/FicheroMiniatura.vue').default);

Vue.component('iconizador', require('./components/Icono/Iconizador.vue').default);

Vue.component('buscador', require('./components/Buscador/Buscador.vue').default);

Vue.component('gif-loading', require('./components/Gif/GifLoading.vue').default);

Vue.component('chart', require('./components/grafico/Chart.vue').default);


//confirm dialog
Vue.component('vue-confirm-dialog', VueConfirmDialog.default)


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
