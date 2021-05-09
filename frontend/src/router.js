import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

const routes = [
    {path: '/main', component: () => import('./components/pages/test')},
    {path: '/', component: () => import('./components/pages/characters/index')},
    {path: '/characters', component: () => import('./components/pages/characters/index')},
    {path: '/characters/add', component: () => import('./components/pages/characters/add')},
    {path: '/characters/:id_character', component: () => import('./components/pages/characters/view')},
    {path: '/characters/:id_character/edit', component: () => import('./components/pages/characters/edit')},
    {path: '/classes', component: () => import('./components/pages/classes/index')},
    {path: '/elements', component: () => import('./components/pages/elements/index')},
    {path: '/races', component: () => import('./components/pages/races/index')},
    {path: '/site/registration', component: () => import('./components/pages/registration')},
];

export default new VueRouter({
    mode: "history",
    routes
});
