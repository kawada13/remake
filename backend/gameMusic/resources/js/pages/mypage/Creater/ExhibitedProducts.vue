<template>
  <div class="exhibited_products">
    <!-- 売上金とか(上) -->
    <div class="card-group">
      <div class="card text-center">
        <div class="card-body earnings">
          <h5 class="card-title">売上金額合計</h5>
          <h1><i class="fas fa-yen-sign"></i>{{ earning | comma }}</h1>
        </div>
      </div>
      <div class="card text-center">
        <div class="card-body cumulative">
          <h5 class="card-title">累計の売上金額</h5>
          <h1><i class="fas fa-yen-sign"></i>{{ cumulative | comma }}</h1>
        </div>
      </div>
    </div>

    <!-- 下 -->
    <div class="mt-5">
      <div class="card listing_audio">
        <h2 class="card-header">
          出品作品
        </h2>
        <div class="card-body" v-for="(audio, i) in audios" :key="i">
            <h5 class="card-title audio_title" @click="$router.push({ name: 'audio-show' })">{{audio.title}}</h5>
            <p>
              <button type="button" class="btn btn-outline-info ml-4"><i class="fas fa-yen-sign"></i>{{ audio.price | comma }}</button>
              <button type="button" class="btn btn-success text-white" @click="$router.push({ name: 'audio-edit', params: { id: `${audio.id}` }})">編集</button>
              <button type="button" class="btn btn-danger text-white" @click="del">削除</button>
            </p>
            <audio controls controlslist="nodownload">
              <source :src="audio.sound">
            </audio>
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
          id: 1,
          title:'生演奏！アコースティックギターのポップス',
          sound: '/images/Closed_Case.mp3',
          price: 3000
        },
        {
          id: 2,
          title:'生演奏！アコースティックギターのポップス',
          sound: '/images/Closed_Case.mp3',
          price: 3000
        },
        {
          id: 3,
          title:'生演奏！アコースティックギターのポップス',
          sound: '/images/Closed_Case.mp3',
          price: 3000
        },
        {
          id: 4,
          title:'生演奏！アコースティックギターのポップス',
          sound: '/images/Closed_Case.mp3',
          price: 3000
        },
      ]
    }
  },
  methods: {
    del() {
      alert('本当に削除しますか？');
    }
  },

}
</script>

<style scoped>
.earnings h1 {
  font-weight: bold;
  color: hsla(357, 100%, 37%, 0.979);
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
.card .audio_title:hover {
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