<template>
    <div class="mt-3 mb-5">
        <h2 class="text-aside font-semibold text-xl">Settings | Maintenance</h2>
    </div>
    <TabsComponent @click="switchTab" :tabData="tabData">
        <template #misc>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-10 p-5">
                <CategoryPanel v-if="mountCategory"></CategoryPanel>
                <!-- <CategoryPanel v-if="mountCategory"></CategoryPanel> -->
            </div>
        </template>
        <template #certificate>

                <CertificatePanel v-if="mountCertificate"></CertificatePanel>

        </template>
    </TabsComponent>
</template>

<script setup>
import { onMounted, reactive, ref, watch, computed, provide, inject, onUpdated, nextTick   } from "vue";
import { UserIcon, BuildingOffice2Icon, UsersIcon, BuildingOfficeIcon, ListBulletIcon, Cog8ToothIcon, ClipboardDocumentIcon, NewspaperIcon } from '@heroicons/vue/24/outline'
import TabsComponent from '@/components/parts/Tab/TabIcon.vue';
import CategoryPanel from '@/components/private/Settings/parts/Category.vue';
import CertificatePanel from '@/components/private/Settings/parts/Certificates.vue';

const tabData = ref([
     { name: 'misc', label: 'Miscellaneous', icon: BuildingOffice2Icon, disabled: false, show: true },
     { name: 'certificate', label: 'Certificates', icon: ClipboardDocumentIcon, disabled: false, show: true },
])
const mountCategory = ref(false)
const mountCertificate = ref(false)



function switchTab(index) {
    // Reset all panels
    mountCategory.value = false;
    mountCertificate.value = false;


    // Enable relevant panels
    if (index === 0) {
        mountCategory.value = true
    }
    else if (index === 1) {
        mountCertificate.value = true;
    }
    //else if(index === 2){
    //     mountFinancialPeriod.value = true;
    // }else if(index == 3){
    //     mountReceipts.value = true;
    // }else if(index === 4){
    //     mountReceiptTemplate.value = true
    // }
}

onMounted(() => {
      mountCategory.value = true
})

</script>
