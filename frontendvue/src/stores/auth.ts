import { defineStore  } from "pinia";
import api from "@/services/api";
import type { User } from '../models/User';
import type { AuthState } from '../models/AuthState';

export const useAuthStore = defineStore("auth", {

    state: (): AuthState => ({
        
       user: null,  
        token: localStorage.getItem('token') || null,
        role: null,
    }),

   persist: true,
    actions: {

        async login(email: string, password: string) {
            try {
                await api.get('sanctum/csrf-cookie')
                const response = await api.post('api/login', { email, password })
                this.setAuth(response.data.token, response.data.user)
            } catch (error) {
                console.error("Login failed:", error)
                throw error
            }
        },
        setAuth(token: string, user: User) {
            this.token = token
            this.user = user
            this.role = user.roles.length > 0 ? user.roles[0] : null
            // Store the token and user in localStorage
            localStorage.setItem('token', token)
           
        },

        setToken(token: string) { 
            this.token = token
            localStorage.setItem('token', token)
        },

        setRole(role: string) { 
            this.role = role
        },

        logout() {
            this.token = null
            this.user = null
            localStorage.removeItem('token')
          
        }
    }
})