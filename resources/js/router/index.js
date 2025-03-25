import {createRouter, createWebHistory} from 'vue-router'
import Category from "../views/Category.vue";
import Products from "../views/Products.vue";


const routes = [
    { path: '/Category', name:'Category', component: Category },
    { path: '/products', name:'Products', component: Products },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
});
export default router;
