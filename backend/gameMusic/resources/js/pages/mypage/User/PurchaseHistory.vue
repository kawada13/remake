<template>
  <div>
        <!-- ローディング中 -->
        <div class="my-5" v-if="loading">
          <Loader />
        </div>

        <div class="card mt-2" v-if="!loading">
            <h3 class="card-header">
              購入履歴
            </h3>
            <p class="purchase_count ml-4 mt-3 mb-5">購入した商品：{{audios.length}}件</p>
            <div class="no_audio mt-4" v-if="!audios.length">
              <p>購入されたオーディオは現在ございません。</p>
            </div>
            <div class="audios ml-4 my-4" v-for="(audio,i) in audios" :key="i">
              <h4 class="audio_title " @click="$router.push({ name: 'audio-show', params: { id: `${audio.id}` } })">{{ audio.title }}</h4>
              <h6 class="card-subtitle mb-2 text-muted creater_name" @click="$router.push({ name: 'user-show', params: { id: `${audio.user.id}` }})">クリエイター：{{audio.user.name}}</h6>
              <h6 class="card-subtitle mb-2 text-muted" >購入日：{{audio.purchase_records[0].created_at | fromiso}}</h6>
              <h6 class="card-subtitle mb-2 price font-weight-bold text-danger"><i class="fas fa-yen-sign"></i>{{audio.price | comma}}</h6>
              <audio controls controlslist="nodownload" class="my-3">
                <source :src="audio.sample_audio_file">
              </audio>
              <div>
                <!-- <audio controls class="my-3">
                <source :src="audio.audio_file">
              </audio> -->
                 <a type="button" class="btn btn-danger font-weight-bold text-white" id="download" @click="download(audio.audio_file)" download><i class="fas fa-download mr-2"></i>ダウンロード</a>
                 <!-- <a class="btn btn-danger font-weight-bold text-white" href="https://example.com/my_file.txt" download="sample"><i class="fas fa-download mr-2"></i>ダウンロード</a> -->
              </div>
            </div>
        </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      audios:[],
      loading:false
    }
  },
  methods: {
    download(url) {
      const link = document.createElement('a')
      link.download = 'result.csv'
      link.href = url
      link.click()
    },
    async getPurchases() {

      try{
        this.loading = true
        await this.$store.dispatch('purchase/getPurchases')
        this.audios = this.$store.state.purchase.purchases

      }
      catch(e){
        // console.log(e);
        this.loading = false
      }
      finally{
        this.loading = false
      }
    }

  },
  created() {
    Promise.all([
      this.getPurchases(),
    ])
  },

}
</script>

<style scoped>

.purchase_audio_body button {
  margin: 0!important;
}

.purchase_audio_body .audio_title:hover {
  cursor: pointer;
  text-decoration: underline;
}
.audio_title:hover {
  cursor: pointer;
  text-decoration: underline;
}
.creater_name:hover {
  cursor: pointer;
  text-decoration: underline;
}

.no_audio {
  text-align: center;
}

.audio_price {
  cursor: auto!important;
}
.audio_price:hover {
   background: white!important;
   color: black!important;
   border: #6CB2EB ;
}

.purchase_count {
  font-weight: 600;
  font-size: 18px;
  color: #334e6f;
}


@media screen and (max-width:767px) {
    /*画面サイズが767px以下の場合読み込む（スマホ）*/

    .purchase_audio_title h3 {
      font-weight: bold;
      font-size: 20px;
    }



}
@media screen and (min-width:768px){
    /*画面サイズが768px以上の場合読み込む（PC）*/

    .purchase_audio_title h3 {
      font-weight: bold;
    }

}


</style>