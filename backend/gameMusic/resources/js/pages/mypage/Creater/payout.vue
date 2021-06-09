<template>
  <div class="container">

    <!-- ローディング中 -->
    <div class="my-5" v-if="loading">
      <Loader />
    </div>

    <div v-if="!loading">

      <div class="header mt-3">
        <h3 class="font-weight-bold">振込申請</h3>
      </div>

      <div class="transfer_account_information my-4">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title font-weight-bold text-primary">振込先口座</h4>

            <div class="button text-center mt-4" v-if="!transferAccount.id">
              <p>振込申請には、振込口座設定をお願いします。</p>
              <button type="button" class="btn btn-primary font-weight-bold text-white" @click="$router.push({ name: 'transfer-account-setting' })">振込先口座を登録</button>
            </div>

            <div class="mt-4" v-if="transferAccount.id">
              <table class="table">
                <tbody>
                  <tr>
                    <th scope="row">銀行名</th>
                    <td>{{transferAccount.bank_name}}</td>
                  </tr>
                  <tr>
                    <th scope="row">支店コード</th>
                    <td>{{transferAccount.bank_code}}</td>
                  </tr>
                  <tr>
                    <th scope="row">口座種別</th>
                    <td>{{transferAccount.deposit_type}}</td>
                  </tr>
                  <tr>
                    <th scope="row">口座番号</th>
                    <td>{{transferAccount.account_number}}</td>
                  </tr>
                  <tr>
                    <th scope="row">口座名義</th>
                    <td>{{transferAccount.account_holder}}</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="button text-right" v-if="transferAccount.id">
              <button type="button" class="btn btn-primary font-weight-bold text-white" @click="$router.push({ name: 'transfer-account-setting' })">振込先口座を編集</button>
            </div>

          </div>
        </div>
      </div>


      <div class="transfer_money my-4" v-if="transferAccount.id">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title font-weight-bold text-primary">振込申請金額情報</h4>
            <h5 class="card-title mt-4">商品名：{{payoutAudio.title}}</h5>
            <p class="card-text font-weight-bold text-danger h3" v-if="payoutAudio.price">
              合計：<i class="fas fa-yen-sign"></i>{{ payoutAudio.price | comma }}
            </p>

          </div>
        </div>
      </div>

    </div>

    <div class="p-2 text-center" v-if="transferAccount.id">
        <button 
            type="submit" 
            class="btn btn-primary my-4 store mr-5"
            :disabled="payoutProcessing"
            v-text="payoutProcessing ? '申請中' : '振込申請する'"
            @click="processPayout"
            >
        </button>
        <button type="button" class="btn btn-primary my-4 cancel" @click="$router.push({ name: 'sales'})">戻る</button>
    </div>

  </div>
</template>

<script>
export default {
  data() {
    return {
      loading: false,
      payoutProcessing: false,
      transferAccount: {},
      payoutAudio: {},
      options: {
          duration: 1500,
          type: 'info'
      }
    }
  },
  methods: {
    async processPayout() {
      let res = confirm("振込申請してもよろしいですか？");

      if( res == true ) {
          try{
            this.loading = true
            await this.$store.dispatch('purchase/payout', this.$route.params.id)
          }
          catch(e){
            this.loading = false
          }
          finally{
            this.loading = false
            this.toasted()
            this.$router.push({ name: 'sales'})
          }
      }
      else {
         return
      }

    },
    async getTransferAccountData() {

      try{
        this.loading = true
        await this.$store.dispatch('transferAccount/show')
        this.transferAccount = this.$store.state.transferAccount.transferAccountInformation
      }
      catch(e){
        // console.log(e);
        this.loading = false
      }
      finally{
        this.loading = false
      }
    },
    async getPayoutAudioData() {

      try{
        this.loading = true
        await this.$store.dispatch('purchase/getPayoutAudio', this.$route.params.id)
        this.payoutAudio = this.$store.state.purchase.payoutAudio
      }
      catch(e){
        // console.log(e);
        console.log(1111);
        this.loading = false
      }
      finally{
        this.loading = false
      }
    },
    toasted() {
      this.$toasted.show('振込申請完了しました。', this.options);
    }
  },
  created() {
    Promise.all([
      this.getTransferAccountData(),
      this.getPayoutAudioData(),
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
.cancel{
  color: white;
  font-weight: bold;
  padding: 12px 30px;
  border-radius: 20px;
  background: #4DB7FE;
}


</style>