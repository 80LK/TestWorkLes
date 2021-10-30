<template>
  <v-card>
    <v-skeleton-loader v-if="loading" type="article" />


    <v-card-title v-if="!loading">
      {{ provider.companyName || fullName }}
    </v-card-title>
    <v-card-subtitle v-if="!loading">
      {{ provider.companyName ? fullName : "Физ. лицо" }}
    </v-card-subtitle>
    <v-card-text v-if="!loading">
      <p>
        <v-icon small>mdi-map-marker</v-icon>{{ provider.address }}
      </p>
      <p>
        <v-icon small>mdi-phone</v-icon> {{ provider.phone }}
      </p>
    </v-card-text>
    <v-card-actions  v-if="!loading">
      <v-btn text color="warning" @click="$emit('edit', provider)">Редактировать</v-btn>
      <v-btn text color="error" @click="$emit('delete', provider)">Удалить</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
  name: "ProviderCard",
  props:{
    loading: Boolean,
    provider: Object
  },
  computed:{
    fullName:function(){
      return  `${this.provider.name[0]}.${this.provider.fatherName[0]}. ${this.provider.surname}`;
    }
  }
}
</script>

<style scoped>

</style>