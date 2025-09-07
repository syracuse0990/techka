<template>
        <div :id="id" aria-modal="true" role="dialog" :class="isShowing ? 'transform-none' : 'translate-x-full'" class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform border  shadow-md shadow-primary bg-white w-96 dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-right-label">
            <h5 id="drawer-label" class="inline-flex items-center mb-4 text-base font-semibold text-primary dark:text-gray-400">
                <slot name="header">
                    {{ title }}
                </slot>

            </h5>
            <hr>
            <div class="content">
                <slot name="content">

                </slot>
            </div>
        </div>
        <div v-if="isShowing" drawer-backdrop="" class="bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-30"></div>
  </template>

  <script setup>
 const props = defineProps({
    title: {
      type: String,
      default: 'Button',
    },
    id: {
      type: String,
      default: 'drawer-modal',
    },
    class:{
        type: String,
        default: '',
    },
    areaHidden:{
        type: Boolean,
        default: true
    },
    isShowing:{
        type: Boolean,
        default: false
    }

  });
  console.log('isShowing:', props.isShowing);
    //TOP orientation use - fixed top-0 left-0 right-0 z-40 w-full p-4 transition-transform -translate-y-full bg-white dark:bg-gray-800
      //RIGHT orientation use - fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white w-80 dark:bg-gray-800
      //LEFT orientation use - fixed top-0 left-0 z-40 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white w-80 dark:bg-gray-800
      //BOTTOM orientation use - fixed bottom-0 left-0 right-0 z-40 w-full p-4 overflow-y-auto transition-transform bg-white dark:bg-gray-800 transform-none
  </script>


