import { defineStore } from "pinia";
import type { User } from '@/models/User';
import  api  from "@/services/api";
import { ref } from "vue";


export const useUserStore = defineStore("user", { 

    state: () => ({
        users: [] as User[],
        loading: false,
       
    }),

    actions: {

        async getAllUsets() {
            this.loading = true;
            try {
                const response = await api.get('api/admin/users');
                this.users = response.data.data || []
                this.loading = false;
            } catch (error) {
                console.error("Error fetching users:", error);
            } finally {
                this.loading = false;
            }
        },
        
        async addNewUser(user: User) {

            try {
                const response = await api.post('api/admin/users', user);
                this.users.push(response.data);
                return true
            } catch (error: any) {
              if(error.responnse && error.response?.status == 422) {
                throw error.response.data.errors
              } else {
                console.error("Error adding user:", error);
                throw error
              }

              return false
            }
        },
        async updateUser(id: number, user: User) {
            
            try {
                const response = await api.put(`api/admin/users/${id}`, user);
                const index = this.users.findIndex(u => u.id === id);
                if (index !== -1) {
                    this.users[index] = response.data;
                }
                return true
            } catch (error) {
                console.error("Error updating user:", error);
                return false
            }
        },

        async deleteUser(id: number) {

            try {
                await api.delete(`api/admin/users/${id}`);
                this.users = this.users.filter(user => user.id !== id);
                return true
            } catch (error) {
                console.error("Error deleting user:", error);
                return false
            }
        },
        async bulkDeleteUsers(ids: number[]) {
            try {
                await api.post('api/admin/users/bulk-delete', { ids });
                this.users = this.users.filter(user => !ids.includes(user.id));
                return true
            } catch (error) {
                console.error("Error deleting users:", error);
                return false
            }
        }
    }

});