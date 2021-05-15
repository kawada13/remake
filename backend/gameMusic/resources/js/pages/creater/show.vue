<template>
  <div class="container">
      <div class="row my-3">

        <!-- 左側 -->
        <div class="col-sm-3 col-xs-12">
          <div class="creater_image d-flex justify-content-start mb-3">
            <img src="/images/498467_s.jpg" class="rounded-circle">
          </div>

          <h3>Creater Name</h3>
          <a class="btn btn-outline-primary mt-2">このアーティストをフォロー</a>
        </div>



        <!-- 右側 -->
        <div class="col-sm-9 col-xs-12 right">

          <div class="profile_title">
            <h2>Creater Nameさんのプロフィール</h2>
          </div>

          <!-- 自己紹介 -->
          <div class="card mt-5">
            <div class="card-header">
              自己紹介
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item" v-html="introduce" style="white-space: pre-wrap; word-wrap:break-word; line-height:1.7"></li>
            </ul>
          </div>

          <!-- 使用機材 -->
          <div class="card mt-2">
            <div class="card-header">
              使用機材
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item" v-html="instrument" style="white-space: pre-wrap; word-wrap:break-word; line-height:1.7"></li>
            </ul>
          </div>

          <!-- 新着オーディオ -->
          <div class="card mt-2">
            <div class="card-header">
              新着オーディオ
            </div>
            <div class="audios ml-4 my-3" v-for="(audio,i) in audios" :key="i">
              <h4>{{ audio.title }}</h4>
              <audio controls controlslist="nodownload" class="my-3">
                <source :src="audio.sound">
              </audio>
                <p>
                  <a class="btn btn-outline-primary">この曲をお気に入りに登録</a>
                </p>
            </div>

            <div class="button my-3 more">
              <button 
                type="button" 
                class="btn btn-primary"
                >
                <i class="fas fa-arrow-right mr-2"></i>
                このクリエイターの作品をもっと見る</button>
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
      introduce:`株式会社テックミーのCTOを務めております。
フロントエンドとバックエンド、どちらも実務経験があります。特にLaravelやVue.jsでの開発を得意としています。

また、WordPressでのWeb制作も経験してきましたので、HTML/CSSコーディングや、WordPressオリジナルテーマ構築といった分野でもお役に立てます。

あと、得意分野というわけではありませんが、linuxやAWSに関してもある程度知見がありますので、お役に立てるかもしれません。`,
      instrument:`DAW：Studio One 4 Professional
オーディオインターフェイス：UNIVERSAL AUDIO APOLLO TWIN MKII QUAD
`,
      audios:[
        {
          sound: '/images/Closed_Case.mp3',
          title: '生演奏！アコースティックギターのポップス',
          artist: 'rokedt1',
          price: 4000
        },
        {
          sound: '/images/Closed_Case.mp3',
          title: '生演奏！アコースティックギターのポップス',
          artist: 'rokedt1',
          price: 4000
        },
        {
          sound: '/images/Closed_Case.mp3',
          title: '生演奏！アコースティックギターのポップス',
          artist: 'rokedt1',
          price: 4000
        },
      ]

    }
  },

}
</script>

<style scoped>
.creater_image img {
  height: 144px;
}

.profile_title h2 {
  font-weight: bold;
}

.more {
  text-align: center;
}
.more .btn{
  color: white;
  font-weight: bold;
  padding: 12px 40px;
  border-radius: 20px;
}

</style>