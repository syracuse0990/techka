<template>
    <div class="relative ">
        <TopBar></TopBar>
        <Aside></Aside>
        <div class = "bg-gray-50 min-h-screen content ml-12 transform ease-in-out duration-500 pt-20 px-2 md:px-5 pb-4 ">
            <router-view :key="$route.fullPath" v-slot="{ Component }">
                <component :is="Component" />
            </router-view>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, reactive, onMounted, onBeforeUnmount, onActivated, onUpdated, onDeactivated, onBeforeUpdate } from 'vue';
import Aside from '@/components/layouts/parts/Aside.vue';
import TopBar from '@/components/layouts/parts/Topbar.vue';

import { initFlowbite } from 'flowbite'

    onMounted(() => {
        initFlowbite();
    })

</script>
