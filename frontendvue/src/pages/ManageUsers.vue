<script setup lang="ts">
import { onMounted, ref, computed } from 'vue';
import { useUserStore } from '@/stores/user';
import type { User } from '@/models/User';
import { useAuthStore } from '@/stores/auth';
import { useNewUserForm } from '@/composables/useNewUserForm';
import { useNewUserFormErrors } from '@/composables/useNewUserFormErrors';
const userStore = useUserStore();

const headers = [

    { title: 'ID', key: 'id' },
    { title: 'Name', key: 'first_name' },
    { title: 'Username', key: 'username' },
    { title: 'Phone', key: 'phone' },
    { title: 'Address', key: 'address' },
    { title: 'Zip Code', key: 'postal_code' },
    { title: 'Email', key: 'email' },
    { title: 'Roles', key: 'roles' },
    { title: 'Permissions', key: 'permissions' },
   
    { title: 'Actions', key: 'actions' }
]

const users = ref<User[]>([])
const selectedUsers = ref<number[]>([]);
const authStore = useAuthStore();
const confirmDeleteDialog = ref(false);
const addUserDialog = ref(false);
const deleteMode = ref<'single' | 'bulk'>('single');
const userIdToDelete = ref<number | null>(null);
const openUserDialog = ref(false);
const editMode = ref(false);
const userToEdit = ref<User | null>(null);

const { newUser, roles, resetForm } = useNewUserForm();
const { resetErrors } = useNewUserFormErrors();
const openNewUserDialog = () => {
    
    editMode.value = false;
    userToEdit.value = null;
    openUserDialog.value = true;
   
    
}

const openUpdateUserDialog = (user: User) => {
    resetForm();
    openUserDialog.value = true;
    editMode.value = true;
    userToEdit.value = user;
   
}

const openSingleDeleteDialog = (id: number) => {
    userIdToDelete.value = id;
    deleteMode.value = 'single';
    confirmDeleteDialog.value = true;
}

const openBulkDeleteDialog = () => {
    deleteMode.value = 'bulk';
    confirmDeleteDialog.value = true;
}

const confirmDelete = async () => {
    if (deleteMode.value === 'single' && userIdToDelete.value !== null) {
        await userStore.deleteUser(userIdToDelete.value);
    } else if (deleteMode.value === 'bulk') {
        await userStore.bulkDeleteUsers(selectedUsers.value);
        selectedUsers.value = [];
    }
    confirmDeleteDialog.value = false;
}




onMounted(() => {
    
    userStore.getAllUsets();
});
</script>
<template>
   
    <v-container fluid>
        <v-card>
            <v-card-title class="pa-10">
                <div class="d-flex align-center w-100">
                    <h4>Manage Users</h4>
                    <v-spacer></v-spacer>
                    <v-btn v-if="selectedUsers.length > 0" color="error" @click="openBulkDeleteDialog" class="mr-2">Delete Selected ({{ selectedUsers.length }})</v-btn>
                    
                    <v-btn color="primary" @click="openNewUserDialog">Add User</v-btn>
                </div>
                
            </v-card-title>

            <v-card-text class="pa-10">
                <v-data-table :items="userStore.users" :headers="headers" :loading="userStore.loading" item-value="id" show-select v-model="selectedUsers">
                    
                    <template #item.roles="{ item }">
                        <v-chip v-for="role in item.roles" :key="role" color="primary" class="ma-1">
                            {{ role }}
                        </v-chip>
                    </template>
                    <template #item.permissions="{ item }">
                        <v-chip v-for="permission in item.permissions" :key="permission" color="primary" class="ma-1">
                            {{ permission }}
                        </v-chip>
                    </template>
                    <template #item.first_name="{item}">
                        {{ `${item.first_name} ${item.last_name}` }}
                    </template>
                    <template #item.actions="{item}">
                        <div class="d-flex justify-space-between">
                            <v-btn @click="openUpdateUserDialog(item)" size="small" class="mr-2" text variant="text">
                                Update
                            </v-btn>
                            <v-btn color="error" size="small" @click="openSingleDeleteDialog(item.id)" text variant="text">
                                Delete
                            </v-btn>
                        </div>
                    </template>
                </v-data-table>

                <!-- Confirm Delete Dialog -->
                <v-dialog v-model="confirmDeleteDialog" max-width="400">
                    <v-card>
                        <v-card-title class="text-h6">
                            Confirm Delete
                        </v-card-title>
                        <v-card-text>
                            Are you sure you want to delete
                            <span v-if="deleteMode === 'single'">this user?</span>
                            <span v-else>{{ selectedUsers.length }} users?</span>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="dark-grey" text @click="confirmDeleteDialog = false">Cancel</v-btn>
                            <v-btn color="error" variant="flat" @click="confirmDelete">Confirm</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
                <!-- End Confirm Delete Dialog -->

                <!-- Add User Dialog -->
                <UserDialog
                    v-model="openUserDialog" :is-edit-mode="editMode" :user="userToEdit">
                </UserDialog>
                

                

            </v-card-text>
        </v-card>
    </v-container>
</template>