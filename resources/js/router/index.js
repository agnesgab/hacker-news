import { createRouter, createWebHistory} from "vue-router";

import NewsIndex from '../components/news/NewsIndex.vue'
import Home from '../components/Home.vue'

const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/news',
        name: 'news.index',
        component: NewsIndex
    }
]

export default createRouter({
    history: createWebHistory(),
    routes
})
