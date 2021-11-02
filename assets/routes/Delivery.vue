<template>
  <v-row>
    <v-col cols="12" md="4" sm="6">
      <ProviderCard 
        :loading="loading"
        :provider="delivery && delivery.provider"
      />
    </v-col>

    <v-col cols="12" md="8" sm="6">
      <v-skeleton-loader 
        v-if="loading"
        type="text@4"/>
      
      <div v-if="!loading">
        Порода древисины: {{ delivery.woodSpecies.name }}
      </div>
      <div v-if="!loading">
        Объем: {{ delivery.volume }}
      </div>
      <div v-if="!loading">
        Дата поставки: {{dateToString(delivery.date)}}
      </div>
      <p v-if="!loading && delivery.note">
        Примечание: {{delivery.note}}
      </p>
    </v-col>
    
   </v-row>
</template>

<script>
import ProviderCard from "../components/ProviderCard";
import {dateToString} from "../utils/date";

export default {
  name: "Delivery",
  components:{
    ProviderCard
  },
  data:()=>({
    delivery: null,
    loading: true 
  }),
  methods:{
    dateToString:dateToString
  },
  async mounted(){
    const response = await fetch("/api/delivery/" + this.$route.params.id);
    if(response.status == 404){
      this.$router.push("/error404");
    }
    this.delivery = await response.json();
    this.loading = false;
  }
}
</script>

<style scoped>

</style>
