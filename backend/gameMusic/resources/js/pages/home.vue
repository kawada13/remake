<template>
  <div>
    <!-- ヒーロー画像アンドテキストで検索 -->
    <div class="hero">
      <Hero />
    </div>

    <!-- 中身 -->
    <div class="contents">
      <new-audio />
      <audio-index />
      <how-to />
    </div>

  </div>
</template>

<script>
import Hero from '../components/Hero.vue'
import NewAudio from '../components/NewAudio.vue'
import AudioIndex from '../components/AudioIndex.vue'
import HowTo from '../components/HowTo.vue'

export default {
  components: { 
    Hero,
    NewAudio,
    AudioIndex,
    HowTo
  },
  methods: {
    async getUser() {
       await this.$store.dispatch('auth/getUser')
    },
  },
  created() {
    Promise.all([
      this.getUser()
    ])
    // this.$router.go({path: this.$router.currentRoute.path, force: true})
  },
}
</script>

<style scoped>
</style>