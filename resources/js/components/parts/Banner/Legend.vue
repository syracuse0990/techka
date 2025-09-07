<template>
  <div class="flex items-center my-4">
    <div v-if="centered" class="flex-grow border-t border-slate-300"></div>
      <span :class="[labelCss, centered ? 'pl-4': '']" class="dark:text-white">{{ label }}</span>
    <div class="flex-grow border-t border-slate-300"></div>

    <button v-if="showButton"
      :class="['ml-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border  hover:text-white focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700', buttonClass]"
      @click="onButtonClick" >

      <component :is="icon" class="w-5 h-5" :class="iconClass" />
    </button>
  </div>
</template>

<script setup>
const props = defineProps({
  label: {
    type: String,
    default: 'ACTIONS',
  },
  labelCss: {
    type: String,
    default: 'text-md pr-4 font-medium text-primary',
  },
  showButton: {
    type: Boolean,
    default: false,
  },
  centered:{
    type: Boolean,
    default: false,
  },
  buttonClass:{
    type: String,
    default: 'border-red-300 hover:bg-red-100 py-0 px-1.5',
  },
  icon:{
    type: Object,
    default: []
  },
  iconClass:{
    type: String,
    default: '',
  },
  onButtonClick: {
    type: Function,
    default: () => {},
  },
});
</script>
