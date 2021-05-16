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
            <p class="card-text"><small class="text-muted creater_name" @click="$router.push({ name: 'creater-show', params: { id: `${audio.id}` }})">{{audio.artist}}</small></p>
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
.creater_name:hover {
  cursor: pointer;
  text-decoration: underline;
}


</style>