<template>
    <div>
        <v-container>
            <v-row>
                <p class="font-weight-bold text-decoration-underline mt-1">
                    {{ category }}
                </p>
                <!-- trending wala haru fetch gar jati aatxa in one line -->
                <!-- <v-chip v-for="item in selectedCategory[0].sub_category" :key="item.id" class="mx-2">{{item.subCategory_name}}</v-chip> -->

                <v-spacer></v-spacer>

                <v-btn dark rounded @click="expand = !expand">
                    <v-icon>mdi-filter-variant</v-icon>
                    Filter
                </v-btn>
                <v-expand-transition>
                    <v-card
                        style="width:100%;"
                        v-show="expand"
                        color="background"
                        flat
                    >
                        <v-container fluid>
                            <v-row>
                                <!-- sorting option -->
                                <v-col cols="12" lg="2" md="6">
                                    <p class="body-1 font-weight-bold">
                                        Sort By
                                    </p>
                                    <v-row
                                        v-for="(item, index) in sorts"
                                        :key="index"
                                        class="py-2 px-2"
                                    >
                                        <v-btn
                                            text
                                            class="body-2 text-capitalize"
                                            small
                                            @click="sortBy(item)"
                                            >{{ item.title }}</v-btn
                                        >
                                    </v-row>
                                </v-col>
                                <!-- end sorting option -->

                                <!-- range filter -->
                                <v-col cols="12" lg="2" md="6">
                                    <p class="body-1 font-weight-bold">Price</p>
                                    <v-row
                                        v-for="(item, index) in prices"
                                        :key="index"
                                        class="py-2 px-2"
                                    >
                                        <v-btn
                                            text
                                            class="body-2 text-capitalize"
                                            small
                                            @click="priceFilter(item)"
                                            >{{ item.range }}</v-btn
                                        >
                                    </v-row>
                                </v-col>
                                <!-- end range filter -->

                                <!-- color filter -->
                                <v-col cols="12" lg="2" md="6">
                                    <p class="body-1 font-weight-bold">Color</p>
                                    <v-row
                                        v-for="(item, index) in colors"
                                        :key="index"
                                        class="py-2 px-2"
                                    >
                                        <v-btn
                                            text
                                            class="body-2 text-capitalize"
                                            small
                                        >
                                            <v-icon
                                                :color="getColor(item)"
                                                class="mr-1"
                                                >mdi-checkbox-blank-circle</v-icon
                                            >
                                            {{ item.color_name }}
                                        </v-btn>
                                    </v-row>
                                </v-col>
                                <!-- end color filter -->

                                <!-- company filter -->
                                <v-col cols="12" lg="6" md="6">
                                    <p class="body-1 font-weight-bold">
                                        Brands
                                    </p>
                                    <v-chip
                                        class="mx-2"
                                        color="green"
                                        outlined
                                        v-for="item in companies"
                                        :key="item.id"
                                        @click="companyFilter(item)"
                                        >{{ item.company_name }}</v-chip
                                    >
                                </v-col>
                                <!-- end company filter -->
                            </v-row>
                        </v-container>
                    </v-card>
                </v-expand-transition>
            </v-row>
            <v-row>
                <v-col
                    cols="12"
                    lg="2"
                    md="3"
                    v-for="item in productsList"
                    :key="item.id"
                >
                    <v-card max-width="300" class="mx-auto" tile flat>
                        <v-hover v-slot="{ hover }">
                            <div style="overflow: hidden;">
                                <v-img
                                    :src="getImage(item)"
                                    width="200"
                                    height="250"
                                    style="transition: transform .4s;"
                                    :class="{ 'on-hover': hover }"
                                >
                                    <v-slide-y-reverse-transition hide-on-leave>
                                        <div
                                            v-if="hover"
                                            class="d-flex transition-fast-in-fast-out v-card--reveal"
                                            style="height: 30%;"
                                        >
                                            <v-col align="center">
                                                <v-btn
                                                    rounded
                                                    color="white"
                                                    class="text-capitalize mb-3"
                                                    small
                                                    @click="quickView(item)"
                                                    >Quick View</v-btn
                                                >
                                                <div
                                                    style="background-color:rgba(0,0,0,0.7)"
                                                >
                                                    <v-rating
                                                        v-model="rating"
                                                        background-color="yellow"
                                                        half-increments
                                                        small
                                                        color="orange"
                                                        class="mt-n2"
                                                    ></v-rating>
                                                </div>
                                            </v-col>
                                        </div>
                                    </v-slide-y-reverse-transition>
                                </v-img>
                            </div>
                        </v-hover>
                        <v-card-actions class="pa-0">
                            <v-card-subtitle
                                class="pa-0 link"
                                @click="goToDetails(item)"
                            >
                                {{ item.title }}
                            </v-card-subtitle>

                            <v-spacer></v-spacer>
                            <v-btn icon v-if="wishlistItem.includes(item.id)">
                                <v-icon color="red" @click="alreadyMessage"
                                    >mdi-heart</v-icon
                                >
                            </v-btn>
                            <v-btn icon v-else>
                                <v-icon color="red" @click="addToWishlist(item)"
                                    >mdi-heart-outline</v-icon
                                >
                            </v-btn>
                        </v-card-actions>
                        <v-card-title class="pa-0">
                            Rs.{{ item.price }}
                        </v-card-title>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script>
import { mapState, mapActions, mapMutations } from "vuex";
export default {
    data() {
        return {
            productsList: [],
            expand: false,
            selectedCategory: [],
            rating: 4,
            sorts: [
                {
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
            prices: [
                {
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
                .post("api/getProducts", {
                    subCat: this.subCategory
                })
                .then(res => {
                    this.productsList = res.data
                })
                .catch(err => console.log(err.response));
        },
        getImage(item) {
            return "../storage/" + item.image;
        },
        getFilters() {
            axios
                .post("api/getFilters", {
                    subCat: this.subCategory
                })
                .then(res => {
                    this.colors = res.data.color;
                    this.companies = res.data.subCategory[0].company;
                    console.log(this.companies);
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
                    console.log(this.selectedCategory[0].category_name);
                })
                .catch(err => console.log(err.response));
        },
        getColor(item) {
            return item.color_code;
        },
        sortBy(item) {
            axios.post('/api/sortBy',{
                field:item.title,
                subCat: this.subCategory
            }).then(res=>{
                this.productsList=res.data
            }).catch(err=>console.log(err.response))
        },
        colorFilter() {},
        companyFilter(item) {
            axios
                .post("/api/companyFilter", {
                    name:item.company_name,
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
        }
    }
};
</script>
