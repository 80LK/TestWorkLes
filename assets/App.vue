<template>
  <v-app id="inspire">

    <v-app-bar app>
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title>Application</v-toolbar-title>
    </v-app-bar>

    <v-navigation-drawer
        v-model="drawer"
        fixed
        temporary
    >
      <v-list
          dense
          nav
      >
        <v-list-item
            v-for="item in items"
            :key="item.title"
            link
        >
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
      <!--  -->
    </v-navigation-drawer>

    <v-main class="grey lighten-2">
      <Home></Home>
    </v-main>
  </v-app>
</template>

<script>
  import routes from "./routes/routes";
  import Home from "./routes/Home.vue";

  export default {
    name: "App",
    components: {
      Home
    },
    data: () => ({
      drawer: null,
      items: [],
      right: null
    })
  }
</script>
