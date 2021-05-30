<template>
  <div class="container">
      <div class="row my-3">

        <!-- 左側 -->
        <div class="col-sm-3 col-xs-12 left_side_bar mb-5" v-if="!loading">

          <!-- アイコン(登録されてなければデフォルト画像) -->
          <div class="creater_image mb-3" v-if="user.user.user_information.profile_image">
            <img :src="user.user.user_information.profile_image" class="rounded-circle">
          </div>
          <div class="creater_image mb-3" v-else>
            <img src="/images/default_img.png" class="rounded-circle">
          </div>

          <h3>{{user.user.name}}</h3>
          <a class="btn btn-outline-primary mt-2">このクリエイターをフォロー</a>
        </div>



        <!-- 右側 -->
        <div class="col-sm-9 col-xs-12 right">
          <router-view />
        </div>

      </div>
    </div>
</template>

<script>
export default {
  data() {
    return {
      loading:false,
      user: {}
    }
  },
  methods: {
    async getUserShowData() {
      try{
        this.loading = true
        await this.$store.dispatch('user/getUserShow', this.$route.params.id)
        this.user = this.$store.state.user.user
      }
      catch(e){
        // console.log(e);
        this.loading = false
      }
      finally{
        this.loading = false
      }
    }
  },
  created() {
    Promise.all([
      this.getUserShowData(),
    ])
  },



}
</script>

<style scoped>
.creater_image img {
  height: 144px;
}

.left_side_bar {
  text-align: center;
}



</style>