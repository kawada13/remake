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
        <p class="favorite_cont ml-3 mt-3 mb-5">お気に入り件数：{{audios.length}}件</p>
        <div class="no_favorite_audio my-4" v-if="!audios.length">
          <p>現在お気に入りしているオーディオはございません。</p>
        </div>
        <div class="audios my-3" v-for="(audio,i) in audios" :key="i">
          <h4 class="audio_title " @click="$router.push({ name: 'audio-show', params: { id: `${audio.id}` } })">{{ audio.title }}</h4>
          <h6 class="card-subtitle mb-2 text-muted creater_name" @click="$router.push({ name: 'user-show', params: { id: `${audio.user.id}` }})">クリエイター：{{audio.user.name}}</h6>
          <h6 class="card-subtitle mb-2 price font-weight-bold text-danger"><i class="fas fa-yen-sign"></i>{{audio.price | comma}}</h6>
          <audio controls controlslist="nodownload" class="my-3">
            <source :src="audio.sample_audio_file">
          </audio>
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
.favorite_cont {
  font-weight: 600;
  font-size: 18px;
  color: #334e6f;
}
.no_favorite_audio {
  text-align: center;
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