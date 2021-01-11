require('./bootstrap');

window.Vue = require('vue');

import App from './components/App'
import vuetify from "./vuetify";
import router from "./router";
import store from "./store/mainStore";
import style from "./assets/style.css";

import "froala-editor/css/froala_editor.pkgd.min.css"; // all styles (also for buttons)
import "froala-editor/js/plugins.pkgd.min"; // all plugins (you can add plugins by one too)
require("froala-editor/js/languages/ru"); // lang file for localization
import VueFroala from "vue-froala-wysiwyg"; // editor
Vue.use(VueFroala);

new Vue({
    el: "#app",
    router,
    vuetify,
    style,
    store,
    components: {
        app: App
    }
});
