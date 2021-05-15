<template>
  <div class="audio-show">
    <div class="container">
      <div class="row my-3">

        <!-- 左側 -->
        <div class="col-sm-8 col-xs-12">

       <!-- 左上 -->
        <div class="audio_head">
          <h1>{{ audio.title }}</h1>
           <audio controls controlslist="nodownload">
            <source :src="audio.sound">
           </audio>
        </div>

         <!-- 左下 -->
          <div class="card mt-3">
            <div class="card-body detail type_title d-flex titles justify-content-start">
              <p class="">種類：</p>
            </div>
            <div class="card-body detail type_content buttons">
              <button type="button" class="btn btn-outline-dark mr-2 mb-2">Dark</button>
              <button type="button" class="btn btn-outline-dark mr-2 mb-2">Dark</button>
              <button type="button" class="btn btn-outline-dark mr-2 mb-2">Dark</button>
              <button type="button" class="btn btn-outline-dark mr-2 mb-2">Dark</button>
              <button type="button" class="btn btn-outline-dark mr-2 mb-2">Dark</button>
              <button type="button" class="btn btn-outline-dark mr-2 mb-2">Dark</button>
              <button type="button" class="btn btn-outline-dark mr-2 mb-2">Dark</button>
              <button type="button" class="btn btn-outline-dark mr-2 mb-2">Dark</button>
            </div>

            <div class="card-body detail understanding_title d-flex justify-content-start">
              <p class="">イメージ：</p>
            </div>
            <div class="card-body detail type_content buttons">
              <button type="button" class="btn btn-outline-dark mr-2 mb-2">Dark</button>
              <button type="button" class="btn btn-outline-dark mr-2 mb-2">Dark</button>
              <button type="button" class="btn btn-outline-dark mr-2 mb-2">Dark</button>
              <button type="button" class="btn btn-outline-dark mr-2 mb-2">Dark</button>
              <button type="button" class="btn btn-outline-dark mr-2 mb-2">Dark</button>
              <button type="button" class="btn btn-outline-dark mr-2 mb-2">Dark</button>
              <button type="button" class="btn btn-outline-dark mr-2 mb-2">Dark</button>
              <button type="button" class="btn btn-outline-dark mr-2 mb-2">Dark</button>
            </div>

            <div class="card-body detail instrument_title d-flex justify-content-start">
              <p class="">楽器：</p>
            </div>
            <div class="card-body detail type_content buttons">
              <button type="button" class="btn btn-outline-dark mr-2 mb-2">Dark</button>
              <button type="button" class="btn btn-outline-dark mr-2 mb-2">Dark</button>
              <button type="button" class="btn btn-outline-dark mr-2 mb-2">Dark</button>
              <button type="button" class="btn btn-outline-dark mr-2 mb-2">Dark</button>
              <button type="button" class="btn btn-outline-dark mr-2 mb-2">Dark</button>
              <button type="button" class="btn btn-outline-dark mr-2 mb-2">Dark</button>
              <button type="button" class="btn btn-outline-dark mr-2 mb-2">Dark</button>
              <button type="button" class="btn btn-outline-dark mr-2 mb-2">Dark</button>
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
                <li class="list-group-item price py-4"><i class="fas fa-yen-sign"></i>{{ price | comma }}</li>
                <li class="list-group-item purchase_btn"><button type="button" class="btn btn-warning py-3 px-5">購入する<i class="fas fa-chevron-right pl-2"></i></button></li>
              </ul>
            </div>
          </div>


          <!-- 右下 -->
          <div class="right_down mt-5">
            <p class="purchase_title">アーティスト：</p>
            <div class="card">
              <div class="card-header">
                <p @click="$router.push({ name: 'creater-show' })">Creater Name</p>
                <img src="/images/498467_s.jpg" class="rounded-circle">
              </div>
              <div class="card-body pt-5">
                <h5 class="card-title">紹介文</h5>
                <p class="card-text">446 点の作品を登録しています。よろしくお願いいたします。</p>
                <a class="btn btn-outline-primary">このアーティストをフォロー</a>
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
      price: 4000,
      audio: {
          sound: '/images/Closed_Case.mp3',
          title: '生演奏！アコースティックギターのポップス',
          artist: 'rokedt1'
      },
      junnes: [
        {
          value: 'sound_effect',
          text: 'BGM',
        },
        {
          value: 'pops',
          text: '効果音',
        },
        {
          value: 'voice',
          text: '声',
        },
        {
          value: 'song',
          text: '歌',
        },
      ],
    }
  },

}
</script>

<style scoped>
.new-audio {
  height: auto;
  background: #F6F6F4;
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
  color: hsla(357, 100%, 37%, 0.979);;
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
.detail p {
  font-weight: 600;
  font-size: 18px;
  color: #334e6f;
}
.buttons{
  padding: 0 0 20px 20px;
  text-align: left;
}
.titles {
  padding-bottom: 0;
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