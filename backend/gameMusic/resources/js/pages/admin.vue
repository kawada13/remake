<template>
  <div class="container">


    <div class="mypage">
        <div class="row my-3">

          <!-- (左側) -->
          <div class="col-sm-3 col-xs-12">


            <!-- ユーザー名 -->
            <!-- v-ifをつけたのはレンダリングする順番によって読み込みエラーが出てしまうから -->
            <h3>管理者ページ</h3>

            <!-- いろんな選択肢 -->
            <div class="card my-3">
              <ul class="list-group list-group-flush admin_management">
                <li class="list-group-item" @click="$router.push({ name: 'withdrawal' })">出金管理</li>
                <li class="list-group-item" @click="$router.push({ name: 'users' })">登録ユーザー</li>
                <li class="list-group-item" @click="$router.push({ name: 'audios' })">登録オーディオ</li>
              </ul>
            </div>
          </div>

          <!-- (右側) -->
          <div class="col-sm-9 col-xs-12">
            <div>
              <router-view />
            </div>
          </div>

        </div>
    </div>
    
  </div>
</template>

<script>
export default {

}
</script>

<style scoped>
.admin_management li:hover {
  cursor: pointer;
  color: #58BDF0;
}

</style>