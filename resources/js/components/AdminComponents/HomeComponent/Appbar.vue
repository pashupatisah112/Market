<template>
<div>
    <v-app-bar app :flat="true" height="75px">
        <v-app-bar-nav-icon></v-app-bar-nav-icon>

        <v-toolbar-title>Admin Dashboard</v-toolbar-title>

        <v-spacer></v-spacer>

        <div class="mx-3">

            <!--users-->
            <v-menu bottom left offset-y origin="top right" transition="scale-transition">
                <template v-slot:activator="{ attrs, on }">
                    <v-btn class="ml-2" min-width="0" text v-bind="attrs" v-on="on">
                        <v-badge color="red" overlap bordered>
                            <template v-slot:badge>
                                <span>{{users.length}}</span>
                            </template>
                            <v-icon>mdi-account</v-icon>
                        </v-badge>
                    </v-btn>
                </template>
                <v-card width="300" flat tile>
                    <v-card-actions class="py-0">
                        <p class="para-text mx-2 my-0"><b>New Users</b></p>
                    </v-card-actions>

                    <v-divider></v-divider>

                    <v-card flat tile v-if="users.length">
                        <v-virtual-scroll :items="users" :item-height="40" height="200">
                            <template v-slot="{item}">
                                <v-list three-line>
                                    <v-list-item :key="item.created_at" dense>
                                        <v-list-item-content>
                                            <v-list-item-title>
                                                <v-icon class="mt-n2">mdi-music-note-whole</v-icon>New User:{{item.user_name}}.
                                            </v-list-item-title>
                                        </v-list-item-content>
                                        <v-list-item-action>
                                            <v-list-item-action-text>
                                                2 min
                                            </v-list-item-action-text>
                                        </v-list-item-action>

                                    </v-list-item>
                                </v-list>
                                <v-divider></v-divider>
                            </template>
                        </v-virtual-scroll>
                        <v-divider></v-divider>
                        <v-card-actions class="py-0">
                            <v-spacer></v-spacer>
                            <v-btn text>Checked All</v-btn>
                            <v-spacer></v-spacer>
                        </v-card-actions>
                    </v-card>
                    <p v-else class="text--secondary my-10 text-center">No new user</p>
                </v-card>
            </v-menu>
            <!-- end users -->

            <!-- orders -->
            <v-menu bottom left offset-y origin="top right" transition="scale-transition">
                <template v-slot:activator="{ attrs, on }">
                    <v-btn class="ml-2" min-width="0" text v-bind="attrs" v-on="on">
                        <v-badge color="red" overlap bordered>
                            <template v-slot:badge>
                                <span>{{orders.length}}</span>
                            </template>
                            <v-icon>mdi-cart-arrow-down</v-icon>
                        </v-badge>
                    </v-btn>
                </template>
                <v-card width="300" flat tile>
                    <v-card-actions class="py-0">
                        <p class="para-text my-2"><b>Orders</b></p>
                    </v-card-actions>
                    <v-divider></v-divider>
                    <v-card flat tile v-if="orders.length>0">
                        <v-virtual-scroll :items="orders" :item-height="45" height="200">
                            <template v-slot="{item}">
                                <v-list>
                                    <v-list-item :key="item.created_at" dense to="/admin/sales">
                                        <v-list-item-content>
                                            <v-list-item-title>
                                                <v-icon class="mt-n2">mdi-music-note-whole</v-icon>{{item.user_name}} ordered {{item.item_num}} items.
                                            </v-list-item-title>
                                        </v-list-item-content>
                                        <v-list-item-action>
                                            <v-list-item-action-text>
                                                {{ moment.utc(item.created_at).fromNow() }}
                                            </v-list-item-action-text>
                                        </v-list-item-action>

                                    </v-list-item>
                                </v-list>
                            </template>
                        </v-virtual-scroll>
                        <v-divider></v-divider>
                        <v-card-actions class="py-0">
                            <v-spacer></v-spacer>
                            <v-btn text>Checked All</v-btn>
                            <v-spacer></v-spacer>
                        </v-card-actions>
                    </v-card>
                    <p v-else class="text--secondary my-10 text-center">No new order</p>
                </v-card>
            </v-menu>
            <!-- end orders -->

            <!-- comments -->
            <v-menu bottom left offset-y origin="top right" transition="scale-transition">
                <template v-slot:activator="{ attrs, on }">
                    <v-btn class="ml-2" min-width="0" text v-bind="attrs" v-on="on">
                        <v-badge color="red" overlap bordered>
                            <template v-slot:badge>
                                <span>{{comments.length}}</span>
                            </template>
                            <v-icon>mdi-comment-account-outline</v-icon>
                        </v-badge>
                    </v-btn>
                </template>
                <v-card width="300" flat tile>
                    <v-card-actions class="py-0">
                        <p class="para-text mx-2 my-0"><b>Comments</b></p>
                    </v-card-actions>

                    <v-divider></v-divider>

                    <v-card flat tile v-if="comments.length>0">
                        <v-virtual-scroll :items="comments" :item-height="45" height="200">
                            <template v-slot="{item}">
                                <v-list three-line>
                                    <v-list-item :key="item.created_at" dense>
                                        <v-list-item-content>
                                            <v-list-item-title>
                                                <v-icon class="mt-n2">mdi-music-note-whole</v-icon>{{item.user_name}} commented on a product.
                                            </v-list-item-title>
                                        </v-list-item-content>
                                        <v-list-item-action>
                                            <v-list-item-action-text>
                                                2 min
                                            </v-list-item-action-text>
                                        </v-list-item-action>

                                    </v-list-item>
                                </v-list>
                                <v-divider></v-divider>
                            </template>
                        </v-virtual-scroll>

                        <v-divider></v-divider>

                        <v-card-actions class="py-0">
                            <v-spacer></v-spacer>
                            <v-btn text>Checked All</v-btn>
                            <v-spacer></v-spacer>
                        </v-card-actions>
                    </v-card>
                    <p v-else class="text--secondary my-10 text-center">No new comment</p>

                </v-card>
            </v-menu>
            <!-- end comments -->

            <v-btn text>
                <v-icon @click="logout">mdi-logout</v-icon>
            </v-btn>
        </div>
    </v-app-bar>
</div>
</template>

<script>
var moment = require("moment");
import {
    mapMutations,
    mapActions
} from 'vuex'
export default {
    data() {
        return {
            moment: moment,
            comments: [],
            users: [],
            orders: [],
        }
    },
    computed: {

    },
    mounted() {
        this.getNotification()
        console.log(this.orders)
    },
    methods: {
        logout() {
            localStorage.removeItem('token');
            localStorage.removeItem('role');
            this.$router.push('/adminLogin').then(res => console.log('Logged out')).catch(err => console.log(err));

        },
        getNotification() {
            let data = []
            db.collection("notification")
                .where("read_at", "==", null)
                .onSnapshot((querySnapshot) => {
                    querySnapshot.forEach((doc) => {
                        if (doc.data().type == 'order') {
                            this.orders.push(doc.data())
                        } else if (doc.data().type == 'comment') {
                            this.comments.push(doc.data())
                        } else if (doc.data().type == 'user') {
                            this.users.push(doc.data())
                        }

                    });
                });
        }
    }
}
</script>
