<template>
  <div>
     <div class="flex flex-wrap -mx-2 mt-4">
          <div class="p-2 w-full">
              <div class="relative">
                  <label for="card-element" class="leading-7 text-sm text-gray-600">Credit Card Info</label>
                  <div id="card-element"></div>
              </div>
          </div>
          <p>{{error}}</p>
      </div>
      <div class="p-2 w-full">
          <button
              class="btn btn-primary"
              @click="processPayment"
              :disabled="paymentProcessing"
              v-text="paymentProcessing ? 'Processing' : 'Pay Now'"
          ></button>
      </div>
  </div>
</template>

<script>
import { loadStripe } from '@stripe/stripe-js';
export default {
  data() {
    return {
      stripe: {},
      cardElement: {},
      paymentProcessing: false,
      price: 200000,
      name: '田中',
      error: '',

      form: {
        price: 400,
        name: '安藤',
        mail: 'test@gmail.com',
        token_id: '',
      }
    }
  },
  methods: {
    async processPayment() {
        this.paymentProcessing = true;
        const { token, error } = await this.stripe.createToken(this.cardElement);
        if (error) {
            this.paymentProcessing = false;

            console.error(error);
            this.error = error.message
        } else {
          console.log('成功');
          this.form.token_id = token.id;

          axios.post('/api/purchase', this.form)
              .then((response) => {
                  this.paymentProcessing = false;
                  console.log(response);
              })
              .catch((error) => {
                  this.paymentProcessing = false;
                  console.error(error);
              });

        }
    },
    async test() {
      console.log(12);
      await axios.post('/api/test')
        .then(res => {
          console.log(res.data);
        })
        .catch(e => {
          console.log(e);
        })
    }
  },
  async mounted() {
      this.stripe = await loadStripe('pk_test_51IrZ1FAccOz42G5p5HiPoJZbZ6zVGiiR44z7u6ZKGQwRBzCbMIVqrzgwRd9W9lijHvmR4RpttiGCKyOSfOYL7uIB00p2qLe7wu');
      const elements = this.stripe.elements();
      this.cardElement = elements.create('card', {
          classes: {
              base: 'bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-base outline-none text-gray-700 p-3 leading-8 transition-colors duration-200 ease-in-out',
          },
          hidePostalCode: true
      });
      this.cardElement.mount('#card-element');
      // this.test()
  },

}
</script>

<style>

</style>