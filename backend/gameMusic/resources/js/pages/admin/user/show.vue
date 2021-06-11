<template>
  <div class="container">

   <!-- ローディング中 -->
    <div class="my-5" v-if="loading">
      <Loader />
    </div>


     <div class="profile" v-if="!loading">
          <div class="profile_title">
          <h2>{{ user.user.name }}さんのユーザー情報</h2>
      </div>

      <!-- 自己紹介 -->
      <div class="card mt-5">
        <div class="card-header">
          自己紹介文
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item" v-html="user.user.user_information.introduce" style="white-space: pre-wrap; word-wrap:break-word; line-height:1.7"></li>
        </ul>
      </div>

      <!-- 使用機材 -->
      <div class="card mt-2">
        <div class="card-header">
          使用機材
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item"  v-html="user.user.user_information.instrument" style="white-space: pre-wrap; word-wrap:break-word; line-height:1.7"></li>
        </ul>
      </div>

      <!-- 口座情報 -->
      <div class="mt-4">
        <h3>口座情報</h3>
        <div class="text-center"  v-if="!user.user.transfer_account">
          <p>このユーザーは口座登録していません。</p>
        </div>
        <table class="table" v-if="user.user.transfer_account">
          <tbody>
            <tr>
              <th scope="row">銀行名</th>
              <td>{{user.user.transfer_account.bank_name}}</td>
            </tr>
            <tr>
              <th scope="row">支店コード</th>
              <td>{{user.user.transfer_account.bank_code}}</td>
            </tr>
            <tr>
              <th scope="row">口座種別</th>
              <td>{{user.user.transfer_account.deposit_type}}</td>
            </tr>
            <tr>
              <th scope="row">口座番号</th>
              <td>{{user.user.transfer_account.account_number}}</td>
            </tr>
            <tr>
              <th scope="row">口座名義</th>
              <td>{{user.user.transfer_account.account_holder}}</td>
            </tr>
          </tbody>
        </table>
      </div>


    </div>


  </div>

</template>

<script>
export default {
  data() {
    return {
      user: {},
      loading: false
    }
  },
  methods: {
    async getUserData() {
       this.isLogined = false
      try{
        this.loading = true
        await this.$store.dispatch('user/getUserShow', this.$route.params.id)
        this.user = this.$store.state.user.user

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
      this.getUserData(),
    ])
  },


}
</script>

<style scoped>


.cancel{
  color: white;
  font-weight: bold;
  padding: 12px 30px;
  border-radius: 20px;
  background: #4DB7FE;
}

</style>


