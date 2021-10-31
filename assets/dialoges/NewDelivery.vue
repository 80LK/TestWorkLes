<template>
  <v-dialog
      :value="opened"
      scrollable
      width="500"
  >
    <v-card>
      <v-card-title class="text-h5 grey lighten-2">
        Добавить поставку
      </v-card-title>

      <v-divider/>

      <v-card-text>
        <v-spacer/>
        <v-form
            ref="form"
            v-model="valid"
        >
          <v-select
              v-model:value="woodSpecies"
              :disabled="woodsSpeciesLoading"
              :items="woodsSpecies"
              :loading="woodsSpeciesLoading"
              :rules="[v=>v!=null||'Обязательное поле!']"
              item-text="name"
              item-value="id"
              label="Порода древисины"
              required
          />

          <v-text-field
              v-model:value="volume"
              :rules="[
                  v => !!v || 'Обязательное поле!',
                  v => !isNaN(parseFloat(v)) || 'Допустимы только цифры',
                  v => parseFloat(v) > 0 || 'Число должно быть больше 0'
              ]"
              label="Объем"
              required
          />

          <v-select
              v-model:value="provider"
              :disabled="providersLoading"
              :items="providers"
              :loading="providersLoading"
              :rules="[v=>v!=null||'Обязательное поле!']"
              item-text="name"
              item-value="id"
              label="Поставщик"
              required
          />

          <v-menu ref="menuDate"
                  :close-on-content-click="false"
                  nudge-width="min-content"
                  offset-y>
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                  :value="date"
                  label="Дата поставки"
                  v-bind="attrs"
                  v-on="on"
              >
                <template v-slot:append>
                  <v-fade-transition leave-absolute>
                    <v-icon
                        v-on="on">
                      mdi-calendar
                    </v-icon>
                  </v-fade-transition>
                </template>
              </v-text-field>
            </template>
            <v-date-picker
                v-model="date"
                @click:date="$refs.menuDate.save()"
            />
          </v-menu>

          <v-menu ref="menuTime"
                  :close-on-content-click="false"
                  nudge-width="min-content"
                  offset-y>
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                  :value="time"
                  label="Время поставки"
                  v-bind="attrs"
                  v-on="on"
              >
                <template v-slot:append>
                  <v-fade-transition leave-absolute>
                    <v-icon
                        v-on="on">
                      mdi-clock-outline
                    </v-icon>
                  </v-fade-transition>
                </template>
              </v-text-field>
            </template>
            <v-time-picker
                v-model="time"
                format="24hr"
                use-seconds
                @click:second="$refs.menuTime.save()"
            />
          </v-menu>

          <v-textarea
              v-model="note"
              auto-grow
              label="Примечание"
              rows="1"/>
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
import {getCompanyName} from "../utils/provider";

export default {
  name: "NewDelivery",
  components: {
    AgreeDialog
  },
  data: function () {
    const date = (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString();
    return {
      woodSpecies: null,
      provider: null,
      volume: 0,
      note: "",
      date: date.substr(0, 10),
      time: date.substr(11, 8),

      woodsSpecies: [],
      woodsSpeciesLoading: true,

      providers: [],
      providersLoading: true,

      open_changenotsave: false,

      valid: false
    }
  },
  props: {
    opened: Boolean
  },
  mounted() {
    this.initWoodsSpecies();
    this.initProviders();
    this.$on("change", this.resetFields);
  },
  destroyed() {
    this.$off("change", this.resetFields);
  },
  methods: {
    async initWoodsSpecies() {
      const response = await fetch("/api/wood_species/list");
      this.woodsSpecies = await response.json();
      this.woodsSpeciesLoading = false;
    },
    async initProviders() {
      const response = await fetch("/api/provider/list");
      this.providers = (await response.json()).map(e => ({
        id: e.id,
        name: getCompanyName(e)
      }));
      this.providersLoading = false;
    },
    resetFields() {
      this.woodSpecies = null;
      this.provider = null;
      this.volume = 0;

      this.initWoodsSpecies();
      this.initProviders();
    },
    save() {
      if (!(this.valid = this.$refs.form.validate()))
        return;

      if (this.hasChanges)
        this.$emit("save", {
          woodSpecies: this.woodSpecies,
          provider: this.provider,
          volume: this.volume,
          note: this.note || null,
          date: this.date,
          time: this.time,
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
    hasChanges: function () {
      return this.volume !== 0 ||
          this.note !== "" ||
          this.provider !== null ||
          this.woodSpecies !== null;
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