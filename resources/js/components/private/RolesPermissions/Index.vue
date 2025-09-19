<template>
    <div>
        <div class="mt-3 mb-5">
            <h2 class="text-primary font-semibold text-xl">Roles and Permission</h2>
        </div>
        <TabsComponent @click="switchTab" :tabData="[ { name: 'roles', label: 'Roles & Permissions' }, { name: 'maintenance', label: 'Maintenance' } ]" >
            <template #roles>
                <RolesComponent :data="permissions" :isFetching="isFetching" :key="permissionKey"></RolesComponent>
            </template>
            <template #maintenance>
                <MaintenanceComponent></MaintenanceComponent>
            </template>
        </TabsComponent>
    </div>
</template>
<script setup>
import { ref, watch, reactive, onMounted, onBeforeUnmount, onActivated, onUpdated, onDeactivated, onBeforeUpdate, nextTick } from 'vue';
import TabsComponent from '@/components/parts/Tab/tab.vue';
import MaintenanceComponent from '@/components/private/RolesPermissions/Maintenance.vue';
import RolesComponent from '@/components/private/RolesPermissions/Roles.vue';

const permissions = ref([]);
const isFetching = ref(true)
const permissionKey = ref(0)

const switchTab = (tabIndex) => {
  if(tabIndex == 0) getPermissions();
};

function getPermissions() {
    axios.get('/api/maintenance?meta_parent=permission').then((response) => {
        permissions.value = response.data.data;
        console.log(permissions.value)
        openAccordions.value = permissions.value.map(() => false);
        contentHeights.value = permissions.value.map(() => 0);
        isFetching.value = false

        permissionKey.value++;
    }).catch((error) => {
        isFetching.value = false
    });
}


onMounted(() => {
    getPermissions();
});

</script>
