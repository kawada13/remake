<template>
  <div>

    <div class="" v-if="!loading">
      <div class="card listing_audio">
        <h2 class="card-header">
          出品オーディオ
        </h2>
        <div class="no_audio mt-4" v-if="!audios.length">
          <p>登録されているオーディオはまだありません。</p>
        </div>
        <div class="card-body my-4" v-for="(audio, i) in audios" :key="i">
            <h5 class="card-title audio_title" @click="$router.push({ name: 'audio-show',  params: { id: `${audio.id}` } })">{{audio.title}}</h5>
            <h6 class="card-subtitle mb-2 text-muted" >出品日：{{audio.created_at | fromiso}}</h6>
              <h6 class="card-subtitle mb-2 price font-weight-bold text-danger"><i class="fas fa-yen-sign"></i>{{audio.price | comma}}</h6>
            <audio controls controlslist="nodownload">
              <source :src="audio.audio_file">
            </audio>
            <p>
              <button type="button" class="btn btn-success text-white ml-2" @click="$router.push({ name: 'audio-edit', params: { id: `${audio.id}` }})">編集</button>
              <button type="button" class="btn btn-danger text-white ml-2" @click="del(audio.id)">削除</button>
            </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      options: { //トーストオプション
          duration: 1500,
          type: 'success'
      },
      loading: false,
      audios:[]
    }
  },
  methods: {
    async del(id) {
       let conf = confirm('本当に削除しますか？');

       if(conf) {
          console.log('削除');
          try {
            this.loading = true
            await this.$store.dispatch('audio/getExhibitedAudioDelete', id)
          }
          catch(e){
            console.log(e);
            this.loading = false
          }
          finally{
            this.toasted();
            this.getExhibitedAudiosData()
            this.loading = false
          }
       }else {
         return
       }

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
    },
    toasted(){
      this.$toasted.show('削除しました', this.options);
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

.no_audio {
  text-align: center;
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