<template>
<v-app id="inspire">
    <div class="back">

        <drawer></drawer>

        <appbar></appbar>
        
        <v-main class="mx-5 my-5">
            <router-view></router-view>
        </v-main>
    </div>
</v-app>
</template>

<script>
import Drawer from './HomeComponent/Drawer';
import Appbar from './HomeComponent/Appbar';
import { mapActions } from 'vuex';
export default {
    components:{Drawer,Appbar},
    data() {
        return {
        
        }
    },
    computed:{
    
    },
    mounted() {
        this.checkAdmin()
    },
    methods: {
        checkAdmin(){
            if(!localStorage.getItem('token')){
                this.$router.push({name:'AdminLogin'})
            }
        }
    }
}
</script>

<style lang="css">
.back {
    background: #f5f5f5;
    width: 100%;
    height: 100%;
}
</style>
