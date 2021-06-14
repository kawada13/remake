<template>
  <div class="container">

    <!-- フォーム部分 -->
    <div class="card" v-if="!userloading">
      <div class="card-header">
        メッセージ
      </div>
      <div class="card-body">
        <form>
          <div class="form-group">
            <label for="exampleFormControlTextarea1">{{user.user.name}}さんにメッセージを送る</label>
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
    <div class="card mt-3" v-for="(chatMessage, i) in chatMessages" :key="i">
      <div class="card-body">
        <div class="d-flex justify-content-start">
          <div class="profile_image">
            <!-- アイコン(登録されてなければデフォルト画像) -->
            <div class="creater_image" v-if="chatMessage.user.user_information.profile_image">
              <img :src="chatMessage.user.user_information.profile_image" class="rounded-circle">
            </div>
            <div class="creater_image" v-else>
              <img src="/images/default_img.png" class="rounded-circle">
            </div>
          </div>
          <div class="name_post">
            <p>{{chatMessage.user.name}}</p>
            <p class="created">{{chatMessage.created_at | fromiso}}</p>
          </div>
        </div>
        <p class="card-text mt-3">{{ chatMessage.message }}</p>
      </div>
    </div>


  </div>
</template>

<script>
export default {
  data() {
    return {
      messageloading: false,
      userloading: false,
      form:{
        message: ''
      },
      errors: {
        message: {
          required: false
        }
      },
      chatMessages:[],
      user: {}
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
        this.getChatMessagesData()
      }
    },
    async getChatMessagesData() {
      try{
        this.messageloading = true
        await this.$store.dispatch('chat/getChatMessages', this.$route.params.id)
        this.chatMessages = this.$store.state.chat.chatMessages
      }
      catch(e){
        this.messageloading = false
        console.log(e);
      }
      finally{
        this.messageloading = false
      }
    },
    async getUserData() {
      try{
        this.userloading = true
        await this.$store.dispatch('user/getUserShow', this.$route.params.id)
        this.user = this.$store.state.user.user

        // url直打ち対策
        if(this.user.authId == Number(this.$route.params.id)) {
          this.$router.push('/')
          return
        }
        if(!this.user.message) {
          this.$router.push('/')
          return
        }
      }
      catch(e){
        this.userloading = false
        console.log(e);
      }
      finally{
        this.userloading = false
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
      this.getUserData()
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

.card-header {
  font-weight: 600;
  font-size: 18px;
  color: #334e6f;
}

</style>