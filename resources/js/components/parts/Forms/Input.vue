<template>
    <div>
      <label :for="id" class="block mb-1 text-sm font-medium text-slate-700 dark:text-white" >
        {{ label }}
      </label>
      <input @mouseenter="resetError" :type="type" :id="id" :value="modelValue" :disabled="disabled" @input="$emit('update:modelValue', $event.target.value)"
        :class="[error ? 'border-red-400' : 'border-gray-300', 'bg-white border  text-gray-900 text-sm rounded-md focus:ring-aside focus:border-aside', ' block w-full p-135', 'dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white', 'dark:focus:ring-blue-500 dark:focus:border-blue-500' ]"
        :placeholder="placeholder"
        :required="required"
      />
      <p v-if="error" class="text-red-600 text-xs my-2">{{ errorMsg }}</p>
    </div>
  </template>
  
  <script setup>
  const props = defineProps({
    label: {
      type: String,
      required: true,
    },
    disabled:{
      type: Boolean,
      default: false,
    },
    id: {
      type: String,
      required: true,
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
      type: String,
      default: '',
    },
    required: {
      type: Boolean,
      default: false,
    },
    error:{
      type: Boolean,
      default: false,
    },
    errorMsg:{
      type: String,
      default: '',
    }
  });

  const emit = defineEmits(['update:modelValue', 'update:error']);

  // Emit event to reset error on hover
  const resetError = () => {
    emit('update:error', false);
  };
  
  </script>