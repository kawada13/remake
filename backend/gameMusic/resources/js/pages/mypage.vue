<template>
<div class="mypage">
  <div class="container">

    <div class="d-flex justify-content-end select_btn">
      <button type="button" class="btn btn-secondary btn-lg mr-3 text-white" :class="classColorSetUser" @click="userClassActive()"><i class="fas fa-shopping-cart mr-2"></i>購入者メニュー</button>
      <button type="button" class="btn btn-secondary btn-lg text-white" :class="classColorSetArtist" @click="artistClassActive()"><i class="fas fa-music mr-2"></i>出品者メニュー</button>
    </div>

    <!-- <div v-if="userClass">
      <user-page />
    </div>
    <div v-if="createrClass">
      <creater-page />
    </div> -->
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

      isUser:false,
      isCreater:false
    }
  },
  methods: {

    // タブ切り替えのためのメソッド
    userClassActive() {
      // 初期化
      this.userClass = false
      this.createrClass = false

      this.userClass = true
      this.isUser=true,
      this.$router.push({ name: 'purchase-history' })
    },
    artistClassActive() {
      // 初期化
      this.userClass = false
      this.artistClass = false

      this.createrClass = true
      this.isCreater = true

      this.$router.push({ name: 'exhibited-products' })
    },

  },
  computed: {
    // タブ切り替えのためのcomputed
    classColorSetUser() {
      if(this.$route.name == 'purchase-history') {
        console.log(1);
        this.isUser=true
        return {
          user: this.userClass
        }
      }
    },
    classColorSetArtist() {
      if(this.$route.name == 'exhibited-products') {
        console.log(2);
        this.isCreater = true
      }
      return {
        user: this.createrClass
      }
    },
  },

  created() {
    // console.log(this.$route.name);
    // if(this.$route.name == 'purchase-history') {
    //   console.log(1);
    //   this.isUser=true
    // }
    // if(this.$route.name == 'exhibited-products') {
    //   console.log(2);
    //   this.isCreater = true
    // }

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