import { createRouter, createWebHistory } from 'vue-router';

import HomePage from '../components/HomePage.vue';
import ProductsPage from '../components/ProductsPage.vue';

const routes = [
    {
        path: '/',
        component: HomePage
    },
    {
        path: '/products/:categorySlug?',
        component: ProductsPage
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
});
  
export default router;