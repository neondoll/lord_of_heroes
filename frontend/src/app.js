import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import {ModalPlugin} from 'bootstrap-vue';

Vue.use(ModalPlugin);

new Vue({
    render: h => h(App),
    router

}).$mount('#app');