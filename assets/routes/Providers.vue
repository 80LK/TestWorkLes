<template>
  <v-row>
    <v-col
        v-for="item in items"
        :key="item.id"
        cols="12" sm="6" md="4"
    >
      <ProviderCard :provider="item"
          :loading="loadings[item.id] || false"
          @edit="openDialogEditProvider"
          @delete="removeProvider"
      />
    </v-col>

    <ProviderEdit
        v-model="open_dialog_edit_provider"
        @save="save"
        :provider="currentItem"
    />

    <AgreeDialog
        v-model="open_dialog_remove_provider"
        title="Удалить поставщика"
        @disagree="open_dialog_remove_provider = false"
        @agree="removeForceProvider"
    >
      Данные будут удалены буз возможности восстановленя. Вы уверены, что хотите удалить поставщика?
    </AgreeDialog>

    <v-btn
        fab
        absolute
        bottom
        left
        style="bottom: 16px"
        color="success"
        @click="openDialogNewProvider()"
    ><v-icon>mdi-plus</v-icon></v-btn>
  </v-row>
</template>

<script>
import Vue from "vue";
import ProviderEdit from "../dialoges/ProviderEdit";
import ProviderCard from "../components/ProviderCard";
import AgreeDialog from "../dialoges/AgreeDialog";

export default {
  name: "Providers",
  components:{
    ProviderEdit,
    ProviderCard,
    AgreeDialog
  },
  data: ()=>({
    open_dialog_edit_provider: false,
    open_dialog_remove_provider: false,
    currentItem: null,
    items:[{id:-1}, {id:-2}, {id:-3}],
    loadings:{
      [-1]:true,[-2]:true,[-3]:true
    },

    addIndex:-1
  }),
  methods:{
    openDialogEditProvider(provider){
      this.open_dialog_edit_provider = true;
      this.currentItem = provider;
    },
    openDialogNewProvider(){
      return this.openDialogEditProvider(null);
    },
    removeProvider(provider){
      this.currentItem = provider;
      this.open_dialog_remove_provider = true;
    },

      /**
       * edit or save new provider
       * @returns {Promise<void>}
       */
    async save(new_data){
      const data = new FormData();
      for(const key in new_data)
        data.append(key, new_data[key]);

      let url = "/api/provider";
      const currentId = this.currentItem ? this.currentItem.id : this.addIndex--;

      if(this.currentItem){
        url += "/" + currentId;
      }else{
        this.items.push({ id:currentId });
      }

      this.loadings[currentId] = true;

      const response = await fetch(url, {
        method:"post",
        body: data
      });
      const json_response = await response.json();

      if(json_response.error){
        alert(json_response.error);
      }else {
        const provider = json_response.success;

        if (this.currentItem)
          Vue.set(this.items, this.items.findIndex(e => e.id == currentId), provider);
        else
          this.items = [
            ...this.items.filter(e => e.id != currentId), provider
          ];
      }
      this.loadings[currentId] = false;
    },
    /**
     * remove provider
     * @returns {Promise<void>}
     */
    async removeForceProvider(){
      const currentId = this.currentItem.id;
      this.loadings[currentId] = true;

      const response = await fetch("/api/provider/" + currentId, {method:"delete"});
      const result = await response.json();
      if(result.error) {
        alert(result.error)
      }else{
        this.loadings[currentId] = false;

        this.items = this.items.filter(e => e.id != currentId);
        this.currentItem = null;
      }
    }
  },

  async mounted() {
    const response = await fetch("/api/provider/list");
    const providers = await response.json();

    this.items = providers;
    this.loading=false;
  }
}
</script>

<style scoped>

</style>