import { createRouter, createWebHistory} from "vue-router";

import NewsIndex from '../components/news/NewsIndex.vue'

const routes = [
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
