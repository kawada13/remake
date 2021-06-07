<template>
  <div>
    <!-- ローディング中 -->
    <div class="my-5" v-if="loading">
      <Loader />
    </div>


    <div  v-if="!loading">
      <div class="card purchase_audio_title">
        <h3 class="card-header">
          購入履歴
        </h3>

        <div class="no_audio mt-4" v-if="!audios.length">
          <p>購入されたオーディオは現在ございません。</p>
        </div>

        <div class="card-body purchase_audio_body" v-for="(audio, i) in audios" :key="i">
            <div class="card-body detail type_content buttons row">
              <span class="mr-2 mb-2 border border-info p-2" ><i class="fas fa-yen-sign"></i>{{audio.price | comma}}</span>
            </div>
            <audio controls controlslist="nodownload">
              <source :src="audio.sample_audio_file">
            </audio>
            <p class="card-text"><small class="text-muted creater_name" @click="$router.push({ name: 'user-show', params: { id: `${audio.id}` }})">クリエイター名：{{audio.user.name}}</small></p>
            <p class="card-text"><small class="text-muted">購入日時：{{audio.created_at | fromiso}}</small></p>
            <p class="card-text"><small class="text-muted">購入日時：{{'2020-08-08' | fromiso}}</small></p>
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