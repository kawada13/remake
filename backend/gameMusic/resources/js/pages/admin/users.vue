<template>
  <div class="container">
     <!-- ローディング中 -->
    <div class="my-5" v-if="loading">
      <Loader />
    </div>


    <div class="card mt-2" v-if="!loading">
        <h3 class="card-header">
          登録ユーザー
        </h3>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">ユーザー名</th>
              <th scope="col">登録日時</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td>Mark</td>
              <td>Otto</td>
            </tr>
            <tr>
              <th scope="row">2</th>
              <td>Jacob</td>
              <td>Thornton</td>
            </tr>
            <tr>
              <th scope="row">3</th>
              <td>Larry</td>
              <td>the Bird</td>
            </tr>
          </tbody>
        </table>
    </div>



  </div>
</template>

<script>
export default {
  data() {
    return {
      loading:false,
      users: []
    }
  },
  methods: {
    async getUsersData() {
       this.isLogined = false
      try{
        this.loading = true
        await this.$store.dispatch('user/getUsers')
        this.users = this.$store.state.user.users

      }
      catch(e){
        // console.log(e);
        this.loading = false
      }
      finally{
        this.loading = false
      }
    },
  },
  created() {
    Promise.all([
      this.getUsersData(),
    ])
  },

}
</script>

<style>

</style>