<template>
  <div>
    <div class="">

      <div class="card-group mb-5">
        <div class="card text-center">
          <div class="card-body earnings">
            <h5 class="card-title">売上金額合計</h5>
            <h1><i class="fas fa-yen-sign"></i>{{ earning | comma }}</h1>
          </div>
        </div>
        <div class="card text-center">
          <div class="card-body cumulative">
            <h5 class="card-title">累計の売上金額</h5>
            <h1><i class="fas fa-yen-sign"></i>{{ cumulative | comma }}</h1>
          </div>
        </div>
      </div>


      <div class="card purchase_audio_title">
        <h3 class="card-header">
          売上履歴
        </h3>

        <div class="card-body purchase_audio_body" v-for="(audio, i) in audios" :key="i">
            <h5 class="card-title audio_title" @click="$router.push({ name: 'audio-show' })">{{audio.title}}</h5>
            <p>
              <button type="button" class="btn btn-outline-info ml-4"><i class="fas fa-yen-sign"></i>{{ audio.price | comma }}</button>
              <button type="button" class="btn btn-danger text-white ml-3" data-toggle="modal" data-target="#exampleModal">
                出勤申請をする
              </button>
              <button type="button" class="btn btn-secondary text-white">出金済み</button>
            </p>
            <audio controls controlslist="nodownload">
              <source :src="audio.sound">
            </audio>
            <p class="card-text"><small class="text-muted creater_name" @click="$router.push({ name: 'user-show', params: { id: `${audio.id}` }})">購入ユーザー名：{{audio.artist}}</small></p>



            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{audio.title}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    金額：<i class="fas fa-yen-sign"></i>{{ audio.price | comma }}
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary text-white" data-dismiss="modal">キャンセル</button>
                    <button type="button" class="btn btn-primary text-white application_btn">申請する</button>
                  </div>
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
      earning:4000,
      cumulative:60000,
      audios:[
        {
          id: 1,
          title:'生演奏！アコースティックギターのポップス',
          sound: '/images/Closed_Case.mp3',
          price: 3000,
          artist: 'dsfa1'
        },
        {
          id: 2,
          title:'生演奏！アコースティックギターのポップス',
          sound: '/images/Closed_Case.mp3',
          price: 3000,
          artist: 'dsfa2'
        },
        {
          id: 3,
          title:'生演奏！アコースティックギターのポップス',
          sound: '/images/Closed_Case.mp3',
          price: 3000,
          artist: 'dsfa3'
        },
        {
          id: 4,
          title:'生演奏！アコースティックギターのポップス',
          sound: '/images/Closed_Case.mp3',
          price: 3000,
          artist: 'dsfa4'
        },
      ],
      sales:[]
    }
  },
  methods: {
    async getSalesData() {
      try{
        this.loading = true
        await this.$store.dispatch('purchase/getSales')
        this.sales = this.$store.state.purchase.sales

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
      this.getSalesData(),
    ])
  },

}
</script>

<style scoped>

.earnings h1 {
  font-weight: bold;
  color: hsla(357, 100%, 37%, 0.979);
}
.cumulative h1 {
  font-weight: bold;
  color: black;
}


.purchase_audio_body .audio_title:hover {
  cursor: pointer;
  text-decoration: underline;
}
.creater_name:hover {
  cursor: pointer;
  text-decoration: underline;
}

@media screen and (max-width:767px) {
    /*画面サイズが767px以下の場合読み込む（スマホ）*/

    .purchase_audio_title h3 {
      font-weight: bold;
      font-size: 20px;
    }



}
@media screen and (min-width:768px){
    /*画面サイズが768px以上の場合読み込む（PC）*/

    .purchase_audio_title h3 {
      font-weight: bold;
    }

}


</style>