<template>
<!--  <h2>Поставщики</h2>-->
  <v-row>
      <v-col
          v-for="n in 6"
          :key="n"
          cols="4"
          v-if="loading"
      >
        <v-skeleton-loader
            type="article"
        ></v-skeleton-loader>
      </v-col>
      <v-col
          v-if="!loading"
          v-for="item in items"
          :key="item.id"
          cols="4"
      >
        <v-card>
          <v-card-title>{{ item.companyName || `${item.name[0]}.${item.fatherName[0]}. ${item.surname}` }}</v-card-title>
          <v-card-subtitle v-if="item.companyName">
            {{ `${item.name[0]}.${item.fatherName[0]}. ${item.surname}` }}
          </v-card-subtitle>
          <v-card-text>
            <p> <v-icon small>mdi-map-marker</v-icon>{{ item.address }} </p>
            <p> <v-icon small>mdi-phone</v-icon>{{ item.phone }} </p>
          </v-card-text>
          <v-card-actions>
            <v-btn text color="warning">Редактировать</v-btn>
            <v-btn text color="error">Удалить</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
      <v-btn
          fab
          absolute
          bottom
          left
          style="bottom: 16px"
          color="success"
      ><v-icon>mdi-plus</v-icon></v-btn>
  </v-row>
</template>

<script>
export default {
  name: "Providers",
  data: ()=>({
    items:[], loading:true
  }),
  async mounted() {
    const response = await fetch("/api/provider/list");
    const providers = await response.json();
    console.log(providers);
    this.items = providers;
    this.loading=false;
  }
}
</script>

<style scoped>

</style>