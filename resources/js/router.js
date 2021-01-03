import Vue from "vue";
import VueRouter from "vue-router";
Vue.use(VueRouter);

import Main from './components/Index';
import Home from './components/Home/Home';

const routes = [
    {
        path: "/",
        component: Main,
        children:[
            {
                path:'',
                name:'Home',
                component:Home
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
