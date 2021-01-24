import Axios from "axios";
import { sortedIndex } from "lodash";
import router from "../router";
import Vue from 'vue';


export default {
    state: {
        categories: [],

        //quickview variables
        quickViewDialog: true,
        quickViewItem:{},
        //end

        cartlist: [],
        cartlistItem:[],
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
        quickView(state,item){
            Axios.post('api/getQuickViewItem',{
                product_id:item.id
            }).then(res=>{
                state.quickViewItem=res.data
                state.quickViewDialog=true
            }).catch(err=>console.log(err.response))
        },
        closeQuickView(state){
             state.quickViewDialog=false
        },
    
        addToCartlist(state,item){
            state.cartlist.push(item)
            state.cartlistItem.push(item.id)
        },
        cartList(state,item) {
            state.cartlist=item

        },
        getCartListItem(state){
            Axios.get('api/getCartListItem')
            .then(res=>{
                state.cartlistItem=res.data
            })
            .catch(err=>console.log(err.response))
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
