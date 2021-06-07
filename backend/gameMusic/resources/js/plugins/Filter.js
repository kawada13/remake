import moment from 'moment';

export default {
  install(vue){
    console.log('Installing Filters plugin..')
    vue.mixin({

      filters: {
        comma (val) {
          // console.log(val);
          return `${val.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")}`
        },
        fromiso (val) {
          // console.log(val);
          return moment(val).format('YYYY/MM/DD')
        },
      }
    })
  }
}