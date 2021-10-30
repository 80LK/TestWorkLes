<template>
    <v-row>
      <v-col
          v-for="route in routes"
          :key="route.title"
          cols="12" sm="6" md="4"
      >
        <router-link v-bind:to="route.path" v-slot="{ navigate }">
          <v-card @click="navigate">
            <v-card-title>{{ route.name }}</v-card-title>
          </v-card>
        </router-link>
      </v-col>
    </v-row>
</template>

<script>
import routes from '../routes/nav_routes';

export default {
  name: "Home",
  data:()=>({ routes })
}
</script>

<style scoped>

</style>