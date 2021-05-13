<template>
<div class="mypage">
  <div class="container">

    <div class="d-flex justify-content-end select_btn">
      <button type="button" class="btn btn-secondary btn-lg mr-3 text-white" :class="classColorSetUser" @click="userClassActive()"><i class="fas fa-shopping-cart mr-2"></i>購入者メニュー</button>
      <button type="button" class="btn btn-secondary btn-lg text-white" :class="classColorSetArtist" @click="artistClassActive()"><i class="fas fa-music mr-2"></i>出品者メニュー</button>
    </div>

    <div v-if="userClass">
      <user-page />
    </div>
    <div v-if="artistClass">
      <artist-page />
    </div>

  </div>
</div>
</template>

<script>
import ArtistPage from '../components/mypage/ArtistPage'
import UserPage from '../components/mypage/UserPage'

export default {
  components: {
    ArtistPage,
    UserPage
  },
  data() {
    return {
      userClass: true,
      artistClass: false
    }
  },
  methods: {

    // タブ切り替えのためのメソッド
    userClassActive() {
      // 初期化
      this.userClass = false
      this.artistClass = false

      this.userClass = true
    },
    artistClassActive() {
      // 初期化
      this.userClass = false
      this.artistClass = false

      this.artistClass = true
    },

  },
  computed: {
    // タブ切り替えのためのcomputed
    classColorSetUser() {
      return {
        user:this.userClass,
      }
    },
    classColorSetArtist() {
      return {
        artist:this.artistClass,
      }
    },
  },

}
</script>

<style scoped>
.mypage {
  height: auto;
  background: #F6F6F4;
}


.select_btn {
  font-size: 13px;
}

.select_btn .user {
  background: #58BDF0;
}
.select_btn .artist {
  background: #FF6E3B;
}

@media screen and (max-width:767px) {
    /*画面サイズが767px以下の場合読み込む（スマホ）*/

    .select_btn button {
      font-size: 13px;
    }

}
@media screen and (min-width:768px){
    /*画面サイズが768px以上の場合読み込む（PC）*/


    .select_btn button {
      font-size: 18px;
    }

}

</style>