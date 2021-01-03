import Vue from 'vue';
import vuex from 'vuex';
import createPersistedState from "vuex-persistedstate";

import { getField, updateField } from 'vuex-map-fields'; //to bind v-model https://github.com/maoberlehner/vuex-map-fields
Vue.use(vuex);

import advertisementModule from './advertisementModule';
import analyticsModule from './analyticsModule';
import authenticationModule from './authenticationModule';
import basicContentModule from './basicContentModule';
import communityModule from './communityModule';
import complainModule from './complainModule';
import courseModule from './courseModule';
import examSetModule from './examAndSetModule';
import noticeModule from './noticeModule';
import profileModule from './profileModule';
import requestModule from './requestModule';
import resultModule from './resultModule';
import roleModule from './roleModule';
import validationModule from './validationModule';



const store=new vuex.Store({
    plugins: [createPersistedState()],//saves all state on page refresh !!!imp
    modules:{
        advertisement:advertisementModule,
        analytics:analyticsModule,
        authentication:authenticationModule,
        basicContent:basicContentModule,
        community:communityModule,
        complain:complainModule,
        course:courseModule,
        examSet:examSetModule,
        notice:noticeModule,
        profile:profileModule,
        request:requestModule,
        result:resultModule,
        role:roleModule,
        validation:validationModule
    },

    state:{
        adminPanel:'Welcome to Admin Panel',
        staffPanel:'Welcome to Staff Panel',
        snackbar:false,
        snackMessage:'',
    },
    actions:{
        
    },
    mutations:{
        updateField,
        getUpdateMessage(state,payload){
            state.snackMessage=payload;
            state.snackbar=true;
        }
    },
    getters:{
        welcomeAdmin(state){
            return state.adminPanel;
        },
        getField
    },
});
export default store;