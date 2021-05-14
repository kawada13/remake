<template>
  <div>
    <div class="">
      <div class="card purchase_audio_title">
        <h2 class="card-header">
          購入作品
        </h2>
        <div class="card-body purchase_audio_body" v-for="(audio, i) in audios" :key="i">
            <h5 class="card-title audio_title" @click="$router.push({ name: 'audio-show' })">{{audio.title}}</h5>
            <p>
              <button type="button" class="btn btn-outline-info ml-4"><i class="fas fa-yen-sign"></i>{{ audio.price | comma }}</button>
            </p>
            <audio controls controlslist="nodownload">
              <source :src="audio.sound">
            </audio>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      audios:[
        {
          title:'生演奏！アコースティックギターのポップス',
          sound: '/images/Closed_Case.mp3',
          price: 3000
        },
        {
          title:'生演奏！アコースティックギターのポップス',
          sound: '/images/Closed_Case.mp3',
          price: 3000
        },
        {
          title:'生演奏！アコースティックギターのポップス',
          sound: '/images/Closed_Case.mp3',
          price: 3000
        },
        {
          title:'生演奏！アコースティックギターのポップス',
          sound: '/images/Closed_Case.mp3',
          price: 3000
        },
      ]
    }
  },

}
</script>

<style scoped>
.purchase_audio_title h2 {
  font-weight: bold;
}
.purchase_audio_body button {
  margin: 0!important;
}

.purchase_audio_body .audio_title:hover {
  cursor: pointer;
  text-decoration: underline;
}


</style>