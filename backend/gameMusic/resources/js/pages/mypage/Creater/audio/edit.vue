<template>

<div>

  <!-- ローディング中 -->
  <div class="mt-5" v-if="loading">
    <Loader />
  </div>

  <div v-if="!loading">
   <div class="head">
      <h4>商品編集</h4>
    </div>
    <div class="form_creater_edit my-5">
      <div class="card">
        <div class="card-body">
          <form @submit.prevent="upload">

            <div class="form-group">
              <div><label for="title" class="weight">タイトル<span class="badge badge-danger ml-2">必須</span></label></div>
              <input type="text" class="form-control form-control-lg" id="title" v-model="audio.title">
              <div class="alert alert-danger mt-2" role="alert" v-if="errors.title.required">
                入力は必須です！
              </div>
            </div>

            <div class="form-group">
              <div><label for="price" class="weight">価格<span class="badge badge-danger ml-2">必須</span></label></div>
              <input type="number" class="form-control form-control-lg" id="price" v-model="audio.price">
              <div class="alert alert-danger mt-2" role="alert" v-if="errors.price.required">
                入力は必須です！
              </div>
            </div>

            <div class="form-group">
              <div><label class="weight">オーディオをアップロード</label><span class="badge badge-danger ml-2">必須</span></div>
              <label class="input-group-btn">
                <span class="btn btn-secondary">
                    ファイルを選択<input type="file" style="display:none" @change="fileSelected" accept="audio/*">
                </span>
              </label>
              <div class="d-flex justify-content-start"><small class="form-text text-muted">ファイル形式は MP3 のみアップロードできます。</small></div>
              <div class="d-flex justify-content-start"><small class="form-text text-muted">ファイルの上限サイズは5MBです。</small></div>
              <div class="alert alert-danger" role="alert" v-if="errors.audio_url.required">
                ファイルが選択されていません!
              </div>
              <div class="alert alert-danger" role="alert" v-if="errors.audio_url.isFile">
                ファイル形式は MP3 ファイルのみです!
              </div>
              <div class="alert alert-danger" role="alert" v-if="errors.audio_url.size">
                ファイルの上限サイズ5MBを超えています!
              </div>
            </div>

            <div class="form-group select">
              <div><label for="sound" class="weight">サウンド<span class="badge badge-danger ml-2">必須</span></label></div>
              <select class="custom-select select-music" id="inputGroupSelect" v-model="audio.sound_id">
                <option v-for="(sound,i) in sounds" :key="i" :value="sound.id">{{sound.name}}</option>
              </select>
              <div class="alert alert-danger mt-2" role="alert" v-if="errors.sound.required">
                選択は必須です！
              </div>
            </div>

            <div class="form-group">
              <div class="types">
                <div class="card-body sound_title d-flex title justify-content-start">
                <p class="">イメージ(複数選択できます)</p>
                </div>
                <div class="card-body detail">
                  <label v-for="(understanding,i) in understandings" :key="i"><input type="checkbox" :value="understanding.id" v-model="audio.audio_understandings"><span>{{understanding.name}}</span></label>
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="types">
                <div class="card-body sound_title d-flex title justify-content-start">
                <p class="">シーン(複数選択できます)</p>
                </div>
                <div class="card-body detail">
                  <label v-for="(use,i) in uses" :key="i"><input type="checkbox" :value="use.id" v-model="audio.audio_uses"><span>{{use.name}}</span></label>
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="types">
                <div class="card-body sound_title d-flex title justify-content-start">
                <p class="">使用機材(複数選択できます)</p>
                </div>
                <div class="card-body detail">
                  <label v-for="(instrument,i) in instruments" :key="i"><input type="checkbox" :value="instrument.id" v-model="audio.audio_instruments"><span>{{instrument.name}}</span></label>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary my-4 store mr-5">保存<i class="fas fa-chevron-right pl-2"></i></button>
            <button type="button" class="btn btn-primary my-4 cancel" @click="cancel">戻る</button>
          </form>
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
      options: { //トーストオプション
          duration: 1500,
          type: 'success'
      },
      loading: false,
      errors: { //バリデーションエラー
        title: {
          required: false,
        },
        price: {
          required: false,
        },
        audio_url: {
          required: false,
          isFlie: false,
          size: false
        },
        sound: {
          required: false
        }
      },
      formInfo: {
        title: '',
        price: '',
        audio:{
          url: '', //ファイル名
          file_info:'' //ファイル情報
        },
        sound:'',
        understanding:[],
        use: [],
        instrument: []
      },
      audio: {},//取得してきたオーディオ情報



      sounds: [ //サウンド選択肢
      ],
      understandings: [], //understandings関連選択肢
      uses: [],
      instruments: [],
    }
  },
  methods: {
    fileSelected(e) {
      this.audio.audio_file = e.target.files[0]

      // エラー初期化
      this.errors.audio_url.isFile = false
      // 代入(名前表示のためのみ)
      this.formInfo.audio.url = this.audio.audio_file.name

      // mp3のみを許可するバリデーション
      if (this.audio.audio_file.type != 'audio/mpeg') {
        this.errors.audio_url.isFile = true
      }
      // ファイルサイズ5MB以下のみを許可するバリデーション
      if (this.audio.audio_file.size > 5000000) {
        this.errors.audio_url.size = true
      }
    },
    async upload() {

      // 初期化
      this.errors.title.required = false
      this.errors.price.required = false
      this.errors.audio_url.required = false
      this.errors.audio_url.isFlie = false
      this.errors.audio_url.size = false
      this.errors.sound.required = false

      // バリデーション
      this.validate();
      if(this.errors.title.required || this.errors.price.required || this.errors.audio_url.required || this.errors.audio_url.isFile || this.errors.audio_url.size)
      {
        return
      }
      console.log('アップロード！');

      let data = new FormData();
      data.append("title", this.formInfo.title);
      data.append("price", this.formInfo.price);
      data.append("audio_file", this.audio.audio_file);
      data.append("sound_id", this.formInfo.sound);
      data.append("understanding", this.formInfo.understanding);
      data.append("use", this.formInfo.use);
      data.append("instrument", this.formInfo.instrument);


      try {
        this.loading = true
        await this.$store.dispatch('audio/createAudio', data)
      }
      catch(e){
        this.loading = false
      }
      finally{
        this.toasted();
        this.$router.push({ name: 'exhibited-audios' })
        this.loading = false
      }


    },
    validate() {

      if (!this.formInfo.title) {
        this.errors.title.required = true
      }
      if (!this.formInfo.price) {
        this.errors.price.required = true
      }
      if (!this.formInfo.audio.url) {
        this.errors.audio_url.required = true
      }
      if (!this.formInfo.sound) {
        this.errors.sound.required = true
      }

    },
    cancel() {
      this.$router.push({ name: 'exhibited-audios'})
    },
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
    async getAudioData() {
      try{
        this.loading = true
        await this.$store.dispatch('audio/getExhibitedAudioShow', this.$route.params.id)

        // 必要なデータだけ抜き出す
        let audio_instruments = this.$store.state.audio.audio.audioInstrument.map(o => o.instrument_id)
        let audio_understandings = this.$store.state.audio.audio.audioUnderstanding.map(o => o.understanding_id)
        let audio_uses = this.$store.state.audio.audio.audioUse.map(o => o.use_id)

        console.log(this.$store.state.audio.audio);

        // 取得したデータを代入
        this.audio = {
          file : this.$store.state.audio.audio.audio.audio_file,
          id : this.$store.state.audio.audio.audio.id,
          title : this.$store.state.audio.audio.audio.title,
          price : this.$store.state.audio.audio.audio.price,
          sound_id : this.$store.state.audio.audio.audio.sound_id,
          user_id : this.$store.state.audio.audio.audio.user_id,
          audio_instruments: audio_instruments,
          audio_understandings: audio_understandings,
          audio_uses: audio_uses,
        }
      }
      catch(e){
        // console.log(e);
      }
      finally{
        this.loading = false
      }

    },
    toasted(){
      this.$toasted.show('保存しました', this.options);
    }
  },
  created() {
    Promise.all([
      this.getSoundData(),
      this.getUnderstandingData(),
      this.getUseData(),
      this.getInstrumentData(),
      this.getAudioData(),
    ])
  },

}
</script>


<style scoped>
.head h4 {
  font-weight: bold;
}
.store{
  color: white;
  font-weight: bold;
  padding: 12px 30px;
  border-radius: 20px;
}
.cancel{
  color: white;
  font-weight: bold;
  padding: 12px 30px;
  border-radius: 20px;
  background: #4DB7FE;
}
.weight {
  font-weight: bold;
}

.types .title {
  padding: 10px 0 0 0;
}
.types .title p{
  font-weight: bold;
}


.detail {
  padding-left: 0;
  padding-bottom: 0;

}
.detail label {
    margin-right: 5px; /* ボタン同士の間隔 */
    margin-bottom: 20px;
}
.detail label input {
    display: none; /* デフォルトのinputは非表示にする */
}
.detail label span {
    color: #333; /* 文字色を黒に */
    font-size: 14px; /* 文字サイズを14pxに */
    border: 1px solid #333; /* 淵の線を指定 */
    border-radius: 20px; /* 角丸を入れて、左右が丸いボタンにする */
    padding: 5px 20px; /* 上下左右に余白をトル */
    cursor: pointer;
}
.detail label input:checked + span {
    color: #FFF; /* 文字色を白に */
    background: #333; /* 背景色を薄い赤に */
    border: 1px solid #333; /* 淵の線を薄い赤に */
    cursor: pointer;
}

</style>