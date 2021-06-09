<template>
  <div class="container">
    <h2>出金管理</h2>

    <ul id="myTabs" class="nav nav-tabs">
      <li role="presentation" class="active"><a href="#home"  aria-controls="home" role="tab" data-toggle="tab" class="nav-link active">最新ニュース</a></li>
      <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab" class="nav-link">セミナー情報</a></li>
      <li role="presentation"><a href="#message" aria-controls="message" role="tab" data-toggle="tab" class="nav-link">メディア掲載歴</a></li>
    </ul>

    <div class="tab-content p-2 ">

      <div role="tabpanel" class="tab-pane active fade show" id="home">
        <h3>SEO実績更新</h3>
        <p>ウェブストエイトが「ホームページ作成セミナー」でSEO一位を獲得しました。(2017年9月調べ)</p>
      </div>

      <div role="tabpanel" class="tab-pane fade" id="profile">
        <h3>2018年1月のセミナー情報</h3>
        <p>
          2018年1月20日にワードプレスセミナーを開催します。
          <br>
          詳細は下記のページをご覧ください。
        </p>
      </div>

      <div role="tabpanel" class="tab-pane fade" id="message">
        <h3>〇〇新聞に掲載されました</h3>
        <p>
          ウェブストエイトが〇〇新聞に掲載されました。
          <br>
          詳細はこちらをご覧ください。
        </p>
      </div>

    </div>
  </div>

</template>

<script>
export default {

}
</script>

<style>

</style>