<template>
  <div class="container">

     <!-- ローディング中 -->
    <div class="my-5" v-if="loading">
      <Loader />
    </div>


    <div class="card mt-2" v-if="!loading">
        <h3 class="card-header">
          登録オーディオ
        </h3>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">タイトル</th>
              <th scope="col">作成者</th>
              <th scope="col">登録日時</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(audio, i) in audios" :key="i">
              <th scope="row">{{i + 1}}</th>
              <td><a href @click="$router.push({ name: 'usershow', params: { id: `${audio.id}` }})">{{ audio.title }}</a></td>
              <td><a href @click="$router.push({ name: 'usershow', params: { id: `${audio.user_id}` }})">{{ audio.user.name }}</a></td>
              <td>{{audio.created_at | fromiso}}</td>
            </tr>
          </tbody>
        </table>
    </div>

  </div>
</template>

<script>
export default {
  data() {
    return {
      audios: [],
      loading: false
    }
  },
  methods: {
    async getAudiosData() {
       this.isLogined = false
      try{
        this.loading = true
        await this.$store.dispatch('audio/getAllAudios')
        this.audios = this.$store.state.audio.allAudios

      }
      catch(e){
        // console.log(e);
        this.loading = false
      }
      finally{
        this.loading = false
      }
    },
  },

  created() {
    Promise.all([
      this.getAudiosData(),
    ])
  },

}
</script>

<style>

</style>