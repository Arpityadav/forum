
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue');
require('./bootstrap');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('flash', require('./components/Flash.vue').default);
Vue.component('avatar-form', require('./components/AvatarForm.vue').default);
Vue.component('user-notifications', require('./components/UserNotifications.vue').default);
Vue.component('thread-view', require('./pages/Thread.vue').default);
Vue.component('paginator', require('./components/Paginator.vue').default);
Vue.component('wysiwyg', require('./components/Wysiwyg.vue').default);

const app = new Vue({
    el: '#app'
});
