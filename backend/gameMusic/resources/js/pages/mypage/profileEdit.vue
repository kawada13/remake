<template>
  <div class="mt-5">
    <div class="title">
      <h4>プロフィール編集</h4>
    </div>


    <div class="form_creater_edit my-5">
      <div class="card">
        <div class="card-body">
          <form @submit.prevent="upload">
            <div class="form-group">
              <div><label for="creater_name">ユーザー名</label></div>
              <input type="text" class="form-control form-control-lg" id="creater_name">
            </div>
            <div class="form-group">
              <label for="introduce">自己紹介</label>
              <textarea class="form-control" id="introduce" placeholder="よろしくお願いします。"></textarea>
            </div>
            <div class="form-group">
              <label for="instruments">使用機材</label>
              <textarea class="form-control" id="instruments" placeholder="ギター、ベース"></textarea>
            </div>
            <div class="form-group">

              <div><label>プロフィール画像</label></div>

              <div class="creater_image mt-5 mb-3">
                <img src="/images/498467_s.jpg" class="rounded-circle">
              </div>

              <label class="input-group-btn">
                <span class="btn btn-secondary">
                    ファイルを選択<input type="file" style="display:none" @change="fileSelected">
                </span>
                <span></span>
              </label>

              <div class="d-flex justify-content-start"><small class="form-text text-muted">画像は jpg, png 画像のみアップロードできます。</small></div>
              <div class="alert alert-danger" role="alert" v-if="errors.image.isFile">
                画像は jpg, pngファイルのみです!
              </div>
              <div class="alert alert-danger" role="alert" v-if="errors.image.size">
                画像ファイルの縦横幅それぞれは、700 px を超えることはできません。!
              </div>

              <div class="creater_image mt-5 mb-3" v-if="confirmedImage">
                <hr>
                <p>アップロード画像確認</p>
                  <img :src="confirmedImage" />
              </div>

            </div>
            <button type="submit" class="btn btn-primary my-4 store mr-5">保存<i class="fas fa-chevron-right pl-2"></i></button>
            <button type="button" class="btn btn-primary my-4 cancel" @click="cancel">キャンセル</button>
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
        image: {
          isFile: false,
          size: false
        }
      },
      file: '',
      confirmedImage: '',
      size: {
        width: '',
        height: ''
      }
    }
  },
  methods: {
     fileSelected(e) {
      this.errors.image.isFile = false
      this.file = e.target.files[0]

      // jpg, pngのみを許可するバリデーション
      if (this.file.type != 'image/jpeg' && this.file.type != 'image/png') {
        this.errors.image.isFile = true
        return
      }

      // 画像の縦横サイズを取得
      // まずはimagepathを取得
      let image = new Image();
      image.src = URL.createObjectURL(this.file);
      // そのイメージpathをもとに画像サイズを取得
      this.loadImage(image.src)
      .then(res => {
        // console.log(res.width, res.height);
        this.size.width = res.width
        this.size.height = res.height

       // 縦横サイズを取得できたので、縦横サイズそれぞれ700px以内にするバリデーション
        this.errors.image.size = false
        console.log(this.size.width);
        if(this.size.width > 700 || this.size.height > 700) {
          this.errors.image.size = true
        }
      })
      .catch(e => {
        console.log('onload error', e);
      });
      // アップロード画像の読み込み
      this.createImage(this.file);
    },
    createImage(file) {
       // プレビュー画像を表示
        let reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = e => {
            this.confirmedImage = e.target.result;
        };
        reader.src = URL.createObjectURL(file)
    },
    loadImage(src) {
      return new Promise((resolve, reject) => {
        const img = new Image();
        img.onload = () => resolve(img);
        img.onerror = (e) => reject(e);
        img.src = src;
      });
    },
    upload() {
      // エラーが残ってないかチェック
      if(this.errors.image.isFile || this.errors.image.size )
      {
        return
      }
      console.log('アップロード！');
    },
    cancel() {
      this.$router.go(-1)
    }
  },

}
</script>

<style scoped>
.title h4 {
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
textarea {
  height: 100px;
}
.creater_image img {
  height: 120px;
}
</style>


