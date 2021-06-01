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
              <input type="text" class="form-control py-4" placeholder="キーワードを入力してください" v-model="keyword">
              <button class="btn btn-primary ml-2" type="submit" @click="keywordSearch"><i class="fas fa-search"></i></button>
            </div>

          <div class="types">


            <!-- サウンド -->
            <div class="card-body sound_title d-flex title justify-content-start">
              <p class="">サウンド</p>
            </div>
            <div class="card-body detail sound_content content buttons">
              <button type="button" class="btn btn-outline-dark mr-2 mb-2 text-dark" v-for="(sound,i) in sounds" :key="i" @click="soundSearch(sound.name)">{{sound.name}}</button>
            </div>

            <!-- イメージ -->
            <div class="card-body sound_title d-flex title justify-content-start">
              <p class="">イメージ：</p>
            </div>
            <div class="card-body detail sound_content content buttons">
              <button type="button" class="btn btn-outline-dark mr-2 mb-2 text-dark" v-for="(understanding,i) in understandings" :key="i" @click="understandingSearch(understanding.name)">{{understanding.name}}</button>
            </div>

            <!-- 用途 -->
            <div class="card-body sound_title d-flex title justify-content-start">
              <p class="">シーン：</p>
            </div>
            <div class="card-body detail sound_content content buttons">
              <button type="button" class="btn btn-outline-dark mr-2 mb-2 text-dark" v-for="(use,i) in uses" :key="i" @click="useSearch(use.name)">{{use.name}}</button>
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
      loading:false,
      keyword: '',
      sounds: [],
      understandings: [],
      uses: [],
    }
  },
  methods: {
    keywordSearch() {
      this.$router.push({ name: 'audio-index', query: { keyword: this.keyword, sound: '', understanding: '', use: '', instruments: '' } })
    },
    soundSearch(name) {
      this.$router.push({ name: 'audio-index', query: { sound: name, understanding: '', use: '', instruments: '' } })
    },
    understandingSearch(name) {
      this.$router.push({ name: 'audio-index', query: { sound: '', understanding: name, use: '', instruments: '' } })
    },
    useSearch(name) {
      this.$router.push({ name: 'audio-index', query: { sound: '', understanding: '', use: name, instruments: '' } })
    },
    async getSoundData() {
      try{
        this.loading = true
        await this.$store.dispatch('soundType/getSound')
        this.sounds = this.$store.state.soundType.sound;
      }
      catch(e){
        console.log(e);
      }
      finally{
        this.loading = false
      }
    },
    async getUnderstandingData() {
      try{
        this.loading = true
        await this.$store.dispatch('soundType/getUnderstanding')
        this.understandings = this.$store.state.soundType.understanding;
      }
      catch(e){
        // console.log(e);
      }
      finally{
        this.loading = false
      }
    },
    async getUseData() {
      try{
        this.loading = true
        await this.$store.dispatch('soundType/getUse')
        this.uses = this.$store.state.soundType.use;
      }
      catch(e){
        // console.log(e);
      }
      finally{
        this.loading = false
      }
    },
  },
  created() {
    Promise.all([
      this.getSoundData(),
      this.getUnderstandingData(),
      this.getUseData(),
    ])
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
