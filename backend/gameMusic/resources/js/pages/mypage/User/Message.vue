<template>
  <div class="container">

    <!-- フォーム部分 -->
    <div  class="card">
      <div class="card-header">
        チャットルーム
      </div>
      <div class="card-body">
        <form>
          <div class="form-group">
            <label for="exampleFormControlTextarea1">Exampleさんにメッセージを送る</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" v-model="form.message"></textarea>
          </div>
          <div class="alert alert-danger mt-2" role="alert" v-if="errors.message.required">
            メッセージ入力は必須です！
          </div>
        </form>
        <a class="btn btn-primary" @click="sendMessage">送信する</a>
      </div>
    </div>


    <!-- チャット内容表示部分 -->
    <div class="card mt-5">
      <div class="card-body">
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
      </div>
    </div>
    <div class="card mt-5">
      <div class="card-body">
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
      </div>
    </div>
    <div class="card mt-5">
      <div class="card-body">
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
      </div>
    </div>
    <div class="card mt-5">
      <div class="card-body">
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      loading: false,
      form:{
        message: ''
      },
      errors: {
        message: {
          required: false
        }
      }
    }
  },
  methods: {
    async sendMessage() {
      await this.validate();
      if(this.errors.message.required )
      {
        return
      }

      console.log(132);

      try{
        await this.$store.dispatch('chat/sendMessage', {id: this.$route.params.id, data: this.form})
      }
      catch(e){
        console.log(e);
      }
      finally{
        this.form.message = ''
      }
    },
    validate() {
      // 初期化
      this.errors = {
        message: {
          required: false
        }
      }

      if (!this.form.message) {
        this.errors.message.required = true
      }
    },
  }
}
</script>

<style>

</style>