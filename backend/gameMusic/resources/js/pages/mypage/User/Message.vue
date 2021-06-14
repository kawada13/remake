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
        <div class="d-flex justify-content-start">
          <div class="profile_image">
            <div class="creater_image">
              <img src="/images/default_img.png" class="rounded-circle">
            </div>
          </div>
          <div class="name_post">
            <p>名前</p>
            <p class="created">2020-08-08 20:31:05</p>
          </div>
        </div>
        <p class="card-text mt-3">With supporting text below as a natural lead-in to additional content.</p>
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
      },
      chatMessages:[]
    }
  },
  methods: {
    async sendMessage() {
      await this.validate();
      if(this.errors.message.required )
      {
        return
      }
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
    async getChatMessagesData() {
      try{
        await this.$store.dispatch('chat/getChatMessages', this.$route.params.id)
        this.chatMessages = this.$store.state.chat.chatMessages
      }
      catch(e){
        console.log(e);
      }
      finally{
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
  },
  created() {
    Promise.all([
      this.getChatMessagesData(),
    ])
  },
}
</script>

<style scoped>
.profile_image {
  margin-right: 10px;
}
.creater_image img {
  height: 35px;
}
.name_post p {
  margin: 0;
}
.created {
  color: gray;
  font-size: 10px;
}

</style>