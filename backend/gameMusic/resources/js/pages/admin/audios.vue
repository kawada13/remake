<template>
  <div>
    audios
  </div>
</template>

<script>
export default {
  data() {
    return {
      audios: [],
      loading: false
    }
  },
  methods: {
    async getAudiosData() {
       this.isLogined = false
      try{
        this.loading = true
        await this.$store.dispatch('audio/getAllAudios')
        this.audios = this.$store.state.audio.allAudios

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
      this.getAudiosData(),
    ])
  },

}
</script>

<style>

</style>