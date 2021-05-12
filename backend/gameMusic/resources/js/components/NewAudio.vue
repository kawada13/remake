<template>
  <div class="new-audio">

    <div class="container">
      <div class="content-top-title">
        <h1>新着オーディオ</h1>
      </div>
      
      <audio controls>
        <source :src="mp3">
      </audio>
    </div> 
  </div>
</template>

<script>
export default {
  data() {
    return {
      mp3: 'images/Closed_Case.mp3'
    }
  },

}
</script>

<style scoped>
.new-audio {
  height: 600px;
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
</style>