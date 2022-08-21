<template>
  <v-container fluid class="grey lighten-5">
    <router-view />
    <notifications position="bottom left" />
  </v-container>
</template>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}
</style>
