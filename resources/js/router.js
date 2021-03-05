import Vue from "vue";
import VueRouter from "vue-router";
Vue.use(VueRouter);

//ADMIN
import AdminLogin from "./components/AdminComponents/AdminLogin";
import Admin from "./components/AdminComponents/Home";
import Dashboard from "./components/AdminComponents/Dashboard";
import Customer from "./components/AdminComponents/CustomerComponent/Customers";
import Product from "./components/AdminComponents/ProductComponent/Product";
import ProductSup from "./components/AdminComponents/ProductComponent/ProductSup";
import Carousel from "./components/AdminComponents/PromoComponent/Carousel";
import Orders from "./components/AdminComponents/OrderComponent/Orders";
import Comment from "./components/AdminComponents/CommentComponent/Comment";
import Invoice from './components/AdminComponents/OrderComponent/Invoice';

//User
import Main from "./components/Index";
import Home from "./components/Home/Home";
import Category from "./components/List/Home";
import TopSeller from './components/TopSeller/TopSeller';
import Collection from "./components/Collections/Collection";
import Offer from './components/Offers/Offer';
import Sale from './components/Sale/Sale';
import Detail from "./components/Details/Home";
import Cart from "./components/Account/CartView";
import PurchaseHistory from "./components/Account/History";
import About from "./components/Other/About";
import Contact from "./components/Other/Contact";
import Search from './components/Home/Search';
import NotFound from './components/Account/404';

import Test from './components/Home/Test';

const routes = [
    {
        path: "/padmin",
        redirect: "/padmin/dashboard"
    },
    {
        path: "/adminLogin",
        name: "AdminLogin",
        component: AdminLogin
    },

    {
        path: "/padmin",
        component: Admin,
        children: [
            {
                path: "dashboard",
                name: "AdminDashboard",
                component: Dashboard
            },
            {
                path: "customers",
                name: "CustomersList",
                component: Customer
            },
            {
                path: "products",
                name: "ProductList",
                component: Product
            },
            {
                path: "products-sup",
                name: "ProductSup",
                component: ProductSup
            },
            {
                path: "carousel",
                name: "Carousel",
                component: Carousel
            },
            {
                path: "orders",
                name: "Sales",
                component: Orders
            },
            {
                path: "comments",
                name: "Comments",
                component: Comment
            },
           
        ],
        beforeEnter: (to, from, next) => {
            if(localStorage.getItem('role')=='admin'){
                next()
            }else if(localStorage.getItem('role')=='user'){
                next("/404")
            }else{
                next("/adminLogin")
            }
            // axios
            //     .get("api/verify")
            //     .then(res => {
            //         console.log('login data:',res.data)
            //         // if (res.data.role_id == 1) {
            //         //     next()
            //         // } else {
            //         //     next("/adminLogin");
            //         // }
            //     })
            //     .catch(err =>{
            //         console.log(err.response)
            //         //next("/adminLogin")
            //     });
        }
        
    },
    {
        path: "/invoice",
        name: "Invoice",
        component: Invoice
    },
    
    {
        path: "/",
        component: Main,
        children: [
            {
                path: "",
                name: "Home",
                component: Home
            },
            
            {
                path: "/collections",
                name: "Collection",
                component: Collection
            },
            {
                path: "/top-sellers",
                name: "TopSeller",
                component: TopSeller
            },
            
            {
                path: "/offers",
                name: "Offers",
                component: Offer
            },
            {
                path: "/sale",
                name: "Sale",
                component: Sale
            },
            {
                path: "/cart-view",
                name: "CartView",
                component: Cart
            },
            {
                path: "/history-view",
                name: "History",
                component: PurchaseHistory
            },
            {
                path: "/about",
                name: "About",
                component: About
            },
            
            
            {
                path: "/contact",
                name: "Contact",
                component: Contact
            },
            {
                path: "/test",
                name: "test",
                component: Contact
            },
            {
                path: "search",
                name: "Search",
                component: Search
            },
            {
                path: ":category/:subCategory",
                name: "Category",
                component: Category
            },
            {
                path: "/detail/:code", //yaha arko param 'title' pni rakhda save hudaina refresh garda but 'code' matrai rakhda hunxa
                name: "Detail",
                component: Detail
            },
            {
                path: "404",
                name: "Not Found",
                component: NotFound
            },
           
        ],
    },
    { path: "*", component: NotFound }
];
const userRoutes = [];
const router = new VueRouter({routes, userRoutes}); //global token check for authorization [mode: 'history',]add this to remo hashtag mode
router.beforeEach((to, from, next) => {
    const token = localStorage.getItem("token") || null;
    window.axios.defaults.headers["Authorization"] = "Bearer " + token;
    next();
});
export default router;
