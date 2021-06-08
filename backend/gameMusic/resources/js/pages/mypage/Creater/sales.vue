<template>
  <div>
      <!-- ローディング中 -->
    <div class="my-5" v-if="loading">
      <Loader />
    </div>


    <div class="" v-if="!loading">
      <div class="card-group mb-5">
        <div class="card text-center">
          <div class="card-body earnings">
            <h5 class="card-title">売上金額合計</h5>
            <h1><i class="fas fa-yen-sign"></i>{{ earning | comma }}</h1>
          </div>
        </div>
        <div class="card text-center">
          <div class="card-body cumulative">
            <h5 class="card-title">累計の売上金額</h5>
            <h1><i class="fas fa-yen-sign"></i>{{ cumulative | comma }}</h1>
          </div>
        </div>
      </div>


      <div class="card purchase_audio_title">
        <h3 class="card-header">
          売上履歴
        </h3>

        <div class="card-body purchase_audio_body" v-for="(sale, i) in sales" :key="i">
          <h5 class="card-title audio_title" @click="$router.push({ name: 'audio-show' })">{{sale.audio.title}}</h5>
          <h6 class="card-subtitle mb-2 text-muted creater_name" @click="$router.push({ name: 'user-show', params: { id: `${sale.user_id}` }})">購入ユーザー名：{{sale.user.name}}</h6>
          <h6 class="card-subtitle mb-2 text-muted" >日付：{{sale.created_at | fromiso}}</h6>
          <h6 class="card-subtitle mb-2 price font-weight-bold text-danger"><i class="fas fa-yen-sign"></i>{{sale.price | comma}}</h6>
          <div class="application_button">
            <button type="button" class="btn btn-danger text-white" data-toggle="modal" data-target="#exampleModal" v-if="sale.status == 0">
              出勤申請をする
            </button>
            <button type="button" class="btn btn-secondary text-white withdrawn" v-if="sale.status == 1">
              出金済み
            </button>
          </div>


            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="exampleModalLabel">{{sale.audio.title}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body audio_price">
                    金額：<i class="fas fa-yen-sign"></i>{{ sale.price | comma }}
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary text-white" data-dismiss="modal">キャンセル</button>
                    <button type="button" class="btn btn-primary text-white application_btn" data-dismiss="modal" @click="$router.push({ name: 'payout', params: { id: `${sale.audio_id}` }})">申請する</button>
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
  data() {
    return {
      loading: false,
      sales:[]
    }
  },
  computed: {
    cumulative() { //累計金額

      // まずはpriceだけ取り出した配列を作成
      let price = this.sales.map(o => o.price)
      // その中身の合計を出す
      let total = price.reduce((sum, element) => sum + element, 0);
      return total
    },
    earning() { // 売上金額

      // まずはstatusが0(金額を引き出してない)もののみをfilter
      let notWithdraw = this.sales.filter(o => o.status == 0);
      // priceだけ取り出した配列を作成
      let price = notWithdraw.map(o => o.price);
      // その中身の合計を出す
      let total = price.reduce((sum, element) => sum + element, 0);

       return total
    }
  },
  methods: {
    async getSalesData() {
      try{
        this.loading = true
        await this.$store.dispatch('purchase/getSales')
        this.sales = this.$store.state.purchase.sales

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
      this.getSalesData(),
    ])
  },

}
</script>

<style scoped>

.earnings h1 {
  font-weight: bold;
  color: hsla(357, 100%, 37%, 0.979);
}
.cumulative h1 {
  font-weight: bold;
  color: black;
}


.purchase_audio_body .audio_title:hover {
  cursor: pointer;
  text-decoration: underline;
}
.creater_name:hover {
  cursor: pointer;
  text-decoration: underline;
}

.audio_price {
  font-size: 23px;
  color: hsla(357, 100%, 37%, 0.979);
  font-weight: bold;
}
.withdrawn {
  cursor: auto!important;
}

@media screen and (max-width:767px) {
    /*画面サイズが767px以下の場合読み込む（スマホ）*/

    .purchase_audio_title h3 {
      font-weight: bold;
      font-size: 20px;
    }



}
@media screen and (min-width:768px){
    /*画面サイズが768px以上の場合読み込む（PC）*/

    .purchase_audio_title h3 {
      font-weight: bold;
    }

}


</style>