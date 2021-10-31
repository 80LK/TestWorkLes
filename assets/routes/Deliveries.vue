<template>
  <v-row>
    <v-col cols="12">
      <v-simple-table>
        <thead>
        <tr>
          <th class="text-left"> ID</th>
          <th class="text-left"> Порода древисины</th>
          <th class="text-left"> Объем</th>
          <th class="text-left"> Поставщик</th>
          <th class="text-left"> Дата поставки</th>
          <th class="text-left"> Примечание</th>
        </tr>
        </thead>
        <tbody>
        <router-link
            v-for="item in deliveries"
            :key="item.id"
            style="cursor: pointer;"
            tag="tr"
            to="/">
          <td>{{ item.id }}</td>
          <td>{{ item.woodSpecies.name }}</td>
          <td>{{ item.volume }}</td>
          <td>{{ getCompanyName(item.provider) }}</td>
          <td>{{ new Date(item.date).toLocaleString() }}</td>
          <td>{{ item.note }}</td>
        </router-link>
        <tr v-if="loading">
          <td>
            <v-skeleton-loader type="text"/>
          </td>
          <td>
            <v-skeleton-loader type="text"/>
          </td>
          <td>
            <v-skeleton-loader type="text"/>
          </td>
          <td>
            <v-skeleton-loader type="text"/>
          </td>
          <td>
            <v-skeleton-loader type="text"/>
          </td>
          <td>
            <v-skeleton-loader type="text"/>
          </td>
        </tr>
        </tbody>
      </v-simple-table>

      <NewDelivery v-model="open_dialog_add_delivery"/>

      <v-btn
          color="success"
          fab
          fixed
          style="bottom: 16px; right:16px"
          @click="open_dialog_add_delivery = true"
      >
        <v-icon>mdi-plus</v-icon>
      </v-btn>
    </v-col>
  </v-row>
</template>

<script>
import {getCompanyName} from "../utils/provider";
import NewDelivery from "../dialoges/NewDelivery";

export default {
  name: "Deliveries",
  components: {NewDelivery},
  data: () => ({
    loading: true,
    open_dialog_add_delivery: false,

    deliveries: []
  }),
  methods: {
    getCompanyName: getCompanyName
  },
  async mounted() {
    const response = await fetch("/api/delivery/list");
    const deliveries = await response.json();

    this.deliveries = deliveries;
    this.loading = false;
  }
}
</script>

<style scoped>

</style>
