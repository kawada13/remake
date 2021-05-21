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
                position: 'top-center',
                duration: 5000,
                fullWidth: true,
                type: 'error'
            }
        }
    },
    methods: {
        doClick(){
        this.$toasted.show('hello billo', this.options);
        }
    },



}
</script>

<style>

</style>