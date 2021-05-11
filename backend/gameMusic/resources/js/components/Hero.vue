<template>
  <div class="jumbotron">
    <div class="container">

      <!-- タイトル -->
      <div class="hero-title">
        <h1>ゲームで使える</h1>
        <h1>BGM・効果音が探せる</h1>
      </div>

      <!-- 検索ふぉーむ -->
      <!-- <div class="form-row">
        <div class="col-xs-12 col-md-6">
          <input type="text" class="form-control" placeholder="キーワードを入力してください">
        </div>
        <div class="col-xs-12 col-md-6">
          <input type="text" class="form-control" placeholder="名前" aria-label="名前">
        </div>
      </div> -->

      <div class="mt-5">
          <input type="text" class="form-control py-4" placeholder="キーワードを入力してください">
      </div>
      <div class="input-group mt-3 ">
          <select class="custom-select select-music" id="inputGroupSelect">
            <option v-for="(junne,i) in junnes" :key="i" :value="junne.value">{{junne.text}}</option>
          </select>
          <select class="custom-select" id="inputGroupSelect">
            <option selected>イメージ</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
          </select>
          <div class="input-group-append">
            <button class="btn btn-primary" type="submit">検索</button>
          </div>
      </div>

    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      junnes: [
        {
          value: 'rock',
          text: 'ロック',
        },
        {
          value: 'pops',
          text: 'ポップ',
        },
      ]
        
    }
  },

}
</script>

<style scoped>
.jumbotron {
    position: relative;
    height: 100vh;
    max-height: 610px;
    background: url('/images/hero-top.jpg') no-repeat center center;
    background-size: cover;
}
.hero-title {
  text-align: center;
  color:white;
}
.hero-title h1{
  font-weight: bold;
}
.btn {
  color: white;
  font-weight: bold;
}
@media screen and (max-width:767px) {
    /*画面サイズが767px以下の場合読み込む（スマホ）*/
    h1 { font-size:23pt;}
}
@media screen and (min-width:768px){
    /*画面サイズが768px以上の場合読み込む（PC）*/
    h1 { font-size:34pt;}
}

</style>
