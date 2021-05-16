<template>
  <div>
    <div class="card mt-2">
        <div class="card-header">
          お気に入り作品一覧
        </div>
        <div class="audios ml-4 my-3" v-for="(audio,i) in audios" :key="i">
          <h4 class="audio_title" @click="$router.push({ name: 'audio-show', params: { id: `${audio.id}` } })">{{ audio.title }}</h4>
          <audio controls controlslist="nodownload" class="my-3">
            <source :src="audio.sound">
          </audio>
          <p class="card-text"><small class="text-muted creater_name" @click="$router.push({ name: 'creater-show', params: { id: `${audio.id}` }})">{{audio.artist}}</small></p>
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
          sound: '/images/Closed_Case.mp3',
          title: '生演奏！アコースティックギターのポップス',
          artist: 'rokedt1',
          price: 4000
        },
        {
          id: 2,
          sound: '/images/Closed_Case.mp3',
          title: '生演奏！アコースティックギターのポップス',
          artist: 'rokedt2',
          price: 4000
        },
        {
          id: 3,
          sound: '/images/Closed_Case.mp3',
          title: '生演奏！アコースティックギターのポップス',
          artist: 'rokedt3',
          price: 4000
        },
      ]
    }
  },

}
</script>

<style scoped>
audio {
  margin-bottom: 0!important;
}

.audios .audio_title:hover {
  cursor: pointer;
  text-decoration: underline;
}
.audios .creater_name:hover {
  cursor: pointer;
  text-decoration: underline;
}

</style>