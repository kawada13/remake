<template>
  <div>



    <!-- ローディング中 -->
    <div class="my-5" v-if="loading">
      <Loader />
    </div>


    <div class="card mt-2" v-if="!loading">
        <h3 class="card-header">
          フォローしているクリエイター
        </h3>
        <div class="no_user my-4" v-if="!users.length">
          <p>現在フォローしているクリエイターはございません。</p>
        </div>
        <ul class="list-group list-group-flush follows">
          <li class="list-group-item" v-for="(user, i) in users" :key="i">

            <div class="row">
              <!-- (左側) -->
              <div class="col-sm-9 col-xs-12">
                <div class="d-flex justify-content-start">


                  <div v-if="user.user_information.profile_image" class="profile_image">
                    <img :src="user.user_information.profile_image" class="rounded-circle" @click="$router.push({ name: 'user-show', params: { id: `${user.id}` }})">
                  </div>
                  <div v-else class="profile_image">
                    <img src="/images/default_img.png" class="rounded-circle" @click="$router.push({ name: 'user-show', params: { id: `${user.id}` }})">
                  </div>

                  <div class="d-flex align-items-center ml-2">
                    <span class="creater_name" @click="$router.push({ name: 'user-show', params: { id: `${user.id}` }})">{{ user.name }}</span>
                  </div>
                </div>
              </div>
              <!-- (右側) -->
              <div class="col-sm-3 col-xs-12 d-flex align-items-center">
                <a type="button" class="btn btn-danger text-light" @click="unfollow(user.id)">フォロー解除</a>
              </div>
            </div>
          </li>
        </ul>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      loading :false,
      users: []
    }
  },
  methods: {
    async getFollowUsers() {
      try{
        this.loading = true
        await this.$store.dispatch('follow/lists')
        this.users = this.$store.state.follow.followUsers
      }
      catch(e){
        // console.log(e);
        this.loading = false
      }
      finally{
        this.loading = false
      }
    },
    async unfollow(userId) {
      try{
        await this.$store.dispatch('follow/delete', userId)
      }
      catch(e){
        // console.log(e);
      }
      finally{
        this.getFollowUsers()
      }
    },
  },
  created() {
    Promise.all([
      this.getFollowUsers(),
    ])
  },

}
</script>

<style scoped>

.follows img{
  height: 60px;
}
.follows span{
  font-weight: 700;
  font-size: 25px;
}

.creater_name:hover{
  cursor: pointer;
  text-decoration: underline;
}
.profile_image img {
  cursor: pointer;
}

.no_user {
  text-align: center;
}

@media screen and (max-width:767px) {
    /*画面サイズが767px以下の場合読み込む（スマホ）*/

    h3 {
      font-weight: bold;
      font-size: 20px;
    }


}
@media screen and (min-width:768px){
    /*画面サイズが768px以上の場合読み込む（PC）*/

    h3 {
      font-weight: bold;
    }

}

</style>