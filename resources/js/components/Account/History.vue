<template>
    <div>
        <v-container>
            <v-row justify="center">
                <p class="font-weight-bold">My Purchase History</p>
                <v-col cols="12">
                    <v-simple-table class="border">
                    <template v-slot:default>
                        <thead>
                            <tr>
                                <th class="text-left">
                                    Product
                                </th>
                                <th class="text-left">
                                    Color
                                </th>
                                <th class="text-left">
                                    Size
                                </th>
                                <th class="text-left">
                                    Price
                                </th>
                                <th class="text-left">
                                    Quantity
                                </th>
                                <th class="text-left">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in history" :key="item.id">
                                <td>
                                    <v-list two-line dense>
                                        <v-list-item>
                                            <v-list-item-avatar tile size="60">
                                                <v-img :alt="`${item.title} avatar`" :src="getImage(item.product)"></v-img>
                                            </v-list-item-avatar>

                                            <v-list-item-content>
                                                <v-list-item-title v-text="item.product.title"></v-list-item-title>
                                            </v-list-item-content>
                                        </v-list-item>
                                    </v-list>
                                </td>
                                <td><span v-if="item.color">{{item.color.color_name}}</span><span v-else>-</span></td>
                                <td><span v-if="item.size">{{item.size.size}}</span><span v-else>-</span></td>
                                <td>{{item.product.price}}</td>
                                <td>
                                    {{item.quantity}}
                                </td>
                                <td>
                                    {{item.order.delivery_status}}
                                </td>
    
                            </tr>
                        </tbody>
                    </template>
                </v-simple-table>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>
<script>
export default {
    data(){
        return{
            history:[]
        }
    },
    mounted(){
        this.getPurchaseHistory()
    },
    methods:{
        getPurchaseHistory(){
            axios.post('api/getPurchaseHistory')
            .then(res=>{
                this.history=res.data
            })
            .catch(err=>console.log(err.response))
        },
        getImage(item){
            return item.image
        }
    }
}
</script>