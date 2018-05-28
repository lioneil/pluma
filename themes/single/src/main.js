// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import '@/assets/stylus/main.styl'
import axios from 'axios'
import directives from './directives'
import filters from './filters'
import helpers from './helpers'
import mixins from './mixins'
import components from './components'
import router from './router'
import store from './store'
import VeeValidate from 'vee-validate'
import Vue from 'vue'
import Vuetify from 'vuetify'

/**
 *------------------------------------------------------------------------------
 * Use Block
 *------------------------------------------------------------------------------
 * Vue.use statements
 *
 */
Vue.use(Vuetify, {
  theme: {
    primary: '#107bd0',
    secondary: '#d982a6', // '#ea4763',
    accent: '#fbde3c',
    success: '#81c106',
    warning: '#ff8017',
    error: '#ad2c1a',
    info: '#2196f3'
  }
})
Vue.use(directives)
Vue.use(filters)
Vue.use(components)
Vue.use(helpers)
Vue.use(mixins)
Vue.use(VeeValidate)

/**
 *------------------------------------------------------------------------------
 * Components Block
 *------------------------------------------------------------------------------
 * Here we define additional global components to be used throughout the app.
 * We require theme dynamically to avoid loading unused components.
 *
 */
// Vue.component('alert-icon', () => import('./components/partials/AlertIcon.vue'))
// Vue.component('breadcrumbs', () => import('./components/partials/Breadcrumbs.vue'))
// Vue.component('sidebar', () => import('./components/partials/Sidebar.vue'))
// Vue.component('image-overlay', () => import('./components/components/ImageOverlay.vue'))
// Vue.component('login-card', () => import('./components/Auth/LoginCard.vue'))

/**
 *------------------------------------------------------------------------------
 * Miscellaneous Configurations Block
 *------------------------------------------------------------------------------
 *
 */
// Axios
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.defaults.baseURL = (process.env.NODE_ENV !== 'production') ? 'http://pluma' : ''

// Vue Prototypes
Vue.config.productionTip = false
Vue.prototype.$http = axios
Vue.prototype.$token = axios.defaults.headers.common['X-CSRF-TOKEN']

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  http: {
    headers: {
      'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
  },
  data () {
    return {
      user: null,
      navigations: {
        sidebar: []
      },
      router: []
    }
  },
  methods: {
    mountUser () {
      this.user = (window.Pluma && window.Pluma.user) || {
        isRoot: false,
        permissions: []
      }
    },
    // routed () {
    //   let self = this
    //   this.$http.get('/api/v1/misc/routes')
    //     .then(response => {
    //       for (var i = 0; i < response.data.length; i++) {
    //         let current = response.data[i]
    //         self.routes.push({
    //           title: this.$root.trans(current.title),
    //           name: current.name,
    //           path: current.uri.replace(/{/g, ':').replace(/}/g, ''),
    //           meta: {
    //             title: current.title,
    //             description: current.description
    //           },
    //           component: () => import('./modules/' + current.component.replace(/\.vue/g, '') + '.vue'),
    //           beforeEnter: (to, from, next) => {
    //             if (to.path !== '/403' && (self.user.isRoot || self.user.permissions.indexOf(to.name) >= 0)) {
    //               next()
    //             } else {
    //               // self.alert({type: 'error', text: `Permission denied`})
    //               // window.location.href = '/403'
    //               next('/403')
    //             }
    //           }
    //         })
    //       }
    //       self.$router
    //         .addRoutes(self.routes)

    //       self.$router
    //         .beforeEach((to, from, next) => {
    //           document.title = to.meta.title
    //           next()
    //         })
    //     })
    //     .catch(error => {
    //       this.$root.alert({type: 'error', text: `Aw, Snap! Error fetching routes! It's severe! ${error.response}`})
    //     })
    // },
    navigation () {
      let self = this
      // Populate the routes variable
      this.$http.get('/api/v1/misc/navigations/sidebar')
        .then(response => {
          let sidebar = []

          for (let menu in response.data) {
            sidebar.push(response.data[menu])
          }

          sidebar = sidebar.sort(function (a, b) {
            return a.order - b.order
          })

          self.navigations.sidebar = sidebar
        })
        .catch(error => {
          // console.log('[ERROR]', error)
          this.$root.alert({type: 'error', text: `Aw, Snap! Error fetching routes! It's severe! ${error.response}`})
        })
    }
  },
  watch: {
    '$router': function ($router) {
      this.router = $router.options.routes
      console.log(this.router)
    }
  },
  mounted () {
    this.mountUser()
    this.navigation()
    // this.routed()
    const requireRoute = require.context(
      // The relative path of the routes folder
      '@/modules',
      // Whether or not to look in subfolders
      true,
      // The regular expression used to match base route filenames
      /router\/index\.js$/
    )

    requireRoute.keys().forEach(route => {
      console.log('main.js::mounted()|line-179', route)
      const routeConfig = requireRoute(route)
      this.$router.addRoutes(routeConfig.default || routeConfig)
    })
    console.log('main.js::mounted()|line-168', this.router)
  }
})
