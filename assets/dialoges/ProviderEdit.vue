<template>
  <v-dialog
      :value="isOpen"
      scrollable
      width="500"
      @input="$emit('change', $event)"
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

          <v-checkbox v-model="is_jur" label="Юр. лицо"/>
          <v-text-field
              v-model:value="companyName"
              :disabled="!is_jur"
              :rules="[v=> !is_jur || !!v || 'Обязательное поле!']"
              label="Имя компании"
              required/>

          <v-text-field
              v-model:value="surname"
              :rules="[v=>!!v || 'Обязательное поле!']"
              counter="255"
              label="Фамилия"
              required
          />
          <v-text-field
              v-model:value="name"
              :rules="[v=>!!v || 'Обязательное поле!']"
              counter="255"
              label="Имя"
              required
          />
          <v-text-field
              v-model:value="fatherName"
              :rules="[v=>!!v || 'Обязательное поле!']"
              counter="255"
              label="Отчество"
              required
          />

          <v-text-field
              v-model:value="phone"
              :rules="[v=>!!v || 'Обязательное поле!', v=>/^\d+$/.test(v) || 'Номер телефона должен состоять из цифр']"
              append-icon="mdi-phone"
              counter="11"
              label="Телефон"
              required
          />

          <v-textarea
              v-model:value="address"
              :rules="[v=>!!v || 'Обязательное поле!']"
              append-icon="mdi-map-marker"
              auto-grow
              counter="1000"
              label="Адрес"
              required
              rows="1"
          />
        </v-form>
      </v-card-text>

      <v-divider/>

      <v-card-actions>
        <v-btn
            color="success"
            text
            @click="save()"
        > Сохранить
        </v-btn>

        <v-btn
            color="primary"
            text
            @click="cancel()"
        > Отмена
        </v-btn>
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
  components: {
    AgreeDialog
  },
  data: function () {
    return {
      is_jur: false,
      name: "", surname: "", fatherName: "",
      companyName: "",
      phone: "", address: "",

      open_changenotsave: false,
      valid: false
    }
  },
  props: {
    provider: Object,
    opened: Boolean
  },
  methods: {
    save() {
      if (!(this.valid = this.$refs.form.validate()))
        return;

      if (this.hasChanges)
        this.$emit("save", {
          name: this.name,
          surname: this.surname,
          fatherName: this.fatherName,
          phone: this.phone,
          address: this.address,
          companyName: this.is_jur ? this.companyName : ""
        });
      this.close();
    },
    cancel() {
      if (this.hasChanges)
        this.open_changenotsave = true;
      else
        this.close()
    },
    agreeNotSave() {
      this.close()
    },
    close() {
      this.$emit('change', false);
    }
  },
  computed: {
    isOpen: function () {
      if (this.provider) {
        this.name = this.provider.name;
        this.surname = this.provider.surname;
        this.fatherName = this.provider.fatherName;

        this.companyName = this.provider.companyName;
        this.is_jur = !!this.provider.companyName;

        this.phone = this.provider.phone;
        this.address = this.provider.address;
      } else {
        this.name =
            this.surname =
                this.fatherName =
                    this.companyName =
                        this.phone =
                            this.address = "";

        this.is_jur = false;
        if (this.$refs && this.$refs.form)
          this.$refs.form.resetValidation();
      }

      return this.opened;
    },
    hasChanges: function () {
      if (this.provider) {
        return this.name !== this.provider.name ||
            this.surname !== this.provider.surname ||
            this.fatherName !== this.provider.fatherName ||
            this.is_jur !== (!!this.provider.companyName) ||
            (this.is_jur && this.companyName !== this.provider.companyName) ||
            this.phone !== this.provider.phone ||
            this.address !== this.provider.address;
      } else {
        return this.name !== "" ||
            this.surname !== "" ||
            this.fatherName !== "" ||
            (this.is_jur && this.companyName !== "") ||
            this.phone !== "" ||
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