<template>
  <div class="new-audio">

    <div class="container">

      <div class="content-top-title">
        <h1>オーディオ一覧</h1>
      </div>

      <div class="mt-5">
        <div class="card-deck row">
          <div class="col-sm-4" v-for="(audio, i) in audios" :key="i">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">{{ audio.title }}</h5>
                <audio controls controlslist="nodownload">
                  <source :src="audio.sound">
                </audio>
                <p class="card-text"><small class="text-muted">{{audio.artist}}</small></p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="button mt-5">
        <button 
          type="button" 
          class="btn btn-primary"
          @click="$router.push({ name: 'audio-index' })"
          >もっと見る</button>
      </div>
      
    </div> 
  </div>
</template>

<script>
export default {
  data() {
    return {
      audios: [
        {
          sound: 'images/Closed_Case.mp3',
          title: '生演奏！アコースティックギターのポップス',
          artist: 'rokedt'
        },
        {
          sound: 'images/Closed_Case.mp3',
          title: '生演奏ギターの爽やか明るい疾走感ポップス',
          artist: 'rokedt'
        },
        {
          sound: 'images/Closed_Case.mp3',
          title: '明るいEDM テクノ ポップ ダンス曲',
          artist: 'rokedt'
        },
        {
          sound: 'images/Closed_Case.mp3',
          title: '企業VPに爽やかアコースティックギター',
          artist: 'rokedt'
        },
        {
          sound: 'images/Closed_Case.mp3',
          title: 'ほのぼのした日常曲です。',
          artist: 'rokedt'
        },
        {
          sound: 'images/Closed_Case.mp3',
          title: '運動会に使われるテンポの良いクラシック',
          artist: 'rokedt'
        },
      ]
    }
  },

}
</script>

<style scoped>
.new-audio {
  height: auto;
  background: #F6F6F4;
}
.content-top-title {
  text-align: center;
  margin-top: 60px;
}
.content-top-title h1{
  font-weight: bold;
  color: #566985;
}
audio {
  display: block;
}
.card {
  overflow: hidden;
  width: 100%;
}
.card .card-title {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.button {
  text-align: center;
}
.button .btn{
  color: white;
  font-weight: bold;
  padding: 12px 40px;
  border-radius: 20px;
}
</style>