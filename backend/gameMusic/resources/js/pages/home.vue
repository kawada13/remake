<template>
  <div>
    <!-- ヒーロー画像アンドテキストで検索 -->
    <div class="hero">
      <Hero />
    </div>

    <!-- 中身 -->
    <div class="contents">
      <content-top />
    </div>
    

  </div>
</template>

<script>
import Hero from '../components/Hero.vue'
import ContentTop from '../components/ContentTop.vue'
export default {
  components: { 
    Hero,
    ContentTop
    }
}
</script>

<style scoped>
</style>