<template>
    <div class="p-5">
        <div class="flex justify-end items-end">
            <div class="w-96 mr-2">
                <Select id="role-select" label="Roles" placeholder="Select Role" :options="roles" :key="roleKey" @change="getRolesAndPermissions($event)"></Select>
            </div>
            <div class="w-40">
                <SolidButton :type="'button'" label="Add Role" @click.prevent="openDrawer" :icon="UsersIcon" :customClass="'px-[30px] text-white bg-primary border-primary'"  aria-controls="add-role" ></SolidButton>
            </div>
        </div>

        <div class="border-t border-primary my-5 shadow-md p-5">
            <div class="flex justify-between items-end">
                <div class="w-96">
                    <Input label="Search" id="search" placeholder="Search module..." @input="setPreview"></Input>
                </div>
                <div class="w-40">
                    <SolidButton :disabled="isUpdating" :isLoading="permissionsForm.busy" :type="'button'" label="Update Role" :icon="UsersIcon" :customClass="'text-white bg-primary border-primary'" @click.prevent="updateRoleAndPermission"></SolidButton>
                </div>
            </div>
            <hr class="my-5 border-gold">

            <div class="grid grid-cols-2 gap-4 my-5 auto-cols-max" >

                <div class="space-y-4" v-for="(chunk, index) in chunkArray(data, 2)" :key="index" >
                    <div v-for="(item, itemIndex) in chunk" :key="item.id" class="w-full border rounded-md" :class="{'border-primary' : openAccordions[item.id]}" >
                        <button @click="toggleAccordion(item.id)" class="w-full text-left px-4 py-2 flex justify-between items-center focus:outline-none border-b">
                            <div>
                                <input @click.stop type="checkbox" class="w-4 h-4 text-textColor bg-gray-100 border-gray-300 rounded focus:ring-primary z-50"
                                :class="slug(item.meta_name)+'-view'"
                                :value="slug(item.meta_name)"
                                :checked="checkIfPermissionExists(slug(item.meta_name)+'-view')"
                                @change="setPermission($event,slug(item.meta_name),'view')">
                                <span class="text-sm text-textColor font-medium ml-2">{{ item.meta_name }}</span>
                            </div>
                            <svg :class="{ 'rotate-180': openAccordions[item.id] }" class="w-5 h-5 text-primary transform transition-transform duration-300 ease-in-out" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div v-show="openAccordions[item.id]" :ref="el => contentRefs[item.id] = el" class="overflow-hidden transition-all duration-300 ease-in-out" :style="{ maxHeight: contentHeights[item.id] + 'px' }">
                            <div class="p-4">
                                <div class="grid grid-cols-2 gap-1">
                                    <div v-for="action in item.meta_array.primary_actions" :key="action">
                                        <Checkbox :id="slug(item.meta_name)+'-'+action" :checked="checkIfPermissionExists(slug(item.meta_name)+'-'+action)"  :label="action.charAt(0).toUpperCase() + action.slice(1)" @change="setPermission($event,slug(item.meta_name),action)"></Checkbox>
                                    </div>
                                </div>
                                <div v-for="(custom, customIndex) in item.meta_array.custom_actions" :key="customIndex">
                                    <Legend :label="custom.name" :labelCss="'text-sm pr-4 font-medium text-primary'"></Legend>
                                    <div class="grid grid-cols-2 gap-1">
                                        <div v-for="custom_child in custom.items" :key="custom_child.name">
                                            <Checkbox :id="slug(item.meta_name)+'-'+custom_child.key" :checked="checkIfPermissionExists(slug(item.meta_name)+'-'+custom_child.key)"  :label="custom_child.name" @change="setPermission($event,slug(item.meta_name),custom_child.key)"></Checkbox>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Teleport to="body">
            <Drawer :id="'add-role'" title="Add Role" :isShowing="showDrawer">
                <template #content>
                    <form @submit.prevent="saveRole()">
                        <div class="my-5">
                            <Input v-model="roleForm.meta_name" label="Role Name" id="role-name" placeholder="Enter role name..." @input="setMetaValue"></Input>
                        </div>
                        <hr class="my-5">
                        <div class="flex justify-between  items-center">
                            <div class="w-32">
                                <SolidButton @click.prevent="openDrawer" :type="'button'" label="Cancel" :icon="Square3Stack3DIcon" :customClass="'text-white bg-gray-500 border-gray-600 '" ></SolidButton>
                            </div>
                            <div class="w-32">
                                <SolidButton :isLoading="roleForm.busy" :type="'submit'" label="Submit" :icon="Square3Stack3DIcon" :customClass="'text-white bg-primary border-primary '" ></SolidButton>
                            </div>
                        </div>
                    </form>
                </template>
            </Drawer>
        </Teleport>
    </div>
</template>

<script setup>
import { ref, nextTick, onMounted, reactive } from 'vue';
import Form from 'vform'
import SolidButton from '@/components/parts/Buttons/SolidButton.vue';
import Select from '@/components/parts/Forms/Select.vue';
import Input from '@/components/parts/Forms/Input.vue';
import Checkbox from '@/components/parts/Forms/Checkbox.vue';
import Legend from '@/components/parts/Banner/Legend.vue';
import Drawer from '@/components/parts/Modals/Drawer.vue';
import { UsersIcon, Square3Stack3DIcon, XMarkIcon } from '@heroicons/vue/20/solid';
import { successMessage, errorMessage } from "@/utilities/toast.js";
import { chunkArray, slug } from "@/utilities/functions.js";

const props = defineProps({
  data: {
    type: Array,
    default: [],
  },
  isFetching: {
    type: Boolean,
    default: false,
  },
});

const roleForm = reactive(new Form({
    id: null,
    meta_parent_id: '',
    meta_parent: 'role',
    meta_name: '',
    meta_value: '',
}));

const permissionsForm = reactive(new Form({
    id: null,
    role_id: '',
    permissions: [],
}));

const roles = ref([]);
const openAccordions = ref([]);
const contentHeights = ref([]);
const contentRefs = ref([]);
const showDrawer = ref(false)
const roleKey = ref(0)
const updateKey = ref(0)
const isUpdating = ref(true)

const selectedPermissions = ref([]);

function checkIfPermissionExists(name) {
    return permissionsForm.permissions.includes(name);
}

function updateRoleAndPermission(){
    permissionsForm.post('/api/roles-and-permissions').then((response) => {

        successMessage('Success!', 'Role has been updated successfully.', "top-right");

    }).catch((error) => {

        errorMessage("Oops!", "Something went wrong", "top-right");

    })
}

function getRolesAndPermissions(evt){
    isUpdating.value = false
    permissionsForm.role_id = evt.target.value;

    fetchPermissions(evt.target.value);
}

function fetchPermissions(roleID){
    axios.get('/api/roles-and-permissions',{
        params:{
            role_id: roleID
        }
    }).then((response) => {
        permissionsForm.permissions = response.data.data
        updateKey.value++;
    }).catch((error) => {
        isFetching.value = false
    });
}

function saveRole(){
    roleForm.post('/api/maintenance').then((response) => {
        roleForm.reset();
        getRoles();
        successMessage('Success!', 'Role has been created successfully.', "top-right");
    }).catch((error) => {
        errorMessage("Oops!", "Something went worng", "top-right");
    })
}

function getRoles() {
    axios.get('/api/maintenance?meta_parent=role').then((response) => {
        roles.value = response.data.data;
        roleKey.value++;
    }).catch((error) => {
        isFetching.value = false
    });
}

function setMetaValue(){
    let name = roleForm.meta_name
    roleForm.meta_value = 'role-'+slug(name);
}

function setPermission(evt, parentName, childName) {
    const isChecked = evt.target.checked;

    const index = permissionsForm.permissions.indexOf(parentName+'-'+childName);

    if (isChecked) {
        if (index === -1) {
            permissionsForm.permissions.push(parentName+'-'+childName);
        }
    } else {
        if (index !== -1) {
            permissionsForm.permissions.splice(index, 1);
        }
    }

    if(childName == "view"){
        if(isChecked){
            document.getElementById(parentName+'-'+childName).checked = true;
            document.querySelector('.' + parentName + '-view').checked = true;
        }else{
           let permissions = permissionsForm.permissions.filter(item => item.includes(parentName));
           permissions.forEach(element => {
            document.getElementById(element).checked = false;
           });
           document.querySelector('.' + parentName + '-view').checked = false;
           document.getElementById(parentName+'-'+childName).checked = false;
           permissionsForm.permissions = permissionsForm.permissions.filter(item => !item.startsWith(parentName));
        }
    }else{
        document.querySelector('.' + parentName + '-view').checked = true;
        document.getElementById(parentName + '-view').checked = true;
    }
}

function openDrawer(){
    showDrawer.value = !showDrawer.value
}

function setView(evt){
    const isChecked = evt.target.checked;
    let slug = evt.target.value

    if(isChecked){
        permissionsForm.permissions.push(slug+'-view');
        document.getElementById(slug+"-view").checked = true;
    }else{
        permissionsForm.permissions.splice(slug+'-view', 1);
        document.getElementById(slug+"-view").checked = false;
    }
}

const toggleAccordion = async (id) => {
    openAccordions.value[id] = !openAccordions.value[id];

    await nextTick();

    if (openAccordions.value[id]) {
        const contentEl = contentRefs.value[id];
        if (contentEl) {
            contentHeights.value[id] = contentEl.scrollHeight;
        }
    } else {
        contentHeights.value[id] = 0;
    }
};


onMounted(() => {
     getRoles();
});


</script>

<style scoped>
.rotate-180 {
    transform: rotate(180deg);
}
</style>
