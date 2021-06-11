<template>

<div>

  <div v-if="!loading && !audio.id" class="container my-5">
    <p class="font-weight-bold h2 text-center">このオーディオはクリエイターにより削除されました。</p>
    <p class="text-center mt-4">
      <button type="button" class="btn btn-primary my-4 cancel" @click="$router.replace({ name: 'profile' })">マイページへ戻る</button>
    </p>
  </div>


  <!-- ローディング中 -->
  <div class="my-5" v-if="loading">
    <Loader />
  </div>


  <div class="audio-show" v-if="!loading && audio.id">
    <div class="container">
      <div class="row my-3">

        <!-- 左側 -->
        <div class="col-sm-8 col-xs-12">

       <!-- 左上 -->
        <div class="audio_head">
          <h1>{{ audio.title }}</h1>
           <audio controls controlslist="nodownload" class="my-3">
            <source :src="audio.sample_audio_file">
           </audio>
            <p>
              <button type="button" class="btn btn-outline-primary" v-if="isLogined && !isFavoriteData && !isAdmin" @click="favorite">この曲をお気に入りに登録</button>
              <button type="button" class="btn btn-outline-danger  unfavorite" v-if="isLogined && isFavoriteData && !isAdmin" @click="unfavorite">お気に入り解除</button>
            </p>
        </div>

         <!-- 左下 -->
          <div class="card mt-3">
            <div class="card-body detail type_title d-flex titles justify-content-start">
              <p class="">サウンドの種類</p>
            </div>
            <div class="card-body detail type_content buttons row">
              <span class="mr-2 mb-2 border border-info p-2">{{audio.sound.name}}</span>
            </div>

            <div class="card-body detail understanding_title d-flex justify-content-start">
              <p class="">イメージ</p>
            </div>
            <div class="card-body detail type_content buttons row">
              <span class="mr-2 mb-2 border border-info p-2" v-for="(understanding, i) in audio.understandings" :key="i">{{understanding.name}}</span>
            </div>

            <div class="card-body detail instrument_title d-flex justify-content-start">
              <p class="">用途(シーン)</p>
            </div>
            <div class="card-body detail type_content buttons row">
              <span class="mr-2 mb-2 border border-info p-2" v-for="(use, i) in audio.uses" :key="i">{{use.name}}</span>
            </div>

            <div class="card-body detail instrument_title d-flex justify-content-start">
              <p class="">使用楽器</p>
            </div>
            <div class="card-body detail type_content buttons row">
              <span class="mr-2 mb-2 border border-info p-2" v-for="(instrument, i) in audio.instruments" :key="i">{{instrument.name}}</span>
            </div>
          </div>
        </div>



        <!-- 右側 -->
        <div class="col-sm-4 col-xs-12 right">

          <!-- 右上 -->
          <div class="right_top">
            <p class="purchase_title">購入：</p>
            <div class="card">
              <ul class="list-group list-group-flush">
                <li class="list-group-item price py-4"><i class="fas fa-yen-sign"></i>{{ audio.price | comma }}</li>
                <li class="list-group-item purchase_btn" v-if="!isMine && !isPurchase && isLogined && !isAdmin"><button type="button" class="btn btn-warning py-3 px-5" data-toggle="modal" data-target="#exampleModal">購入する<i class="fas fa-chevron-right pl-2"></i></button></li>
                <li class="list-group-item purchase_btn purchased" v-if="!isMine && isPurchase && !isAdmin"><button class="btn btn-warning py-3 px-5">購入済</button></li>
              </ul>
            </div>
          </div>


          <!-- 右下 -->
          <div class="right_down mt-5">
            <p class="purchase_title">クリエイター：</p>
            <div class="card">
              <div class="card-header">

                <p @click="$router.push({ name: 'user-show' })">{{audio.user.name}}</p>


                <!-- アイコン(登録されてなければデフォルト画像) -->
                <div class="user_image d-flex justify-content-center mb-3" v-if="audio.userInformation.profile_image">
                  <img :src="audio.userInformation.profile_image" class="rounded-circle">
                </div>
                <div class="user_image d-flex justify-content-center mb-3" v-else>
                  <img src="/images/default_img.png" class="rounded-circle">
                </div>


              </div>
              <div class="card-body pt-5">
                <h5 class="card-title">紹介文</h5>
                <p class="card-text">{{audio.userInformation.introduce}}</p>
                <a class="btn btn-outline-primary" @click="follow(audio.user_id)" v-if="isLogined && !isFollowed && !isMine && !isAdmin">このクリエイターをフォロー</a>
                <a class="btn btn-outline-danger" @click="unfollow(audio.user_id)" v-if="isLogined && isFollowed && !isMine && !isAdmin">フォロー解除</a>
              </div>
            </div>
          </div>

        </div>


        <!-- 購入Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">{{ audio.title }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>合計：<i class="fas fa-yen-sign"></i>{{ audio.price | comma }}</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary text-white" data-dismiss="modal">キャンセル</button>
                <button type="button" class="btn btn-primary text-white" @click="$router.push({ name: 'audio-payment', params: { id: `${audio.id}` }})" data-dismiss="modal">購入申請する</button>
              </div>
            </div>
          </div>
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
      audio: {},
      loading: false,
      isFavoriteData: false, //このページを見ているログインユーザーが既にこのオーディオをお気に入り済かどうか
      isLogined: false, //現在このページを見ているユーザーがログインしているかどうか
      isFollowed: false, //このページを見ているログインユーザーが既にこのユーザーををフォロー済かどうか
      isMine: false, //このページがログインユーザー自身のページかどうか
      isPurchase: false //この商品をログインユーザーが購入済かどうか
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
    async follow(userId) {
      try{
        await this.$store.dispatch('follow/store', userId)
      }
      catch(e){
        // console.log(e);
      }
      finally{
        this.getAudioShowData()
      }
    },
    async unfollow(userId) {
      try{
        await this.$store.dispatch('follow/delete', userId)
      }
      catch(e){
        // console.log(e);
      }
      finally{
        this.getAudioShowData()
      }
    },
    async favorite() {
      try{
        await this.$store.dispatch('favorite/store', this.$route.params.id)
      }
      catch(e){
        // console.log(e);
      }
      finally{
        this.getIsFavorite()
      }
    },
    async unfavorite() {
      try{
        await this.$store.dispatch('favorite/delete', this.$route.params.id)
      }
      catch(e){
        // console.log(e);
      }
      finally{
        this.getIsFavorite()
      }
    },
    async getIsFavorite() { //お気に入り済かどうかを同時に判断する
      // まず初期化
      this.isFavoriteData = false
      // お気に入り済かどうかを確認しに行く
      try{
        await this.$store.dispatch('favorite/isFavorite', this.$route.params.id)
      }
      catch(e){
        // console.log(e);
      }
      finally{
        // お気に入りすみかどうかの結果を代入
        this.isFavoriteData = this.$store.state.favorite.isFavorite
      }
    },
    async getAudioShowData() {//オーディオデータとってくるついでに「ログインすみかどうか」、「フォロー済かどうか」、「このページがログインユーザー自身のページかどうか」もとってくる
      this.isLogined = false
      try{
        this.loading = true
        await this.$store.dispatch('audio/getAudioShow', this.$route.params.id)
        this.audio = this.$store.state.audio.audio

        // 今時点でログインしているかどうかを確認
        if(!this.audio.authId) {
        this.isLogined = false
        } else {
          this.isLogined = true
        }

        //フォロー済かどうかを同時に判断する
        // まず初期化
        this.isFollowed = false
        await this.$store.dispatch('follow/isFollow', this.audio.user_id)
        // フォローすみかどうかの結果を代入
        this.isFollowed = this.$store.state.follow.isFollow

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
        if(this.audio.user_id !== this.audio.authId) {
            this.isMine = false
            return
        }
            this.isMine = true
        }
    },
    async getIspurchase() { //購入すみかどうかをチェック

      try{
        // this.loading = true
        await this.$store.dispatch('purchase/getIspurchase', this.$route.params.id)
        this.isPurchase = this.$store.state.purchase.isPurchase

      }
      catch(e){
        console.log(e);
        // this.loading = false
      }
      finally{
        // this.loading = false
      }

    },
  },
  created() {
    Promise.all([
      this.getAudioShowData(),
      this.getIsFavorite(),
      this.getIspurchase(),
    ])
  },

}
</script>

<style scoped>
.modal-body p {
  margin-bottom: 0;
  font-size: 23px;
  color: hsla(357, 100%, 37%, 0.979);
  font-weight: bold;
}
.modal-title {
  font-weight: bold;
}
.new-audio {
  height: auto;
  background: #F6F6F4;
}

.audio_head button {
  color: #4DB7FE;
}
.audio_head button:hover {
  color: white;
}
.card {
  text-align: center;
}
.card .card-header p:hover{
  cursor: pointer;
  text-decoration: underline;
}
.card .price{
  font-weight: 700;
  font-size: 36px;
  color: hsla(357, 100%, 37%, 0.979);
}
.card .purchase_btn button{
  background: #F2C963;
  font-weight: bold;
}

.right_top .purchase_title {
  font-weight: 600;
  font-size: 18px;
  color: #334e6f;
}
.right_down .purchase_title {
  font-weight: 600;
  font-size: 18px;
  color: #334e6f;
}
.right_down .card-header {
  height: 130px;
  background: #4DB7FE;
}
.right_down .card-header p{
  padding: 14px;
  font-weight: bold;
  color: white;
  font-size: 25px;
}
.right_down .card-header img{
  height: 70px;
  position: relative;
  z-index: 20;
}
.detail {
  padding-bottom: 10px;
}
.detail p {
  font-weight: 600;
  font-size: 18px;
  color: #334e6f;
}
.buttons{
  margin: 0;
  padding-top: 0;
  text-align: left;
}
.buttons p{
  font-weight: normal;
}
.titles {
  padding-bottom: 0;
}
.unfavorite {
  color: red!important;
}
.unfavorite:hover {
  color: white!important;
}
.purchased button{
  cursor: auto!important;
  background: gray!important;
  color: white!important;
}
.cancel{
  color: white;
  font-weight: bold;
  padding: 12px 30px;
  border-radius: 20px;
  background: #4DB7FE;
}

@media screen and (max-width:767px) {
    /*画面サイズが767px以下の場合読み込む（スマホ）*/

    .audio_head h1 {
      font-weight: bold;
      font-size: 30px
    }
}
@media screen and (min-width:768px){
    /*画面サイズが768px以上の場合読み込む（PC）*/

    .audio_head h1 {
      font-weight: bold;
    }
}
</style>