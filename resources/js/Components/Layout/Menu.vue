<template>
    <v-card>
      <v-layout>
        <v-navigation-drawer
          v-model="drawer"
          :rail="rail"
          permanent
          @click="rail = false"

        >
          <v-list-item
            prepend-avatar="https://main.u18evolute.cloud/assets/img/uni-logo/UOM.png"
            title="University of Mysore"
            nav
          >
            <template v-slot:append>
              <v-btn
                icon="mdi-chevron-left"
                variant="text"
                @click.stop="rail = !rail"
              ></v-btn>
            </template>
          </v-list-item>

          <v-divider></v-divider>

          <v-list density="compact" nav>
            <v-list-item prepend-icon="mdi-account" title="Student" value="student"></v-list-item>
          </v-list>
          <v-list density="compact" nav>
            <v-list-item prepend-icon="mdi-account" title="Shipment" value="shipment"></v-list-item>
          </v-list>
        </v-navigation-drawer>
        <v-main style="height: 250px"></v-main>
      </v-layout>
    </v-card>
  </template>
  <script>
    export default {
      data () {
        return {
          drawer: true,
          rail: true,
        }
      },
    }
  </script>
