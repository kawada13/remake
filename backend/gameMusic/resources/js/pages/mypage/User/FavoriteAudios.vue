<template>
  <div>
    <div class="card mt-2">
        <h3 class="card-header">
          お気に入り作品一覧
        </h3>
        <div class="audios my-3" v-for="(audio,i) in audios" :key="i">
          <h4 class="audio_title" @click="$router.push({ name: 'audio-show', params: { id: `${audio.id}` } })">{{ audio.title }}</h4>
          <audio controls controlslist="nodownload" class="my-3">
            <source :src="audio.sound">
          </audio>
          <p class="card-text"><small class="text-muted creater_name" @click="$router.push({ name: 'user-show', params: { id: `${audio.id}` }})">{{audio.artist}}</small></p>
        </div>

      </div>

  </div>
</template>

<script>
export default {
  data() {
    return {
      audios:[
        {
          id: 1,
          sound: '/images/Closed_Case.mp3',
          title: '生演奏！アコースティックギターのポップス',
          artist: 'rokedt1',
          price: 4000
        },
        {
          id: 2,
          sound: '/images/Closed_Case.mp3',
          title: '生演奏！アコースティックギターのポップス',
          artist: 'rokedt2',
          price: 4000
        },
        {
          id: 3,
          sound: '/images/Closed_Case.mp3',
          title: '生演奏！アコースティックギターのポップス',
          artist: 'rokedt3',
          price: 4000
        },
      ]
    }
  },
  methods: {
    async getFavoriteAudios() {
      try{
        // this.loading = true
        await this.$store.dispatch('favorite/lists')
        // this.user = this.$store.state.user.user
      }
      catch(e){
        // console.log(e);
        this.loading = false
      }
      finally{
        this.loading = false
      }
    },
  },
  created() {
    Promise.all([
      this.getFavoriteAudios(),
    ])
  },

}
</script>

<style scoped>
audio {
  margin-bottom: 0!important;
}


.audios .audio_title:hover {
  cursor: pointer;
  text-decoration: underline;
}
.audios .creater_name:hover {
  cursor: pointer;
  text-decoration: underline;
}

@media screen and (max-width:767px) {
    /*画面サイズが767px以下の場合読み込む（スマホ）*/

    .audios {
      margin-left: 10px;
    }

    h3 {
      font-weight: bold;
      font-size: 20px;
    }

}
@media screen and (min-width:768px){
    /*画面サイズが768px以上の場合読み込む（PC）*/
    .audios {
      margin-left: 20px;
    }

    h3 {
      font-weight: bold;
    }

}

</style>