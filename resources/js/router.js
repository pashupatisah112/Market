import Vue from "vue";
import VueRouter from "vue-router";
Vue.use(VueRouter);

import Main from './components/Index';
import Home from './components/Home/Home';
import Category from './components/List/Home';

const routes = [
    {
        path: "/",
        component: Main,
        children:[
            {
                path:'',
                name:'Home',
                component:Home
            },
            {
                path:'/category_name',
                name:'Category',
                component:Category
            }
        ]
    },
];
const userRoutes = [];
const router = new VueRouter({ routes, userRoutes }); //global token check for authorization
router.beforeEach((to, from, next) => {
    const token = localStorage.getItem("token") || null;
    window.axios.defaults.headers["Authorization"] = "Bearer " + token;
    next();
});
export default router;
