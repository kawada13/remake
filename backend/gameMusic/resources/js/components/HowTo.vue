<template>
  <div class="new-audio">

    <div class="container">

      <div class="content-top-title">
        <h1>使い方</h1>
      </div>
      
      <div class="mt-5 explanation">
        <div class="card-deck row">
          <div class="col-sm-4">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">検索する</h4>
                <p class="card-text">検索ボックスにて、「オープニング」「バトル」などの用途や、「ロック」「ジャズ」などの音楽ジャンル、「明るい」「楽しい」などのイメージなど、欲しい作品に関連するキーワードを自由に入力して検索してください。</p>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">アーティストから購入</h4>
                <p class="card-text">検索ボックスにて、「オープニング」「バトル」などの用途や、「ロック」「ジャズ」などの音楽ジャンル、「明るい」「楽しい」などのイメージなど、欲しい作品に関連するキーワードを自由に入力して検索してください。</p>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">ダウンロード</h4>
                <p class="card-text">検索ボックスにて、「オープニング」「バトル」などの用途や、「ロック」「ジャズ」などの音楽ジャンル、「明るい」「楽しい」などのイメージなど、欲しい作品に関連するキーワードを自由に入力して検索してください。</p>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
    }
  },

}
</script>

<style scoped>
.new-audio {
  height: auto;
  background: #F6F6F4;
}
.content-top-title {
  text-align: center;
  margin-top: 60px;
}
.content-top-title h1{
  font-weight: bold;
  color: #566985;
}
.card .card-title{
  font-weight: bold;
  text-align: center;
}
.explanation {
  margin-bottom: 120px;
}
</style>