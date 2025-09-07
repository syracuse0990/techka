<template>
  <div>
    <div class="border-b border-primary dark:border-gray-700">
      <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" role="tablist">
        <li v-for="(tab, index) in tabData" :key="index" class="me-1" role="presentation">
          <button :class="[ 'inline-block px-3 py-2 border-t border-l border-r rounded-t-lg', activeTab === index ? 'border-secondary bg-primary text-white' : 'hover:text-secondary hover:border-gray-300 text-gold border-gold dark:hover:text-gray-300' ]"
            @click="selectTab(index)" :id="`${tab.name}-tab`" type="button" role="tab" :aria-controls="tab.name" :aria-selected="activeTab === index" >
            {{ tab.label }}
          </button>
        </li>
      </ul>
    </div>
    <div v-for="(tab, index) in tabData" :key="index" :id="tab.name" role="tabpanel" :aria-labelledby="`${tab.name}-tab`" :class="[ 'bg-white border-b-2 shadow-md border-primary rounded-b-md', activeTab === index ? '' : 'hidden' ]" >
      <slot :name="tab.name"></slot>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
  tabData: {
    type: Array,
    default: () => [],
  },
});

const activeTab = ref(0);

const selectTab = (index) => {
  activeTab.value = index;
  emit('click', index);
};


const emit = defineEmits(['click']);

</script>
