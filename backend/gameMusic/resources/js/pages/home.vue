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
    </div>
    

    <!-- フッター -->
    <!-- <div>
      <Footer />
    </div> -->

  </div>
</template>

<script>
import Hero from '../components/Hero.vue'
import NewAudio from '../components/NewAudio.vue'
import AudioIndex from '../components/AudioIndex.vue'
import Footer from '../components/Footer.vue'

export default {
  components: { 
    Hero,
    NewAudio,
    AudioIndex,
    Footer
    }
}
</script>

<style scoped>
</style>