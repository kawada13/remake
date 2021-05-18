<template>
  <div class="new-audio">

    <div class="container">
      <div class="content-top-title">
        <h1>ログイン</h1>
      </div>

    <div class="form_register d-flex justify-content-center my-5">
      <div class="card" style="width: 24rem;">
        <div class="card-body">
          <form @submit.prevent="login">
            <div class="form-group">
              <div class="alert alert-danger mt-2" role="alert" v-if="errors.isLogin">
                登録したメールアドレスまたはパスワードが間違っています！
              </div>
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
            <button type="submit" class="btn btn-primary my-4">ログインする</button>
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
        email: {
          required: false,
        },
        password: {
          required: false,
          size: false,
        },
        isLogin: false
      },
      form: {
        email: '',
        password: '',
      }
    }
  },
  methods: {
    async login() {

      // auth処理だけはstoreを使わずAPI通信をする。
      // ⇨エラーメッセージ表示をうまく表示させるため。

      // フォームバリデーション
      await this.validate();
      if(this.errors.email.required || this.errors.password.required || this.errors.password.size)
      {
        return
      }

      // サンクタム処理
       await axios.get('/sanctum/csrf-cookie')

      //  ログイン処理
       axios.post('/api/login', {
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
          this.errors.isLogin = false

          // 最後にリダイレクト
          this.$router.push("/");
        })
        .catch(error => {
          // storeにもログイン状態を保存
          this.$store.dispatch('auth/SET_IS_AUTH', false)

          // storeにユーザーデータを保存
          this.$store.dispatch('auth/setUser', null)

          // エラーメッセージ表示
          this.errors.isLogin = true

          // アラート
          alert('ログインに失敗しました。');
        });



    },
    validate() {
      
      // 初期化
      this.errors = {
        email: {
          required: false,
        },
        password: {
          required: false,
          size: false,
        },
        isLogin: false
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