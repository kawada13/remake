<template>
  <div>
    <div class="card mt-2">
        <h3 class="card-header">
          フォローしているクリエイター
        </h3>
        <ul class="list-group list-group-flush follows">
          <li class="list-group-item" v-for="(creater, i) in creaters" :key="i">

            <div class="row">
              <!-- (左側) -->
              <div class="col-sm-9 col-xs-12">
                <div class="d-flex justify-content-start">
                  <img :src="creater.img" class="rounded-circle">
                  <div class="d-flex align-items-center ml-2">
                    <span class="creater_name" @click="$router.push({ name: 'user-show', params: { id: `${creater.id}` }})">{{ creater.name }}</span>
                  </div>
                </div>
              </div>
              <!-- (右側) -->
              <div class="col-sm-3 col-xs-12 d-flex align-items-center">
                <a type="button" class="btn btn-secondary text-light">フォロー解除</a>
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
      creaters: [
        {
          id: 1,
          img: '/images/498467_s.jpg',
          name: 'Creater Name1'
        },
        {
          id: 2,
          img: '/images/498467_s.jpg',
          name: 'Creater Name2'
        },
        {
          id: 3,
          img: '/images/498467_s.jpg',
          name: 'Creater Name3'
        },
        {
          id: 4,
          img: '/images/498467_s.jpg',
          name: 'Creater Name4'
        },
      ]
    }
  },

}
</script>

<style scoped>

.follows img{
  height: 60px;
}
.follows span{
  font-weight: 700;
  font-size: 15px;
}

.creater_name:hover{
  cursor: pointer;
  text-decoration: underline;
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