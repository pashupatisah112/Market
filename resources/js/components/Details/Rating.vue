<template>
<div>
    <v-container fluid>
        <v-row justify="center">
            <p v-if="rating==0">Rate this product:</p>
            <p v-else>Your rating:</p>
            <v-rating v-model="rating" @input="giveRating" class="mt-n3" background-color="yellow" half-increments color="orange"></v-rating>

            <v-col cols="5" align="center">
                <p class="text-h3">{{this.avg}}</p>
                <v-rating v-model="avg" background-color="yellow" readonly half-increments small color="orange"></v-rating>
                <p>{{this.rating_count}} people rated this</p>
            </v-col>
            <v-col cols="7">
                <div v-if="this.rating_count>0">
                    <v-list-item class="mt-n6 ml-n5" v-for="item in rated" :key="item.id" >
                        <v-list-item-avatar>
                            {{item.rating}}
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title>
                                <v-progress-linear :value="getValue(item)" color="amber" rounded height="10"></v-progress-linear>
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </div>

                <p v-else class="font-weight-bold mx-auto">Not Rated yet</p>
            </v-col>
        </v-row>
    </v-container>
</div>
</template>

<script>
export default {
    data() {
        return {
            rating: 0,
            rated: [],
            product_code: this.$route.params.code,
            avg: 0,
            rating_count: 0,
        }
    },
    mounted() {
        this.getRatings()
    },
    methods: {
        getRatings() {
            axios.post('api/getRatings', {
                    code: this.product_code
                }).then(res => {
                    if(res.data.avg>0){
                    this.avg = parseFloat(res.data.avg).toFixed(1)

                    }
                    this.rating_count = res.data.rating_count
                    this.rated=res.data.rated
                    this.rating=parseInt(res.data.user_rated.rating)
                })
                .catch(err => console.log(err.response))
        },
        giveRating() {
            axios.post('api/giveRating', {
                    code: this.product_code,
                    rated: this.rating
                }).then(res => {
                    this.$toast.success({
                        title: "Rating",
                        message: "Thanks for your rating."
                    });
                })
                .catch(err => console.log(err.response))
        },
        getValue(item){
            let count=100/this.rating_count
            return item.total*count
        }
    }
}
</script>
