<template>
  <div class="jumbotron">
    <div class="container">

      <!-- タイトル -->
      <div class="hero-title">
        <h1>ゲームで使える</h1>
        <h1>サウンドが探せる</h1>
      </div>

      <!-- 検索ふぉーむ -->
      <div class="search_form d-flex justify-content-center">
        <div class="card mt-5" style="width: 40rem;">
          <div class="card-body">
            <div class="d-flex justify-content-start">
              <input type="text" class="form-control py-4" placeholder="キーワードを入力してください">
              <button class="btn btn-primary ml-2" type="submit"><i class="fas fa-search"></i></button>
            </div>

          <div class="types">


            <!-- サウンド -->
            <div class="card-body sound_title d-flex title justify-content-start">
              <p class="">サウンド：</p>
            </div>
            <select class="custom-select select_sound mt-3" id="inputGroupSelect">
              <option v-for="(sound,i) in sounds" :key="i" :value="sound.value">{{sound.text}}</option>
            </select>

            <!-- イメージ -->
            <div class="card-body sound_title d-flex title justify-content-start">
              <p class="">イメージ：</p>
            </div>
            <div class="card-body detail sound_content content buttons">
              <button type="button" class="btn btn-outline-dark mr-2 mb-2 text-dark" v-for="(understanding,i) in understandings" :key="i">{{understanding.text}}</button>
            </div>

            <!-- 用途 -->
            <div class="card-body sound_title d-flex title justify-content-start">
              <p class="">シーン：</p>
            </div>
            <div class="card-body detail sound_content content buttons">
              <button type="button" class="btn btn-outline-dark mr-2 mb-2 text-dark" v-for="(use,i) in uses" :key="i">{{use.text}}</button>
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
      sounds: [
        {
          value: 'sound_effect',
          text: 'BGM',
        },
        {
          value: 'SE',
          text: 'SE',
        },
        {
          value: 'jingle',
          text: 'ジングル',
        },
        {
          value: 'voice',
          text: '声',
        },
      ],
      understandings: [
        {
          value: 'gorgeous',
          text: '華やか',
        },
        {
          value: 'sad',
          text: '悲しい',
        },
        {
          value: 'pleasant',
          text: '楽しい',
        },
        {
          value: 'horror',
          text: 'ホラー',
        },
      ],
      uses: [
        {
          value: 'battle',
          text: 'バトル',
        },
        {
          value: 'love',
          text: '恋愛',
        },
        {
          value: 'past',
          text: '過去',
        },
        {
          value: 'future',
          text: '未来',
        },
        {
          value: 'everyday',
          text: '日常',
        },
      ],
    }
  },

}
</script>

<style scoped>

.types .title {
  padding: 10px 0 0 0;
}
.types .title p{
  font-weight: bold;
}

.types .content {
  padding-top: 0!important;
  padding-right: 0!important;
  padding-bottom: 10px!important;
  padding-left: 0!important;
}
.types .content button:hover{
   color: white!important;
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

.select_sound {
  margin: 0!important;
}

@media screen and (max-width:767px) {
    /*画面サイズが767px以下の場合読み込む（スマホ）*/

    h1 { font-size:23pt;}

    .jumbotron {
        position: relative;
        height: 70vh;
        max-height: 480px;
        background: url('/images/hero-top.jpg') no-repeat center center;
        background-size: cover;
        margin-bottom: 0;
    }
}
@media screen and (min-width:768px){
    /*画面サイズが768px以上の場合読み込む（PC）*/

    h1 { font-size:34pt;}

    .jumbotron {
        position: relative;
        height: 110vh;
        max-height: 490px;
        background: url('/images/hero-top.jpg') no-repeat center center;
        background-size: cover;
        margin-bottom: 0;
    }
}

</style>
