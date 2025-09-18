<template>
  <div class="rounded-md shadow-md border border-gray-200 px-4 pb-5" data-aos="fade-in" data-aos-delay="100" data-aos-duration="1000">
    <div class="flex justify-between items-center border-b border-aside py-2">
      <h3 class="text-aside">Certificate Template</h3>
      <ClearButton :icon="null" @click="openDrawer" :buttonClass="'py-1 px-1.5 text-aside border-bluer'" :label="!createNew ? 'Create New Template' : 'Back to Table'"></ClearButton>
    </div>

    <Table v-if="!createNew" :url="'/api/receipt-series-summary'" :headers="templateTable" :hasDateFilter="false" :key="tableKey" :searchKey="searchTerm"></Table>
    <div v-else :key="switchKey">
      <form @submit.prevent="editMode ? updateTemplate() : saveTemplate()">
          <div class="grid grid-cols-5 gap-4 my-5">
            <Input v-model="form.name" :error="form.errors.has('name')" :errorMsg="form.errors.get('name')" label="Template Name" id="booklet" placeholder=""></Input>
            <Input v-model="form.height" :error="form.errors.has('height')" :errorMsg="form.errors.get('height')" label="Receipt Height (inches)" id="height" placeholder="" @input="setHeight"></Input>
            <Input v-model="form.width" :error="form.errors.has('width')" :errorMsg="form.errors.get('width')" label="Receipt Width (inches)" id="width" placeholder="" @input="setWidth"></Input>
            <Input v-model="form.font_size" label="Font Size" id="font-size" placeholder="" :error="form.errors.has('font_size')" :errorMsg="form.errors.get('font_size')"></Input>
          </div>
          <div class="flex items-start justify-start my-5 gap-4">
            <Input :class="'w-80'" :error="form.errors.has('guide_image_path')" type="file" :errorMsg="form.errors.get('guide_image_path')" label="Image Guide/Model" id="model" @change="handleImageUpload"></Input>
            <div>
              <label class="text-aside text-sm" for="unique-fields">Unique Field Name</label>
              <v-select id="unique-fields"  class="text-sm w-80 font-thin v-select-gray" :options="unique_fields" @option:selected="setLabel" label="title" placeholder=""></v-select>
              <p v-if="form.errors.has('fields')" class="text-red-600 text-xs my-1">{{ form.errors.get('fields') }}</p>
            </div>
            <div class="w-44">
              <SolidButton :type="'submit'" label="Save Template" :icon="null" :customClass="'text-white bg-aside hover:bg-blue-600 mt-6'"></SolidButton>
            </div>
          </div>
          <div class="my-10">
            <FabricCanvas :fields="selectedFields" :box_width="width" :box_height="height" :key="fabricKey" :backgroundImage="imageBG" @update-text-box-data="handleTextBoxData"></FabricCanvas>
          </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { onMounted, reactive, ref, watch, computed, provide, inject, onUpdated, nextTick, onUnmounted } from "vue";
import Form from 'vform';
import { successMessage, errorMessage } from "@/utilities/toast.js";
import { siteSettings } from '@/store/utils';
import Legend from '@/components/parts/Banner/Legend.vue';
import { PlusIcon } from '@heroicons/vue/20/solid';
import ClearButton from '@/components/parts/Buttons/ClearButtons.vue';
import Table from '@/components/parts/Tables/Table.vue';
import Input from '@/components/parts/Forms/Input.vue';
import SolidButton from '@/components/parts/Buttons/SolidButton.vue';
import Select from '@/components/parts/Forms/Select.vue';
import { chunkArray, slug, activityLog } from "@/utilities/functions.js";
import { userAuthStore } from '@/store/auth';
import Dropdown from '@/components/parts/Buttons/Dropdown.vue';
import TabsComponent from '@/components/parts/Tab/TabIcon.vue';
import FabricCanvas from '@/components/parts/Forms/Fabric.vue';
import { UserIcon, BuildingOffice2Icon, UsersIcon, BuildingOfficeIcon, ListBulletIcon, Cog8ToothIcon, ClipboardDocumentIcon, ClipboardDocumentCheckIcon, DocumentMagnifyingGlassIcon } from '@heroicons/vue/24/outline';

const createNew = ref(false);
const fabricCanvas = ref(null);
const editMode = ref(false)
const selectedFields = ref([]);
const width = ref(1200);
const height = ref(600);
const fabricKey = ref(0);
const switchKey = ref(0);
const imageBG = ref(null);

const form = reactive(new Form({
  id: '',
  name: '',
  receipt_type: '',
  tax_zone: '',
  height: '',
  width: '',
  font_size: '',
  box_width: '',
  guide_image_path: '',
  fields: [],
}));


const unique_fields = ref([

  { id: 'title', title: 'Title' },
  { id: 'name', title: 'Customer Name' },
  { id: 'topic', title: 'Topic Title' },
]);

const templateTable = reactive([
  { title: 'Template Name', onSet: true, sortable: false, query: 'numbering', date_filtered: false, searchable: true, checked: true, hasInlineEdit: true, textAlign: 'left', columnWidth: 'w-80' },
//   { title: 'Receipt Type', onSet: true, sortable: false, query: 'numbering', date_filtered: false, searchable: true, checked: true, hasInlineEdit: true, textAlign: 'left' },
//   { title: 'Tax Zone', onSet: true, sortable: true, query: 'numbering', date_filtered: false, searchable: true, checked: true, hasInlineEdit: false, textAlign: 'center' },
  { title: 'Preview', onSet: true, sortable: false, query: 'numbering', date_filtered: false, searchable: true, checked: true, hasInlineEdit: true, textAlign: 'center' },
  { title: 'ACTIONS', onSet: true, sortable: false, query: 'used', date_filtered: false, searchable: true, checked: true, hasInlineEdit: false, textAlign: 'center' },
]);

function openDrawer() {
  createNew.value = !createNew.value;
  fabricKey.value++;
  switchKey.value++;

  if (!createNew.value) {
    form.reset();
    imageBG.value = null;
    selectedFields.value = [];
  }
}

function setLabel(field) {
  selectedFields.value.push(field);
}

function setHeight(event) {
  const newHeight = event.target.value * 192;
  height.value = newHeight;
}

function setWidth(event) {
  const newWidth = event.target.value * 192;
  width.value = newWidth;
}

function handleImageUpload(event) {
    const file = event.target.files[0];
    if (!file) {
      errorMessage("Oops!", "No file selected", "top-right");
      return;
    }

    if (!file.type.startsWith('image/')) {
      errorMessage("Oops!", "File is not an image", "top-right");
      return;
    }

    const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2MB
    if (file.size > MAX_FILE_SIZE) {
      errorMessage("Oops!", "File is too large. 2MB max.", "top-right");
      return;
    }

    const reader = new FileReader();
    reader.onload = (e) => {
      imageBG.value = e.target.result;
      form.guide_image_path = e.target.result;
    };
    reader.onerror = (error) => {
      errorMessage("Oops!", 'Error reading file:', error, "top-right");
    };
    reader.readAsDataURL(file);
}

const handleTextBoxData = (data) => {
  form.fields = data
};

function saveTemplate(){
  form.post('/api/receipt-template').then((response) => {
    form.reset();
    imageBG.value = null;
    selectedFields.value = [];
    successMessage('Success!', 'Template has been created successfully.', "top-right");
  }).catch((error) => {
    errorMessage("Oops!", "Something went wrong.", "top-right");
  });
}

</script>

<style>
.v-select-gray .vs__search::placeholder,
.v-select-gray .vs__dropdown-toggle {
  background: #fff;
  border: none;
  color: #4b5563;
  font-size: 14px;
  padding: 4px 0;
  border: 1px solid #d1d5db;
  background: #fff;
}

.v-select-gray .vs__selected {
  color: #4b5563;
}

.v-select-gray .vs__clear,
.v-select-gray .vs__open-indicator {
  fill: #4b5563;
}
</style>
