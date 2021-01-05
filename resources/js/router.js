import Vue from "vue";
import VueRouter from "vue-router";
Vue.use(VueRouter);

//ADMIN
import AdminLogin from './components/AdminComponents/AdminLogin';

import Main from "./components/Index";
import Home from "./components/Home/Home";
import Category from "./components/List/Home";
import Detail from "./components/Details/Home";
import Cart from "./components/Account/CartView";

const routes = [
    {
        path: "/admin",
        redirect: "/adminLogin"
    },
    {
        path: "/adminLogin",
        name:"AdminLogin",
        component:AdminLogin
    },
    // {
    //     path: "/admin",
    //     component: AdminHome,
    //     children: [
    //         {
    //             path: "dashboard",
    //             name: "AdminDashboard",
    //             component: Dashboard
    //         },

    //     ],
    //     beforeEnter: (to, from, next) => {
    //         //AUTHORIZATION FOR A SINGLE ROUTE
    //         axios
    //             .get("api/verify")
    //             .then(res => {
    //                 if (res.data.role_id == 1) {
    //                     next();
    //                 } else {
    //                     next("/administration");
    //                 }
    //             })
    //             .catch(err => next("/administration"));
    //     }
    // },
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
                path: "/category_name",
                name: "Category",
                component: Category
            },
            {
                path: "/category_name/product_name",
                name: "Detail",
                component: Detail
            },
            {
                path: "/cart",
                name: "Cart",
                component: Cart
            }
        ]
    }
];
const userRoutes = [];
const router = new VueRouter({ routes, userRoutes }); //global token check for authorization
router.beforeEach((to, from, next) => {
    const token = localStorage.getItem("token") || null;
    window.axios.defaults.headers["Authorization"] = "Bearer " + token;
    next();
});
export default router;
