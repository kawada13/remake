<template>
  <div class="new-audio">

    <div class="container">
      <div class="content-top-title">
        <h1>ログイン</h1>
      </div>

    <div class="form_register d-flex justify-content-center my-5">
      <div class="card" style="width: 24rem;">
        <div class="card-body">
          <form @submit.prevent="register">
            <div class="form-group">
              <div class="d-flex justify-content-start"><label for="email">メールアドレス</label></div>
              <input type="email" class="form-control form-control-lg" id="email" v-model="email">
              <div class="alert alert-danger mt-2" role="alert" v-if="errors.email.required">
                メールアドレスの入力は必須です！
              </div>
            </div>
            <div class="form-group">
              <div class="d-flex justify-content-start"><label for="password">パスワード</label></div>
              <input type="password" class="form-control form-control-lg" id="passsword" v-model="password">
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
      },
      email: '',
      password: '',
    }
  },
  methods: {
    register() {
      this.validate();
    },
    validate() {
      this.errors = {
        email: {
          required: false,
        },
        password: {
          required: false,
          size: false,
        },
      }

      if (!this.email) {
        this.errors.email.required = true
      }
      if (!this.password) {
        this.errors.password.required = true
      }
      if (this.password.length < 6) {
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