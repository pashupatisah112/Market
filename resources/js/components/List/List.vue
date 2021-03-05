<template>
<div>
    <v-container>
        <v-row>
            <v-col cols="12" lg="11" md="11">
                <v-row class="px-5">
                    <p class="font-weight-bold text-decoration-underline mt-1">
                        {{ category }}
                    </p>
                    <v-chip v-for="item in selectedCategory.sub_category" :key="item.id" class="mx-2" @click="filterTop(item)" link>{{item.subCategory_name}}</v-chip>

                </v-row>

            </v-col>
            <v-col cols="12" lg="1" md="1">
                <v-spacer></v-spacer>
                <v-btn dark rounded @click="expand = !expand">
                    <v-icon>mdi-filter-variant</v-icon>
                    Filter
                </v-btn>
            </v-col>

            <v-expand-transition>
                <v-card style="width:100%;" v-show="expand" color="background" flat>
                    <v-container fluid>
                        <v-row>
                            <!-- sorting option -->
                            <v-col cols="12" lg="2" md="6">
                                <p class="body-1 font-weight-bold">
                                    Sort By
                                </p>
                                <v-row v-for="(item, index) in sorts" :key="index" class="py-2 px-2">
                                    <v-btn text class="body-2 text-capitalize" small @click="sortBy(item)">{{ item.title }}</v-btn>
                                </v-row>
                            </v-col>
                            <!-- end sorting option -->

                            <!-- range filter -->
                            <v-col cols="12" lg="2" md="6">
                                <p class="body-1 font-weight-bold">Price</p>
                                <v-row v-for="(item, index) in prices" :key="index" class="py-2 px-2">
                                    <v-btn text class="body-2 text-capitalize" small @click="priceFilter(item)">{{ item.range }}</v-btn>
                                </v-row>
                            </v-col>
                            <!-- end range filter -->

                            <!-- company filter -->
                            <v-col cols="12" lg="6" md="6">
                                <p class="body-1 font-weight-bold">
                                    Brands
                                </p>
                                <v-chip class="mx-2" color="green" outlined v-for="item in companies" :key="item.id" @click="companyFilter(item)">{{ item.company_name }}</v-chip>
                            </v-col>
                            <!-- end company filter -->
                        </v-row>
                    </v-container>
                </v-card>
            </v-expand-transition>
        </v-row>
        <v-row justify="center" v-if="productsList.data">
            <v-col cols="12" lg="2" md="4" sm="6" v-for="item in productsList.data" :key="item.id">
                <v-card max-width="300" class="mx-auto" tile flat>
                    <v-hover v-slot="{ hover }">
                        <div style="overflow: hidden;">
                            <v-img :src="getImage(item)" max-width="300" height="350" style="transition: transform .4s;" :class="{ 'on-hover': hover }">
                                <v-slide-y-reverse-transition hide-on-leave>
                                    <div v-if="hover" class="d-flex transition-fast-in-fast-out v-card--reveal" style="height: 30%;">
                                        <v-row justify="center">
                                            <v-col align="center" cols="12">
                                                <v-btn rounded color="white" class="text-capitalize mb-1" small @click="quickView(item)">Quick View</v-btn>
                                                <div style="background-color:rgba(0,0,0,0.7)" class="mb-n2">
                                                    <v-rating :value="getRating(item)" readonly background-color="yellow" half-increments small color="orange"></v-rating>
                                                </div>
                                            </v-col>
                                        </v-row>
                                    </div>
                                </v-slide-y-reverse-transition>
                            </v-img>
                        </div>
                    </v-hover>
                    <v-card-actions class="pa-0">
                        <v-card-subtitle class="pa-0 link" @click="goToDetails(item)">
                            {{ item.title }}
                        </v-card-subtitle>

                        <v-spacer></v-spacer>
                        <v-btn icon v-if="wishlistItem.includes(item.id)">
                            <v-icon color="red" @click="alreadyMessage">mdi-heart</v-icon>
                        </v-btn>
                        <v-btn icon v-else>
                            <v-icon color="red" @click="addToWishlist(item)">mdi-heart-outline</v-icon>
                        </v-btn>
                    </v-card-actions>
                    <v-card-title class="pa-0">
                        Rs.{{ item.price }}
                    </v-card-title>
                </v-card>
            </v-col>
            <v-col cols="12" align="center">
                <v-pagination
                        v-model="page"
                        :length="productsList.last_page"
                        prev-icon="mdi-menu-left"
                        next-icon="mdi-menu-right"
                        :total-visible="7"
                        @input="input"
                        @next="next"
                        @previous="previous"
                        class="my-5"
                    ></v-pagination>
            </v-col>
        </v-row>
        <hollow-dots-spinner class="mx-auto my-16" v-else-if="productsList.length <1 && noProdText==''" :animation-duration="1000" :dot-size="20" :dots-num="3" color="#ff1d5e" />
        <p v-else class="text-center text-secondary">{{noProdText}}</p>
    </v-container>
</div>
</template>

<script>
import {
    mapState,
    mapActions,
    mapMutations
} from "vuex";
import {
    HollowDotsSpinner
} from "epic-spinners";
export default {
    components:{HollowDotsSpinner},
    data() {
        return {
            page:1,
            productsList: [],
            noProdText:'',
            expand: false,
            selectedCategory: [],
            rating: 4,
            sorts: [{
                    title: "Default"
                },
                {
                    title: "Popularity"
                },
                {
                    title: "Average Rating"
                },
                {
                    title: "Newest"
                },
                {
                    title: "Price: Low to High"
                },
                {
                    title: "Price: High to Low"
                }
            ],
            colors: [],
            prices: [{
                    range: "Any",
                    low: 0,
                    high: 50000
                },
                {
                    range: "Rs.0 - Rs.1000",
                    low: 0,
                    high: 1000
                },
                {
                    range: "Rs.1000 - Rs.2000",
                    low: 1000,
                    high: 2000
                },
                {
                    range: "Rs.2000 - Rs.3000",
                    low: 2000,
                    high: 3000
                },
                {
                    range: "Rs.3000 - Rs.5000",
                    low: 3000,
                    high: 5000
                },
                {
                    range: "Rs.5000 + above",
                    low: 5000,
                    high: 50000
                }
            ],
            companies: []
        };
    },
    computed: {
        category() {
            return this.$route.params.category;
        },
        subCategory() {
            return this.$route.params.subCategory;
        },
        ...mapState({
            wishlistItem: state => state.product.wishlistItem
        })
    },
    mounted() {
        this.getProductsList();
        this.getSelectedCategory();
        this.getFilters();
    },
    methods: {
        ...mapActions(["goToDetails", "alreadyMessage"]),
        ...mapMutations([
            "pushToWishlist",
            "addToCart",
            "quickView",
            "addToWishlist"
        ]),
        getProductsList() {
            axios
                .post("api/getProducts?page=" + this.page, {
                    subCat: this.subCategory
                })
                .then(res => {
                    this.productsList = res.data
                    if(res.data.data.length<1){
                        this.noProdText='No any related products founr. Try different filter.'
                    }
                })
                .catch(err => console.log(err.response));
        },
        getImage(item) {
            return item.image;
        },
        getRating(item) {
            let rate = 0
            for (var i = 0; i < item.rating.length; i++) {
                rate = rate + parseInt(item.rating[i].rating)

            }
            return rate / item.rating.length
        },
        getFilters() {
            axios
                .post("api/getFilters", {
                    subCat: this.subCategory
                })
                .then(res => {
                    this.colors = res.data.color;
                    this.companies = res.data.subCategory[0].company;
                })
                .catch(err => console.log(err.response));
        },
        getSelectedCategory() {
            axios
                .post("api/getSelectedCategory", {
                    category_name: this.category
                })
                .then(res => {
                    this.selectedCategory = res.data;
                })
                .catch(err => console.log(err.response));
        },
        getColor(item) {
            return item.color_code;
        },
        sortBy(item) {
            axios.post('/api/sortBy', {
                field: item.title,
                subCat: this.subCategory
            }).then(res => {
                this.productsList = res.data
            }).catch(err => console.log(err.response))
        },
        companyFilter(item) {
            axios
                .post("/api/companyFilter", {
                    name: item.company_name,
                    subCat: this.subCategory
                })
                .then(res => {
                    this.productsList = res.data;
                })
                .catch(err => console.log(err.response));
        },
        priceFilter(item) {
            axios
                .post("/api/priceFilter", {
                    low_range: item.low,
                    high_range: item.high,
                    subCat: this.subCategory
                })
                .then(res => {
                    this.productsList = res.data;
                })
                .catch(err => console.log(err.response));
        },
        filterTop(item) {
            axios.post('api/filterTopCategories', {
                    sub_cat_id: item.id
                })
                .then(res => this.productsList = res.data)
                .catch(err => console.log(err.response))
        },
        input(e) {
            this.page = e;
            this.getProductsList();
        },
        next(e) {
            axios
                .get(this.productsList.next_page_url)
                .then(res => {
                    this.productsList = res.data;
                })
                .catch(err => console.log(err.response));
        },
        previous() {
            axios
                .get(this.productsList.previous_page_url)
                .then(res => {
                    this.productsList = res.data;
                })
                .catch(err => console.log(err.response));
        }
    }
};
</script>
