<template>
  <div>
      <h1>練習場</h1>
      <div id="app">
        <button v-on:click="doClick">Show!</button>
      </div>

  </div>
</template>

<script>
export default {
    data() {
        return {
            options: {
                duration: 1500,
                type: 'success'
            }
        }
    },
    methods: {
        doClick(){
        this.$toasted.show('保存しました', this.options);
        }
    },



}
</script>

<style>

</style>