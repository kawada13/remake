<template>
  <div class="artist_mypage">
    <div class="container">
      <div class="row my-3">

        <!-- (左側) -->
        <div class="col-sm-3 col-xs-12">

          <!-- アイコン -->
          <div class="artist_image d-flex justify-content-center mb-3">
            <img src="/images/default_img.png" class="rounded-circle" @click="$router.push({ name: 'profile-setting'})">
          </div>

          <!-- ユーザー名 -->
          <!-- v-ifをつけたのはレンダリングする順番によって読み込みエラーが出てしまうから -->
          <h3 v-if="userInformation.user">{{ userInformation.user.name }}</h3>

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
      userInformation: {}
    }
  },
  methods: {
    async getUserData() {
      await this.$store.dispatch('auth/getUserInformation')

      // api通信でとってきたデータを代入
      this.userInformation = this.$store.state.auth.user
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
.artist_mypage {
  height: auto;
  background: #F6F6F4;
}
.artist_image img {
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