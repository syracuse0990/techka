<template>
    <div class="py-5">
         <div class="grid grid-cols-2 gap-4">
             <div class="border-r border-slate-200 px-6 py-1">
                 <Input v-model="form.meta_name" label="Permission Name" id="permission_name" placeholder="Enter permission name..." @input="setPreview" :error="form.errors.has('meta_name')" :errorMsg="form.errors.get('meta_name')" ></Input>
                 <Legend label="Actions"></Legend>
                 <div class="flex justify-evenly items-center pl-[62px]">
                     <div class="flex-1">
                         <Checkbox v-model="checkbox_view" :disabled="setDisabled" id="view" label="View" @change="setAction($event,'view')"></Checkbox>
                     </div>
                     <div class="flex-1">
                         <Checkbox v-model="checkbox_update" :disabled="setDisabled" id="update" label="Update"  @change="setAction($event,'update')" ></Checkbox>
                     </div>
                     <div class="flex-1">
                         <Checkbox v-model="checkbox_create" :disabled="setDisabled" id="create" label="Create" @change="setAction($event,'create')" ></Checkbox>
                     </div>
                     <div class="flex-1">
                         <Checkbox v-model="checkbox_delete" :disabled="setDisabled" id="delete" label="Delete" @change="setAction($event,'delete')" ></Checkbox>
                     </div>
                 </div>
                 <hr class="my-5 border-1 border-aside">
                 <div class="flex items-end">
                     <div class="flex-auto w-full mr-2">
                         <Input :disabled="setDisabled" v-model="type_name" label="Type Name" id="type_name" placeholder="Enter type name..." ></Input>
                     </div>
                     <div class="flex-auto">
                         <ClearButton :icon="PlusIcon"  @click="addCustom()"></ClearButton>
                     </div>
                 </div>
                 <div v-for="(item, index) in form.meta_array.custom_actions" >
                     <Legend :label="item.name" :showButton="true" :onButtonClick="() => removeCustom(index)" :icon="MinusIcon" :iconClass="'text-red-600'"></Legend>
                     <div class="flex justify-end">
                         <div class="flex items-end w-[90%]">
                             <div class="flex-auto w-full mr-2">
                                 <Input v-model="form.meta_array.custom_actions[index].items.name" label="Permission" id="child_name" placeholder="Enter permission name..." ></Input>
                             </div>
                             <div class="flex-auto">
                                 <ClearButton :icon="PlusIcon"  @click="addNewChildItem(index)"></ClearButton>
                             </div>
                         </div>
                     </div>
                     <hr class="my-5 border-1 border-slate-200">
                     <div class="grid grid-cols-3 gap-4 pl-5">
                         <div v-for="(chunk, chunkIndex) in chunkArray(item.items, 4)" :key="chunkIndex">
                             <ul class="text-sm text-aside">
                                 <li class="flex justify-start items-center" v-for="(child, childIndex) in chunk" :key="child.name">
                                     <button @click="removeChild(index, childIndex)" class=" px-1.5 focus:outline-none bg-white rounded-md hover:border border-red-300 hover:bg-red-100 hover:text-white focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700" >
                                         <MinusIcon class="w-4 h-4 text-red-700"></MinusIcon>
                                     </button>
                                     <span class="py-1 ml-2">{{ child.name }}</span>
                                 </li>
                             </ul>
                         </div>
                     </div>

                 </div>
             </div>

             <div  class="pr-4 relative">
                 <Legend :label="'Preview'" :centered="true" :showButton="false"></Legend>
                 <div v-if="!setDisabled" class="rounded-md border border-aside p-4">
                     <div class="flex items-center justify-between">
                         <div class="flex-1">
                             <Checkbox :disabled="true" id="create" :label="form.meta_name" :checked="true"></Checkbox>
                         </div>
                         <span><ChevronDownIcon class="h-6 w-6 text-aside"></ChevronDownIcon></span>
                     </div>
                     <hr class="my-3 border-1 border-slate-300">
                     <div class="flex justify-evenly items-center pl-[62px]">
                         <div class="flex-1">
                             <Checkbox :disabled="true" id="view" label="View" v-model="preview_view"></Checkbox>
                         </div>
                         <div class="flex-1">
                             <Checkbox :disabled="true" id="update" label="Update" v-model="preview_update"></Checkbox>
                         </div>
                         <div class="flex-1">
                             <Checkbox :disabled="true" id="create" label="Create" v-model="preview_create"></Checkbox>
                         </div>
                         <div class="flex-1">
                             <Checkbox :disabled="true" id="delete" label="Delete" v-model="preview_delete"></Checkbox>
                         </div>
                     </div>
                     <div v-for="item in form.meta_array.custom_actions">
                         <Legend :label="item.name"></Legend>
                         <div class="grid grid-cols-3 gap-4 pl-5">
                             <div v-for="(chunk, chunkIndex) in chunkArray(item.items, 4)" :key="chunkIndex">
                                 <ul class="text-sm text-aside">
                                     <li class="flex justify-start items-center" v-for="(child, childIndex) in chunk" :key="child.name">
                                         <Checkbox :disabled="true" :checked="true" :id="child.name" :label="child.name" ></Checkbox>
                                     </li>
                                 </ul>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="absolute bottom-0 right-4">
                     <SolidButton :type="'button'" :disabled="setDisabled" :label="'Submit'" :isLoading="form.busy" :icon="Square3Stack3DIcon" @click.prevent="saveItem" :customClass="'px-[30px] text-primary'"></SolidButton>
                 </div>
             </div>
         </div>
     </div>
 </template>

 <script setup>
 import { ref, watch, reactive, onMounted, onBeforeUnmount, onActivated, onUpdated, onDeactivated, onBeforeUpdate, nextTick } from 'vue';
 import Input from '@/components/parts/Forms/Input.vue';
 import Checkbox from '@/components/parts/Forms/Checkbox.vue';
 import Legend from '@/components/parts/Banner/Legend.vue';
 import ClearButton from '@/components/parts/Buttons/ClearButtons.vue';
 import SolidButton from '@/components/parts/Buttons/SolidButton.vue';
 import { PlusIcon, MinusIcon, ChevronDownIcon, Square3Stack3DIcon } from '@heroicons/vue/20/solid';
 import Form from 'vform'
 import { successMessage, errorMessage } from "@/utilities/toast.js";
 import { chunkArray, slug } from "@/utilities/functions.js";

 const selection = ref([])
 const type_name = ref('')

 const checkbox_view = ref(false)
 const checkbox_update = ref(false)
 const checkbox_create = ref(false)
 const checkbox_delete = ref(false)

 const preview_view = ref(false)
 const preview_update = ref(false)
 const preview_create = ref(false)
 const preview_delete = ref(false)

 const setDisabled = ref(true)

 const form = reactive(new Form({
     id: null,
     meta_parent_id: '',
     meta_parent:'permission',
     meta_name: '',
     meta_value: '',
     meta_array: {
         primary_actions: [],
         custom_actions: [],
     }

 }));


 function setPreview(evt){
    if(evt.target.value != ""){
         setDisabled.value = false
         form.meta_value = 'permission-'+ slug(form.meta_name)
    }else{
     setDisabled.value = true
    }
 }


 function setAction(evt,name){
     const isChecked = evt.target.checked;
     if (isChecked) {
         if (!form.meta_array.primary_actions.includes(name)) {
             form.meta_array.primary_actions.push(name);
         }
         if(name == 'view') preview_view.value = true;
         if(name == 'update') preview_update.value = true;
         if(name == 'create') preview_create.value = true;
         if(name == 'delete') preview_delete.value = true;
     } else {
         if(name == 'view') preview_view.value = false;
         if(name == 'update') preview_update.value = false;
         if(name == 'create') preview_create.value = false;
         if(name == 'delete') preview_delete.value = false;

         const index = form.meta_array.primary_actions.indexOf(name);
         if (index !== -1) {
             form.meta_array.primary_actions.splice(index, 1);
         }
     }
 }

 function addCustom() {
     let name = type_name.value.trim();

     if (name) {
         const newCustomAction = { name: name, key: slug(name), items: [] };
         form.meta_array.custom_actions.push(newCustomAction);
         nextTick(() => {
             if (areNamesUnique(form.meta_array)) {
                 type_name.value = "";
             } else {
                 form.meta_array.custom_actions.pop();
                 errorMessage("Oops!", "Duplicate names found", "top-right");
             }
         });
     } else {
         errorMessage("Oops!", "Type name is required.", "top-right");
     }
 }
 function removeCustom(index){
     if (index !== -1) {
         form.meta_array.custom_actions.splice(index, 1)
     }
 }

 function addNewChildItem(index) {
     const customAction = form.meta_array.custom_actions[index];
     if (customAction) {
         let itemName = customAction.items.name ? customAction.items.name.trim() : '';

         if (itemName) {
             const newChildItem = { name: itemName, key: slug(itemName) };
             customAction.items.push(newChildItem);
             nextTick(() => {
                 if (areNamesUnique(form.meta_array)) {
                     customAction.items.name = "";
                 } else {
                     customAction.items.pop();
                     errorMessage("Oops!", "Duplicate names found", "top-right");
                 }
             });
         } else {
             errorMessage("Oops!", "Permission name is required.", "top-right");
         }
     }
 }

 function removeChild(parentIndex, childIndex){
     form.meta_array.custom_actions[parentIndex].items.splice(childIndex, 1)
 }

 function saveItem(){
     form.post('/api/maintenance').then((response) => {
         if(response.data.success){
             successMessage('Hooray!', 'Permission has been created successfully.', "top-right");

             form.reset();
             form.meta_array.primary_actions = []
             form.meta_array.custom_actions = []
             checkbox_view.value = false
             checkbox_update.value = false
             checkbox_create.value = false
             checkbox_delete.value = false
             setDisabled.value = true
         }
     }).catch((error) => {
         errorMessage("Oops!", error.response.data.message, "top-right");
     })
 }

 function areNamesUnique(actions) {
      const nameSet = new Set();

     // if (actions.primary_actions) {
     //     actions.primary_actions.forEach(action => {
     //         if (nameSet.has(action)) {
     //             return false;
     //         }
     //         nameSet.add(action);
     //     });
     // }

     if (actions.custom_actions) {
         for (let customAction of actions.custom_actions) {
             if (nameSet.has(customAction.name)) {
                 return false;
             }
             nameSet.add(customAction.name);

             if (customAction.items) {
                 for (let item of customAction.items) {
                     if (nameSet.has(item.name)) {
                         return false;
                     }
                     nameSet.add(item.name);
                 }
             }
         }
     }
     return true;
 }


 </script>
