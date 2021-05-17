<template>
    <div class="">
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
      confirm('本当に削除しますか？');
    }
  },

}
</script>

<style scoped>


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