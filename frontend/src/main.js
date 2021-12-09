import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios'
import VueAxios from 'vue-axios'
import vuetify from './plugins/vuetify'
import VueSwal from 'vue-swal'
import "vuetify/dist/vuetify.min.css";


Vue.use(VueAxios, axios)
Vue.config.productionTip = false
Vue.use(VueSwal)

new Vue({
  router,
  store,
  vuetify,
  render: h => h(App)
}).$mount('#app')