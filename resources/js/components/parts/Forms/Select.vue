<template>
    <div class="px-2">
        <label :id="id" class="block mb-2 text-sm font-medium text-aside dark:text-white">{{ label }}</label>
        <select :id="id"  @change="$emit('update:modelValue', $event.target.value)" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-aside focus:border-aside block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option v-if="placeholder" :value="null" disabled selected>{{ placeholder }}</option>
            <option v-for="option in options" :key="option.meta_value" :value="option.id">
                {{ option.meta_name }}
            </option>
        </select>
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
    }
  });

  const emit = defineEmits(['update:modelValue', 'update:error']);


</script>

