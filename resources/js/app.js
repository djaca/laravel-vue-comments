/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import moment from 'moment'

require('./bootstrap')

window.Vue = require('vue')

Vue.prototype.$signedIn = window.App.signedIn
Vue.prototype.$humanTime = timestamp => moment(timestamp).fromNow();

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('comments', require('./components/Comments.vue'))

const app = new Vue({
  el: '#app'
})
