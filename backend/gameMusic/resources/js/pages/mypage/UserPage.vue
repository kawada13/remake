<template>
  <div class="container">

    <!-- ローディング中 -->
    <div class="mt-5" v-if="loading">
      <Loader />
    </div>


   <!-- ローディング終わったら表示 -->
    <div class="mypage" v-if="!loading">
        <div class="row my-3">

          <!-- (左側) -->
          <div class="col-sm-3 col-xs-12">

            <!-- アイコン(登録されてなければデフォルト画像) -->
            <div class="user_image d-flex justify-content-center mb-3" v-if="userInformation.user_information.profile_image">
              <img :src="userInformation.user_information.profile_image" class="rounded-circle" @click="$router.push({ name: 'profile-edit' })">
            </div>
            <div class="user_image d-flex justify-content-center mb-3" v-else>
              <img src="/images/default_img.png" class="rounded-circle" @click="$router.push({ name: 'profile-edit' })">
            </div>

            <!-- ユーザー名 -->
            <!-- v-ifをつけたのはレンダリングする順番によって読み込みエラーが出てしまうから -->
            <h3>{{ userInformation.user.name }}</h3>

            <!-- いろんな選択肢 -->
            <div class="card my-3">
              <ul class="list-group list-group-flush accout_setting">
                <li class="list-group-item" @click="$router.push({ name: 'profile' })">プロフィール</li>
                <li class="list-group-item" @click="$router.push({ name: 'profile-edit' })">プロフィール編集</li>
                <li class="list-group-item" @click="$router.push({ name: 'purchase-history'})">購入履歴</li>
                <li class="list-group-item" @click="$router.push({ name: 'favorite-audios'})">お気に入り作品一覧</li>
                <li class="list-group-item" @click="$router.push({ name: 'follows'})">フォローしているクリエイター</li>
                <li class="list-group-item" @click="$router.push({ name: 'profile-setting'})">ユーザー情報設定</li>
                <li class="list-group-item" @click="$router.push({ name: 'buyer_setteing'})">購入者情報設定</li>
              </ul>
            </div>
          </div>

          <!-- (右側) -->
          <div class="col-sm-9 col-xs-12">
            <div>
              <router-view />
            </div>
          </div>

        </div>
    </div>
    
  </div>
  
</template>

<script>
export default {
  data() {
    return {
      userInformation: {},
      loading: false
    }
  },
  methods: {
    async getUserData() {

      try{
        this.loading = true
        await this.$store.dispatch('auth/getUserInformation')

        // api通信でとってきたデータを代入
        this.userInformation = this.$store.state.auth.user
      }
      catch(e){
        console.log(e);
      }
      finally{
        this.loading = false
      }
    }
  },
  created() {
    Promise.all([
      this.getUserData(),
    ])
  },

}
</script>

<style scoped>
.mypage {
  height: auto;
  background: #F6F6F4;
}
.user_image img {
  height: 160px;
  cursor: pointer;
}

.accout_setting li:hover {
  cursor: pointer;
  color: #58BDF0;
}
h3 {
  text-align: center;
}
.border_s {
  text-align: center;
}




@media screen and (max-width:767px) {
    /*画面サイズが767px以下の場合読み込む（スマホ）*/


}
@media screen and (min-width:768px){
    /*画面サイズが768px以上の場合読み込む（PC）*/

}

</style>