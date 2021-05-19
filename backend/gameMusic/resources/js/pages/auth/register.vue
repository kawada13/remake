<template>
  <div class="new-audio">

    <div class="container">

      <div class="content-top-title">
        <h1>新規登録</h1>
      </div>

      <div class="form_register d-flex justify-content-center my-5">
        <div class="card" style="width: 24rem;">
          <div class="card-body">
            <form @submit.prevent="register">
              <div class="form-group">
                <div class="alert alert-danger mt-2" role="alert" v-if="errors.email.isSame">
                  そのメールアドレスはすでに登録済です！
                </div>
                <div class="d-flex justify-content-start"><label for="name">お名前</label></div>
                <input type="text" class="form-control form-control-lg" id="name" v-model="form.name">
                <div class="d-flex justify-content-start"><small class="form-text text-muted">登録後変更可能です。</small></div>
                <div class="alert alert-danger mt-2" role="alert" v-if="errors.name.required">
                  お名前の入力は必須です！
                </div>
              </div>
              <div class="form-group">
                <div class="d-flex justify-content-start"><label for="email">メールアドレス</label></div>
                <input type="email" class="form-control form-control-lg" id="email" v-model="form.email">
                <div class="alert alert-danger mt-2" role="alert" v-if="errors.email.required">
                  メールアドレスの入力は必須です！
                </div>
              </div>
              <div class="form-group">
                <div class="d-flex justify-content-start"><label for="password">パスワード</label></div>
                <input type="password" class="form-control form-control-lg" id="passsword" v-model="form.password">
                <div class="d-flex justify-content-start"><small class="form-text text-muted">6文字以上で入力してください。</small></div>
                <div class="alert alert-danger mt-2" role="alert" v-if="errors.password.required">
                  パスワードの入力は必須です！
                </div>
                <div class="alert alert-danger mt-2" role="alert" v-if="errors.password.size">
                  6文字以上を指定してください！
                </div>
              </div>
              <button type="submit" class="btn btn-primary my-4">登録する</button>
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
      errors: {
        name: {
          required: false,
        },
        email: {
          required: false,
          isSame: false
        },
        password: {
          required: false,
          size: false,
        },
      },
      form: {
        name: '',
        email: '',
        password: '',
      }
    }
  },
  methods: {
    async register() {
      await this.validate();
      if(this.errors.name.required || this.errors.email.required || this.errors.password.required || this.errors.password.size)
      {
        return
      }

      // サンクタム処理
       await axios.get('/sanctum/csrf-cookie')

      //  登録処理
       axios.post('/api/register', {
          name: this.form.name,
          email: this.form.email,
          password: this.form.password,
        })
        .then(response => {
          // ローカルストレージにログイン状態かどうかを保存
          localStorage.setItem("auth", "true");

          // storeにもログイン状態を保存
          this.$store.dispatch('auth/SET_IS_AUTH', true)

          // storeにユーザーデータを保存
          this.$store.dispatch('auth/setUser', response.data.user)

          // エラーメッセージ非表示
          this.errors.email.isSame = false

          // ヘッダーの表示を変えるためにサイレンダリング
          // this.$router.go({path: this.$router.currentRoute.path, force: true})

          // 最後にリダイレクト
          this.$router.push("/");
        })
        .catch(error => {
          // storeにもログイン状態を保存
          this.$store.dispatch('auth/SET_IS_AUTH', false)

          // storeにユーザーデータを保存
          this.$store.dispatch('auth/setUser', null)

          // エラーメッセージ表示
          this.errors.email.isSame = true

          // アラート
          alert('新規登録に失敗しました。');
        });

    },
    validate() {
      // 初期化
      this.errors = {
        name: {
          required: false,
        },
        email: {
          required: false,
          isSame: false
        },
        password: {
          required: false,
          size: false,
        },
      }

      if (!this.form.name) {
        this.errors.name.required = true
      }
      if (!this.form.email) {
        this.errors.email.required = true
      }
      if (!this.form.password) {
        this.errors.password.required = true
      }
      if (this.form.password.length < 6) {
        this.errors.password.size = true
      }

    }
  },

}
</script>

<style scoped>
.new-audio {
  height: 1151px;
  background: #F6F6F4;
}

.content-top-title h1{
  font-weight: bold;
  color: #566985;
}
.card {
  text-align: center;
}
button{
  color: white;
  font-weight: bold;
  padding: 12px 40px;
  border-radius: 20px;
}

@media screen and (max-width:767px) {
    /*画面サイズが767px以下の場合読み込む（スマホ）*/

    .content-top-title {
      text-align: center;
      margin-top: 60px;
    }
    .content-top-title h1{
      font-size: 27px;
    }
}
@media screen and (min-width:768px){
    /*画面サイズが768px以上の場合読み込む（PC）*/

    .content-top-title {
      text-align: center;
      margin-top: 60px;
    }
}
</style>