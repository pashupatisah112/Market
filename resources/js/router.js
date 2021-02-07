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
import Sales from "./components/AdminComponents/SalesComponent/Sales";
import Comment from "./components/AdminComponents/CommentComponent/Comment";

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

import Test from './components/Home/Test';

const routes = [
    // {
    //     path: "/admin",
    //     redirect: "/adminLogin"
    // },
    {
        path: "/adminLogin",
        name: "AdminLogin",
        component: AdminLogin
    },

    {
        path: "/admin",
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
                path: "sales",
                name: "Sales",
                component: Sales
            },
            {
                path: "comments",
                name: "Comments",
                component: Comment
            }
        ],
        // beforeEnter: (to, from, next) => {
        //     axios
        //         .get("api/verify",{

        //         })
        //         .then(res => {
        //             console.log('login data:',res.data)
        //             // if (res.data.role_id == 1) {
        //             //     next()
        //             // } else {
        //             //     next("/adminLogin");
        //             // }
        //         })
        //         .catch(err => next("/adminLogin"));
        // }
        
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
                path: ":category/:subCategory",
                name: "Category",
                component: Category
            },
            {
                path: "/:code", //yaha arko param 'title' pni rakhda save hudaina refresh garda but 'code' matrai rakhda hunxa
                name: "Detail",
                component: Detail
            },
            {
                path: "/top-sellers",
                name: "TopSeller",
                component: TopSeller
            },
            {
                path: "/collections",
                name: "Collection",
                component: Collection
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
            }
        ]
    }
];
const userRoutes = [];
const router = new VueRouter({routes, userRoutes}); //global token check for authorization [mode: 'history',]add this to remo hashtag mode
router.beforeEach((to, from, next) => {
    const token = localStorage.getItem("token") || null;
    window.axios.defaults.headers["Authorization"] = "Bearer " + token;
    next();
});
export default router;
