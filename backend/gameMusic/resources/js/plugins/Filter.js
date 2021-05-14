export default {
  install(vue){
    console.log('Installing Filters plugin..')
    vue.mixin({

      filters: {
        comma (val) {
          return `${val.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")}`
        },
      }
    })
  }
}