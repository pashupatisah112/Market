import Axios from "axios";
import { sortedIndex } from "lodash";
import router from "../router";
import Vue from 'vue';

import CxltToastr from 'cxlt-vue2-toastr'
 
Vue.use(CxltToastr)

export default {
    state: {
        categories: [],
        quickViewDialog: false,

        cartlist: [],
        wishlist: [],
        wishlistItem: []
    },
    mutations: {
        applyWishlist(state, item) {
            state.wishlist = item;
        },
        addWishlistItem(state, item) {
            state.wishlistItem = item;
        },
        pushToWishlist(state, item) {
            state.wishlistItem.push(item.id);
            state.wishlist.push(item);
        },
        pullFromWishList(state, item) {
            state.wishlistItem.splice(state.wishlistItem.indexOf(item.id));
            state.wishlist.splice(state.wishlist.indexOf(item));
        },
        addToCart(state, item) {
            Axios.post("api/addToCart", {
                product_id: item.id,
                price: item.price
            })
                .then(res => {
                    console.log(res.data.msg)
                    if (res.data.msg = "not null") {
                        console.log('not null')
                        Vue.prototype.$toast.error({ //vue.prototype using in vuex
                            title: "Wishlist",
                            message: "Already in your cart."
                        });
                    }
                    else{
                        state.cartlist.push(res.data.product);
                        this.$toast.success({
                            title: "Wishlist",
                            message: "Successfully added to your cart."
                        });
                        
                    }
                })
                .catch(err => {
                    console.log(err.response);
                });
        }
        // getCart(state) {
        //     Axios.get("api/getCart")
        //         .then(res => {
        //             state.cartlist=res.data
        //             console.log(res.data)
        //         })
        //         .catch(err => console.log(err.response))

        // }
    },
    actions: {
        goToDetails() {
            router.push({
                name: "Detail"
            });
        }
    },
    getters: {}
};
