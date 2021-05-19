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
              <a class="dropdown-item" @click="$router.push({ name: 'purchase-history' })">マイページ</a>
              <a class="dropdown-item" @click="logout()">ログアウト</a>
            </div>
          </li>
          <a class="nav-item nav-link text-white" @click="$router.push({ name: 'favorite-audios' })" v-if="isAuth"><i class="far fa-star text-white mr-2"></i>お気に入り</a>
          <a class="nav-item nav-link text-white" @click="$router.push({ name: 'audio-create' })" v-if="isAuth"><i class="fas fa-music mr-2 text-white"></i>出品する</a>
          <a class="nav-item nav-link text-white" @click="$router.push({ name: 'register' })" v-if="!isAuth">会員登録</a>
          <a class="nav-item nav-link text-white" @click="$router.push({ name: 'login' })" v-if="!isAuth">ログイン</a>
        </div>
      </div>
    </nav>
  </div>
</template>


<script>
export default {
  data() {
    return {
    }
  },
  methods: {
    async logout() {
      await this.$store.dispatch('auth/logout')
    },
  },
  computed: {
    isAuth() {
      // リロード対策
      if(this.$store.state.auth.isAuth || localStorage.getItem("auth"))
      {
        return true
      }
    }
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
