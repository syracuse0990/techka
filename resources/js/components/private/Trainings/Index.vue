<template>
    <div class="mt-3 mb-5">
        <h2 class="text-primary font-semibold text-xl">Manage Trainings</h2>
    </div>
    <TabsComponent @click="switchTab" :tabData="tabData">
        <template #trainings>
            <TrainingsPanel v-if="mountTrainings"> </TrainingsPanel>
        </template>
        <template #enrollments>
            <EnrollmentsPanel v-if="mountEnrollments"> </EnrollmentsPanel>
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
import TrainingsPanel from '@/components/private/Trainings/Trainings.vue';
import EnrollmentsPanel from '@/components/private/Trainings/Enrollments.vue';



const tabData = ref([
     { name: 'trainings', label: 'Trainings', icon: NewspaperIcon, disabled: false, show: true },
     { name: 'enrollments', label: 'Enrollments', icon: UsersIcon, disabled: false, show: true },
])
const mountTrainings = ref(false)
const mountEnrollments = ref(false)



function switchTab(index) {
    mountTrainings.value = false;
    mountEnrollments.value = false;

    // Enable relevant panels
    if (index === 0) {
        mountTrainings.value = true
    }
    else if (index === 1) {
        mountEnrollments.value = true;
    }
    //else if(index == 3){
    //     mountReceipts.value = true;
    // }else if(index === 4){
    //     mountReceiptTemplate.value = true
    // }
}

onMounted(() => {
      mountTrainings.value = true
})

</script>
