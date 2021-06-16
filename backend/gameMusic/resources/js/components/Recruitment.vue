<template>
<div>
  <div class="new-audio">
    <div class="container">

      <div class="content-top-title">
        <h1>募集一覧</h1>
      </div>

      <div class="my-5" v-if="loading">
        <Loader />
      </div>

      <div class="mt-5" v-if="!loading">
        <div class="card-deck row">
          <div class="col-sm-4" v-for="(recruitment, i) in recruitments" :key="i">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title" >{{ recruitment.title }}</h5>
                <p class="card-text"><small class="text-muted">ユーザー名：{{recruitment.user.name}}</small></p>
                <p class="card-text"><small class="text-muted">作成日時：{{recruitment.created_at | fromiso}}</small></p>
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="button mt-5">
        <button 
          type="button" 
          class="btn btn-primary"
          @click="$router.push({ name: 'audio-index' })"
          >もっと見る</button>
      </div>
    </div>
  </div>
</div>
</template>

<script>
export default {
  data() {
    return {
      loading: false,
      recruitments: []
    }
  },
  methods: {
    async getRecruitmentsDatas() {
      try{
        this.loading = true
        await this.$store.dispatch('recruitment/topindex')
        this.recruitments = this.$store.state.recruitment.topRecruitments;
      }
      catch(e){
        this.loading = false
        // console.log(e);
      }
      finally{
        this.loading = false
      }
    }
  },
  created() {
    Promise.all([
      this.getRecruitmentsDatas(),
    ])
  },

}
</script>

<style scoped>
.new-audio {
  height: auto;
  background: #F6F6F4;
}
.content-top-title {
  text-align: center;
  margin-top: 60px;
}
.content-top-title h1{
  font-weight: bold;
  color: #566985;
}
audio {
  display: block;
}
.card {
  overflow: hidden;
  width: 100%;
}
.card .card-title {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.card .card-title:hover {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    text-decoration: underline;
    cursor: pointer;
}
.button {
  text-align: center;
}
.button .btn{
  color: white;
  font-weight: bold;
  padding: 12px 40px;
  border-radius: 20px;
}
.card-text {
  margin-bottom: 0;
}
</style>