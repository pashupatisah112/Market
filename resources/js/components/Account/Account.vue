<template>
<div>
    <v-btn v-if="!token" small text depressed color="transparent" @click="setLoginDialog" class="text-capitalize white--text mx-auto">
        <v-icon color="white">mdi-account</v-icon>
        {{ $t('words.header.login') }}
    </v-btn>
    <v-menu v-else offset-y>
        <template v-slot:activator="{ on, attrs }">
            <v-btn dark v-bind="attrs" v-on="on" small text depressed color="transparent" class=" text-capitalize mx-auto">
                <v-icon>mdi-account</v-icon>
                Account
            </v-btn>
        </template>
        <v-card width="200" tile>
            <v-card-subtitle class="font-weight-bold">{{auth.name}}</v-card-subtitle>
            <v-card-text class="px-1 mt-n3">
                <v-list dense>
                    <v-list-item dense @click="viewCart()">
                        <v-list-item-content>
                            <v-list-item-subtitle>
                                <v-icon class="mr-2">mdi-cart</v-icon>My Cart
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item dense>
                        <v-list-item-content>
                            <v-list-item-subtitle @click="viewHistory">
                                <v-icon class="mr-2">mdi-history</v-icon>Purchase history
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item dense @click="logout">
                        <v-list-item-content>
                            <v-list-item-subtitle>
                                <v-icon class="mr-2">mdi-logout</v-icon>Logout
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-card-text>
        </v-card>
    </v-menu>
</div>
</template>

<script>
import {
    mapState,
    mapMutations
} from 'vuex'
export default {
    data() {
        return {

        }
    },
    computed: {
        ...mapState({
            token: state => state.authentication.token,
            auth: state => state.authentication.auth
        })
    },
    methods: {
        ...mapMutations(['setLoginDialog']),
        viewCart(){
            this.$router.push({
                path:'cart-view'
            })
        },
        viewHistory(){
            this.$router.push({
                path:'history-view'
            })
        },
        logout() {
            localStorage.removeItem('token');
            localStorage.removeItem('role');
            localStorage.clear()
            window.location.reload()
        },
    }
}
</script>
