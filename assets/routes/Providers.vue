<template>
<!--  <h2>Поставщики</h2>-->
  <v-row>
    <v-col
        v-for="item in 3" :key="item"
        cols="12" sm="6" md="4"
        v-if="loading"
    >
      <v-skeleton-loader type="article" />
    </v-col>

    <v-col
          v-for="item in items" :key="item.id"
          cols="12" sm="6" md="4"
          v-if="!loading"
      >
        <ProviderCard :provider="item"
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
    items:[null, null, null],
    loading:true
  }),
  methods:{
    async save(new_data){
      const data = new FormData();
      for(const key in new_data)
        data.append(key, new_data[key]);

      let url = "/api/provider";
      if(this.currentItem)
         url += "/" + this.currentItem.id;

      const response = await fetch(url, {
        method:"post",
        body: data
      });
      const json_response = await response.json();

      if(json_response.error){
        alert(json_response.error);
      }else {
        const provider = json_response.success;

        if (this.currentItem) {
          const index = this.items.findIndex(e => e.id == this.currentItem.id);
          for(const key in provider)
            if(key != "id")
              this.items[index][key] = provider[key];

        } else
          this.items.push(provider);
      }
    },
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
    async removeForceProvider(){
      const response = await fetch("/api/provider/" + this.currentItem.id, {method:"delete"});
      const result = await response.json();
      if(result.error) {
        alert(result.error)
      }else{
        this.items = this.items.filter(e=>e.id!=this.currentItem.id);
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