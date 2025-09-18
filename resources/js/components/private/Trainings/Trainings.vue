<template>
   <div class="bg-white p-4 rounded-lg border-t border-primary m-5 shadow-md">
        <Table :url="'/api/users'" :headers="tableHeaders" :key="tableKey">
            <template #customButtons>
                <Dropdown :buttons="buttons"></Dropdown>
            </template>
            <template v-slot:full_name="slotProps" >
                <div class="flex justify-start items-center">
                    <img class="w-10 h-10 rounded-full p-[1px] border border-gray-400 mr-2" :src="slotProps.data.avatar ? '/avatars/'+ slotProps.data.avatar: avatar">
                    <span class="text-primary text-sm">{{ slotProps.data.full_name }}</span>
                </div>
            </template>
            <template v-slot:online="slotProps" >

                <span v-if="slotProps.data.online == 'ONLINE'" class="rounded-full text-xs py-0.5 px-3 border border-green-600 bg-green-100 text-green-700 tracking-wide">Online</span>
                <span v-else class="rounded-full text-xs py-0.5 px-3 border border-red-600 bg-red-100 text-red-700 tracking-wide">Offline</span>
            </template>
            <template v-slot:status="slotProps" >
                <span v-if="slotProps.data.status == 'ACTIVE'" class="rounded-full text-xs py-0.5 px-3 border border-green-600 bg-green-100 text-green-700 tracking-wide">ACTIVE</span>
                <span v-else class="rounded-full text-xs py-0.5 px-3 border border-red-600 bg-red-100 text-red-700 tracking-wide">INACTIVE</span>
            </template>
            <template v-slot:actions="slotProps" >
                <button  type="button" @click="editUser(slotProps.data)" class="rounded-md bg-primary p-1 ml-2 text-white shadow-sm hover:bg-secondary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                    <PencilSquareIcon class="h-4 w-4" aria-hidden="true" />
                </button>
            </template>
        </Table>
    </div>
   <Teleport to="body">
        <Drawer :id="'user-form'" :title="(editMode ? 'Update' : 'Add') +' Training'" :isShowing="showDrawer" customClass="w-[1000px]">
            <template #content>
                <form @submit.prevent="editMode ? updateForm() : formSubmit()">
                    <div class="p-3  rounded-md mb-2">
                        <div class="flex justify-end items-center mb-4">

                            <ToogleInput v-model="form.status" label="Status" :labelPosition="'left'"></ToogleInput>
                        </div>
                        <div class="flex items-end justify-center">
                            <div class="flex-initial w-[500px]" for="file-upload">
                                <p class="text-gray-600 text-sm mb-2">Image Banner</p>
                                <label for="file-upload" class=" cursor-pointer">
                                    <img class="block w-[470px] h-60 rounded-lg border-2 border-stroke-gray" :src="form.avatar || avatar" alt="">
                                </label>
                                <input id="file-upload" name="file-upload" type="file" class="sr-only" @change="handleFileChange($event)" accept=".jpeg,.jpg,.png" />
                            </div>

                            <div class="flex-1">
                                <div class="w-full mb-2">
                                    <FloatingInput v-model="form.title" label="Title" id="title" placeholder="" :error="form.errors.has('title')" :errorMsg="form.errors.get('title')"></FloatingInput>
                                </div>
                                 <div class="w-full mb-2">
                                    <FloatingInput v-model="form.category" label="Category" id="category" placeholder=""></FloatingInput>
                                </div>
                                <div class="w-full mb-2">
                                    <FloatingInput type="select" v-model="form.type" :options="trainingTypes" label="Type" id="type" placeholder=""></FloatingInput>
                                </div>
                                <div class="w-full mb-2">
                                    <FloatingInput v-model="form.link" label="Video Link" id="link" placeholder=""></FloatingInput>
                                </div>
                                <div class="w-full mb-2">
                                    <FloatingInput v-model="form.duration" label="Video Duration" id="duration" placeholder=""></FloatingInput>
                                </div>
                            </div>
                        </div>
                        <Legend label="Text Contents" :labelCss="'text-xs pr-4 font-medium text-aside'"></Legend>
                        <div class="w-full mb-2">
                            <FloatingInput type="textarea" v-model="form.short_description" label="Short Description" id="short_description" placeholder="" :error="form.errors.has('short_description')" :errorMsg="form.errors.get('short_description')"></FloatingInput>
                        </div>
                        <div class="w-full mt-5">
                            <label for="text_content" class="block mb-1 text-sm text-gray-600">Long Description</label>
                            <QuillEditor theme="snow" v-model:content="form.long_description" content-type="html" toolbar="full" class="custom-quill-editor" />

                        </div>

                    </div>
                    <hr class="my-5">
                    <div class="flex justify-between items-center">
                        <div class="w-32 ">
                            <SolidButton @click="openDrawer" :type="'button'" label="Close" :icon="XMarkIcon" :customClass="'text-white bg-gray-500 border-gray-600 hover:bg-gray-400'" ></SolidButton>
                        </div>
                        <div class="w-32 ">
                            <SolidButton :isLoading="form.busy" :type="'submit'" :label="editMode ? 'Update' : 'Submit'" :icon="Square3Stack3DIcon" :customClass="'text-white bg-primary border-primary hover:bg-green-600'" ></SolidButton>
                        </div>
                    </div>
                </form>
            </template>
        </Drawer>


    </Teleport>
</template>

<script setup>
import { onMounted, reactive, ref, watch, computed, provide, inject, onUpdated, nextTick   } from "vue";
import Form from 'vform'
import { successMessage, errorMessage } from "@/utilities/toast.js";
import { chunkArray, slug, emitter } from "@/utilities/functions.js";
import * as XLSX from 'xlsx';
import chunk from "lodash/chunk";

import Table from '@/components/parts/Tables/Table.vue';
import Dropdown from '@/components/parts/Buttons/Dropdown.vue';
import { useRouter } from 'vue-router';
import { PlusIcon, MinusIcon, PencilSquareIcon, Square3Stack3DIcon } from '@heroicons/vue/24/outline'
import Drawer from '@/components/parts/Modals/Drawer.vue';
import SolidButton from '@/components/parts/Buttons/SolidButton.vue';
import Select from '@/components/parts/Forms/Select.vue';
import {  XMarkIcon, MagnifyingGlassIcon } from '@heroicons/vue/20/solid';
import ToogleInput from '@/components/parts/Forms/Toogle.vue';
import FloatingInput from '@/components/parts/Forms/FloatingInput.vue';
import Legend from '@/components/parts/Banner/Legend.vue';
import axios from "axios";
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'

const avatar = ref('/images/profile-image.png')


const tableHeaders = reactive([
   { title: 'NAME', onSet: true, sortable: true, query: 'full_name', date_filtered: false, searchable: true, checked: true, hasInlineEdit: true, textAlign: 'left', columnWidth: 'w-64' },
   { title: 'EMAIL', onSet: true, sortable: false, query: 'email', date_filtered: false, searchable: true, checked: true, hasInlineEdit: false, textAlign: 'left', columnWidth: 'w-64' },
   { title: 'PHONE #', onSet: false, sortable: false, query: 'phone', date_filtered: false, searchable: true, checked: false, hasInlineEdit: false, textAlign: 'left' },
   { title: 'ROLE', onSet: true, sortable: true, query: 'role', date_filtered: false, searchable: true, checked: false, hasInlineEdit: false, textAlign: 'left' },
   { title: 'ONLINE', onSet: true, sortable: true, query: 'online', date_filtered: true, searchable: false, checked: false, hasInlineEdit: true, textAlign: 'left' },
   { title: 'REGISTERED USING', onSet: true, sortable: true, query: 'registered_using', date_filtered: false, searchable: true, checked: false, hasInlineEdit: false, textAlign: 'left' },
   { title: 'REGISTERED DATE', onSet: true, sortable: true, query: 'created_at', date_filtered: false, searchable: true, checked: false, hasInlineEdit: false, textAlign: 'left' },
   { title: 'STATUS', onSet: true, sortable: false, query: 'status', date_filtered: true, searchable: false, checked: false, hasInlineEdit: true, textAlign: 'center' },
   { title: 'ACTIONS', onSet: true, sortable: false, query: 'actions', date_filtered: false, searchable: false, checked: false, hasInlineEdit: true, textAlign: 'center' },
]);
const trainingTypes = ref([
    { value: 'video', label: 'Video' },
    { value: 'module', label: 'Text Module' },
])

const router = useRouter();
const buttons = reactive([
   { label: 'Add New', key: 'button', function: openDrawer },
//    { label: 'Export', key: 'button', function: exportData},
//    { label: 'Import', key: 'button', function: openImportModal },
//    { label: 'Import Master List', key: 'button', function: openImportMasterModal },
//    { label: 'Email Blasting', key: 'button', function: openBlastingModal },
]);

const tableKey = ref(0)
const showDrawer = ref(false)
const showBlastingDrawer = ref(false)
const showMasterDrawer = ref(false)
const showImportDrawer = ref(false)
const editMode = ref(false)
const roles = ref([])
const percentage = ref(0)
const totalData = ref(0)
const isMasterListImporting = ref(false)
const isBlasting = ref(false)
const isImporting = ref(false)
const masterListData = ref([])
const selectedRole = ref(null)


const form = reactive(new Form({
    id: null,
    title:'',
    category:'',
    type:'',
    link: '',
    duration:'',
    short_description:'',
    long_description:'',
}));

function selectFile(event){
    isImporting.value = true
    const file = event.target.files[0];
          if (!file) return;
          const reader = new FileReader();

          reader.onload = (e) => {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, { type: 'array' });

            const sheetName = workbook.SheetNames[0];
            const worksheet = workbook.Sheets[sheetName];

            const jsonData = XLSX.utils.sheet_to_json(worksheet, {
              raw: false,
              dateNF: 'YYYY-MM-DD HH:MM:SS',
              cellDates: true,
              cellNF: false,
              cellText: false,
              cellStyles: true,
            });

            if(jsonData.length > 0){
                totalData.value = jsonData.length
                const chunkSize = 100
                const batchChunk = chunk(jsonData, chunkSize)
                let counter = 0;
                const batchUpload = async () => {
                    for (const chunk of batchChunk) {
                        counter += chunk.length

                        await axios.post('/api/batch-user-import', {
                            data: chunk
                        }).then((response) => {
                            response.data.data
                        })
                        percentage.value = counter
                    }
                }
                batchUpload();

            }

        };

        reader.readAsArrayBuffer(file);
}

function selectMasterListFile(event){
    const file = event.target.files[0];
          if (!file) return;
          const reader = new FileReader();

          reader.onload = async (e) => {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, { type: 'array' });

            const sheetName = workbook.SheetNames[0];
            const worksheet = workbook.Sheets[sheetName];

            masterListData.value = XLSX.utils.sheet_to_json(worksheet, {
              raw: false,
              dateNF: 'YYYY-MM-DD HH:MM:SS',
              cellDates: true,
              cellNF: false,
              cellText: false,
              cellStyles: true,
            });
        }
        reader.readAsArrayBuffer(file);

}

function getUsersByRoles(event){

    selectedRole.value = event.target.value;
}

function openBlastingModal(){
    showBlastingDrawer.value = !showBlastingDrawer.value
}

function openImportDrawer(){
    showImportDrawer.value = !showImportDrawer.value
}

function openImportMasterModal(){
    showMasterDrawer.value = !showMasterDrawer.value
}
function exportData(){
    errorMessage("Oops!", "Under Construction.", "top-right");
}

function startBlasting(){
    isBlasting.value = true
    axios.post('/api/blast-email-credentials', {
        role: selectedRole.value
    }).then((response) => {
        successMessage('Success!', "Email sending is on the way.", "top-right");
        isBlasting.value = false
    })
    .catch((e) => {
            errorMessage("Oops!",e.message, "top-right");
            isBlasting.value = false
    })
}

function updateForm(){
    form.put('/api/users/'+ form.id).then((response) => {
        form.reset();
        tableKey.value++;
        successMessage('Success!', 'User has been updated successfully.', "top-right");
    }).catch((error) => {
        errorMessage("Oops!", "Something went wrong when updating the user.", "top-right");
    })
}

async function importMasterListing(){
    isMasterListImporting.value = true
    await axios.post('/api/master-list-import', {
                data: masterListData.value
            }).then((response) => {
                successMessage('Success!', "Users have been created.", "top-right");
                isMasterListImporting.value = false
                tableKey.value++;
            })
            .catch((e) => {
                 errorMessage("Oops!",e.message, "top-right");
                 isMasterListImporting.value = false
            })
        }


function formSubmit(){
    form.post('/api/users').then((response) => {
        form.reset();
        tableKey.value++;
        successMessage('Success!', 'User has been created successfully.', "top-right");
    }).catch((error) => {
        errorMessage("Oops!", "Something went wrong when saving the user.", "top-right");
    })
}

async function getRoles() {
  await axios.get('/api/maintenance?meta_parent=role').then((response) => {
        roles.value = response.data.data;
    }).catch((error) => {
        isFetching.value = false
    });
}


async function editUser(data){
    fetchUser(data.id)
    editMode.value = true
    showDrawer.value = true
}

function openDrawer(){
    editMode.value = false
    showDrawer.value = !showDrawer.value
}

function openImportModal(){
    showImportDrawer.value = !showImportDrawer.value
}

async function fetchUser(id){
    try{
        const response = await axios.get('/api/users/'+id);
        editMode.value = true
        form.fill(response.data.data);
        form.avatar = '/avatars/'+ response.data.data.avatar

    }catch{
        errorMessage("Oops!", "Something went wrong.", "top-right");
    }
}

function handleFileChange (event){
    const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
          form.avatar = e.target.result;
        };

        reader.readAsDataURL(file);
      }
}



onMounted( () => {
 getRoles();
});


</script>
<style >
.custom-quill-editor {
  line-height: 1.8;
  height: 200px !important;
}
</style>
