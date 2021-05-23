<template>
  <div>




    <div class="" v-if="!loading">
      <div class="card listing_audio">
        <h2 class="card-header">
          出品オーディオ
        </h2>
        <div class="card-body" v-for="(audio, i) in audios" :key="i">
            <h5 class="card-title audio_title" @click="$router.push({ name: 'audio-show' })">{{audio.title}}</h5>
            <p>
              <button type="button" class="btn btn-outline-info ml-4"><i class="fas fa-yen-sign"></i>{{ audio.price | comma }}</button>
              <button type="button" class="btn btn-success text-white ml-2" @click="$router.push({ name: 'audio-edit', params: { id: `${audio.id}` }})">編集</button>
              <button type="button" class="btn btn-danger text-white ml-2" @click="del">削除</button>
            </p>
            <audio controls controlslist="nodownload">
              <source :src="audio.audio_file">
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
      loading: false,
      audios:[]
    }
  },
  methods: {
    del() {
      confirm('本当に削除しますか？');
    },
    async getExhibitedAudiosData() {
      try{
        this.loading = true
        await this.$store.dispatch('audio/getExhibitedAudios')
        this.audios = this.$store.state.audio.userAudios;
      }
      catch(e){
        console.log(e);
      }
      finally{
        this.loading = false
      }
    }
  },
  created() {
    Promise.all([
      this.getExhibitedAudiosData(),
    ])
  },

}
</script>

<style scoped>


.listing_audio .card-header {
  font-weight: bold;
}
.listing_audio button {
  margin-left: 0!important;
  margin-right: 15px;
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

    .card-header {
      font-size: 25px;
    }

}
@media screen and (min-width:768px){
    /*画面サイズが768px以上の場合読み込む（PC）*/

    .listing i {
      margin-left: 148px;
    }
}

</style>