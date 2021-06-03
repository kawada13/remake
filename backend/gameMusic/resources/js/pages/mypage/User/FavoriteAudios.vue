<template>
  <div>

    <!-- ローディング中 -->
    <div class="my-5" v-if="loading">
      <Loader />
    </div>


    <div class="card mt-2" v-if="!loading">
        <h3 class="card-header">
          お気に入り作品一覧
        </h3>
        <div class="audios my-3" v-for="(audio,i) in audios" :key="i">
          <h4 class="audio_title" @click="$router.push({ name: 'audio-show', params: { id: `${audio.id}` } })">{{ audio.title }}</h4>
          <audio controls controlslist="nodownload" class="my-3">
            <source :src="audio.sample_audio_file">
          </audio>
          <p class="card-text"><small class="text-muted creater_name" @click="$router.push({ name: 'user-show', params: { id: `${audio.id}` }})">{{audio.user.name}}</small></p>
        </div>
    </div>

  </div>
</template>

<script>
export default {
  data() {
    return {
      audios:[],
      loading: false
    }
  },
  methods: {
    async getFavoriteAudios() {
      try{
        this.loading = true
        await this.$store.dispatch('favorite/lists')
        this.audios = this.$store.state.favorite.favoriteAudios
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