<template>
  <v-card>
    <v-card-title>{{ provider.companyName || fullName }}</v-card-title>
    <v-card-subtitle>
      {{ provider.companyName ? fullName : "Физ. лицо" }}
    </v-card-subtitle>
    <v-card-text>
      <p> <v-icon small>mdi-map-marker</v-icon>{{ provider.address }} </p>
      <p> <v-icon small>mdi-phone</v-icon>{{ provider.phone }} </p>
    </v-card-text>
    <v-card-actions>
      <v-btn text color="warning" @click="$emit('edit', provider)">Редактировать</v-btn>
      <v-btn text color="error" @click="$emit('delete', provider)">Удалить</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
  name: "ProviderCard",
  props:{
    provider:Object
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