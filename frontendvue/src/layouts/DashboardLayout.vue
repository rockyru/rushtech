import { RouterView } from 'vue-router';
<script lang="ts" setup>
import { ref } from 'vue'

const theme = ref('light')

</script>
<template>
    <v-responsive>
        <v-app :theme="theme">
            <v-app-bar class="px-3">
                <Header />
            </v-app-bar>
            <v-main class="bg-grey-lighten-4">
                <v-container fluid>
                    <RouterView></RouterView>
                </v-container>
            </v-main>
        
        </v-app>
    </v-responsive>
  </template>
  

  