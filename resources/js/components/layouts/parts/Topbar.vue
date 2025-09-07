<template>
    <div>
        <div class = "fixed w-full z-30 flex bg-white  dark:bg-darkmode-800 p-2 items-center shadow-sm justify-center h-16 px-10 dark:border-gray-800">
            <div class = "logo ml-12 dark:text-white  transform ease-in-out duration-500 flex-none h-full flex items-center justify-center">
                <img class="h-14" :src="[bgTheme == 'light' ? '/images/proptech-logo.png' : '/images/proptech-logo.png']" alt="">

            </div>

            <!-- SPACER -->
            <div class = "grow h-full flex items-center justify-center"></div>
            <div class = "flex-none h-full text-center flex items-center justify-center">
                <div class="flex pr-4 items-center space-x-2 ">
                    <div>
                        <div  @click.prevent="setDark('dark')" class="moon text-blue-800 hover:text-blue-500 dark:hover:text-white dark:text-darkmode-444">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={3} stroke="currentColor" class="w-6 h-6">
                                <path strokeLinecap="round" strokeLinejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                            </svg>
                        </div>
                        <div  @click.prevent="setDark('light')" class = "sun hidden text-blue-800 hover:text-blue-500 dark:hover:text-white dark:text-darkmode-444" >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                            </svg>
                        </div>
                    </div >
                    <div class = "text-blue-800 hover:text-blue-500 dark:hover:text-white dark:text-darkmode-444">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={3} stroke="currentColor" class="w-6 h-6">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                    </div>
                </div>
                <Menu as="div" class="relative">
                    <MenuButton class="-m-1.5 flex items-center p-1.5">
                        <span class="sr-only">Open user menu</span>
                        <img class="h-8 w-8 rounded-full bg-gray-50" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                        <span class="hidden lg:flex lg:items-center">
                        <span class="ml-4 text-sm font-semibold leading-6 text-gray-900 dark:hover:text-white dark:text-darkmode-444" aria-hidden="true">{{ user.name }}</span>
                        <ChevronDownIcon class="ml-2 h-5 w-5 text-gray-400" aria-hidden="true" />
                        </span>
                    </MenuButton>
                    <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                        <MenuItems class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none">
                            <MenuItem>
                                <button :class="[ active ? 'bg-violet-500 text-white' : 'text-gray-900', 'group flex w-full items-center rounded-md px-2 py-2 text-sm', ]" >
                                    <UserCircleIcon  class="mr-2 h-4 w-4 text-blue-800" aria-hidden="true" />
                                    Account Info
                                </button>
                            </MenuItem>
                            <MenuItem>
                                <button @click.prevent="logout()" :class="[ active ? 'bg-blue-500 text-white' : 'text-gray-900', 'group flex w-full items-center rounded-md px-2 py-2 text-sm', ]" >
                                    <PowerIcon  class="mr-2 h-4 w-4 text-blue-800" aria-hidden="true" />
                                    Logout
                                </button>
                            </MenuItem>
                        </MenuItems>
                    </transition>
                </Menu>
            </div>
        </div>
    </div>
</template>


<script>
    import { MenuButton,Menu,MenuItem,MenuItems,TransitionChild,TransitionRoot,} from '@headlessui/vue';
    import { Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions } from '@headlessui/vue'
    import { UserCircleIcon, PowerIcon } from '@heroicons/vue/20/solid';
    import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/20/solid'
    import {siteSettings} from '@/store/utils';
    import {userAuthStore} from '@/store/auth';

    export default{
        name:'TopBar',
        components:{ MenuButton,Menu,MenuItem,MenuItems,TransitionChild,TransitionRoot,Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions,  PowerIcon, UserCircleIcon, CheckIcon, ChevronUpDownIcon },
        data(){
            return{

                bgTheme: siteSettings().getTheme,
                user: userAuthStore().getUser,

                userNavigation : [
                    { name: 'Your profile', href: '#' },
                    { name: 'Sign out', href: '#' },
                ],
                selected:{ id: 1, name: 'All Companies' },
                company : [
                    { id: 1, name: 'All Companies' },
                    { id: 2, name: 'Environet Total Services, Inc.' },
                    { id: 3, name: 'Global Facilities Management Experts, Inc.' },
                    { id: 4, name: 'Globalland Property Management, Inc.' },
                    { id: 5, name: 'Happy Housekeepers, Inc.' },
                    { id: 6, name: 'MGS Insurance' },
                    { id: 7, name: 'Optimum Exchange Remit, Inc.' },
                ]
            }
        },
        methods:{
            setDark(val){
                siteSettings().setTheme(val)
                    this.bgTheme = val
                    const moon = document.querySelector(".moon")
                    const sun = document.querySelector(".sun")

                    const body = document.querySelector("body")

                    if(val === "dark"){
                        document.documentElement.classList.add('dark')
                        moon.classList.add("hidden")
                        sun.classList.remove("hidden")
                        body.classList.remove("bg-white")
                        body.classList.add("bg-slate-700")

                    }else{
                        document.documentElement.classList.remove('dark')
                        sun.classList.add("hidden")
                        moon.classList.remove("hidden")
                        body.classList.remove("bg-slate-700")
                        body.classList.add("bg-white")
                    }
                },
                logout(){
                    userAuthStore().signOut();
                }
            },

        mounted(){


        },
        created(){

        }
    }

</script>
