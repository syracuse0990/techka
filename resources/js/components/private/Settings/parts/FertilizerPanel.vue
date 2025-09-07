<template>
    <div class="rounded-md shadow-md border border-gray-200 px-4 pb-5" data-aos="fade-in" data-aos-delay="100" data-aos-duration="1500">
        <div class="flex justify-between items-center border-b border-aside py-2">
            <h3 class="text-aside">Developer</h3>
            <ClearButton :icon="PlusIcon"  @click="openDrawer" :buttonClass="'py-1 px-1.5 text-aside border-bluer'"></ClearButton>
        </div>

        <Table :url="'/api/maintenance?for=table&meta_parent=maintenance-developer'" :headers="tableHeaders" :hasDateFilter="false" :showFiltering="false" :showSelect="false" :key="tableKey">
            <template v-slot:actions="slotProps" >
                <button  type="button" @click="editData(slotProps.data)" class="rounded-md bg-blue-600 p-1 ml-2 text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                    <PencilSquareIcon class="h-4 w-4" aria-hidden="true" />
                </button>
            </template>
        </Table>
    </div>
    <Teleport to="body">
        <Drawer :id="'maintenance-developer'" :title="(editMode ? 'Update' : 'Add') +' Developer'" :class="[ showDrawer ? 'transform-none' : 'translate-x-full']">
            <template #content>
                <form @submit.prevent="editMode ? updateForm() :formSubmit()">
                    <div class="my-5">
                        <Input v-model="form.meta_name" label="Developer Name" id="developer-name" placeholder="Enter developer name..." @input="setMetaValue"></Input>
                    </div>
                    <hr class="my-5">
                    <div class="flex justify-between items-center">
                        <div class="w-32 ">
                            <SolidButton @click="openDrawer" :type="'button'" label="Close" :icon="XMarkIcon" :customClass="'text-white bg-gray-500 hover:bg-gray-600 '" ></SolidButton>
                        </div>
                        <div class="w-32 ">
                            <SolidButton :isLoading="form.busy"  :type="'submit'" :label="editMode ? 'Update' : 'Submit'" :icon="Square3Stack3DIcon" :customClass="'text-white bg-aside '" ></SolidButton>
                        </div>


                    </div>
                </form>
            </template>
        </Drawer>
        <div v-if="showDrawer" drawer-backdrop="" class="bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-30"></div>
    </Teleport>

</template>
<script setup>
import { onMounted, reactive, ref, watch, computed, provide, inject, onUpdated, nextTick   } from "vue";
import Form from 'vform'
import { successMessage, errorMessage } from "@/utilities/toast.js";

import Legend from '@/components/parts/Banner/Legend.vue';
import { PlusIcon, MinusIcon, PencilSquareIcon, Square3Stack3DIcon, XMarkIcon } from '@heroicons/vue/20/solid';
import ClearButton from '@/components/parts/Buttons/ClearButtons.vue';
import Table from '@/components/parts/Tables/Table.vue';
import Drawer from '@/components/parts/Modals/Drawer.vue';
import Input from '@/components/parts/Forms/Input.vue';
import SolidButton from '@/components/parts/Buttons/SolidButton.vue';
import { chunkArray, slug } from "@/utilities/functions.js";


const tableHeaders = reactive([
    { title: 'DEVELOPER ID', onSet: true, sortable: true, query: 'id', date_filtered: false, searchable: true, checked: true, hasInlineEdit: false, textAlign: 'left' },
    { title: 'DEVELOPER NAME', onSet: true, sortable: true, query: 'meta_name', date_filtered: false, searchable: true, checked: true, hasInlineEdit: false, textAlign: 'left' },
    { title: 'ACTIONS', onSet: true, sortable: false, query: 'actions', date_filtered: false, searchable: false, checked: false, hasInlineEdit: true, textAlign: 'center' },
]);

const form = reactive(new Form({
    id: null,
    meta_parent_id: '',
    meta_parent: 'maintenance-developer',
    meta_name: '',
    meta_value: '',
}));

const tableKey = ref(0)
const showDrawer = ref(false)
const editMode = ref(false)

function formSubmit(){
    form.post('/api/maintenance').then((response) => {
        form.reset();
        tableKey.value++;
        successMessage('Success!', 'Developer has been created successfully.', "top-right");
    }).catch((error) => {
        errorMessage("Oops!", "Something went worng", "top-right");
    })
}

function updateForm(){
    form.put('/api/maintenance/'+ form.id).then((response) => {
        form.reset();
        tableKey.value++;
        successMessage('Success!', 'Developer has been updated successfully.', "top-right");
    }).catch((error) => {
        errorMessage("Oops!", "Something went worng", "top-right");
    })
}

function refreshData() {
    axios.get('/api/maintenance?meta_parent=maintenance-developer').then((response) => {
        tableKey.value++;
    }).catch((error) => {
        isFetching.value = false
    });
}

function setMetaValue(){
    let name = form.meta_name
    form.meta_value = 'developer-'+slug(name);
}


function openDrawer(){
    editMode.value = false
    showDrawer.value = !showDrawer.value
}

function editData(data){
    showDrawer.value = !showDrawer.value
    editMode.value = true
    form.fill(data);
    console.log(form)
}



</script>
