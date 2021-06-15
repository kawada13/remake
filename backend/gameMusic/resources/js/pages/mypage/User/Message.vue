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
            <small id="emailHelp" class="form-text text-muted">250字以内</small>
          </div>
          <div class="alert alert-danger mt-2" role="alert" v-if="errors.message.required">
            メッセージ入力は必須です！
          </div>
          <div class="alert alert-danger mt-2" role="alert" v-if="errors.message.length">
            250字以内です！
          </div>
        </form>
        <a class="btn btn-primary" @click="sendMessage">送信する</a>
      </div>
    </div>

    <!-- チャット内容表示部分 -->
    <div class="card mt-3" v-for="(chatMessage, i) in getItems" :key="i">
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
          <div class="trash" v-if="chatMessage.user_id == user.authId" @click="messageDelete(chatMessage.id)">
            <i class="fas fa-trash-alt"></i>
          </div>
        </div>
        <p class="card-text mt-3">{{ chatMessage.message }}</p>
      </div>
    </div>

    <!-- ページネーション -->
    <div class="pagination mt-5 d-flex justify-content-center">
        <div v-if="paginateData.chatMessages.length">
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
  components: {
  },
  data() {
    return {
      messageloading: false,
      userloading: false,
      form:{
        message: ''
      },
      errors: {
        message: {
          required: false,
          length: false
        }
      },
      chatMessages:[],
      user: {},
      paginateData: {
        chatMessages: [],
        parPage: 10, //1ページに表示する件数
        currentPage: 1
      },
    }
  },
  computed: {
    getItems() { //ページネーション用(1ページに表示する数)
        let current = this.paginateData.currentPage * this.paginateData.parPage;
        let start = current - this.paginateData.parPage;
        return this.paginateData.chatMessages.slice(start, current);
    },
    getPageCount() {// ページネーション用(全体のページ数)
        return Math.ceil(this.paginateData.chatMessages.length / this.paginateData.parPage);
    },
  },
  methods: {
    clickCallback(pageNum) { //ページネーション用
      this.paginateData.currentPage = Number(pageNum);
    },
    async messageDelete(id) {
      let res = confirm("本当に削除しますか？");
      if( res == true ) {
         try{
            await this.$store.dispatch('chat/deleteChatMessages', id)
          }
          catch(e){
            console.log(e);
          }
          finally{
            this.form.message = ''
            this.getChatMessagesData()
          }
      }
      else {
        console.log('キャンセル');
      }
    },
    async sendMessage() {
      await this.validate();
      if(this.errors.message.required || this.errors.message.length)
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
         this.paginateData.chatMessages = this.$store.state.chat.chatMessages
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
          required: false,
          length: false
        }
      }

      if (!this.form.message) {
        this.errors.message.required = true
      }
      if (this.form.message.length > 250) {
        this.errors.message.length = true
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

@media screen and (max-width:767px) {
    /*画面サイズが767px以下の場合読み込む（スマホ）*/

    .trash {
      margin-left: 140px;
    }
    .trash:hover {
      cursor: pointer;
    }


}
@media screen and (min-width:768px){
    /*画面サイズが768px以上の場合読み込む（PC）*/

    .trash {
      margin-left: 410px;
    }
    .trash:hover {
      cursor: pointer;
    }

}

</style>