<script setup lang="ts">
import { useNewUserForm } from '@/composables/useNewUserForm';
import { useNewUserFormRules } from '@/composables/useNewUserFormRules';
import { useNewUserFormErrors } from '@/composables/useNewUserFormErrors';
import { useSnackbar } from '@/composables/useSnackbar';
import { ref, computed, defineProps, watch } from 'vue';
import { useUserStore } from '@/stores/user';
import { useAuthStore } from '@/stores/auth';
import type { User } from '@/models/User';

const { newUser, roles, resetForm } = useNewUserForm();
const { show,message,variant,successVariant,errorVariant } = useSnackbar();
const { formErrors, setErrors, removeFieldError, resetErrors } = useNewUserFormErrors();

const rules = computed(() => useNewUserFormRules(newUser.value.password)); 
const validForm = ref(false);

const userStore = useUserStore();

const props= defineProps({
  isEditMode: {
    type: Boolean,
    default: false
  },
  user: {
    type: Object as () => User | null,
    default: null,
   
  },
  roles: {
      type: Array as () => string[],
      default: () => []
    },
    showDiualog: {
      type: Boolean,
      default: false
    },
    modelValue: {
      type: Boolean,
      default: false
    },
    
    
})

const emit = defineEmits<{
  (e: 'update:modelValue', value: boolean): void
  (e: 'refresh'): void
 
}>()


const isOpen = computed({
  get: () => props.modelValue,
  set: (val) => emit('update:modelValue', val),
})



const closeDialog = () => {
  emit('update:modelValue', false);
  
  resetForm();
  resetErrors();
}

watch(() => props.user, (user) => {
  if (user && props.isEditMode) {
   newUser.value = { ...user };
  } else {
    resetForm();
  }
}, { immediate: true });



const submitForm = async() => {
   
    if(props.isEditMode) {
        if(!newUser.value.id) {
            errorVariant('ID is required for update');
            return;
        }
        resetErrors();
        if(!validForm.value) {
            errorVariant('Please check the form for errors.');
            return;
        }
     
       await submitUpdateUser();
    } else {
       await submitAddNewUser();
    }
}

async function submitAddNewUser() {
    resetErrors(); 
        try {
        const response =  await userStore.addNewUser(newUser.value);
        if(response) {
            successVariant('User added successfully');
        
            userStore.getAllUsets();
            resetForm();
            
            emit('update:modelValue', false);
        } 
            
        
        } catch (error: any) {
           if(error.response && error.response.status === 422) {
                setErrors(error.response.data.errors);
                errorVariant('Please check the form for errors.');
            } 
            
        }
}

async function submitUpdateUser() {
    if(!newUser.value.id) {
        errorVariant('ID is required for update');
        return;
    }

    try {
        const response = await userStore.updateUser(newUser.value.id, newUser.value);
        if(response) {
            successVariant('User updated successfully');
            userStore.getAllUsets();
            resetForm();
            emit('update:modelValue', false);
        }
    } catch (error: any) {
        if(error.response && error.response.status === 422) {
            setErrors(error.response.data.errors);
            errorVariant('Please check the form for errors.');
        } else {
            errorVariant('An error occurred while updating the user');
        }
    } 
}

onMounted(() => {
   
});
</script>

<template>
  <v-dialog v-model="isOpen" max-width="600">
    <v-card>
        <v-card-title class="text-h6 pt-4">
            {{ isEditMode ? 'Edit User' : 'Add New User' }}
        </v-card-title>
        <v-card-text>
            <v-form ref="addNewUserForm" v-model="validForm" lazy-validation>
                <v-row>
                    <v-col >
                        <v-text-field v-model="newUser.first_name" label="First Name" required :rules="[rules.required]" 
                        :error-messages="formErrors.first_name" @input="removeFieldError('first_name')"></v-text-field>
                    </v-col>
                    <v-col >
                        <v-text-field v-model="newUser.last_name" label="Last Name" required :rules="[rules.required]" 
                        :error-messages="formErrors.last_name" @input="removeFieldError('last_name')"></v-text-field>
                    </v-col>
                </v-row>
                <v-row no-gutters>
                <v-col>
                    <v-text-field v-model="newUser.username" label="Username" required :rules="[rules.required, rules.usernameLength]" 
                    :error-messages="formErrors.username" @input="removeFieldError('username')"></v-text-field>
                </v-col>
                </v-row>
                <v-row no-gutters>
                <v-col>
                    <v-text-field v-model="newUser.email" label="Email" required :rules="[rules.required, rules.email]"
                    :error-messages="formErrors.email" @input="removeFieldError('email')"></v-text-field>
                </v-col>
                </v-row>
                <v-row no-gutters>
                <v-col>
                    <v-text-field v-model="newUser.address" label="Address" required :rules="[rules.required]"
                    :error-messages="formErrors.address" @input="removeFieldError('address')"></v-text-field>
                </v-col>
                </v-row>
                <v-row>
                    <v-col>
                        <v-text-field v-model="newUser.phone" label="Phone" required :rules="[rules.required]"
                        :error-messages="formErrors.phone" @input="removeFieldError('phone')"></v-text-field>
                    </v-col>
                    <v-col>
                        <v-text-field v-model="newUser.postal_code" label="Postal Code" required :rules="[rules.required]"
                        :error-messages="formErrors.postal_code" @input="removeFieldError('postal_code')"></v-text-field>
                    </v-col>
                </v-row>
                <v-row no-gutters>
                <v-col>
                    <label for="" class="text-red text-subtitle-2" v-if="isEditMode">(Optional)</label>
                    <v-text-field v-model="newUser.password" label="Password" type="password" required :rules="isEditMode && !newUser.password ? [] : [rules.required, rules.minPasswordLength]"
                    :error-messages="formErrors.password" @input="removeFieldError('password')"></v-text-field>
                </v-col>
                </v-row>
                <v-row no-gutters>
                <v-col>
                    <label for="" class="text-red text-subtitle-2" v-if="isEditMode">(Optional)</label>
                    <v-text-field v-model="newUser.password_confirmation" label="Confirm Password" type="password" required :rules="isEditMode && !newUser.password_confirmation ? [] : [rules.required, rules.passwordMatch]"
                    :error-messages="formErrors.password_confirmation" @input="removeFieldError('password_confirmation')"></v-text-field>
                </v-col>
                </v-row>
                <v-row no-gutters>
                <v-col v-if="!isEditMode">
                    <v-select v-model="newUser.role" :items="roles" label="Role"  required :rules="[rules.required]" 
                    :error-messages="formErrors.role" @input="removeFieldError('role')"></v-select>
                </v-col>
                </v-row>
                
            </v-form>
        </v-card-text>
        <v-card-actions class="pb-4">
            <v-spacer></v-spacer>
            <v-btn text color="primary" @click="closeDialog">Cancel</v-btn>
            <v-btn variant="flat" color="primary" @click="submitForm">
                {{ isEditMode ? 'Update User' : 'Add User' }}
            </v-btn>
        </v-card-actions>
    </v-card>
</v-dialog>

<!-- Snackbar -->
<v-snackbar v-model="show" :color="variant" timeout="3000" location="top">
    {{ message }}
    
</v-snackbar>
<!-- End Snackbar -->
</template>