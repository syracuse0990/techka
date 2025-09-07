<template>
    <div>
        <div class="border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap transform transition-transform duration-300 ease-in-out -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                <li class="me-2" v-for="(tab, index) in tabData" :key="index">
                    <a href="#" 
                       @click.prevent="!tab.disabled && selectTab(index)" 
                       :id="`${tab.name}-tab`" 
                       :class="['inline-flex  items-center justify-center px-4 py-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group', 
                                activeTab === index ? 'text-aside border-b-2 border-aside' : 'border-b-2 border-transparent']">
                        <component v-if="tab.icon" :is="tab.icon" class="h-5 w-5 me-1" />
                        {{ tab.label }}
                    </a>
                </li>
            </ul>
        </div>
        <div v-for="(tab, index) in tabData" :key="index" :id="tab.name" role="tabpanel" 
             :aria-labelledby="`${tab.name}-tab`" 
             :class="[ 'bg-white border-b-2 shadow-md border-aside rounded-b-md', activeTab === index ? '' : 'hidden' ]">
            <slot :name="tab.name"></slot>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
  tabData: {
    type: Array,
    default: () => [],
  },
});

const activeTab = ref(0);
const emit = defineEmits(['click']);

const selectTab = (index) => {
  activeTab.value = index;
  emit('click', index); 
};
</script>
