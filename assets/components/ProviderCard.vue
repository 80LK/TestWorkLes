<template>
  <v-card>
    <v-skeleton-loader v-if="loading" type="article"/>


    <v-card-title v-if="!loading">
      {{ provider.companyName || fullName }}
    </v-card-title>
    <v-card-subtitle v-if="!loading">
      {{ provider.companyName ? fullName : "Физ. лицо" }}
    </v-card-subtitle>
    <v-card-text v-if="!loading">
      <p>
        <v-icon small>mdi-map-marker</v-icon>
        {{ provider.address }}
      </p>
      <p>
        <v-icon small>mdi-phone</v-icon>
        {{ provider.phone }}
      </p>
    </v-card-text>
    <v-card-actions v-if="!loading">
      <slot name="actions"></slot>
    </v-card-actions>
  </v-card>
</template>

<script>
import {getFullName} from "../utils/provider";

export default {
  name: "ProviderCard",
  props: {
    loading: Boolean,
    provider: Object
  },
  computed: {
    fullName: function () {
      return getFullName(this.provider);
    }
  }
}
</script>

<style scoped>

</style>
