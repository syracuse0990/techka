<template>
    <button :type="type" :disabled="loading" @click="handleClick" :class="[ buttonClass,' text-sm font-medium  focus:outline-none', 'bg-white rounded-lg border  hover:bg-gray-100 hover:text-blue-700', 'focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700', 'dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700', { 'cursor-not-allowed opacity-50': loading } ]" >
      <span v-if="loading">
        <svg class="animate-spin h-5 w-5 text-gray-900 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" >
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" ></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" ></path>
        </svg>
      </span>
      <component v-else-if="icon" :is="icon" class="h-5 w-5" />
      <span v-else>
        {{ label }}
      </span>
    </button>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  const props = defineProps({
    label: {
      type: String,
      default: 'Button',
    },
    buttonClass:{
      type: String,
      default: 'py-2 px-2.5 text-gray-900 border-gray-200',
    },
    icon: {
      type: Object, 
      default: null,
    },
    type: {
      type: String,
      default: 'button',
    },
  });
  
  const emit = defineEmits(['click']);
  const loading = ref(false);
  
  const handleClick = () => {
    loading.value = true;
    emit('click');
    setTimeout(() => {
      loading.value = false; 
    }, 500); 
  };
  </script>
  