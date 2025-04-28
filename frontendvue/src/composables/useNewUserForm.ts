import { ref } from "vue";
import { ro } from "vuetify/locale";


export function useNewUserForm() {

    const newUser = ref({
        first_name: "",
        last_name: "",
        email: "",
        address: "",
        phone: "",
        postal_code: "",
        username: "",
        password: "",
        password_confirmation: "",
        permissions: [],
        id: null,
        role: "",
        roles: "",
    })

    const roles = ['admin', 'user']

    const resetForm = () => { 
        newUser.value = {
            first_name: "",
            last_name: "",
            email: "",
            address: "",
            phone: "",
            postal_code: "",
            username: "",
            password: "",
            password_confirmation: "",
            permissions: [],
            id: null,
            role: "",
            roles: "",
        }
    }

    return {
        newUser,
        roles,
        resetForm,
    }
}