<template>
    <div class="relative w-full">
        <select v-if="type == 'select'" :id="id" :value="localValue" :required="required" @change="onChange($event)" :class="[inputClass,error ? 'border-red-400' : 'border-gray-300',]" class="bg-white capitalize border text-gray-600  text-xs rounded-md focus:ring-primary focus:border-primary block w-full px-2 py-[10.5px] dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 ">
              <option v-if="placeholder" :value="''"  selected>{{ placeholder }}</option>
              <option v-for="option in options" :key="isMaintenance ? option.id : option.value" :value="isMaintenance ? option.id : option.value">
                  {{ isMaintenance ? option.meta_name :option.label }}
              </option>
        </select>
        <textarea v-else-if="type == 'textarea'":id="id" :value="modelValue" :disabled="disabled" @input="$emit('update:modelValue', $event.target.value)" :placeholder="placeholder" rows="3"
        :required="required" :class="[inputClass, error ? 'border-red-600' : 'border-gray-300' ]" class="block px-2.5 pb-1.5 pt-3 w-full text-xs text-gray-900 bg-transparent rounded-lg border-1  appearance-none dark:text-white dark:border-gray-600 dark:focus:border-aside focus:outline-none focus:ring-0 focus:border-aside peer"></textarea>

        <input v-else  :type="type" :id="id" :value="modelValue" :disabled="disabled" @input="$emit('update:modelValue', $event.target.value)" :placeholder="placeholder"
        :required="required" :class="[inputClass, error ? 'border-red-600' : 'border-gray-300' ]" class="block px-2.5 pb-1.5 pt-3 w-full text-xs text-gray-900 bg-transparent rounded-lg border-1  appearance-none dark:text-white dark:border-gray-600 dark:focus:border-aside focus:outline-none focus:ring-0 focus:border-aside peer" />


        <label :for="id"  class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-primary peer-focus:dark:text-aside peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">{{ label }}</label>

    </div>
    <p v-if="error" class="text-xs text-red-600 mt-1 font-normal ">{{ errorMsg }}</p>
</template>

<script setup>
import { ref, watch } from 'vue';
const props = defineProps({
  label: {
    type: String,
    required: true,
  },
  disabled:{
    type: Boolean,
    default: false,
  },
  inputClass:{
    type: String,
    default: '',
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
  isMaintenance:{
    type: Boolean,
    default: false,
  },
   options: {
    type: Array,
    default: []
    // validator(value) {
    //   return value.every(option => 'label' in option && 'value' in option);
    // },
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

const emit = defineEmits(['update:modelValue', 'change']);

     const localValue = ref(props.modelValue);

      watch(() => props.modelValue, (newValue) => {
        localValue.value = newValue;
      });


      const onChange = (event) => {
  const newValue = typeof event === 'object' && event.target ? event.target.value : event;
  emit('update:modelValue', newValue); // Update v-model binding
  emit('change', newValue); // Emit the change event
};


</script>

