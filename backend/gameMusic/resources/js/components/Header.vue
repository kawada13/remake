<template>
  <div>
    <v-app-bar
      color="blue-grey darken-4"
      dark
      elevate-on-scroll
      height="90"
    >
    <v-container>
      <v-row>
        <v-col cols="12" sm="4">
           <v-toolbar-title 
            class="display-1" 
            style="cursor: pointer" 
            @click="$router.push({ name: 'home' })"
            >
            Site Logo
            </v-toolbar-title>
        </v-col>

        <v-spacer></v-spacer>

          <v-toolbar-title 
            class="ml-5"
            style="cursor: pointer" 
            @click="$router.push({ name: 'home' })"
            >
            <v-icon>mdi-heart</v-icon>
            </v-toolbar-title>

          <v-toolbar-title 
            class="ml-5"
            style="cursor: pointer" 
            @click="$router.push({ name: 'home' })"
            >
            会員登録
            </v-toolbar-title>

          <v-toolbar-title 
            class="ml-5"
            style="cursor: pointer" 
            @click="$router.push({ name: 'home' })"
            >
            ログイン
            </v-toolbar-title>

     </v-row>
    </v-container>
    
      

    </v-app-bar>
  </div>
</template>
<script>
</script>
<style>
</style>
