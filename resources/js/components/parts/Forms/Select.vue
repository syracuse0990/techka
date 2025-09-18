<template>
    <div class="relative">
        <label v-if="hasLabel" :id="id" :class="customClass" class="block mb-1 text-sm  text-gray-700 dark:text-white">{{ label }}</label>
        <select :id="id"  @change="$emit('update:modelValue', $event.target.value)" :class="[customClass,error ? 'border-red-600' : 'border-gray-400']" class="bg-white py-[7.5px] border  text-gray-900 text-sm rounded-lg focus:ring-aside focus:border-aside block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option v-if="placeholder" :value="null" disabled selected>{{ placeholder }}</option>
            <option v-for="option in options" :key="option.meta_value" :value="valueArray ? JSON.stringify(option) : option.id" :selected="option.meta_parent == 'maintenance-jas-year' && option.status == true">
                {{ option.meta_name }}
            </option>
        </select>
        <p v-if="error" class="text-xs text-red-600 mt-1 font-normal">{{ errorMsg }}</p>
    </div>
</template>

<script setup>
    const props = defineProps({
    label: {
      type: String,
      default: 'Select an option',
    },
    options: {
      type: Array,
      required: true,
      validator(value) {
        return value.every(option => 'meta_name' in option && 'id' in option);
      },
    },
    modelValue: {
      type: [String, Number, Object, Boolean],
      default: null,
    },
    id: {
      type: String,
      default: 'select-id',
    },
    placeholder: {
      type: String,
      default: null,
    },
    error:{
      type: Boolean,
      default: false,
    },
    errorMsg:{
      type: String,
      default: '',
    },
    customClass:{
      type: String,
      default: '',
    },
    valueArray: {
      type: Boolean,
      default: false,
    },
    hasLabel:{
      type: Boolean,
      default: true,
    }
  });

  const emit = defineEmits(['update:modelValue', 'update:error']);


</script>

