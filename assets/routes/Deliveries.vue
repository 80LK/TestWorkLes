<template>
  <v-row>
    <v-col cols="12">
      <v-data-table
          :single-expand="true"
          :expanded.sync="expanded"
          :loading="loading"
          loading-text="Загрузка"
          :headers="headers"
          :items="deliveries"
          :server-items-length="total"
          :options.sync="options"
          :footer-props="{
            itemsPerPageText:'Элементов на странице',
            itemsPerPageOptions:[1,5,10,15,20,25,50,100]
          }"
          multi-sort
          show-expand
          item-key="id"
      >
        <template
            v-slot:item.data-table-expand="{item, expand, isExpanded}"
        >
          <v-icon v-if="item.note || false"
                  icon
                  :style="isExpanded ? 'transform: rotate(-180deg)' : ''"
                  @click="expand(!isExpanded)">
            mdi-chevron-down
          </v-icon>

        </template>
        <template v-slot:expanded-item="{ headers, item }">
          <td :colspan="headers.length">
            {{ item.note }}
          </td>
        </template>
      </v-data-table>

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

function getDeliveryItemForTable(item) {
  item.woodSpecies = item.woodSpecies.name;
  item.date = new Date(item.date).toLocaleString();
  item.provider = getCompanyName(item.provider);
  item["data-table-expand"] = false;
  return item;
}

export default {
  name: "Deliveries",
  components: {NewDelivery},
  data: () => ({
    headers: [
      {
        text: 'Тип древесины',
        align: 'start',
        sortable: false,
        value: 'woodSpecies'
      },
      {
        text: "Объем",
        value: "volume"
      },
      {
        text: "Поставщик",
        sortable: false,
        value: "provider"
      },
      {
        text: "Дата поставки",
        value: "date"
      },
      {text: '', value: 'data-table-expand'}
    ],
    expanded: [],
    options: {
      sortBy: ["date"],
      sortDesc: [true]
    },
    total: 0,

    loading: true,
    open_dialog_add_delivery: false,

    deliveries: []
  }),
  watch: {
    options: {
      handler() {
        this.getData()
      },
      deep: true,
    },
  },
  methods: {
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
        this.getData();
      }
      this.loading = false;
    },
    async getData() {
      console.log(this.options);
      this.loading = true;
      const data = new URLSearchParams();

      data.append("count", this.options.itemsPerPage);
      data.append("offset", this.options.itemsPerPage * (this.options.page - 1));

      if (this.options.sortBy) {
        for (const i in this.options.sortBy) {
          const key = this.options.sortBy[i];
          data.append(`sort[${key}]`, this.options.sortDesc[i] ? "DESC" : "ASC")
        }
      }
      const response = await fetch("/api/delivery/list?" + data.toString());
      const deliveries = await response.json();

      this.deliveries = deliveries.map(getDeliveryItemForTable);
      this.total = parseInt(response.headers.get("Total"));
      this.loading = false;
    }
  }
}
</script>

<style scoped>

</style>
