<template>
<div>
    <v-navigation-drawer app permanent absolute dark width="240px" src="https://cdn.vuetifyjs.com/images/backgrounds/bg-2.jpg">
        <v-list dense nav class="py-0">
            <v-list-item two-line :class="miniVariant && 'px-0'">
                <v-img src="../images/assets/logo.png"></v-img>
            </v-list-item>

            <v-divider></v-divider>

            <v-list-item v-for="item in items" :key="item.title" :to="item.to" link>
                <v-list-item-icon>
                    <v-icon>{{ item.icon }}</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>
    </v-navigation-drawer>
</div>
</template>

<script>
export default {
    data() {
        return {
            drawer: true,
            items: [{
                    title: 'Dashboard',
                    icon: 'mdi-view-dashboard',
                    to: '/padmin/dashboard',
                },
                {
                    title: 'Customers',
                    icon: 'mdi-account-star',
                    to: '/padmin/customers'
                },
                {
                    title: 'Product',
                    icon: 'mdi-car-lifted-pickup',
                    to: '/padmin/products'
                },
                {
                    title: 'Product sup',
                    icon: 'mdi-gamepad-round',
                    to: '/padmin/products-sup'
                },
                {
                    title: 'Promo',
                    icon: 'mdi-google-ads',
                    to: '/padmin/carousel'
                },
                {
                    title: 'Orders',
                    icon: 'mdi-cart-arrow-down',
                    to: '/padmin/orders'
                },
                {
                    title: 'Comments',
                    icon: 'mdi-account-group',
                    to: '/padmin/comments'
                },

            ],
            color: 'primary',
            right: false,
            miniVariant: false,
            expandOnHover: false,
        }
    },
}
</script>
