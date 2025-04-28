
<script lang="ts" setup>
  import {ref } from 'vue'
  import { useRouter } from 'vue-router'
  import { useAuthStore } from '@/stores/auth'
  import { useSnackbar } from '@/composables/useSnackbar'

  const { show, message, variant, successVariant, errorVariant } = useSnackbar()

  const email = ref('')
  const password = ref('')
  const router = useRouter()
  const authStore = useAuthStore()

  const login = async () => {
    try {
      await authStore.login(email.value, password.value);
      // const role = authStore.user.roles[0];
      router.push('/dashboard')

      
    } catch (error) {
      errorVariant('Invalid Credentials.')
    
    }
  }

</script>
<template>
  <v-main class="fill-height bg-grey-lighten-4">
    <v-container fluid class="fill-height">
      <v-card min-width="350" class="elevation-1 mx-auto pt-4 pb-4 rounded-lg">
            <v-card-title class="text-center ">
                <h3 class="text-grey-darken-4">Login</h3>
              </v-card-title>
            <v-card-text class="pb-0">
              <v-text-field type="text" label="Email" v-model="email"></v-text-field>
              <v-text-field type="password" label="Password" v-model="password" @keydown.enter="login"></v-text-field>
            </v-card-text>
            <v-card-action class="">
              <div class="container px-4">
                <v-btn variant="flat" color="primary" class="mx-auto" block size="large" @click="login">
                  Login
                </v-btn>
              </div>
            </v-card-action>
          </v-card>
      
    </v-container>

    <!-- Snackbar -->
    <v-snackbar v-model="show" :color="variant" timeout="3000" location="top">
        {{ message }}
        
    </v-snackbar>
    <!-- End Snackbar -->
  </v-main>
  
</template>

<style scoped>
  body {
    background-color: red;
  }
</style>