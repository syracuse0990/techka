<template>
    <div class="w-full border rounded-md">
      <!-- Accordion Header -->
      <button @click="toggleAccordion" class="w-full text-left px-4 py-2 flex justify-between items-center focus:outline-none" >
        <span class="text-sm text-aside">{{ title }}</span>
        <svg :class="{ 'rotate-180': isOpen }" class="w-5 h-5 text-aside transform transition-transform duration-300 ease-in-out" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" > <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /> </svg>
      </button>
  

      <div v-if="isOpen" ref="content" class="overflow-hidden transition-all duration-300 ease-in-out" :style="{ maxHeight: contentHeight + 'px' }" >
        <div class="p-4">
          <slot></slot>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, nextTick } from 'vue'
  
  const props = defineProps({
    title: String,
  })
  
  const isOpen = ref(false)
  const contentHeight = ref(0)
  const content = ref(null)
  
  const toggleAccordion = async () => {
    isOpen.value = !isOpen.value
    await nextTick()
    if (isOpen.value) {
      contentHeight.value = content.value.scrollHeight
    } else {
      contentHeight.value = 0
    }
  }
  
  onMounted(() => {
    contentHeight.value = isOpen.value ? content.value.scrollHeight : 0
  })
  </script>
  
  <style scoped>
  .rotate-180 {
    transform: rotate(180deg);
  }
  </style>
  