<template>
  <div class="container">
      <div class="row my-3">

        <!-- 左側 -->
        <div class="col-sm-3 col-xs-12">
          <div class="creater_image d-flex justify-content-start mb-3">
            <img src="/images/498467_s.jpg" class="rounded-circle">
          </div>

          <h3>Creater Name</h3>
          <a class="btn btn-outline-primary mt-2">このアーティストをフォロー</a>
        </div>



        <!-- 右側 -->
        <div class="col-sm-9 col-xs-12 right">
          <div class="profile_title">
            <h2>Creater Nameさんのプロフィール</h2>
          </div>
        </div>

      </div>
    </div>
</template>

<script>
export default {

}
</script>

<style scoped>
.creater_image img {
  height: 144px;
}

.profile_title h2 {
  font-weight: bold;
}

</style>