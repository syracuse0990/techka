<template>
    <div class="flex items-center">
      <input :id="id" type="checkbox" :disabled="disabled" :checked="modelValue || checked"  @change="$emit('update:modelValue', $event.target.checked)"
        :class="[
          'w-4 h-4 text-aside bg-gray-100 border-gray-300 rounded focus:ring--aside',
          'dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2',
          'dark:bg-gray-700 dark:border-gray-600'
        ]"
      />
      <label :for="id" class="ms-2 text-sm  text-aside dark:text-gray-300" >
        {{ label }}
      </label>
    </div>
  </template>

  <script setup>
  const props = defineProps({
    id: {
      type: String,
      required: true,
    },
    disabled:{
      type: Boolean,
      default: false,
    },
    checked:{
      type: Boolean,
      default: false,
    },
    label: {
      type: String,
      required: true,
    },
    modelValue: {
      type: Boolean,
      default: false,
    },
  });
  </script>
