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
import firebase from "firebase/app";


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

//firebase
require("firebase/firestore");
var firebaseConfig = {
    apiKey: "AIzaSyCkEpnos4CcH0oJbkTmI2EJKe2Krg4CG-0",
    authDomain: "esmartorder.firebaseapp.com",
    projectId: "esmartorder",
    storageBucket: "esmartorder.appspot.com",
    messagingSenderId: "194647642539",
    appId: "1:194647642539:web:fe87d37ac0e255464382ee",
    measurementId: "G-2R3YXKNSJK"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);


  var db = firebase.firestore();
  window.db = db; //global connection

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
