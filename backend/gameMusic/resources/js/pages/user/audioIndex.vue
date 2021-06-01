<template>
<div>


  <!-- ローディング中 -->
  <div class="my-5" v-if="loading">
    <Loader />
  </div>


  <div v-if="!loading">
    <div class="profile_title mb-4" v-if="!userloading">
        <h2>{{user.user.name}}さんの作品一覧</h2>
    </div>
      <!-- 作品一覧 -->
      <div class="card mt-2">
        <div class="card-header">
          オーディオ一覧
        </div>
        <div class="audios ml-4 my-3" v-for="(audio,i) in getItems" :key="i">
          <h4 class="audio_title" @click="$router.push({ name: 'audio-show', params: { id: `${audio.id}` } })">{{ audio.title }}</h4>
          <audio controls controlslist="nodownload" class="my-3">
            <source :src="audio.sample_audio_file">
          </audio>
          <p class="card-text"><small class="text-muted creater_name" @click="$router.push({ name: 'user-show', params: { id: `${audio.user.id}` }})">{{audio.user.name}}</small></p>
          <p>
            <a class="btn btn-outline-primary" v-if="isFavorite">この曲をお気に入りに登録</a>
            <a class="btn btn-outline-primary" v-if="isFavorite">お気に入り解除</a>
          </p>
        </div>

        <!-- ページネーション -->
        <div class="pagination mt-5 d-flex justify-content-center">
            <div v-if="paginateData.audios.length">
              <paginate
              :page-count="getPageCount"
              :page-range="3"
              :margin-pages="2"
              :click-handler="clickCallback"
              :prev-text="'＜'"
              :next-text="'＞'"
              :containerClass="'pagination'"
              :page-class="'page-item'"
              :page-link-class="'page-link'"
              :prev-class="'page-item'"
              :prev-link-class="'page-link'"
              :next-class="'page-item'"
              :next-link-class="'page-link'"
              >
              </paginate>
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
      userloading: false,
      loading: false,
      paginateData: {
        audios: [],
        parPage: 2, //1ページに表示する件数
        currentPage: 1
      },
      user: {}
    }
  },
  computed: {
    getItems() { //ページネーション用(1ページに表示する数)
        let current = this.paginateData.currentPage * this.paginateData.parPage;
        let start = current - this.paginateData.parPage;
        return this.paginateData.audios.slice(start, current);
    },
    getPageCount() {// ページネーション用(全体のページ数)
        return Math.ceil(this.paginateData.audios.length / this.paginateData.parPage);
    },
    isFavorite() {
      // そもそもログインしていなければ
      if(!this.user.authId) {
        return false
      }
        return true
    }
  },
  methods: {
    clickCallback(pageNum) { //ページネーション用
      this.paginateData.currentPage = Number(pageNum);
    },
    async getAudioDatas() {
      try{
        this.loading = true
        await this.$store.dispatch('audio/getAudios', this.$route.params.id)
        this.paginateData.audios = this.$store.state.audio.user_audios
      }
      catch(e){
        // console.log(e);
        this.loading = false
      }
      finally{
        this.loading = false
      }
    },
    async getUserData() {
      try{
        this.userloading = true
        await this.$store.dispatch('user/getUserShow', this.$route.params.id)
        this.user = this.$store.state.user.user
      }
      catch(e){
        // console.log(e);
        this.userloading = false
      }
      finally{
        this.userloading = false
      }
    }
  },
  created() {
    Promise.all([
      this.getAudioDatas(),
      this.getUserData(),
    ])
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