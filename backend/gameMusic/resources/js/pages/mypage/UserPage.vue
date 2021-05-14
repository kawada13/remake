<template>
  <div class="artist_mypage">
    <div class="container">
      <div class="row my-3">

        <!-- (左側) -->
        <div class="col-sm-3 col-xs-12">

          <!-- アイコン -->
          <div class="artist_image d-flex justify-content-center mb-3">
            <img src="/images/498467_s.jpg" class="rounded-circle">
          </div>

          <!-- ユーザー名 -->
          <h3>User Name</h3>

          <!-- いろんな選択肢 -->
          <div class="card my-3">
            <ul class="list-group list-group-flush accout_setting">
              <li class="list-group-item">お気に入り作品一覧</li>
              <li class="list-group-item">フォローしているクリエイター</li>
              <li class="list-group-item">購入者情報設定</li>
            </ul>
          </div>
        </div>

        <!-- (右側) -->
        <div class="col-sm-9 col-xs-12">


          <div class="mt-5">
            <div class="card listing_audio">
              <h2 class="card-header">
                購入した作品：{{audios.length}}件
              </h2>
              <div class="card-body" v-for="(audio, i) in audios" :key="i">
                  <h5 class="card-title" @click="$router.push({ name: 'audio-show' })">{{audio.title}}</h5>
                  <p>
                    <button type="button" class="btn btn-outline-info ml-4"><i class="fas fa-yen-sign"></i>{{ audio.price | comma }}</button>
                  </p>
                  <audio controls controlslist="nodownload">
                    <source :src="audio.sound">
                  </audio>

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
      earning: 3000,
      cumulative: 6000,
      audios:[
        {
          title:'生演奏！アコースティックギターのポップス',
          sound: '/images/Closed_Case.mp3',
          price: 3000
        },
        {
          title:'生演奏！アコースティックギターのポップス',
          sound: '/images/Closed_Case.mp3',
          price: 3000
        },
        {
          title:'生演奏！アコースティックギターのポップス',
          sound: '/images/Closed_Case.mp3',
          price: 3000
        },
        {
          title:'生演奏！アコースティックギターのポップス',
          sound: '/images/Closed_Case.mp3',
          price: 3000
        },
      ]
    }
  },
  computed: {
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
.listing li {
  outline: solid #58BDF0;
}
.listing li:hover {
  cursor: pointer;
  color: #58BDF0;
}
h3 {
  text-align: center;
}
.border_s {
  text-align: center;
}

.earnings h1 {
  font-weight: bold;
  color: #FF6E3B;
}
.cumulative h1 {
  font-weight: bold;
  color: black;
}

.listing_audio .card-header {
  font-weight: bold;
}
.listing_audio button {
  margin: 0!important;
}
.card .card-title:hover {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    text-decoration: underline;
    cursor: pointer;
}

@media screen and (max-width:767px) {
    /*画面サイズが767px以下の場合読み込む（スマホ）*/

    .listing i {
      margin-left: 209px;
    }

}
@media screen and (min-width:768px){
    /*画面サイズが768px以上の場合読み込む（PC）*/

    .listing i {
      margin-left: 148px;
    }
}

</style>