<template>
  <div class="container">

    <!-- ローディング中 -->
    <div class="my-5" v-if="loading">
      <Loader />
    </div>

    <div v-if="!loading">
      <h2>出金管理</h2>

      <ul id="myTabs" class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#home"  aria-controls="home" role="tab" data-toggle="tab" class="nav-link active">出金申請中</a></li>
        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab" class="nav-link">出金済</a></li>
      </ul>

      <div class="tab-content p-2">

        <div role="tabpanel" class="tab-pane active fade show" id="home">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">申請ユーザー</th>
                <th scope="col">申請日時</th>
                <th scope="col">申請金額</th>
                <th scope="col">アクション</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(purchasing, i) in purchasings" :key="i">
                <th scope="row">{{i + 1}}</th>
                <td><a href="">{{purchasing.audio.user.name}}</a></td>
                <td>{{purchasing.withdraw_at | fromiso}}</td>
                <td><i class="fas fa-yen-sign"></i>{{purchasing.price | comma}}</td>
                <td><button type="button" class="btn btn-danger text-white font-weight-bold" @click="payment(purchasing.id)">入金する</button></td>
              </tr>
            </tbody>
          </table>
        </div>

        <div role="tabpanel" class="tab-pane fade" id="profile">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">申請ユーザー</th>
                <th scope="col">申請日時</th>
                <th scope="col">申請金額</th>
                <th scope="col">入金日時</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(purchased, i) in purchaseds" :key="i">
                <th scope="row">{{i + 1}}</th>
                <td><a href="">{{purchased.audio.user.name}}</a></td>
                <td>{{purchased.withdraw_at | fromiso}}</td>
                <td><i class="fas fa-yen-sign"></i>{{purchased.price | comma}}</td>
                <td>{{purchased.updated_at | fromiso}}</td>
              </tr>
            </tbody>
          </table>
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
      purchases: [], //全ての購入履歴データ
      purchasings:[], //申請中の購入履歴データ
      purchaseds:[], //入金済の購入履歴データ
      options: {
          duration: 1500,
          type: 'info'
      }

    }
  },
  methods: {
    async getPurchaseData() {
      try{
        this.loading = true
        await this.$store.dispatch('purchase/getAllPurchase')

        //全ての購入履歴データ
        this.purchases = this.$store.state.purchase.allPurchases

        //申請中の購入履歴データ
        this.purchasings = this.purchases.filter(o => o.status == 1)

        //入金済の購入履歴データ
        this.purchaseds = this.purchases.filter(o => o.status == 2)
      }
      catch(e){
        // console.log(e);
        this.loading = false
      }
      finally{
        this.loading = false
      }
    },
    async payment(id) {
      let res = confirm("「入金済」にステータスを変更してもよろしいですか？");

      if( res == true ) {
        try{
          this.loading = true
          await this.$store.dispatch('purchase/adminPayment', id)
        }
        catch(e){
          // console.log(e);
          this.loading = false
        }
        finally{
          this.loading = false
          this.toasted()
          this.getPurchaseData()
        }
      } else {
        return
      }

    },
    toasted() {
      this.$toasted.show('保存しました。', this.options);
    },
  },
  created() {
    Promise.all([
      this.getPurchaseData(),
    ])
  },

}
</script>

<style>

</style>