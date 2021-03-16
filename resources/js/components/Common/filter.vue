<template>
<div>
    <v-container>
        <v-row>
            <p class="font-weight-bold text-decoration-underline mt-1">{{category}}</p>
            <!-- trending wala haru fetch gar jati aatxa in one line -->
            <!-- <v-chip v-for="item in selectedCategory[0].sub_category" :key="item.id" class="mx-2">{{item.subCategory_name}}</v-chip> -->

            <v-spacer></v-spacer>

            <v-btn dark rounded @click="expand=!expand">
                <v-icon>mdi-filter-variant</v-icon>
                {{$t('words.fil.sort')}}
            </v-btn>
            <v-expand-transition>
                <v-card style="width:100%;" v-show="expand" color="background" flat>
                    <v-container fluid>
                        <v-row>
                            <!-- sorting option -->
                            <v-col cols="12" lg="2" md="6">
                                <p class="body-1 font-weight-bold">{{$t('words.filter.sort')}}</p>
                                <v-row v-for="(item,index) in sorts" :key="index" class="py-2 px-2">
                                    <v-btn text class="body-2 text-capitalize" small>{{$t(item.title)}}</v-btn>
                                </v-row>
                            </v-col>
                            <!-- end sorting option -->

                            <!-- range filter -->
                            <v-col cols="12" lg="2" md="6">
                                <p class="body-1 font-weight-bold">{{$t('words.filter.price')}}</p>
                                <v-row v-for="(item,index) in prices" :key="index" class="py-2 px-2">
                                    <v-btn text class="body-2 text-capitalize" small>{{$t(item.range)}}</v-btn>
                                </v-row>
                            </v-col>
                            <!-- end range filter -->

                            <!-- color filter -->
                            <v-col cols="12" lg="2" md="6">
                                <p class="body-1 font-weight-bold">Color</p>
                                <v-row v-for="(item,index) in colors" :key="index" class="py-2 px-2">
                                    <v-btn text class="body-2 text-capitalize" small>
                                        <v-icon :color="getColor(item)" class="mr-1">mdi-checkbox-blank-circle</v-icon>
                                        {{item.color_name}}
                                    </v-btn>
                                </v-row>
                            </v-col>
                            <!-- end color filter -->

                            <!-- company filter -->
                            <v-col cols="12" lg="6" md="6">
                                <p class="body-1 font-weight-bold">{{$t('words.filter.brand')}}</p>
                                <v-chip class="mx-2" color="green" outlined v-for="item in companies" :key="item.id">{{item.company_name}}</v-chip>
                            </v-col>
                            <!-- end company filter -->

                        </v-row>
                    </v-container>
                </v-card>
            </v-expand-transition>

        </v-row>
    </v-container>
</div>
</template>

<script>
export default {
    data() {
        return {
            expand: false,
            selectedCategory: [],
            sorts: [{
                    title: 'words.filter.default'
                }, {
                    title: 'words.filter.popularity'
                }, {
                    title: 'words.filter.rating'
                }, {
                    title: 'words.filter.newest'
                },
                {
                    title: 'words.filter.priceAsc'
                }, {
                    title: 'words.filter.priceDes'
                }
            ],
            colors: [],
            prices: [{
                    range: 'Any'
                }, {
                    range: 'Rs.0-Rs.1000'
                },
                {
                    range: 'Rs.1000-Rs.2000'
                }, {
                    range: 'Rs.2000-Rs.3000'
                }, {
                    range: 'Rs.3000-Rs.5000'
                }, {
                    range: 'Rs.5000+above'
                }
            ],
            companies: []
        }
    },
    computed: {
        category() {
            return this.$route.params.category
        },
        subCategory() {
            return this.$route.params.subCategory
        }
    },
    mounted() {
        this.getSelectedCategory()
        this.getFilters()
    },
    methods: {
        getFilters() {
            axios.post('api/getFilters', {
                    subCat: this.subCategory
                })
                .then(res => {
                    this.colors = res.data.color
                    this.companies = res.data.subCategory[0].company
                    console.log(this.companies)
                })
                .catch(err => console.log(err.response))
        },
        getSelectedCategory() {
            axios.post('api/getSelectedCategory', {
                    category_name: this.category
                }).then(res => {
                    this.selectedCategory = res.data
                    console.log(this.selectedCategory[0].category_name)
                })
                .catch(err => console.log(err.response))
        },
        getColor(item) {
            return item.color_code
        }
    }
}
</script>
