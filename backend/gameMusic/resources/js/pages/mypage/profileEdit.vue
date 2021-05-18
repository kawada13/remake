<template>
  <div class="mt-5">
    <div class="title">
      <h4>プロフィール編集</h4>
    </div>


    <div class="form_creater_edit my-5">
      <div class="card">
        <div class="card-body">
          <form @submit.prevent="">
            <div class="form-group">
              <div><label for="creater_name">クリエイター名</label></div>
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
              </label>

              <div class="d-flex justify-content-start"><small class="form-text text-muted">画像は jpg, png 画像のみアップロードできます。</small></div>
              <div class="alert alert-danger" role="alert" v-if="errors.image.isFile">
                画像は jpg, pngファイルのみです!
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
          isFile: false
        }
      },
    }
  },
  methods: {
    fileSelected(e) {
      // jpg, pngのみを許可するバリデーション
      this.errors.image.isFile = false
      if (e.target.files[0].type != 'image/jpeg' && e.target.files[0].type != 'image/png') {
        this.errors.image.isFile = true
      }
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


