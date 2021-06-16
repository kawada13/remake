<template>
  <div class="container mt-5">

    <div class="text-center" v-if="!loading">
      <h2 class="recruitment_title">募集一覧</h2>
      <hr>
      <p class="recruitment_text">募集全{{paginateData.recruitments.length}}件。</p>
    </div>

    <div class="my-5" v-if="loading">
      <Loader />
    </div>

    <div class="mt-5" v-if="!loading">
      <div class="card-deck row">
        <div class="col-sm-6" v-for="(recruitment, i) in getItems" :key="i">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title" @click="$router.push({ name: 'recruitment_show', params: { id: `${recruitment.id}` }})">{{ recruitment.title }}</h5>
              <p class="card-text user_name"><small class="text-muted" @click="$router.push({ name: 'user-show', params: { id: `${recruitment.user_id}` }})">ユーザー名：{{recruitment.user.name}}</small></p>
              <p class="card-text"><small class="text-muted">作成日時：{{recruitment.created_at | fromiso}}</small></p>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- ページネーション -->
    <div class="pagination mt-5 d-flex justify-content-center">
      <div v-if="paginateData.recruitments.length">
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
</template>

<script>
export default {
  data() {
    return {
      loading: false,
      paginateData: {
        recruitments: [],
        parPage: 10, //1ページに表示する件数
        currentPage: 1
      },
    }
  },
  computed: {
    getItems() { //ページネーション用(1ページに表示する数)
        let current = this.paginateData.currentPage * this.paginateData.parPage;
        let start = current - this.paginateData.parPage;
        return this.paginateData.recruitments.slice(start, current);
    },
    getPageCount() {// ページネーション用(全体のページ数)
        return Math.ceil(this.paginateData.recruitments.length / this.paginateData.parPage);
    },
  },
  methods: {
    clickCallback(pageNum) { //ページネーション用
      this.paginateData.currentPage = Number(pageNum);
    },
    async getRecruitmentsData() {
      try{
        this.loading = true
        await this.$store.dispatch('recruitment/index')
        this.paginateData.recruitments = this.$store.state.recruitment.recruitments
      }
      catch(e){
        this.loading = false
        console.log(e);
      }
      finally{
        this.loading = false
      }
    },
  },
  created() {
    Promise.all([
      this.getRecruitmentsData(),
    ])
  },

}
</script>

<style scoped>



.recruitment_text {
  font-weight: 700;
  font-size: 14px;
}

.user_name {
  cursor: pointer;
}
.user_name:hover {
  text-decoration: underline;
}

.card-title:hover {
  cursor: pointer;
  text-decoration: underline;
}


@media screen and (max-width:767px) {
    /*画面サイズが767px以下の場合読み込む（スマホ）*/

    .recruitment_title {
      font-weight: 700;
      font-size: 24px;
      color: #3490dc;
    }

}
@media screen and (min-width:768px){
    /*画面サイズが768px以上の場合読み込む（PC）*/

    .recruitment_title {
      font-weight: 700;
      font-size: 28px;
      color: #3490dc;
    }

}


</style>