import Vue from 'vue'
import router from './router'

import App from './components/App'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap/dist/js/bootstrap.js'


const app = new Vue({
  el: '#app',
  components: { App },
  router,
});
