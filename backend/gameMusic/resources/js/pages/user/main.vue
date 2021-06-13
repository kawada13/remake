<template>
  <div class="container">
      <div class="row my-3">

        <!-- 左側 -->
        <div class="col-sm-3 col-xs-12 left_side_bar mb-5" v-if="!loading">

          <!-- アイコン(登録されてなければデフォルト画像) -->
            <div class="creater_image mb-3" v-if="user.user.user_information.profile_image">
              <img :src="user.user.user_information.profile_image" class="rounded-circle">
            </div>
            <div class="creater_image mb-3" >
              <img src="/images/default_img.png" class="rounded-circle">
            </div>

          <h3>{{user.user.name}}</h3>
          <a class="btn btn-outline-primary mt-2" v-if="isLogined && !isFollowed && !isMine && !isAdmin" @click="follow()">このクリエイターをフォロー</a>
          <a class="btn btn-outline-danger mt-2" v-if="isLogined && isFollowed && !isMine && !isAdmin" @click="unfollow()">フォロー解除</a>
        </div>



        <!-- 右側 -->
        <div class="col-sm-9 col-xs-12 right">
          <router-view />
        </div>

      </div>
    </div>
</template>

<script>
export default {
  data() {
    return {
      loading: false,
      user: {},
      isLogined: false, //現在このページを見ているユーザーがログインしているかどうか
      isFollowed: false, //このページを見ているログインユーザーが既にこのユーザーををフォロー済かどうか
      isMine: false //このページがログインユーザー自身のページかどうか
    }
  },
  computed: {
    isAdmin() {
      if(localStorage.getItem("admin")) {
        return true
      } else {
        return false
      }
    },
  },
  methods: {
    async follow() {
      try{
        await this.$store.dispatch('follow/store', this.$route.params.id)
      }
      catch(e){
        // console.log(e);
      }
      finally{
        this.getIsFollow()
      }
    },
    async unfollow() {
      try{
        await this.$store.dispatch('follow/delete', this.$route.params.id)
      }
      catch(e){
        // console.log(e);
      }
      finally{
        this.getIsFollow()
      }
    },
    async getUserShowData() {//ユーザーデータとってくるついでに「ログインすみかどうか」「このページがログインユーザー自身のページかどうか」もとってくる
      try{
        this.loading = true
        await this.$store.dispatch('user/getUserShow', this.$route.params.id)
        this.user = this.$store.state.user.user

        // 今時点でログインしているかどうかを確認
        if(!this.user.authId) {
          this.isLogined = false
        } else {
          this.isLogined = true
        }
      }
      catch(e){
        // console.log(e);
        this.loading = false
      }
      finally{
        this.loading = false
        // まず初期化
        this.isMine = false
        // このページがログインユーザー自身のページかどうかチェック⇨ログインユーザーのページだったらフォローボタンを消す
        if(this.user.user.id !== this.user.authId) {
            this.isMine = false
            return
        }
            this.isMine = true
        }
      },
      async getIsFollow() { //フォロー済かどうかを同時に判断する
      // まず初期化
      this.isFollowed = false
      // フォロー済かどうかを確認しに行く
      try{
       await this.$store.dispatch('follow/isFollow', this.$route.params.id)
      }
      catch(e){
        // console.log(e);
      }
      finally{
        // フォローすみかどうかの結果を代入
        this.isFollowed = this.$store.state.follow.isFollow
      }
    },
  },
  created() {
    Promise.all([
      this.getUserShowData(),
      this.getIsFollow(),
    ])
  },



}
</script>

<style scoped>
.creater_image img {
  height: 144px;
}

.left_side_bar {
  text-align: center;
}



</style>