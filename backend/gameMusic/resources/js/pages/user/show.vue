<template>
<div>
   <!-- ローディング中 -->
  <div class="my-5" v-if="loading">
    <Loader />
  </div>
  
  <div v-if="!loading">
    <div class="profile_title">
        <h2>{{user.user.name}}さんのプロフィール</h2>
      </div>

      <!-- 自己紹介 -->
      <div class="card mt-5">
        <div class="card-header">
          自己紹介
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item" v-html="user.user.user_information.introduce" style="white-space: pre-wrap; word-wrap:break-word; line-height:1.7"></li>
        </ul>
      </div>

      <!-- 使用機材 -->
      <div class="card mt-2">
        <div class="card-header">
          使用機材
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item" v-html="user.user.user_information.instrument" style="white-space: pre-wrap; word-wrap:break-word; line-height:1.7"></li>
        </ul>
      </div>

      <!-- 新着オーディオ -->
      <div class="card mt-2">
        <div class="card-header">
          新着オーディオ
        </div>
        <div class="audios ml-4 my-3" v-for="(audio,i) in user.userAudios" :key="i">
          <h4 class="audio_title" @click="$router.push({ name: 'audio-show', params: { id: `${audio.id}` } })">{{ audio.title }}</h4>
          <audio controls controlslist="nodownload" class="my-3">
            <source :src="audio.sample_audio_file">
          </audio>
            <p>
              <a class="btn btn-outline-primary">この曲をお気に入りに登録</a>
            </p>
        </div>

        <div class="button my-3 more">
          <button 
            type="button"
            class="btn btn-primary"
            @click="$router.push({ name: 'user-audios', params: { id: `${$route.params.id}` }})"
            >
            <i class="fas fa-arrow-right mr-2"></i>
            作品をもっと見る</button>
        </div>
      </div>

  </div>
</div>
</template>

<script>
export default {
  data() {
    return {
      loading:false,
      user: {}
    }
  },
  methods: {
    async getUserShowData() {
      try{
        this.loading = true
        await this.$store.dispatch('user/getUserShow', this.$route.params.id)
        this.user = this.$store.state.user.user
      }
      catch(e){
        // console.log(e);
        this.loading = false
      }
      finally{
        this.loading = false
      }
    }
  },
  created() {
    Promise.all([
      this.getUserShowData(),
    ])
  },


}
</script>

<style scoped>

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

.audio_title:hover {
  cursor: pointer;
  text-decoration: underline;
}


@media screen and (max-width:767px) {
    /*画面サイズが767px以下の場合読み込む（スマホ）*/

    .button button {
      font-size: 14px;
    }

}
@media screen and (min-width:768px){
    /*画面サイズが768px以上の場合読み込む（PC）*/

}
</style>