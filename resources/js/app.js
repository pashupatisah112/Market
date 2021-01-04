require('./bootstrap');

window.Vue = require('vue');

import App from './components/App'
import vuetify from "./vuetify";
import router from "./router";
import store from "./store/mainStore";
import style from "./assets/style.css";

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
