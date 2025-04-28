<script lang="ts" setup>
import { useAuthStore } from '@/stores/auth'
import { useRouter } from 'vue-router'

const authStore = useAuthStore()

</script>
<template>  
    <div>
        <h1>Welcome, {{ authStore.user?.first_name }}</h1>
    </div>
</template>