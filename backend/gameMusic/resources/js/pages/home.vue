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
      <Recruitment />
      <how-to />
    </div>

  </div>
</template>

<script>
import Hero from '../components/Hero.vue'
import NewAudio from '../components/NewAudio.vue'
import AudioIndex from '../components/AudioIndex.vue'
import Recruitment from '../components/Recruitment.vue'
import HowTo from '../components/HowTo.vue'

export default {
  components: { 
    Hero,
    NewAudio,
    AudioIndex,
    Recruitment,
    HowTo
  },
  methods: {
    // async getUser() {
    //    await this.$store.dispatch('auth/getUser')
    // },
  },
  created() {
    Promise.all([
      // this.getUser()
    ])
  },
}
</script>

<style scoped>
</style>