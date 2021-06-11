<template>
  <div class="container">

     <!-- ローディング中 -->
    <div class="my-5" v-if="loading">
      <Loader />
    </div>



    <div class="card mt-3 text-center" v-if="!loading">
        <h2 class="mt-2">{{audio.title}}の詳細</h2>
        <div class="card-body detail type_title d-flex titles justify-content-start">
          <p class="">オーディオファイル</p>
        </div>
        <div class="card-body detail type_content buttons row">
          <audio controls controlslist="nodownload" class="">
            <source :src="audio.audio_file">
          </audio>
        </div>
        <div class="card-body detail type_title d-flex titles justify-content-start">
          <p class="">サウンドの種類</p>
        </div>
        <div class="card-body detail type_content buttons row">
          <span class="mr-2 border border-info p-2">{{audio.sound.name}}</span>
        </div>

        <div class="card-body detail understanding_title d-flex justify-content-start">
          <p class="">イメージ</p>
        </div>
        <div class="card-body detail type_content buttons row">
          <span class="mr-2  border border-info p-2" v-for="(understanding, i) in audio.understandings" :key="i">{{understanding.name}}</span>
        </div>

        <div class="card-body detail instrument_title d-flex justify-content-start">
          <p class="">用途(シーン)</p>
        </div>
        <div class="card-body detail type_content buttons row">
          <span class="mr-2 border border-info p-2" v-for="(use, i) in audio.uses" :key="i">{{use.name}}</span>
        </div>

        <div class="card-body detail instrument_title d-flex justify-content-start">
          <p class="">使用楽器</p>
        </div>
        <div class="card-body detail type_content buttons row">
          <span class="mr-2 border border-info p-2" v-for="(instrument, i) in audio.instruments" :key="i">{{instrument.name}}</span>
        </div>
    </div>

  </div>
</template>

<script>
export default {
  data() {
    return {
      audio: {},
      loading: false
    }
  },
  methods: {
    async getAudioData() {
      try{
        this.loading = true
        await this.$store.dispatch('audio/getAudioShow', this.$route.params.id)
        this.audio = this.$store.state.audio.audio

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
      this.getAudioData(),
    ])
  },

}
</script>

<style scoped>
.detail{
  margin: 0;
}
.detail p {
  font-weight: 600;
  font-size: 18px;
  color: #334e6f;
}

</style>