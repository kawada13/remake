<template>
  <div class="new-audio">

    <div class="container">
      <div class="content-top-title">
        <h1>新着オーディオ</h1>
      </div>
      <audio controls controlslist="nodownload">
        <source :src="mp3">
      </audio>
    </div> 
  </div>
</template>

<script>
export default {
  data() {
    return {
      mp3: 'images/Closed_Case.mp3'
    }
  },

}
</script>

<style scoped>
.new-audio {
  height: auto;
  background: #F6F6F4;
}

.content-top-title h1{
  font-weight: bold;
  color: #566985;
}


@media screen and (max-width:767px) {
    /*画面サイズが767px以下の場合読み込む（スマホ）*/

    .content-top-title {
      text-align: center;
      margin-top: 215px;
    }

}
@media screen and (min-width:768px){
    /*画面サイズが768px以上の場合読み込む（PC）*/

    .content-top-title {
      text-align: center;
      margin-top: 210px;
    }

}
</style>