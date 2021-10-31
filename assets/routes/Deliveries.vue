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

      <NewDelivery v-model="open_dialog_add_delivery" @save="save"/>

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
    getCompanyName: getCompanyName,
    async save(new_data) {
      this.loading = true;
      new_data.date = new Date(new_data.date + " " + new_data.time).toISOString().slice(0, -5) + "+00:00";
      delete new_data.time;

      const data = new FormData();
      for (const key in new_data)
        data.append(key, new_data[key]);

      const response = await fetch("/api/delivery", {
        method: "post",
        body: data
      });
      const json_response = await response.json();

      if (json_response.error) {
        alert(json_response.error);
      } else {
        const delivery = json_response.success;
        this.deliveries.push(delivery);
      }
      this.loading = false;
    }
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
