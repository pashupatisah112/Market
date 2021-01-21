<template>
<div>
    <v-app-bar app :flat="true" height="75px">
        <v-app-bar-nav-icon></v-app-bar-nav-icon>

        <v-toolbar-title>Admin Dashboard</v-toolbar-title>

        <v-spacer></v-spacer>

        <div class="mx-3">

            <v-menu bottom left offset-y origin="top right" transition="scale-transition">
                <template v-slot:activator="{ attrs, on }">
                    <v-btn class="ml-2" min-width="0" text v-bind="attrs" v-on="on">
                        <v-badge color="red" overlap bordered>
                            <template v-slot:badge>
                                <span>5</span>
                            </template>

                            <v-icon>mdi-bell</v-icon>
                        </v-badge>
                    </v-btn>
                </template>
            </v-menu>

            <v-btn text>
                <v-icon @click="logout">mdi-logout</v-icon>
            </v-btn>
        </div>
    </v-app-bar>
</div>
</template>
<script>
import { mapMutations, mapActions } from 'vuex'
export default {
    data(){
        return{

        }
    },
    computed:{
        
    },
    methods:{
        logout(){
            localStorage.removeItem('token');
            this.$router.push('/adminLogin').then(res => console.log('Logged out')).catch(err => console.log(err));
        
        }
    }
}
</script>
