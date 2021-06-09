<template>
<div class="mypage">
  <div class="container">

    <div class="d-flex justify-content-end select_btn">
      <button type="button" class="btn btn-secondary btn-lg mr-3 text-white" :class="classColorSetUser" @click="userClassActive()"><i class="fas fa-shopping-cart mr-2"></i>購入者メニュー</button>
      <button type="button" class="btn btn-secondary btn-lg text-white" :class="classColorSetArtist" @click="artistClassActive()"><i class="fas fa-music mr-2"></i>出品者メニュー</button>
    </div>
    

    <router-view></router-view>

  </div>
</div>
</template>

<script>

export default {
  components: {
  },
  data() {
    return {
      userClass: false,
      createrClass: false,

    }
  },
  methods: {

    // タブ切り替えのためのメソッド
    userClassActive() {
      // 初期化
      this.userClass = false
      this.createrClass = false

      this.userClass = true
      this.$router.push({ name: 'purchase-history' })
    },
    artistClassActive() {
      // 初期化
      this.userClass = false
      this.createrClass = false

      this.createrClass = true
      this.$router.push({ name: 'exhibited-audios' })
    },

  },
  computed: {
    // タブ切り替えのためのcomputed
    classColorSetUser() {
      return {
        user: this.userClass
      }
    },
    classColorSetArtist() {
      return {
        creater: this.createrClass
      }
    },
  },

  created() {
    if(this.$route.name == 'exhibited-audios' || this.$route.name == 'transfer-account-setting' || this.$route.name == 'audio-create' || this.$route.name == 'audio-edit' || this.$route.name == 'sales' || this.$route.name == 'payout')
    {
      this.createrClass = true
    }
    if(this.$route.name == 'profile' || this.$route.name == 'purchase-history' || this.$route.name == 'favorite-audios' || this.$route.name == 'follows' || this.$route.name == 'profile-setting' || this.$route.name == 'buyer_setteing')
    {
      this.userClass = true
    }
    if(this.$route.name == 'profile-edit')
    {
      this.createrClass = false
      this.userClass = false
    }

  },


}
</script>

<style scoped>
.mypage {
  height: auto;
  background: #F6F6F4;
}

.select_btn .user {
  background: #58BDF0;
}
.select_btn .creater {
  background: #58BDF0;
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