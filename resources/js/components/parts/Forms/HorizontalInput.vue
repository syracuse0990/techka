<template>
    <div class="flex justify-between items-center mb-2">
      <label :for="id" :class="['block w-[250px] text-aside text-sm font-medium', labelClass]" v-if="label">
        {{ label }}
      </label>
      <input v-if="type !== 'textarea' && type !== 'select'" :type="type" :id="id" :class="['bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5', inputClass]" 
      :placeholder="placeholder" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" :required="required" v-bind="$attrs" />

      <textarea v-else-if="type == 'textarea'" :type="type" :id="id" :rows="rows" 
      :class="['block p-2.5 w-full text-sm text-gray-900 bg-white rounded-md border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500', inputClass]" 
      :placeholder="placeholder" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" :required="required" v-bind="$attrs"></textarea>
      
      <select v-else :id="id"  :required="required" @change="$emit('update:modelValue', $event.target.value)" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-aside focus:border-aside block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option v-if="placeholder" :value="null" disabled selected>{{ placeholder }}</option>
            <option v-for="option in options" :key="option.value" :value="option.value">
                {{ option.label }}
            </option>
      </select>

    </div>
  </template>
  
  <script setup>
    const props = defineProps({ 
      id: {
        type: String,
        required: true,
      },
      label: {
        type: String,
        default: '',
      },
      type: {
        type: String,
        default: 'text',
      },
      placeholder: {
        type: String,
        default: '',
      },
      modelValue: {
        type: [String, Number],
        default: '',
      },
      required: {
        type: Boolean,
        default: false,
      },
      inputClass: {
        type: String,
        default: '',
      },
      labelClass: {
        type: String,
        default: '',
      },
      rows: {
        type: [String, Number],
        default: '4',
      },
      options: {
        type: Array,
        required: true,
        validator(value) {
          return value.every(option => 'label' in option && 'value' in option);
        },
      },

     })

     const emit = defineEmits(['update:modelValue', 'update:error']);

  </script>
  