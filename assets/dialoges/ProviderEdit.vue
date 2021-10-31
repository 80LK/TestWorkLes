<template>
  <v-dialog
      :value="isOpen"
      scrollable
      width="500"
  >
    <v-card>
      <v-card-title class="text-h5 grey lighten-2">
        {{ provider ? "Редактировать поставщика" : "Добавить поставщика" }}
      </v-card-title>

      <v-divider/>

      <v-card-text>
        <v-spacer/>
        <v-form
            ref="form"
            v-model="valid"
        >

          <v-checkbox label="Юр. лицо" v-model="is_jur"/>
          <v-text-field
              label="Имя компании"
              :disabled="!is_jur"
              :rules="[v=> !is_jur || !!v || 'Обязательное поле!']"
              required
              v-model:value="companyName"/>

          <v-text-field
              label="Фамилия"
              required
              :rules="[v=>!!v || 'Обязательное поле!']"
              counter="255"
              v-model:value="surname"
          />
          <v-text-field
              label="Имя"
              required
              :rules="[v=>!!v || 'Обязательное поле!']"
              counter="255"
              v-model:value="name"
          />
          <v-text-field
              label="Отчество"
              required
              :rules="[v=>!!v || 'Обязательное поле!']"
              counter="255"
              v-model:value="fatherName"
          />

          <v-text-field
              label="Телефон"
              required
              v-model:value="phone"
              append-icon="mdi-phone"
              :rules="[v=>!!v || 'Обязательное поле!', v=>/^\d+$/.test(v) || 'Номер телефона должен состоять из цифр']"
              counter="11"
          />

          <v-textarea
              label="Адрес"
              required
              v-model:value="address"
              :rules="[v=>!!v || 'Обязательное поле!']"
              append-icon="mdi-map-marker"
              auto-grow
              rows="1"
              counter="1000"
          />
        </v-form>
      </v-card-text>

      <v-divider/>

      <v-card-actions>
        <v-btn
            color="success"
            text
            @click="save()"
        > Сохранить </v-btn>

        <v-btn
            color="primary"
            text
            @click="cancel()"
        > Отмена </v-btn>
      </v-card-actions>
    </v-card>

    <AgreeDialog
        v-model="open_changenotsave"
        title="Изменения не сохранены"
        @agree="agreeNotSave">
      Все несохраненные изменения будут потеряны, все равно закрыть окно?
    </AgreeDialog>

  </v-dialog>
</template>

<script>
import AgreeDialog from "./AgreeDialog";

export default {
  name: "ProviderEdit",
  components:{
    AgreeDialog
  },
  data:function(){
    return {
      is_jur: false,
      name:"", surname:"", fatherName:"",
      companyName: "",
      phone:"", address:"",

      open_changenotsave:false,
      valid:false
    }
  },
  props:{
    provider:Object,
    opened:Boolean
  },
  methods:{
    save(){
      if(!(this.valid = this.$refs.form.validate()))
          return;

      if(this.hasChanges)
        this.$emit("save", {
          name:this.name,
          surname:this.surname,
          fatherName:this.fatherName,
          phone:this.phone,
          address:this.address,
          companyName:this.is_jur ? this.companyName : ""
        });
      this.close();
    },
    cancel(){
      if(this.hasChanges)
        this.open_changenotsave = true;
      else
        this.close()
    },
    agreeNotSave(){
      this.close()
    },
    close(){
        this.$emit('change', false);
    }
  },
  computed:{
    isOpen:function(){
      if(this.provider){
        this.name = this.provider.name;
        this.surname = this.provider.surname;
        this.fatherName = this.provider.fatherName;

        this.companyName = this.provider.companyName;
        this.is_jur = !!this.provider.companyName;

        this.phone = this.provider.phone;
        this.address = this.provider.address;
      }else{
        this.name =
        this.surname =
        this.fatherName =
        this.companyName =
        this.phone =
        this.address = "";
        this.is_jur = false;
      }

      return this.opened;
    },
    hasChanges:function (){
      if(this.provider){
        return this.name !== this.provider.name ||
        this.surname !== this.provider.surname ||
        this.fatherName !== this.provider.fatherName ||
        this.is_jur !== (!!this.provider.companyName) ||
        (this.is_jur && this.companyName !== this.provider.companyName)  ||
        this.phone!== this.provider.phone  ||
        this.address !== this.provider.address;
      }else{
        return this.name !== "" ||
            this.surname !== "" ||
            this.fatherName !== "" ||
            (this.is_jur && this.companyName !== "")  ||
            this.phone !== ""  ||
            this.address !== "";
      }
    }
  },
  model: {
    prop: 'opened',
    event: 'change'
  },
}
</script>

<style scoped>

</style>