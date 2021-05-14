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
            <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-user-alt text-white"></i>
            </a>
            <div class="dropdown-menu " aria-labelledby="navbarDropdown">
              <a class="dropdown-item" @click="$router.push({ name: 'purchase-history' })">マイページ</a>
              <a class="dropdown-item">ログアウト</a>
            </div>
          </li>
          <a class="nav-item nav-link text-white" @click="$router.push({ name: 'register' })">会員登録</a>
          <a class="nav-item nav-link text-white" @click="$router.push({ name: 'login' })">ログイン</a>
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
    a() {
      console.log(12)
    }
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
</style>>
