<template>
  <div class="sticky-top">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark p-2">
      <a class="navbar-brand header-logo" @click="$router.push({ name: 'home' })">Site Logo</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
        <div class="navbar-nav navlink">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-if="isAuth">
              <i class="fas fa-user-alt text-white"></i>
            </a>
            <div class="dropdown-menu " aria-labelledby="navbarDropdown">
              <a class="dropdown-item" @click="$router.push({ name: 'profile' })">マイページ</a>
              <a class="dropdown-item" @click="logout()">ログアウト</a>
            </div>
          </li>
          <a class="nav-item nav-link text-white" @click="$router.push({ name: 'favorite-audios' })" v-if="isAuth"><i class="far fa-star text-white mr-2"></i>お気に入り</a>
          <a class="nav-item nav-link text-white" @click="$router.push({ name: 'audio-create' })" v-if="isAuth"><i class="fas fa-music mr-2 text-white"></i>出品する</a>
          <a class="nav-item nav-link text-white" @click="$router.push({ name: 'register' })" v-if="isGuest">会員登録</a>
          <a class="nav-item nav-link text-white" @click="$router.push({ name: 'login' })" v-if="isGuest">ログイン</a>
          <a class="nav-item nav-link text-white" @click="guestLogin()" v-if="isGuest">ゲストユーザーログイン</a>
          <a class="nav-item nav-link text-white admin" v-if="isAdmin" @click="$router.push({ name: 'withdrawal' })">管理者ページ</a>
          <a class="nav-item nav-link text-white" @click="logout()" v-if="isAdmin">ログアウト</a>
        </div>
      </div>
    </nav>
  </div>
</template>


<script>
export default {
  data() {
    return {
      options: {
          duration: 1500,
          type: 'info'
      }
    }
  },
  methods: {
    async logout() {
      try{
        await this.$store.dispatch('auth/logout')
      }
      catch(e) {
        console.log(e);
      }
      finally{
        // トースト表示
        this.$router.go({path: this.$router.currentRoute.path, force: true})
        this.toasted()
      }
    },
    async guestLogin() {
     // サンクタム処理
       await axios.get('/sanctum/csrf-cookie')

      //  ログイン処理
       axios.post('/api/login', {
          email: 'guest@gmail.com',
          password: 'guestuser',
        })
        .then(response => {

            // ローカルストレージにログイン状態かどうかを保存
            localStorage.setItem("auth", "true");

            // storeにもログイン状態を保存
            this.$store.dispatch('auth/SET_IS_AUTH', true)

            // storeにユーザーデータを保存
            this.$store.dispatch('auth/setUser', response.data.user)


            // 最後にリダイレクト
            this.$router.push("/");

            // トースト表示
            this.guesttoasted();

            this.$router.go({path: this.$router.currentRoute.path, force: true})

          }
        )
        .catch(error => {
          // storeにもログイン状態を保存
          this.$store.dispatch('auth/SET_IS_AUTH', false)

          // storeにユーザーデータを保存
          this.$store.dispatch('auth/setUser', null)


          // アラート
          alert('ログインに失敗しました。');
        })

    },
    toasted() {
      this.$toasted.show('ログアウトしました', this.options);
    },
    guesttoasted() {
      this.$toasted.show('ゲストユーザーとしてログインしました。', this.options);
    },
  },
  computed: {
    isAuth() {
      if(localStorage.getItem("auth")) {
        return true
      } else {
        return false
      }
    },
    isAdmin() {
      if(localStorage.getItem("admin")) {
        return true
      } else {
        return false
      }
    },
    isGuest() {
      if(!localStorage.getItem("admin") && !localStorage.getItem("auth")) {
        return true
      } else {
        return false
      }
    },
  },
  created() {
  },

}


</script>


<style scoped>
.header-logo {
  font-size: 38px;
  cursor: pointer;
}
.navlink {
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
}
</style>
