require('./bootstrap');

window.Vue = require('vue');

import App from './components/App'
import vuetify from "./vuetify";
import router from "./router";
import store from "./store/mainStore";
import style from "./assets/style.css";
import Vue from 'vue'
import VueInternationalization from 'vue-i18n';
import Locale from './vue-i18n-locales.generated';
const lang = localStorage.getItem('locale') || 'en'; 
 
const i18n = new VueInternationalization({
    locale: lang,
    messages: Locale
 });

 //toast notification
import CxltToastr from "cxlt-vue2-toastr";
import "cxlt-vue2-toastr/dist/css/cxlt-vue2-toastr.css";
var toastrConfigs = {
    position: "top right",
    showDuration: 500,
    timeout: 2000
};
Vue.use(CxltToastr, toastrConfigs);

const selectedLang=localStorage.getItem('lang') || 'English'


import "froala-editor/css/froala_editor.pkgd.min.css"; // all styles (also for buttons)
import "froala-editor/js/plugins.pkgd.min"; // all plugins (you can add plugins by one too)
require("froala-editor/js/languages/ru"); // lang file for localization
import VueFroala from "vue-froala-wysiwyg"; // editor
Vue.use(VueFroala);

new Vue({
    el: "#app",
    i18n,
    router,
    vuetify,
    style,
    store,
    components: {
        app: App
    }
});
