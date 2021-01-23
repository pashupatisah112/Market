import Axios from "axios";
import { sortedIndex } from "lodash";
import router from "../router";
import Vue from 'vue';


export default {
    state: {
        categories: [],

        //quickview variables
        quickViewDialog: false,
        quickViewId:null,
        //end

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
        
        addToCart(state,product_id,amount,total){
            Axios.post('api/addToCart',{
                product:product_id,
                amt:amount,
                tot:total
            }).then(res=>console.log(res.data))
            .catch(err=>console.log(err.response))
        },
        getCart(state) {
            Axios.get("api/getCart")
                .then(res => {
                    state.cartlist=res.data
                    console.log('module:',state.cartlist)
                })
                .catch(err => console.log(err.response))

        }
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
