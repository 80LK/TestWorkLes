<template>
  <v-row>
    <v-col 
      cols=12
      v-if="!loading && items.length == 0"
    >
      <p class="no-data">Нет данных</p>
    </v-col>

    <v-col
        v-if="loading || items.length != 0"
        v-for="(item, index) in items"
        :key="item ? item.id : -index"
        cols="12" md="4" sm="6"
    >
      <ProviderCard :loading="item === null"
                    :provider="item"
      >
        <template v-slot:actions>
          <v-btn color="warning" text @click="openDialogEditProvider(item)">Редактировать</v-btn>
          <v-btn color="error" text @click="removeProvider(item)">Удалить</v-btn>
        </template>
      </ProviderCard>
    </v-col>

    <ProviderEdit
        v-model="open_dialog_edit_provider"
        :provider="currentItem"
        @save="save"
    />

    <AgreeDialog
        v-model="open_dialog_remove_provider"
        title="Удалить поставщика"
        @agree="removeForceProvider"
        @disagree="open_dialog_remove_provider = false"
    >
      Данные будут удалены без возможности восстановленя. Вы уверены, что хотите удалить поставщика?
    </AgreeDialog>

    <v-btn
        color="success"
        fab
        fixed
        style="bottom: 16px; right:16px"
        @click="openDialogNewProvider()"
    >
      <v-icon>mdi-plus</v-icon>
    </v-btn>
  </v-row>
</template>

<script>
import Vue from "vue";
import ProviderEdit from "../dialoges/ProviderEdit";
import ProviderCard from "../components/ProviderCard";
import AgreeDialog from "../dialoges/AgreeDialog";

export default {
  name: "Providers",
  components: {
    ProviderEdit,
    ProviderCard,
    AgreeDialog
  },
  data: () => ({
    open_dialog_edit_provider: false,
    open_dialog_remove_provider: false,
    currentItem: null,
    loading: true,
    items: [null, null, null],

    addIndex: -1
  }),
  methods: {
    openDialogEditProvider(provider) {
      this.open_dialog_edit_provider = true;
      this.currentItem = provider;
    },
    openDialogNewProvider() {
      return this.openDialogEditProvider(null);
    },
    removeProvider(provider) {
      this.currentItem = provider;
      this.open_dialog_remove_provider = true;
    },

    /**
     * edit or save new provider
     * @returns {Promise<void>}
     */
    async save(new_data) {
      const data = new FormData();
      for (const key in new_data)
        data.append(key, new_data[key]);

      let url = "/api/provider";
      const currentId = this.currentItem ? this.currentItem.id : null;
      let index;

      if (currentId) {
        url += "/" + currentId;
        index = this.items.findIndex(e => e.id == currentId);
        Vue.set(this.items, index, null);
      } else {
        index = this.items.push(null)-1;
      }

      const response = await fetch(url, {
        method: "post",
        body: data
      });
      const json_response = await response.json();

      if (json_response.error) {
        alert(json_response.error);
      } else {
        const provider = json_response.success;

        Vue.set(this.items, index, provider);
      }

    },
    /**
     * remove provider
     * @returns {Promise<void>}
     */
    async removeForceProvider() {
      const currentId = this.currentItem.id;

      const response = await fetch("/api/provider/" + currentId, {method: "delete"});
      const result = await response.json();
      if (result.error) {
        alert(result.error)
      } else {
        this.items = this.items.filter(e => e.id != currentId);
        this.currentItem = null;
      }
    }
  },

  async mounted() {
    const response = await fetch("/api/provider/list");
    const providers = await response.json();

    this.items = providers;
    this.loading = false;
  }
}
</script>

<style scoped>
.no-data{
  text-align: center;
  font-size: 2em;
  font-weight: bold;
}
</style>
