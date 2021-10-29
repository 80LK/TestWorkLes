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
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="text-h6">
            Application
          </v-list-item-title>
          <v-list-item-subtitle>
            subtext
          </v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>

      <v-list
          dense
          nav
      >
        <router-link
            v-for="item in items"
            :key="item.title"
            v-bind:to="item.path"
            v-slot="{  navigate }"
        >
          <v-list-item link @click="navigate">
            <v-list-item-icon>
              <v-icon>{{ item.icon || "mdi-view-dashboard" }}</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>
                {{ item.title }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </router-link>
      </v-list>
      <!--  -->
    </v-navigation-drawer>

    <v-main class="grey lighten-2">
      <router-view></router-view>
    </v-main>
  </v-app>
</template>

<script>
  import routes from "./routes/general_routes";
  import Home from "./routes/Home.vue";

  export default {
    name: "App",
    components: {
      Home
    },
    data: (...args) => {
      console.log("data", args)
      return {
        drawer: null,
        items: routes,
        right: null
      }
    }
  }
</script>
