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

          <!-- クリエイター名 -->
          <h3>Creater Name</h3>

          <!-- いろんな選択肢 -->
          <div class="card my-3">
            <ul class="list-group list-group-flush listing">
              <li class="list-group-item">出品する<i class="fas fa-chevron-right pl-2"></i></li>
            </ul>
          </div>
          <div class="card">
            <ul class="list-group list-group-flush accout_setting">
              <li class="list-group-item" @click="$router.push({ name: 'exhibited-products' })">出品作品</li>
              <li class="list-group-item" @click="$router.push({ name: 'creater-info-edit' })">クリエイター情報設定</li>
              <li class="list-group-item">振込口座設定</li>
              <li class="list-group-item">Vestibulum at eros</li>
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
  components: {
  },
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
.listing li {
  outline: solid #58BDF0;
}
.listing li:hover {
  cursor: pointer;
  color: #58BDF0;
}
h3 {
  text-align: center;
}
.border_s {
  text-align: center;
}

</style>