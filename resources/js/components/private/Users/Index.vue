<template>
    <div class="mt-3 mb-5">
        <h2 class="text-aside font-semibold text-xl">Manage Users</h2>
    </div>
    <TabsComponent @click="switchTab" :tabData="tabData">
        <template #admins>
            <AdminsPanel v-if="mountAdmins"> </AdminsPanel>
        </template>
        <template #professionals>
            <ProfessionalsPanel v-if="mountProfessionals"> </ProfessionalsPanel>
        </template>
        <template #clients>
            <ClientsPanel v-if="mountClients"> </ClientsPanel>
        </template>
        <!-- <template #item-types>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-10 p-5">
                <ItemType v-if="mountItemTypes"></ItemType>
            </div>
        </template> -->
    </TabsComponent>
</template>

<script setup>
import { onMounted, reactive, ref, watch, computed, provide, inject, onUpdated, nextTick   } from "vue";
import { UserIcon, BuildingOffice2Icon, UsersIcon, BuildingOfficeIcon, ListBulletIcon, Cog8ToothIcon, UserCircleIcon, ClipboardDocumentIcon, NewspaperIcon } from '@heroicons/vue/24/outline'
import TabsComponent from '@/components/parts/Tab/TabIcon.vue';
import AdminsPanel from '@/components/private/Users/Admins.vue';
import ProfessionalsPanel from '@/components/private/Users/Techkalista.vue';
import ClientsPanel from '@/components/private/Users/Techkliyente.vue';


const tabData = ref([
     { name: 'admins', label: 'Admins', icon: UserIcon, disabled: false, show: true },
     { name: 'professionals', label: 'TechKalista', icon: UsersIcon, disabled: false, show: true },
     { name: 'clients', label: 'TechKliyente', icon: UserCircleIcon, disabled: false, show: true },
])
const mountAdmins = ref(false)
const mountProfessionals = ref(false)
const mountClients= ref(false)


function switchTab(index) {
    mountAdmins.value = false;
    mountProfessionals.value = false;
    mountClients.value = false;

    // Enable relevant panels
    if (index === 0) {
        mountAdmins.value = true
    }
    else if (index === 1) {
        mountProfessionals.value = true;
    }else if(index === 2){
        mountClients.value = true;
    }
    //else if(index == 3){
    //     mountReceipts.value = true;
    // }else if(index === 4){
    //     mountReceiptTemplate.value = true
    // }
}

onMounted(() => {
      mountAdmins.value = true
})

</script>
