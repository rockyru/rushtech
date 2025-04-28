<script setup lang="ts">
import { useAuthStore } from '@/stores/auth';

const authStore = useAuthStore();

</script>
<template>
    <v-container >
        <v-row>
            <v-col cols="6" offset="3">
                <v-card>
                    <v-card-title>
                        <h4>Profile</h4>
                    </v-card-title>
                    <v-card-text>
                        <v-row>
                            <v-col cols="2">
                                <label for="">Name</label>
                            </v-col>
                            <v-col cols="10">
                                <p>{{ `${authStore.user?.first_name} ${authStore.user?.last_name}`  }}</p>
                            </v-col>
                        </v-row>

                        <v-row>
                            <v-col cols="2">
                                <label for="">Email</label>
                            </v-col>
                            <v-col cols="10">
                                <p>{{ authStore.user?.email  }}</p>
                            
                               
                            </v-col>
                        </v-row>

                        <v-row>
                            <v-col cols="2">
                                <label for="">Username</label>
                            </v-col>
                            <v-col cols="10">
                              
                                <p>{{ authStore.user?.username }}</p>
                               
                            </v-col>
                        </v-row>

                        <v-row>
                            <v-col cols="2">
                                <label for="">Contact</label>
                            </v-col>
                            <v-col cols="10">
                                <p>{{ authStore.user?.address  }}</p>
                                <p>{{ authStore.user?.postal_code }}</p>
                                <p>{{ authStore.user?.phone }}</p>
                            </v-col>
                        </v-row>
                       
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
    
</template>