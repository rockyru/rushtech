<script setup>
import { ref } from 'vue'
import { RouterView } from 'vue-router';
import Menu from '@/components/Menu.vue'
import { useAuthStore } from '@/stores/auth'
import { useRouter } from 'vue-router'
const router = useRouter()
const authStore = useAuthStore()

</script>
<template>
    <Menu />
    <v-spacer></v-spacer>
    
    <v-menu >
           
        <template #activator="{ props }">
            <v-btn v-bind="props" icon color="primary">
            
            <v-icon>mdi-arrow-down-drop-circle</v-icon>
            </v-btn>
        </template>
        <v-list min-width="250px" class="pa-1">
            <v-list-item>
                <div v-if="authStore.user">
                    <h4>{{  `${authStore.user.first_name} ${authStore.user.last_name}` }}</h4>
                    <small>{{ authStore.user.email }}</small>
                </div>
            </v-list-item>
            <v-divider></v-divider>
            <v-list-item @click="authStore.logout(); router.push('/')">
                <v-list-item-title>Sign Out</v-list-item-title>
            </v-list-item>
        </v-list>
    </v-menu>

</template>