export default {
  install (Vue, options) {
    Vue.directive('title', {
      inserted: function (el) {
        el.setAttribute('title', el.innerText)
      }
    })
  }
}
