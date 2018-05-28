import can from './can.js'
import focus from './focus.js'
import scrollable from './scrollable.js'
import title from './title.js'

export default {
  install (Vue) {
    Vue.directive(can.name, can)
    Vue.directive(focus.name, focus)
    Vue.directive(scrollable.name, scrollable)
    Vue.directive(title.name, title)
  }
}
