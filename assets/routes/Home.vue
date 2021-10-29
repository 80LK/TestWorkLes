<template>
  <v-container>
    <v-row>
      <v-col
          v-for="n in 3"
          :key="n"
          cols="4"
      >
        <v-card>
          <v-card-text>Item {{ n }}</v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "Home"
}
</script>

<style scoped>

</style>