<template>
  <v-dialog
      :value="opened"
      width="500"
      @input="$emit('change', $event)"
  >
    <v-card>
      <v-card-title class="text-h5">
        {{ title }}
      </v-card-title>
      <v-card-text>
        <slot/>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
            color="error darken-1"
            text
            @click="agree()"
        >
          {{ agreeTitle || "Да" }}
        </v-btn>
        <v-btn text @click="disagree()">
          {{ disagreeTitle || "Нет" }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: "ChangeNotSave",
  props: {
    title: String,
    agreeTitle: String,
    disagreeTitle: String,
    opened: Boolean
  },
  methods: {
    disagree() {
      this.close();
      this.$emit("disagree");
    },
    agree() {
      this.close();
      this.$emit("agree");
    },
    close() {
      this.$emit("change", false);
    }
  },
  model: {
    prop: 'opened',
    event: 'change'
  }
}
</script>

<style scoped>

</style>