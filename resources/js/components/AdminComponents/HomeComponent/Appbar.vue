<template>
<div>
    <v-app-bar app :flat="true" height="75px">
        <v-app-bar-nav-icon></v-app-bar-nav-icon>

        <v-toolbar-title>{{welcome}}</v-toolbar-title>

        <v-spacer></v-spacer>

        <div class="mx-3">
            
            <profile></profile>

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
                <v-list :tile="false" nav>
                    <div>
                        <app-bar-item v-for="(n, i) in notifications" :key="`item-${i}`">
                            <v-list-item-title v-text="n" />
                        </app-bar-item>
                    </div>
                </v-list>
            </v-menu>

            <v-btn text @click="logout">
                <v-icon>mdi-logout</v-icon>
            </v-btn>
        </div>
    </v-app-bar>
</div>
</template>

<script>
import Profile from './ProfileChange';
import { mapActions } from 'vuex';
export default {
    components:{Profile},
    data() {
        return {
            color: 'primary',

            notifications: [
                'Mike John Responded to your email',
                'You have 5 new tasks',
                'You\'re now friends with Andrew',
                'Another Notification',
                'Another one',
            ],
        }
    },
    computed:{
        welcome(){
            return this.$store.getters.welcomeAdmin;
        }
        
    },
    methods: {
        logout: function () {
            localStorage.removeItem('token');
            this.$router.push('/login').then(res => console.log('Logged out')).catch(err => console.log(err));
        },
    },
    showProfile(){
        dialog:true
    },
}
</script>
