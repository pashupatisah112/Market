<template>
<v-app id="inspire">
    <div class="back">

        <drawer></drawer>

        <appbar></appbar>
         
        <v-snackbar v-model="snackbar" :bottom="y === 'bottom'" :color="color" :left="x === 'left'" :multi-line="mode === 'multi-line'" :right="x === 'right'" :timeout="timeout" :top="y === 'top'" :vertical="mode === 'vertical'">
            {{text}}
            <v-btn color="white" text @click="snackbar = false">Close</v-btn>
        </v-snackbar>

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
            //for snackber
            color: 'success',
            mode: '',
            snackbar: false,
            text: 'Welcome Pashupati. You are logged in as admin',
            timeout: 5000,
            x: null,
            y: 'top',
        }
    },
    computed:{
        ...mapActions(['getAuthUser'])
    },
    mounted() {
        this.snackbar = localStorage.getItem('loggedIn'); //to load snackbar just once
        localStorage.removeItem('loggedIn')
    },
    methods: {
        
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
