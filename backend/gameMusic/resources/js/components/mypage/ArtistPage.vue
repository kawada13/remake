<template>
  <div class="artist_mypage">
    <div class="container">
      <div class="row my-3">

        <!-- (左側) -->
        <div class="col-sm-3 col-xs-12">
          <div class="artist_image d-flex justify-content-center mb-3">
            <img src="/images/498467_s.jpg" class="rounded-circle">
          </div>
          <h3>Artist Name</h3>
          <div class="card my-3">
            <ul class="list-group list-group-flush listing">
              <li class="list-group-item">出品する<i class="fas fa-chevron-right pl-2"></i></li>
            </ul>
          </div>
          <div class="card">
            <ul class="list-group list-group-flush accout_setting">
              <li class="list-group-item">アーティスト情報設定</li>
              <li class="list-group-item">振込口座設定</li>
              <li class="list-group-item">Vestibulum at eros</li>
            </ul>
          </div>
        </div>

        <!-- (右側) -->
        <div class="col-sm-9 col-xs-12">
          <h2 class="search_result_title">検索結果：<span class="text-primary">全オーディオ一覧</span></h2>
          <hr>
          <p class="search_result_text">検索に一致するオーディオがOO件ありました。</p>

          <div class="mt-5">
            <div class="card-deck row">
              <div class="col-sm-6">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title" @click="$router.push({ name: 'audio-show' })">fsdfsd</h5>
                    <audio controls controlslist="nodownload">
                      <source>
                    </audio>
                    <p class="card-text"><small class="text-muted">fsdfsd</small></p>
                  </div>
                </div>
              </div>
            </div>
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


@media screen and (max-width:767px) {
    /*画面サイズが767px以下の場合読み込む（スマホ）*/

    .listing i {
      margin-left: 209px;
    }

}
@media screen and (min-width:768px){
    /*画面サイズが768px以上の場合読み込む（PC）*/

    .listing i {
      margin-left: 148px;
    }
}

</style>