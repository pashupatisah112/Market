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
        addToWishlist(state,item){
            axios
                .post("api/addToWishlist", {
                    product_id: item.id
                })
                .then(res => {
                    state.wishlistItem.push(item.id);
                    state.wishlist.push(item);
                    Vue.prototype.$toast.success({
                        title: "Wishlist",
                        message: "Added to your wishlist"
                    });
                })
                .catch(err => console.log(err.response));
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
        },
        removeFromCartlist(state,item){
            console.log(item.cart[0].id)
            Axios.post('api/removeFromCartlist',{
                cart_id:item.cart[0].id
            })
            .then(res=>{
                state.cartlistItem.splice(state.cartlistItem.indexOf(item.cart[0].id))
                state.cartlist.splice(state.cartlist.indexOf(item))
                Vue.prototype.$toast.success({
                    title: "Cart",
                    message: "Product removed from cartlist."
                });
            })
            .catch(err=>console.log(err.response))
        }
    },
    actions: {
        
        goToDetails() {
            router.push({
                name: "Detail"
            });
        },
        alreadyMessage(){
            Vue.prototype.$toast.info({
                        title: "Wishlist",
                        message: "Already Present in your wishlist"
                    });
        },
    },
    getters: {}
};
