<template>
  <div>
   <div class="head">
      <h4>商品登録</h4>
    </div>


    <div class="form_creater_edit my-5">
      <div class="card">
        <div class="card-body">
          <form @submit.prevent="upload">

            <div class="form-group">
              <div><label for="title" class="weight">タイトル<span class="badge badge-danger ml-2">必須</span></label></div>
              <input type="text" class="form-control form-control-lg" id="title" v-model="title">
              <div class="alert alert-danger mt-2" role="alert" v-if="errors.title.required">
                入力は必須です！
              </div>
            </div>

            <div class="form-group">
              <div><label for="price" class="weight">価格<span class="badge badge-danger ml-2">必須</span></label></div>
              <input type="number" class="form-control form-control-lg" id="price" v-model="price">
              <div class="alert alert-danger mt-2" role="alert" v-if="errors.price.required">
                入力は必須です！
              </div>
            </div>

            <div class="form-group">
              <div><label class="weight">オーディオをアップロード</label><span class="badge badge-danger ml-2">必須</span></div>
              <label class="input-group-btn">
                <span class="btn btn-secondary">
                    ファイルを選択<input type="file" style="display:none" @change="fileSelected">
                </span>
                <span>{{audio.url}}</span>
              </label>
              <div class="d-flex justify-content-start"><small class="form-text text-muted">ファイル形式は MP3 のみアップロードできます。</small></div>
              <div class="alert alert-danger" role="alert" v-if="errors.audio_url.required">
                ファイルが選択されていません!
              </div>
              <div class="alert alert-danger" role="alert" v-if="errors.audio_url.isFile">
                ファイル形式は MP3 ファイルのみです!
              </div>
            </div>

            <div class="form-group select">
              <div><label for="sound" class="weight">サウンド<span class="badge badge-danger ml-2">必須</span></label></div>
              <select class="custom-select select-music mt-3" id="inputGroupSelect">
                <option v-for="(sound,i) in sounds" :key="i" :value="sound.value">{{sound.text}}</option>
              </select>
            </div>

            <div class="form-group">
              <div class="types">
                <div class="card-body sound_title d-flex title justify-content-start">
                <p class="">イメージ(複数選択できます)</p>
                </div>
                <div class="card-body detail sound_content content buttons">
                  <button type="button" class="btn btn-outline-dark mr-2 mb-2 text-dark" v-for="(understanding,i) in understandings" :key="i">{{understanding.text}}</button>
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="types">
                <div class="card-body sound_title d-flex title justify-content-start">
                <p class="">シーン(複数選択できます)</p>
                </div>
                <div class="card-body detail sound_content content buttons">
                  <button type="button" class="btn btn-outline-dark mr-2 mb-2 text-dark" v-for="(use,i) in uses" :key="i">{{use.text}}</button>
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="types">
                <div class="card-body sound_title d-flex title justify-content-start">
                <p class="">使用機材(複数選択できます)</p>
                </div>
                <div class="card-body detail sound_content content buttons">
                  <button type="button" class="btn btn-outline-dark mr-2 mb-2 text-dark" v-for="(instrument,i) in instruments" :key="i">{{instrument.text}}</button>
                </div>
              </div>
            </div>



            <button type="submit" class="btn btn-primary my-4 store mr-5">保存<i class="fas fa-chevron-right pl-2"></i></button>
            <button type="button" class="btn btn-primary my-4 cancel">キャンセル</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      errors: {
        title: {
          required: false,
        },
        price: {
          required: false,
        },
        audio_url: {
          required: false,
          isFlie: false
        },
      },
      title: '',
      price: '',
      audio:{
        url: '',
        file_info:''
      },


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
      instruments: [
        {
          value: 'guitar',
          text: 'ギター',
        },
        {
          value: 'bass',
          text: 'ベース',
        },
        {
          value: 'drums',
          text: 'ドラム',
        },
        {
          value: 'synth',
          text: 'シンセ',
        },
      ],
    }
  },
  methods: {
    fileSelected(e) {
      // ログ
      console.log(e.target.files[0]);
      // エラー初期化
      this.errors.audio_url.isFile = false
      // 代入(名前表示のためのみ)
      this.audio.url = e.target.files[0].name

      // mp3のみを許可するバリデーション
      if (e.target.files[0].type != 'audio/mpeg') {
        this.errors.audio_url.isFile = true
      }
      // データベースに保存するインフォを代入
      this.audio.file_info = event.target.files[0]
    },
    upload() {
      // バリデーション
      this.validate();

    },
    validate() {

      if (!this.title) {
        this.errors.title.required = true
      }
      if (!this.price) {
        this.errors.price.required = true
      }
      if (!this.audio.url) {
        this.errors.audio_url.required = true
      }

    }
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

.select select {
  margin: 0!important;
}

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

</style>