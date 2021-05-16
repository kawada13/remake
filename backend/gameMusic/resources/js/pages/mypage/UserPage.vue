<template>
  <div class="artist_mypage">
    <div class="container">
      <div class="row my-3">

        <!-- (左側) -->
        <div class="col-sm-3 col-xs-12">

          <!-- アイコン -->
          <div class="artist_image d-flex justify-content-center mb-3">
            <img src="/images/498467_s.jpg" class="rounded-circle">
          </div>

          <!-- ユーザー名 -->
          <h3>User Name</h3>

          <!-- いろんな選択肢 -->
          <div class="card my-3">
            <ul class="list-group list-group-flush accout_setting">
              <li class="list-group-item" @click="$router.push({ name: 'purchase-history'})">購入作品</li>
              <li class="list-group-item" @click="$router.push({ name: 'favorite-audios'})">お気に入り作品一覧</li>
              <li class="list-group-item" @click="$router.push({ name: 'follows'})">フォローしているクリエイター</li>
              <li class="list-group-item">購入者情報設定</li>
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
  data() {
    return {
    }
  },
  computed: {
  },

}
</script>

<style scoped>
.artist_mypage {
  height: auto;
  background: #F6F6F4;
}
.artist_image img {
  height: 160px;
  cursor: pointer;
}

.accout_setting li:hover {
  cursor: pointer;
  color: #58BDF0;
}
h3 {
  text-align: center;
}
.border_s {
  text-align: center;
}



@media screen and (max-width:767px) {
    /*画面サイズが767px以下の場合読み込む（スマホ）*/


}
@media screen and (min-width:768px){
    /*画面サイズが768px以上の場合読み込む（PC）*/

}

</style>