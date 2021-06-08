<template>
  <div class="container">


    <!-- ローディング中 -->
    <div class="my-5" v-if="loading">
      <Loader />
    </div>

    <div v-if="!loading">
      <div class="header mt-5">
        <h3 class="font-weight-bold">購入内容のご確認</h3>
      </div>

      <div class="payment-content my-4">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title font-weight-bold text-primary">ご注文内容</h4>
            <h5 class="card-title">商品名：{{audio.title}}</h5>
            <h6 class="card-subtitle mb-2 text-muted">※購入後、フル音源がダウンロードできます。</h6>
            <p class="card-text font-weight-bold text-danger" v-if="audio.price">
              合計：<i class="fas fa-yen-sign"></i>{{ audio.price | comma }}
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="payment-information my-4">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title font-weight-bold text-primary">お支払い情報</h4>
          <div class="card-text">

            <div class="form-group">
              <div class="d-flex justify-content-start"><label for="name">お名前</label></div>
              <input type="text" class="form-control form-control-lg" id="name" v-model="form.name">
              <div class="alert alert-danger mt-2" role="alert" v-if="errors.name.required">
                お名前の入力は必須です！
              </div>
            </div>

            <div class="form-group">
              <div class="d-flex justify-content-start"><label for="email">メールアドレス</label></div>
              <input type="email" class="form-control form-control-lg" id="email" v-model="form.email">
              <div class="alert alert-danger mt-2" role="alert" v-if="errors.email.required">
                メールアドレスの入力は必須です！
              </div>
            </div>

            <p>カードインフォメーション</p>
            <div id="card-information"></div>
            <p class="text-danger">{{cardError}}</p>

            <div class="p-2">
                <button 
                   type="submit" 
                   class="btn btn-primary my-4 store mr-5"
                   :disabled="paymentProcessing"
                   v-text="paymentProcessing ? '購入中' : '購入する'"
                   @click="processPayment"
                   >
                </button>
                <button type="button" class="btn btn-primary my-4 cancel" @click="$router.push({ name: 'audio-show', params: { id: `${audio.id}` } })">戻る</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { loadStripe } from '@stripe/stripe-js';
export default {
  data() {
    return {
      audio: {},
      loading: false,
      stripe: {},
      cardElement: {},
      paymentProcessing: false,
      cardError: '',
      isPurchase: false,
      errors: {
        name: {
          required: false,
        },
        email: {
          required: false,
        },
      },
      form: {
        price: '',
        name: '',
        mail: '',
        token_id: '',
      },
      options: {
          duration: 1500,
          type: 'info'
      }
    }
  },
  methods: {
    async getAudioShowData() {
      try{
        this.loading = true
        await this.$store.dispatch('audio/getAudioShow', this.$route.params.id)
        this.audio = this.$store.state.audio.audio
        this.form.price = this.$store.state.audio.audio.price
      }
      catch(e){
        // console.log(e);
        this.loading = false
      }
      finally{
        this.loading = false

    }
   },
   async getStripe() {
      this.stripe = await loadStripe('pk_test_51IrZ1FAccOz42G5p5HiPoJZbZ6zVGiiR44z7u6ZKGQwRBzCbMIVqrzgwRd9W9lijHvmR4RpttiGCKyOSfOYL7uIB00p2qLe7wu');
      const elements = this.stripe.elements();
      this.cardElement = elements.create('card', {
          classes: {
              base: 'bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-base outline-none text-gray-700 p-3 leading-8 transition-colors duration-200 ease-in-out',
          },
          hidePostalCode: true
      });
      this.cardElement.mount('#card-information');
   },
   async processPayment() {

        await this.validate();

        if(this.errors.name.required || this.errors.email.required)
        {
          return
        }

        this.paymentProcessing = true;
        const { token, error } = await this.stripe.createToken(this.cardElement);
        if (error) {
            this.paymentProcessing = false;

            console.error(error);
            this.cardError = error.message
        } else {
          console.log('成功');
          this.form.token_id = token.id;

          axios.post(`/api/${this.$route.params.id}/purchase`, this.form)
              .then((response) => {
                  this.paymentProcessing = false;
                  this.toasted()
                  this.$router.replace({ name: 'purchase-history'})
              })
              .catch((error) => {
                  this.paymentProcessing = false;
                  console.error(error);
              });

        }
    },
    toasted() {
      this.$toasted.show('決済が完了しました。', this.options);
    },
    validate() {
      // 初期化
      this.errors = {
        name: {
          required: false,
        },
        email: {
          required: false,
        },
      }

      if (!this.form.name) {
        this.errors.name.required = true
      }
      if (!this.form.email) {
        this.errors.email.required = true
      }
    }
  },

  async mounted() {
    Promise.all([
      this.getAudioShowData(),
      this.getStripe(),
    ])
  },

}
</script>

<style scoped>
.payment-content .card-text {
  font-size: 18px;
}

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


@media screen and (max-width:767px) {
    /*画面サイズが767px以下の場合読み込む（スマホ）*/

}
@media screen and (min-width:768px){
    /*画面サイズが768px以上の場合読み込む（PC）*/

    .card {
      width: 52rem;
    }

}

</style>