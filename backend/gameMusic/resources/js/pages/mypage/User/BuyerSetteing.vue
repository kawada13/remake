<template>
  <div>
    <div v-for="animal in animals" :key="animal.id">ID:{{animal.id}} name:{{animal.name}}</div>
   <!-- InfiniteLoadingコンポーネントを定義 -->
    <infinite-loading @infinite="infiniteHandler" spinner="spiral">
      <div slot="spinner">ロード中...</div>
      <div slot="no-more">もう検索データが無いよ！</div>
      <div slot="no-results">検索結果が無い！</div>
    </infinite-loading>
  </div>
</template>

<script>
  import InfiniteLoading from 'vue-infinite-loading';
  export default {
    components: {
      InfiniteLoading
    },
    data() {
    return {
      animals: [],
      animalData: [],
      start: 0,
      end: 20
    }
  },
  mounted() {
    const list = ['サーバル', 'フェネック', 'アライグマ', 'カバ', 'コツメカワウソ', 'ジャガー', 'トキ']
    for(let i = 0; i < 200; i++) {
      this.animalData.push({id: i, name: list[Math.floor(Math.random()*list.length)]})
    }
  },
  methods: {
    infiniteHandler($state) {
      if (this.end > this.animalData.length) {
        // 表示するデータが無くなった場合
        $state.complete()
      } else {
        // 表示するデータがある場合
        this.getAnimals()
        $state.loaded()
      }      
    },
    // axiosとかのAPI想定
    getAnimals() {
      this.animals = this.animals.concat(this.animalData.slice(this.start, this.end))
      this.start = this.start + 20
      this.end = this.end + 20
    }
  }
  }
</script>
