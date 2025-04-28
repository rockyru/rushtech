<script lang="ts" setup>
import { computed } from 'vue'
import { useAuthStore } from '@/stores/auth'
import { navItems } from './NavItems/nav-items'

const authStore = useAuthStore()
const filteredNavItems = navItems.filter(item => item.roles.includes(authStore.role))
</script>
<template>
   <v-btn v-for="item in filteredNavItems" :key="item.title" :to="item.to" text class="mx-2">
    {{ item.title }}
   </v-btn>
  
</template>

<style>
    .active {
        
        border-radius: 5px;
        
    }
    .active > button {
        background-color:rgb(var(--v-theme-primary)) !important;
        color: white !important;
    }
</style>