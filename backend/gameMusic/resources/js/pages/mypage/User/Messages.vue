<template>
  <div>
    <!-- ローディング中 -->
    <div class="my-5" v-if="loading">
      <Loader />
    </div>


    <div class="card mt-2" v-if="!loading">
        <h3 class="card-header">
          メッセージ一覧
        </h3>
        <div class="no_user my-4 text-center">
          <p>現在メッセージのやりとりがありません。</p>
        </div>
        <!-- <ul class="list-group list-group-flush follows">
          <li class="list-group-item" v-for="(user, i) in users" :key="i">

            <div class="row">

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

              <div class="col-sm-3 col-xs-12 d-flex align-items-center">
                <a type="button" class="btn btn-danger text-light" @click="unfollow(user.id)">フォロー解除</a>
              </div>
            </div>
          </li>
        </ul> -->
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      loading :false,
    }
  },

}
</script>

<style>

</style>