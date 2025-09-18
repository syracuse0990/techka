<template>
    <div class="mt-3 mb-5">
        <h2 class="text-primary font-semibold text-xl">Manage Job Posts</h2>
    </div>
    <TabsComponent @click="switchTab" :tabData="tabData">
        <template #active_posts>
            <ActivePostsPanel v-if="mountActivePosts"> </ActivePostsPanel>
        </template>
        <template #inactive_posts>
            <InactivePostsPanel v-if="mountInactivePosts"> </InactivePostsPanel>
        </template>
        <template #terminated_posts>
            <TerminatedPostsPanel v-if="mountTerminatedPosts"> </TerminatedPostsPanel>
        </template>
    </TabsComponent>
</template>

<script setup>
import { onMounted, reactive, ref, watch, computed, provide, inject, onUpdated, nextTick   } from "vue";
import { UserIcon, BuildingOffice2Icon, UsersIcon, BuildingOfficeIcon, ListBulletIcon, Cog8ToothIcon, UserCircleIcon, ClipboardDocumentIcon, NewspaperIcon } from '@heroicons/vue/24/outline'
import TabsComponent from '@/components/parts/Tab/TabIcon.vue';
import ActivePostsPanel from '@/components/private/Jobs/ActivePosts.vue';
import InactivePostsPanel from '@/components/private/Jobs/InactivePosts.vue';
import TerminatedPostsPanel from '@/components/private/Jobs/TerminatedPosts.vue';


const tabData = ref([
     { name: 'active_posts', label: 'Active Posts', icon: NewspaperIcon, disabled: false, show: true },
     { name: 'inactive_posts', label: 'Inactive Posts', icon: ClipboardDocumentIcon, disabled: false, show: true },
     { name: 'terminated_posts', label: 'Terminated Posts', icon: ListBulletIcon, disabled: false, show: true },
])
const mountActivePosts = ref(false)
const mountInactivePosts = ref(false)
const mountTerminatedPosts = ref(false)



function switchTab(index) {
    mountActivePosts.value = false;
    mountInactivePosts.value = false;
    mountTerminatedPosts.value = false;

    // Enable relevant panels
    if (index === 0) {
        mountActivePosts.value = true
    }
    else if (index === 1) {
        mountInactivePosts.value = true;
    }
    else if(index == 2){
        mountTerminatedPosts.value = true;
    }
    //else if(index === 4){
    //     mountReceiptTemplate.value = true
    // }
}

onMounted(() => {
      mountActivePosts.value = true
})

</script>
