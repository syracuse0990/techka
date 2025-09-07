<template>
    <div class="mt-3 mb-5">
        <h2 class="text-aside font-semibold text-xl">Settings | Maintenance</h2>
    </div>
    <TabsComponent @click="switchTab" :tabData="tabData">
        <template #misc>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-10 p-5">
                <DeveloperPanel v-if="mountDeveloper"></DeveloperPanel>
            </div>
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
import { UserIcon, BuildingOffice2Icon, UsersIcon, BuildingOfficeIcon, ListBulletIcon, Cog8ToothIcon, ClipboardDocumentIcon, NewspaperIcon } from '@heroicons/vue/24/outline'
import TabsComponent from '@/components/parts/Tab/TabIcon.vue';
import FertilizerPanel from '@/components/private/Settings/parts/FertilizerPanel.vue';
//import ItemType from '@/components/private/settings/components/ItemType.vue';

const tabData = ref([
     { name: 'misc', label: 'Miscellaneous', icon: BuildingOffice2Icon, disabled: false, show: true },
     { name: 'item-types', label: 'Item Types', icon: ClipboardDocumentIcon, disabled: false, show: true },
])
const mountFetilizer = ref(false)


function switchTab(index) {
    // Reset all panels
    mountFetilizer.value = false;


    // Enable relevant panels
    if (index === 0) {
        mountFetilizer.value = true
    }
    // else if (index === 1) {
    //     mountItemTypes.value = true;
    // }else if(index === 2){
    //     mountFinancialPeriod.value = true;
    // }else if(index == 3){
    //     mountReceipts.value = true;
    // }else if(index === 4){
    //     mountReceiptTemplate.value = true
    // }
}

onMounted(() => {

})

</script>
