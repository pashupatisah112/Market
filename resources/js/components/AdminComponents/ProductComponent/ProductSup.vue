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
                    <size></size>
                </v-col>
                <v-col cols="6">
                    <company></company>
                </v-col>
                <v-col cols="6">
                    <color></color>
                </v-col>
                <v-col cols="6">
                    <type></type>
                </v-col>
                <v-col cols="6">
                    <tag></tag>
                </v-col>
            </v-row>
        </v-container>
        
    </div>
</template>
<script>
import Category from './Category';
import SubCategory from './SubCategory';
import Size from './Size';
import Color from './Color';
import Company from './Company';
import Tag from './Tags';
import Type from './ProductType';
export default {
    components:{Category,SubCategory,Size,Color,Company,Tag,Type},
    data(){
        return{
            
        }
    }
}
</script>