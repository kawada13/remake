<template>
<div>
  
  <!-- ローディング中 -->
  <div class="my-5" v-if="loading">
    <Loader />
  </div>
  <div class="audio-index" v-if="!loading">
    <div class="container">
      <div class="row my-3">

        <!-- 検索(左側) -->
        <div class="col-sm-4 col-xs-12" >
          <div class="card">
            <div class="card-body">
              <input type="text" class="form-control py-4" placeholder="キーワードを入力してください">
              <select class="custom-select select-music mt-3" id="inputGroupSelect">
                <option v-for="(sound,i) in sounds" :key="i" :value="sound.id">{{sound.name}}</option>
              </select>
              <select class="custom-select mt-3" id="inputGroupSelect">
                <option v-for="(understanding,i) in understandings" :key="i" :value="understanding.id">{{understanding. name}}</option>
              </select>
              <select class="custom-select mt-3" id="inputGroupSelect">
                <option v-for="(use,i) in uses" :key="i" :value="use.id">{{use.name}}</option>
              </select>
              <select class="custom-select mt-3" id="inputGroupSelect">
                <option v-for="(instrument,i) in instruments" :key="i" :value="instrument.id">{{instrument.name}}</option>
              </select>
              <div class="buttn mt-4">
                <button class="btn btn-primary" type="submit">検索する</button>
              </div>
            </div>
          </div>
        </div>

        <!-- 検索結果一覧(右側) -->
        <div class="col-sm-8 col-xs-12">
          <h2 class="search_result_title">検索結果：<span class="text-primary">全オーディオ一覧</span></h2>
          <hr>
          <p class="search_result_text">検索に一致するオーディオがOO件ありました。</p>

          <div class="mt-5">
            <div class="card-deck row">
              <div class="col-sm-6" v-for="(audio, i) in audios" :key="i">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title" @click="$router.push({ name: 'audio-show', params: { id: `${audio.id}` }  })">{{ audio.title }}</h5>
                    <audio controls controlslist="nodownload">
                      <source :src="audio.sound">
                    </audio>
                    <p class="card-text"><small class="text-muted" @click="$router.push({ name: 'user-show', params: { id: `${audio.id}` }  })">{{audio.artist}}</small></p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- ページネーション -->
          <div class="mt-5 d-flex justify-content-center">
            <nav aria-label="Page navigation example">
              <ul class="pagination">
                <li class="page-item">
                  <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                  </a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                  <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                  </a>
                </li>
              </ul>
            </nav>
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
      loading: false,
      sounds: [],
      understandings: [],
      uses: [],
      instruments: [],
      audios: [
        {
          id: 1,
          sound: 'images/Closed_Case.mp3',
          title: '生演奏！アコースティックギターのポップス',
          artist: 'rokedt1'
        },
        {
          id: 2,
          sound: 'images/Closed_Case.mp3',
          title: '生演奏ギターの爽やか明るい疾走感ポップス',
          artist: 'rokedt2'
        },
        {
          id: 3,
          sound: 'images/Closed_Case.mp3',
          title: '明るいEDM テクノ ポップ ダンス曲',
          artist: 'rokedt3'
        },
        {
          id: 4,
          sound: 'images/Closed_Case.mp3',
          title: '企業VPに爽やかアコースティックギター',
          artist: 'rokedt4'
        },
        {
          id: 5,
          sound: 'images/Closed_Case.mp3',
          title: 'ほのぼのした日常曲です。',
          artist: 'rokedt5'
        },
        {
          id: 6,
          sound: 'images/Closed_Case.mp3',
          title: '運動会に使われるテンポの良いクラシック',
          artist: 'rokedt6'
        },
        {
          id: 7,
          sound: 'images/Closed_Case.mp3',
          title: '生演奏！アコースティックギターのポップス',
          artist: 'rokedt7'
        },
        {
          id: 8,
          sound: 'images/Closed_Case.mp3',
          title: '生演奏ギターの爽やか明るい疾走感ポップス',
          artist: 'rokedt8'
        },
        {
          id: 9,
          sound: 'images/Closed_Case.mp3',
          title: '明るいEDM テクノ ポップ ダンス曲',
          artist: 'rokedt9'
        },
        {
          id: 10,
          sound: 'images/Closed_Case.mp3',
          title: '企業VPに爽やかアコースティックギター',
          artist: 'rokedt10'
        },
        {
          id: 11,
          sound: 'images/Closed_Case.mp3',
          title: 'ほのぼのした日常曲です。',
          artist: 'rokedt11'
        },
        {
          id: 12,
          sound: 'images/Closed_Case.mp3',
          title: '運動会に使われるテンポの良いクラシック',
          artist: 'rokedt12'
        },
        {
          id: 13,
          sound: 'images/Closed_Case.mp3',
          title: '生演奏ギターの爽やか明るい疾走感ポップス',
          artist: 'rokedt13'
        },
        {
          id: 14,
          sound: 'images/Closed_Case.mp3',
          title: '明るいEDM テクノ ポップ ダンス曲',
          artist: 'rokedt14'
        },
        {
          id: 15,
          sound: 'images/Closed_Case.mp3',
          title: '企業VPに爽やかアコースティックギター',
          artist: 'rokedt15'
        },
        {
          id: 16,
          sound: 'images/Closed_Case.mp3',
          title: 'ほのぼのした日常曲です。',
          artist: 'rokedt16'
        },
      ]
    }
  },
  methods: {
    async getSoundData() {
      try{
        this.loading = true
        await this.$store.dispatch('soundType/getSound')
        this.sounds = this.$store.state.soundType.sound;
      }
      catch(e){
        // console.log(e);
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
    async getInstrumentData() {
      try{
        this.loading = true
        await this.$store.dispatch('soundType/getInstrument')
        this.instruments = this.$store.state.soundType.instrument;
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
      this.getInstrumentData(),
    ])
  },
}
</script>

<style scoped>
.audio-index {
  height: auto;
  background: #F6F6F4;
}
.buttn{
  text-align: center;
}
.buttn .btn {
  color: white;
  font-weight: bold;
}


.search_result_text{
  font-weight: bold;
  text-align: center;
}

.card .card-title {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.card .card-title:hover {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    text-decoration: underline;
    cursor: pointer;
}
.card .card-text:hover {
    text-decoration: underline;
    cursor: pointer;
}

@media screen and (max-width:767px) {
    /*画面サイズが767px以下の場合読み込む（スマホ）*/

    .search_result_title {
      font-weight: bold;
      color: #566985;
      font-size: 24px;
    }
}
@media screen and (min-width:768px){
    /*画面サイズが768px以上の場合読み込む（PC）*/

    .search_result_title {
      font-weight: bold;
      color: #566985;
    }
}

</style>