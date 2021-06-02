<template>
  <div>
    <h4 class="audio_title" @click="$router.push({ name: 'audio-show', params: { id: `${audioId}` } })">{{ audioTitle }}</h4>
    <audio controls controlslist="nodownload" class="my-3">
      <source :src="sampleAudioFile">
    </audio>
      <p>
        <a class="btn btn-outline-primary" v-if="isLogined && !isFavoriteData" @click="favorite(audioId)">この曲をお気に入りに登録</a>
        <a class="btn btn-outline-danger  unfavorite" v-if="isLogined && isFavoriteData" @click="unfavorite(audioId)">お気に入り解除</a>
      </p>
  </div>
</template>

<script>
export default {
  props: {
    audioId: { type: Number},
    audioTitle: { type: String },
    sampleAudioFile: { type: String },
    isLogined: { type: Boolean, default: false },
  },
  data() {
    return {
      isFavoriteData: false
    }
  },
  methods: {
    async favorite(id) {
      try{
        await this.$store.dispatch('favorite/store', id)
      }
      catch(e){
        console.log(e);
      }
      finally{
        this.getIsFavorite()
      }
    },
    async unfavorite(id) {
      try{
        await this.$store.dispatch('favorite/delete', id)
      }
      catch(e){
        console.log(e);
      }
      finally{
        this.getIsFavorite()
      }
    },
    async getIsFavorite() { //お気に入り済かどうかを同時に判断する
      // まず初期化
      this.isFavoriteData = false
      // お気に入り済かどうかを確認しに行く
      try{
        await this.$store.dispatch('favorite/isFavorite', this.audioId)
      }
      catch(e){
        // console.log(e);
      }
      finally{
        // お気に入りすみかどうかの結果を代入
        this.isFavoriteData = this.$store.state.favorite.isFavorite
      }
    },
  },
  mounted() {
    this.getIsFavorite()
  },

}
</script>

<style>

</style>