<template>
  <div class="">
    <div class="title">
      <h3>募集を編集する</h3>
    </div>


    <div class="form_creater_edit my-5">
      <div class="card">
        <div class="card-body">
          <form @submit.prevent="update">

            <div class="form-group">
              <div><label for="title" class="recruitment_title">タイトル<span class="badge badge-danger ml-2">必須</span></label></div>
              <input type="text" class="form-control form-control-lg" id="title" v-model="form.title">
              <div class="alert alert-danger mt-2" role="alert" v-if="errors.title.required">
                入力は必須です！
              </div>
            </div>

            <div class="form-group">
              <div><label for="content" class="recruitment_title">募集内容<span class="badge badge-danger ml-2">必須</span></label></div>
              <small class="form-text text-muted explain">欲しい楽曲内容を具体的に書いてみましょう。</small>
              <textarea class="form-control mt-3" id="exampleFormControlTextarea1" rows="10" v-model="form.content"  placeholder="戦闘シーンで使う効果音が欲しいです。予算は2,000~6,000円くらいで考えています。"></textarea>
              <div class="alert alert-danger mt-2" role="alert" v-if="errors.content.required">
                入力は必須です！
              </div>
            </div>

            <div class="text-center">
              <button type="submit" class="btn btn-primary my-4 store mr-5">保存する</button>
            </div>

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
      loading: false,
      errors: {
        title: {
          required: false,
        },
        content: {
          required: false,
        },
      },
      form: {
        title: '',
        content: '',
      },
      options: { //トースト用オプション
          duration: 1500,
          type: 'success'
      },
    }
  },
  methods: {
    async update() {
      this.validate();
      // 何か一つでもバリデーションにひっかがっていたらアップデートさせない
      if(this.errors.title.required || this.errors.content.required )
      {
        return
      }
        try {
          this.loading = true
          await this.$store.dispatch('recruitment/store', this.form)
        }
        catch(e){
          console.log(e);
          this.loading = false
        }
        finally{
          this.loading = false
          this.$router.push({ name: 'login_user_recruitments'})
          this.toasted()
        }
    },
    toasted() {
      this.$toasted.show('保存しました', this.options);
    },
    validate() {

      // 一旦初期化
      this.errors = {
        title: {
          required: false,
        },
        content: {
          required: false,
        },
      }

      // 必須チェック
      if (!this.form.title) {
        this.errors.title.required = true
      }
      if (!this.form.content) {
        this.errors.content.required = true
      }

    },
  },
  created() {
    Promise.all([
    ])
  },

}
</script>

<style scoped>
.title h3 {
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
.recruitment_title {
  font-weight: 700;
  font-size: 18px;
}
.explain {
  margin: 0;
}

</style>