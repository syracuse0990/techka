import { defineStore } from 'pinia'
import router from '@/router/index'
import axios from 'axios';


export const userAuthStore = defineStore('userAuth', {
    state: () => ({
        authenticated: false,
        user: {},
        permissions: [],
    }),

    getters: {
        getUser: (state) => state.user,
        getPermissions: (state) => state.permissions,
        getAuthentition: (state) => state.authenticated
    },

    actions: {
        async getToken() {
            await axios.get("/sunctum/csrf-cookie");
        },
        redirect(){
            router.push({name:'dashboard'});
        },
        checkPermission(name){
            return this.permissions.includes(name);
        },
        async signOut(){
            this.authenticated = false
            this.user = {}
            this.permissions = []
            router.push({name:'login'});
        },
    },
    persist: true,
});
