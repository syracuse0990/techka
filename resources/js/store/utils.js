import { defineStore } from 'pinia'

export const siteSettings = defineStore('utilsPinia', {
    state: () => ({
        aside: false,
        theme: 'light',
    }),
    getters: {
        getAside: (state) => state.aside,
        getTheme: (state) => state.theme,
    },
    actions: {
        setAside(status) {
            this.aside = status;
        },
        setTheme(status) {
            this.theme = status;
        },
    },
    persist: true,
})
