<template>
  <v-container>
    <v-row>
      <v-col
          v-for="route in routes"
          :key="route.title"
          cols="4"
      >
        <router-link v-bind:to="route.path" v-slot="{ navigate }">
          <v-card @click="navigate">
            <v-card-text>{{ route.title }}</v-card-text>
          </v-card>
        </router-link>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import routes from './routes';

export default {
  name: "Home",
  data:()=>({
    routes
  })
}
</script>

<style scoped>

</style>