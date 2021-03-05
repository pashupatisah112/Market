<template>
<div>
    <v-app>
        <appbar app></appbar>
        <v-main>
            <router-view></router-view>
        </v-main>
        <productFooter app></productFooter>

        <quickView></quickView>
    </v-app>
</div>
</template>

<script>
import Appbar from './Home/Appbar';
import ProductFooter from './Home/Footer';
import QuickView from './Common/QuickView';
export default {
    components: {
        Appbar,
        ProductFooter,
        QuickView
    },
    data() {
        return {

        }
        
    }
}
</script>
