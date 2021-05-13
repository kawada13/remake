<template>
  <div class="artist_mypage">
    <div class="container">
      <div class="row my-3">

        <!-- 検索(左側) -->
        <div class="col-sm-3 col-xs-12">
          <div class="card">
            <div class="card-body">
              <input type="text" class="form-control py-4" placeholder="キーワードを入力してください">
              <select class="custom-select select-music mt-3" id="inputGroupSelect">
                <option></option>
              </select>
              <select class="custom-select mt-3" id="inputGroupSelect">
                <option selected>イメージ</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
              </select>
              <div class="buttn mt-4">
                <button class="btn btn-primary" type="submit">検索する</button>
              </div>
            </div>
          </div>
        </div>

        <!-- 検索結果一覧(右側) -->
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

</style>