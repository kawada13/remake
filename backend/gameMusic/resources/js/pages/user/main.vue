<template>
  <div class="container">
      <div class="row my-3">

        <!-- 左側 -->
        <div class="col-sm-3 col-xs-12 left_side_bar mb-5">

          <div class="creater_image mb-3">
            <img src="/images/498467_s.jpg" class="rounded-circle">
          </div>

          <h3>Creater Name</h3>
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