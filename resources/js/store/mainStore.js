import Vue from 'vue';
import vuex from 'vuex';
import createPersistedState from "vuex-persistedstate";

import { getField, updateField } from 'vuex-map-fields'; //to bind v-model https://github.com/maoberlehner/vuex-map-fields
Vue.use(vuex);

import advertisementModule from './advertisementModule';
import analyticsModule from './analyticsModule';
import authenticationModule from './authenticationModule';
import productModule from './productModule';
import profileModule from './profileModule'
import validationModule from './validationModule';
import localeModule from "./localeModule";




const store=new vuex.Store({
    plugins: [createPersistedState()],//saves all state on page refresh !!!imp
    modules:{
        advertisement:advertisementModule,
        analytics:analyticsModule,
        authentication:authenticationModule,
        product:productModule,
        profile:profileModule,
        validation:validationModule,
        locale:localeModule
    },

    state:{
        
    },
    actions:{
        
    },
    mutations:{
        updateField //using mutation by vuex-map-fields
    },
    getters:{
        getField //using getters by vuex-map-fields
    },
});
export default store;