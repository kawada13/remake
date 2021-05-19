<template>
  <div>
    <div class="profile_title mb-4">
        <h2>Creater Nameさんの作品一覧</h2>
    </div>

      <!-- 作品一覧 -->
      <div class="card mt-2">
        <div class="card-header">
          新着オーディオ
        </div>
        <div class="audios ml-4 my-3" v-for="(audio,i) in audios" :key="i">
          <h4 class="audio_title" @click="$router.push({ name: 'audio-show', params: { id: `${audio.id}` } })">{{ audio.title }}</h4>
          <audio controls controlslist="nodownload" class="my-3">
            <source :src="audio.sound">
          </audio>
          <p class="card-text"><small class="text-muted creater_name" @click="$router.push({ name: 'user-show', params: { id: `${audio.id}` }})">{{audio.artist}}</small></p>
          <p>
            <a class="btn btn-outline-primary">この曲をお気に入りに登録</a>
          </p>
        </div>

        <!-- ページネーション -->
        <div class="my-3 d-flex justify-content-center">
          <nav aria-label="Page navigation example">
            <ul class="pagination">
              <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                  <span class="sr-only">Previous</span>
                </a>
              </li>
              <li class="page-item"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                  <span class="sr-only">Next</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
      
  </div>
</template>

<script>
export default {
  data() {
    return {
      audios:[
        {
          id: 1,
          sound: '/images/Closed_Case.mp3',
          title: '生演奏！アコースティックギターのポップス',
          artist: 'rokedt1',
          price: 4000
        },
        {
          id: 2,
          sound: '/images/Closed_Case.mp3',
          title: '生演奏！アコースティックギターのポップス',
          artist: 'rokedt1',
          price: 4000
        },
        {
          id: 3,
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
.audios .audio_title:hover {
  cursor: pointer;
  text-decoration: underline;
}
.audios .creater_name:hover {
  cursor: pointer;
  text-decoration: underline;
}

audio {
  margin-bottom: 0!important;
}



@media screen and (max-width:767px) {
    /*画面サイズが767px以下の場合読み込む（スマホ）*/

    .profile_title h2 {
      font-size: 26px;
      font-weight: bold;
    }


}
@media screen and (min-width:768px){
    /*画面サイズが768px以上の場合読み込む（PC）*/

    .profile_title h2 {
      font-weight: bold;
    }

}


</style>