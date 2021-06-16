<template>
  <div class="container">

    <!-- ローディング中 -->
    <div class="my-5" v-if="loading">
      <Loader />
    </div>

    <div v-if="!loading">

      <div class="row my-3">

        <!-- 左側 -->
        <div class="col-sm-8 col-xs-12">

          <!-- 左上 -->
          <div class="redruitmetnt_head">
            <h1>{{ recruitment.title }}</h1>
          </div>

          <!-- 左下 -->
          <div class="card mt-3">
            <div class="card-body detail type_title d-flex titles justify-content-start">
              <p v-html="recruitment.content" class="recruitment_content"></p>
            </div>
          </div>

        </div>



        <!-- 右側 -->
        <div class="col-sm-4 col-xs-12 right">
          <div class="right_down mt-5">
            <p class="user_title">ユーザー：</p>
            <div class="card">
              <div class="card-header">

                <div class="text-center user_name">
                  <p @click="$router.push({ name: 'user-show', params: { id: `${recruitment.user_id}` }  })">{{recruitment.user.name}}</p>
                </div>



                <!-- アイコン(登録されてなければデフォルト画像) -->
                <div class="user_image d-flex justify-content-center mb-3" v-if="recruitment.user.user_information.profile_image">
                  <img :src="recruitment.user.user_information.profile_image" class="rounded-circle">
                </div>
                <div class="user_image d-flex justify-content-center mb-3" v-else>
                  <img src="/images/default_img.png" class="rounded-circle">
                </div>


              </div>
              <div class="card-body pt-5 text-center">
                <h5 class="card-text creater_introduce">{{recruitment.user.user_information.introduce}}</h5>
                <a class="btn btn-outline-primary" v-if="isLogined && !isMine && !isAdmin" @click="$router.push({ name: 'message', params: { id: `${recruitment.user_id}` }})">メッセージを送る</a>
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
      recruitment: {},
      isMine: false,
    }
  },
  computed: {
    isAdmin() {
      if(localStorage.getItem("admin")) {
        return true
      } else {
        return false
      }
    },
    isLogined() {
      if(localStorage.getItem("auth")) {
        return true
      } else {
        return false
      }
    },
  },
  methods: {
    async getRecruitmentData() { 
      try{
        this.loading = true
        await this.$store.dispatch('recruitment/show', this.$route.params.id)
        this.recruitment = this.$store.state.recruitment.recruitment


        // 自身のかどうかチェック
        if(this.recruitment.user_id == this.recruitment.authId) {
          this.isMine = true
        } else {
          this.isMine = false
        }

      }
      catch(e){
        console.log(e);
        this.loading = false
      }
      finally{
        this.loading = false
      }

    },
  },
  created() {
    Promise.all([
      this.getRecruitmentData(),
    ])
  },

}
</script>

<style scoped>
.creater_introduce {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.recruitment_content{
  white-space: pre-wrap;
  word-wrap: break-word;
  line-height: 1.7;
}
.user_name:hover {
  cursor: pointer;
  text-decoration: underline;
}

.user_title {
  font-weight: 600;
  font-size: 18px;
  color: #334e6f;
}

.right_top .user_title {
  font-weight: 600;
  font-size: 18px;
  color: #334e6f;
}
.right_down .user_title {
  font-weight: 600;
  font-size: 18px;
  color: #334e6f;
}
.right_down .card-header {
  height: 130px;
  background: #4DB7FE;
}
.right_down .card-header p{
  padding: 14px;
  font-weight: bold;
  color: white;
  font-size: 25px;
}
.right_down .card-header img{
  height: 70px;
  position: relative;
  z-index: 20;
}

@media screen and (max-width:767px) {
    /*画面サイズが767px以下の場合読み込む（スマホ）*/

    .redruitmetnt_head h1 {
      font-weight: bold;
      font-size: 30px
    }
}
@media screen and (min-width:768px){
    /*画面サイズが768px以上の場合読み込む（PC）*/

    .redruitmetnt_head h1 {
      font-weight: bold;
    }
}
</style>