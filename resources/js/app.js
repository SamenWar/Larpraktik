
require('./bootstrap');
import Vue from "vue";
import VueRouter from "vue-router"


    //Vue.component('app', require('./components/App').default);

    Vue.use(VueRouter)
    Vue.use(Vuelidate)

    import Home from './components/Home'
    import App from "./components/App"
    import About from './components/About'
    import Desks from "./components/desks/Desks";
    import ShowDesk from "./components/desks/ShowDesk";
import {Vuelidate} from "vuelidate";

    const router = new VueRouter({
    mode: 'history',
    routes: [{
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/About',
            name: 'About',
            component: About
        },
        {
            path: '/Desks',
            name: 'Desks',
            component: Desks
        },
        {
            path: '/show/:deskId',
            name: 'ShowDesk',
            component: ShowDesk,
            props: true
        }

        ]
    })

const app = new Vue({
    el: '#app',
    components: {App},
    router

})
