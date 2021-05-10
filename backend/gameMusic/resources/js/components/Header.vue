<template>
  <div>
    <v-app-bar
      color="blue lighten-2"
      dark
    >

      <v-toolbar-title 
        class="display-1" 
        style="cursor: pointer" 
        @click="$router.push({ name: 'home' })"
        >
        Site Logo
        </v-toolbar-title>

      <v-spacer></v-spacer>


      <v-toolbar-title 
        class="ml-5"
        style="cursor: pointer" 
        @click="$router.push({ name: 'home' })"
        >
        Home
        </v-toolbar-title>

    </v-app-bar>
  </div>
</template>
<script>
</script>

<style>
</style>
