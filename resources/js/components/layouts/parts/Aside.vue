<template>
    <div>
        <aside class = "w-60 -translate-x-48 fixed transition transform ease-in-out duration-1000 z-50 flex h-screen bg-aside dark:bg-darkmode-700 border-r border-blue-300 shadow-md">
            <div class = "max-toolbar translate-x-24 scale-x-0 w-full justify-center transition bg-white transform ease-in duration-300 flex items-center dark:border-[#38BDF8] dark:bg-darkmode-700 absolute  h-16 pr-4">
                <div  class = "flex items-center justify-center  text-white ">
                    <div class= "transform ease-in-out duration-300">
                        <!-- <img class="h-12" src="/images/logo.png" alt=""> -->
                         <span class="text-aside font-bold text-2xl text-shadowed">Tech<span class="text-primary">Ka</span></span>
                    </div>
                </div>
            </div>
            <div @click.prevent="openNav()" class = "-right-[22px] transition transform ease-in-out duration-500 flex bg-white border-2 border-primary  dark:border-[#38BDF8] bg-lightblue dark:bg-darkmode-700 dark:hover:bg-blue-100 hover:bg-green-100 absolute top-2.5 p-1 rounded-full text-white">
                <img class="rounded-full h-8 w-8 transition transform ease-in-out duration-500 hover:scale-x-[-1]" :src="logo" alt="">
            </div>


            <div class= "max hidden text-white mt-20 flex-col space-y-2 w-full h-[calc(100vh)]">
                <ul role="list" class="space-y-1 px-2">
                    <li v-for="item in navigation" :key="item.key" >
                        <router-link v-if="!item.children && item.permission" :to="item.href" :class="[$route.path.includes(item.href) ? 'bg-primary text-darkmode-600 dark:bg-darkmode-500' : 'hover:bg-primary dark:hover:bg-darkmode-500 hover:text-white', 'group text-white hover:text-darkmode-600 hover:cursor-pointer flex gap-x-3 rounded-md p-2 text-sm leading-6 font-normal dark:text-darkmode-555']">
                            <component :is="item.icon" class="h-6  hover:text-darkmode-600 w-6 shrink-0 dark:text-darkmode-555" aria-hidden="true" />
                            {{ item.name }}
                        </router-link>
                        <Disclosure as="div" v-if="item.children && item.permission" v-slot="{ open }">
                            <DisclosureButton @click.prevent="gotoPage()" :class="[item.current ? ' bg-white' : ' hover:bg-primary dark:hover:bg-darkmode-500'] + ' has-child flex items-center hover:text-white w-full text-left text-white font-normal rounded-md hover:cursor-pointer p-2 gap-x-3 text-sm leading-6  dark:text-darkmode-555 ' + item.key ">
                                <component :is="item.icon" class="h-6 w-6 shrink-0 hover:text-darkmode-600  dark:text-darkmode-555" aria-hidden="true" />
                                {{ item.name }}
                                <ChevronRightIcon :class="[open ? 'rotate-90 text-white ' : 'text-white ', 'rotate-180 transition hover:text-darkmode-600 duration-300 ml-auto h-5 w-5 shrink-0 dark:text-darkmode-555']" aria-hidden="true" />
                            </DisclosureButton>
                            <DisclosurePanel as="ul" class="px-2 dark:bg-darkmode-700 dark:py-1">
                                <li v-for="subItem in item.children" :key="subItem.name" class="py-0.5">
                                    <router-link :to="subItem.href" :class="[$route.path.includes(subItem.href)? 'bg-primary text-aside' : 'hover:bg-primary dark:hover:bg-darkmode-500', 'block text-white font-normal rounded-md py-2 pr-2 pl-9 text-sm leading-6 dark:text-darkmode-555 ']">
                                        {{ subItem.name }}
                                    </router-link>
                                </li>
                            </DisclosurePanel>
                        </Disclosure>
                    </li>
                </ul>

            </div>
            <!-- MINI SIDEBAR-->
            <div class="mini mt-20 flex flex-col w-full h-[calc(100vh)]">
                <div v-for="item in navigation" :key="item.key">
                    <div class="relative my-1" v-if="item.permission" >
                        <div  @mouseover.prevent="onHoverIn(item.key)" @mouseout.prevent="onHoverOut" :class="[isHovering === item.key ? 'ml-4' : 'hover:ml-4']" class="relative z-1 justify-end pr-3 text-white z-50 hover:text-purple-500 hover:cursor-pointer dark:hover:text-blue-500 w-full bg-primary dark:bg-darkmode-700 dark:hover:bg-darkmode-700 p-3 rounded-full transform ease-in-out duration-300 flex" >
                            <component :is="item.icon" class="h-6 w-6 shrink-0 text-white dark:text-darkmode-555" aria-hidden="true" />
                        </div>
                        <!-- Animated sliding menu -->
                        <div v-show="isHovering === item.key" class="absolute inset-0 flex justify-center items-center w-full  z-10 left-0 mt-1  transform translate-x-full dark:bg-darkmode-500 ease-in-out duration-300">
                            <ul @mouseover.prevent="onHoverIn(item.key)" @mouseout.prevent="onHoverOut" class="py-4 border border-t-1 border-r-1  border-b-1 dark:border-darkmode-700 bg-white dark:bg-darkmode-500 rounded-r-md shadow-lg dark:shadow-none w-60">
                                <router-link :to="item.href" v-if="!item.children" class="pl-10 py-1 dark:text-darkmode-555 text-darkgray dark:hover:text-blue-500 hover:text-bg-lightblue cursor-pointer">
                                    {{ item.name }}
                                </router-link>
                                <li v-else v-for="menuItem in item.children" :key="menuItem.name" class="pl-8 py-1 text-darkgray dark:text-darkmode-555 dark:hover:text-blue-500 hover:text-bg-lightblue cursor-pointer" >
                                    <router-link :to="menuItem.href">&#8226; {{ menuItem.name }}</router-link>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </aside>
    </div>
</template>


<script>
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { MenuButton,Menu,MenuItem,MenuItems,TransitionChild,TransitionRoot,} from '@headlessui/vue';
import { ChevronRightIcon } from '@heroicons/vue/20/solid';
import { HomeIcon, UsersIcon, UserGroupIcon, Cog6ToothIcon, IdentificationIcon, QueueListIcon,UserIcon, BuildingOfficeIcon, DocumentTextIcon, ChatBubbleBottomCenterTextIcon, NewspaperIcon  } from '@heroicons/vue/24/outline'
import { siteSettings } from '@/store/utils';
import { userAuthStore } from '@/store/auth';


export default{
    name:'Aside',
    components:{
        MenuButton,Menu,MenuItem,MenuItems,TransitionChild,TransitionRoot,Disclosure, DisclosureButton, DisclosurePanel, ChevronRightIcon, HomeIcon
    },
    data(){
        return {
            isHovering: null,
            isSidebarOpen: siteSettings().getAside,
            user: userAuthStore().getUser,
            role_permissions: userAuthStore().getUser.role_permissions,
            logo: '/images/techka.png',
            // permissions: userAuthStore().getPermissions,
            isMenuName:'',
            navigation:[
                { name: 'Dashboard', key:'dashboard', href: '/app/dashboard', icon: HomeIcon, current: this.$route.fullPath == 'dashboard', permission: userAuthStore().checkPermission('dashboard-view') },
                { name: 'Roles and Permissions', key:'roles-and-permissions', href: '/app/roles-and-permissions', icon: UserGroupIcon, current: this.$route.fullPath == '/app/roles-and-permissions', permission: true }, //userAuthStore().checkPermission('roles-&-permission-view')
                { name: 'Users', key:'manage-users', href: '/app/manage-users', icon: UserGroupIcon, current: this.$route.fullPath == '/app/manage-users', permission: userAuthStore().checkPermission('users-view') },
                { name: 'Job Posts', key:'manage-jobs', href: '/app/manage-jobs', icon: DocumentTextIcon, current: this.$route.fullPath == '/app/manage-jobs', permission: userAuthStore().checkPermission('job-posts-view') },
                { name: 'Trainings', key:'manage-trainings', href: '/app/manage-trainings', icon: IdentificationIcon, current: this.$route.fullPath == '/app/manage-trainings', permission: userAuthStore().checkPermission('trainings-view') },
                { name: 'Testimonials', key:'manage-testimonials', href: '/app/manage-testimonials', icon: ChatBubbleBottomCenterTextIcon, current: this.$route.fullPath == '/app/manage-testimonials', permission: userAuthStore().checkPermission('testimonials-view') },
                // { name: 'Survey', key:'manage-survey', href: '/app/manage-employees', icon: IdentificationIcon, current: false },
                // {
                //     name: 'Site Settings',
                //     key:'settings',
                //     icon: Cog6ToothIcon,
                //     current: false,
                //     children: [

                //     { name: 'Maintenance', href: '/app/settings/maintenance', },

                //     ],
                // },
                { name: 'Maintenance', key:'maintenance', href: '/app/settings/maintenance', icon: Cog6ToothIcon, current: false, permission: userAuthStore().checkPermission('maintenance-view')  },
                { name: 'My Profile', key:'profile', href: '/app/profile', icon: UserIcon, current: false, permission: userAuthStore().checkPermission('professional-profile-view')  },
                { name: 'Job Posts', key:'job-posts', href: '/app/job-posts', icon: NewspaperIcon, current: false, permission: userAuthStore().checkPermission('professional-job-post-view')  },
                { name: 'Job Applications', key:'job-posts', href: '/app/job-applications', icon: NewspaperIcon, current: false, permission: userAuthStore().checkPermission('professional-job-post-view')  },
                // { name: 'Sales Team', key:'sales', href: '#', icon: ChatBubbleBottomCenterTextIcon, current: false },
                // { name: 'Components', key:'components', href: '/app/components', icon: CubeTransparentIcon, current: this.$route.fullPath == '/app/components' },
            ],
            permittedNavigation: [],
        }
    },
    methods:{
        onHoverIn(key) {
        this.isHovering = key;
        },
        onHoverOut(key) {
        this.isHovering = null;
        },
        gotoPage(){

        },
        openNav() {
            this.isSidebarOpen = !this.isSidebarOpen;
            siteSettings().setAside(this.isSidebarOpen);

            const sidebar = document.querySelector("aside");
            const maxSidebar = document.querySelector(".max")
            const miniSidebar = document.querySelector(".mini")
            const roundout = document.querySelector(".roundout")
            const maxToolbar = document.querySelector(".max-toolbar")
            const logo = document.querySelector('.logo')
            const content = document.querySelector('.content')

            if(this.isSidebarOpen){
                // max sidebar
                sidebar.classList.remove("-translate-x-48")
                sidebar.classList.add("translate-x-none")
                maxSidebar.classList.remove("hidden")
                maxSidebar.classList.add("flex")
                miniSidebar.classList.remove("flex")
                miniSidebar.classList.add("hidden")
                maxToolbar.classList.add("translate-x-0")
                maxToolbar.classList.remove("translate-x-24","scale-x-0")
                logo.classList.remove("ml-12")
                content.classList.remove("ml-12")
                content.classList.add("ml-12","md:ml-60")
            }else{
                // mini sidebar
                sidebar.classList.add("-translate-x-48")
                sidebar.classList.remove("translate-x-none")
                maxSidebar.classList.add("hidden")
                maxSidebar.classList.remove("flex")
                miniSidebar.classList.add("flex")
                miniSidebar.classList.remove("hidden")
                maxToolbar.classList.add("translate-x-24","scale-x-0")
                maxToolbar.classList.remove("translate-x-0")
                logo.classList.add('ml-12')
                content.classList.remove("ml-12","md:ml-60")
                content.classList.add("ml-12")

            }
        },
        // filterNavigations() {
        //     this.navigation.forEach(nav => {
        //         if(this.permissions.some(permission => permission.includes(nav.key))){
        //             this.permittedNavigation.push(nav);
        //         }
        //     });
        // }
    },
    mounted(){
        // this.permissions = JSON.parse(this.role_permissions.permissions);
        this.isSidebarOpen = !this.isSidebarOpen;
        this.openNav();
        // this.filterNavigations();
        // console.log(this.permissions);
        // console.log(this.permittedNavigation);
    },
    created(){
    //    console.log(this.$route.fullPath);
    }


}


</script>
