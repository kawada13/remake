<template>
  <div>
    <!-- ローディング中 -->
    <div class="my-5" v-if="loading">
      <Loader />
    </div>


    <div class="card mt-2" v-if="!loading">
        <h3 class="card-header">
          募集一覧
        </h3>

        <div class="no_user my-4 text-center" v-if="!recruitments.length">
          <p>現在作成している募集はありません。</p>
        </div>

       <ul class="list-group list-group-flush follows">
          <li class="list-group-item" v-for="(recruitment, i) in recruitments" :key="i">

            <div>
              <h5>{{recruitment.title}}</h5>
              <h6 class="mb-2 text-muted">作成日時：{{recruitment.created_at | fromiso}}</h6>
            </div>
            <div class="edit_delete">
               <i class="fas fa-edit mr-3"></i>
               <i class="fas fa-trash-alt" @click="deleteRecruitment(recruitment.id)"></i>
            </div>

          </li>
        </ul>

        <div class="text-center">
          <button type="submit" class="btn btn-primary my-4 store mr-5" @click="$router.push({ name: 'recruitment_create'})">募集を作成</button>
        </div>

    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      loading :false,
      recruitments: [],
      options: { //トーストオプション
          duration: 1500,
          type: 'success'
      },
    }
  },
  methods: {
    async deleteRecruitment(id) {

      let conf = confirm('本当に削除しますか？');

       if(conf) {
          try {
            this.loading = true
            await this.$store.dispatch('recruitment/delete', id)
          }
          catch(e){
            console.log(e);
            this.loading = false
          }
          finally{
            this.toasted();
            this.getRecruitmentsData()
            this.loading = false
          }
       }else {
         return
       }

    },
    async getRecruitmentsData() {
      try{
        this.loading = true
        await this.$store.dispatch('recruitment/loginuUserIndex')
        this.recruitments = this.$store.state.recruitment.loginUserRecruitments
      }
      catch(e){
        this.loading = false
        console.log(e);
      }
      finally{
        this.loading = false
      }
    },
    toasted(){
      this.$toasted.show('削除しました', this.options);
    }
  },
  created() {
    Promise.all([
      this.getRecruitmentsData(),
    ])
  },

}
</script>

<style scoped>

.store{
  color: white;
  font-weight: bold;
  padding: 12px 30px;
  border-radius: 20px;
}
.edit_delete:hover{
  cursor: pointer;
}

@media screen and (max-width:767px) {
    /*画面サイズが767px以下の場合読み込む（スマホ）*/

    h3 {
      font-weight: bold;
      font-size: 20px;
    }

}
@media screen and (min-width:768px){
    /*画面サイズが768px以上の場合読み込む（PC）*/

    h3 {
      font-weight: bold;
    }
}
</style>