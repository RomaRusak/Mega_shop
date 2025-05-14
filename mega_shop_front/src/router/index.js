import { createRouter, createWebHistory } from 'vue-router';

import HomePage from '../components/HomePage.vue';
import ProductsPage from '../components/ProductsPage.vue';
import ProductPage from '../components/ProductPage.vue';

const routes = [
    {
        path: '/',
        name: 'home',
        component: HomePage
    },
    {
        path: '/products/:categorySlug?',
        name: 'products',
        component: ProductsPage
    },
    {
        path: '/products/:categorySlug?/:productSlug',
        name: 'product',
        component: ProductPage,
        beforeEnter: (to, _, next) => {
            const productSlugPattern = /^[a-zA-Z0-9-_]+-\d+$/;
            const productSlug = to.params.productSlug;

            if (productSlug && productSlugPattern.test(productSlug)) {
                next(); 
            } else {
                next(false);
            }
        }
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
});
  
export default router;