import Axios from "axios";
import { sortedIndex } from "lodash";
import router from "../router";
import Vue from 'vue';


export default {
    state: {

        //invoice
        invoiceOrder:[],
        invoiceProduct:[],
        invoiceTotal:0,

        //quickview variables
        quickViewDialog: true,
        quickViewItem:{color:[],size:[]},//clearing error
        //end

        cartlist: [],
        cartlistItem:[],
        wishlist: [],
        wishlistItem: [],

        //search
        searchText:''
    },
    mutations: {
        applyWishlist(state, item) {
            state.wishlist = item;
        },
        addWishlistItem(state, item) {
            state.wishlistItem = item;
        },
        addToWishlist(state,item){
            if(this.state.authentication.token){ //'this.state' refers to root state
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
            }
            else{
                this.state.authentication.loginDialog=true
            }
            
        },
        pullFromWishlist(state, item) {
            state.wishlistItem.splice(state.wishlistItem.indexOf(item.id),1);
            state.wishlist.splice(state.wishlist.indexOf(item),1);
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
            console.log('cart:',item)
               state.cartlist.push(item)
               state.cartlistItem.push(item.product[0].id)
        },
        getCartList(state,item) {
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
            console.log(item.product[0].id)
            Axios.post('api/removeFromCartlist',{
                cart_id:item.id
            })
            .then(res=>{
                state.cartlistItem.splice(state.cartlistItem.indexOf(item.product[0].id),1)
                state.cartlist.splice(state.cartlist.indexOf(item),1)
                Vue.prototype.$toast.success({
                    title: "Cart",
                    message: "Product removed from cartlist."
                });
            })
            .catch(err=>console.log(err.response))
        },
        setupInvoiceOrder(state,order){
            state.invoiceOrder=order
        },
        setupInvoiceProduct(state,product){
            state.invoiceProduct=product
        },
        setupInvoiceTotal(state,total){
            state.invoiceTotal=total
        },
        setSearchItem(state,item){
            state.searchText=item
        },
    },
    actions: {
        goToDetails(state,item) {
            router.push({
                name: "Detail",
                params:{code:item.product_code,title:item.title}
            });
            console.log(item.product_code)
            window.location.reload()
            
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
