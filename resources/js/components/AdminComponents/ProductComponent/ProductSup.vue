<template>
    <div>
        <v-container fluid>
            <v-row>
                <v-col cols="6">
                    <category></category>
                </v-col>
                <v-col cols="6">
                    <subCategory></subCategory>
                </v-col>
                <v-col cols="6">
                    <!-- <cart></cart> -->
                </v-col>
                <v-col cols="6">
                    <!-- <wishlist></wishlist> -->
                </v-col>
            </v-row>
        </v-container>
        
    </div>
</template>
<script>
import Category from './Category';
import SubCategory from './SubCategory';
import Wishlist from './Wishlist';
import Cart from './Carts';
export default {
    components:{Category,SubCategory,Wishlist,Cart},
    data(){
        return{
            
        }
    }
}
</script>