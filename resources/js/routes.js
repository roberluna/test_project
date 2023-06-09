import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)


export const routes = [

    {
        path: '/',
        name: 'home',
        component: require('./home/Users').default,
    },
    {
        path: '/user/create',
        name: 'user.create',
        component: require('./home/Create').default,
    },
    {
        path: '/user/edit/:id',
        name: 'user.edit',
        component: require('./home/Edit').default,
    }
    // {
    //     path: '*',
    //     component: require('./template/404').default
    // }
    
]


export default new Router({
    routes,
    mode: 'history',
})
