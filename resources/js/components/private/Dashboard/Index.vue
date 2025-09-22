<template>
    <div class="relative my-5 px-3">
        <div class="flex w-full justify-center items-center mb-5">
            <div class="pr-4">
                <img class="h-14 w-14 rounded-full" src="https://proptech.globalland.com.ph/images/default/profile_pic.png" alt="">
            </div>
            <div class="flex-1">
                <h3 class="text-font-darkblue text-2xl font-extrabold text-primary">Good Day,</h3>
                <h3 class="text-font-darkblue text-2xl font-extrabold text-primary">{{fullName}}!</h3>
            </div>
        </div>
        <div class="flex justify-between items-center my-5">
            <div class=" flex gap-2 flex-auto">
                <button
                    v-for="(button, index) in buttons"
                    :key="index"
                    @click="setActiveButton(index)"
                    :class="[
                        'px-5 shadow-md rounded-full text-center text-sm cursor-pointer py-1',
                        activeButton === index
                        ? 'bg-primary text-white' // Active button style
                        : 'bg-gold text-white',   // Inactive button style
                        'transition-colors duration-300 ease-in-out' // Smooth transition
                    ]"
                    >
                    {{ button }}
                </button>
            </div>
            <div class="flex-1 flex justify-end">
                <div class="w-60 pr-4">
                    <VueDatePicker :start-date="startDate" placeholder="Filter (From Date)" />
                </div>
                <div class="w-60">
                    <VueDatePicker :start-date="currentDate" placeholder="Filter (To Date)" />
                </div>
            </div>
        </div>
        <hr class="my-5  border-secondary">
        <h2 class="text-secondary text-xl mb-5">Summaries</h2>
        <div class="grid grid-cols-5 gap-5 mb-5">
            <div class="shadow-md border border-gray-300 h-52 rounded-md mb-3"></div>
            <div class="shadow-md border border-gray-300 h-52 rounded-md mb-3"></div>
            <div class="shadow-md border border-gray-300 h-52 rounded-md mb-3"></div>
            <div class="shadow-md border border-gray-300 h-52 rounded-md mb-3"></div>
            <div class="shadow-md border border-gray-300 h-52 rounded-md mb-3"></div>
        </div>
        <div class="flex gap-3">
            <div class="shadow-md border border-gray-300 h-[512px] rounded-md w-2/3"></div>
            <div class="flex flex-col w-1/3">
                <div class="shadow-md border border-gray-300 h-[250px] rounded-md mb-3"></div>
                <div class="shadow-md border border-gray-300 h-[250px] rounded-md mb-3"></div>
            </div>
        </div>
        <h2 class="text-secondary text-xl my-5">Data Summary Charts</h2>
        <div class="grid grid-cols-2 gap-5">
            <div class="shadow-md border border-gray-300 h-[350px] rounded-md mb-3"></div>
            <div class="shadow-md border border-gray-300 h-[350px] rounded-md mb-3"></div>
            <div class="shadow-md border border-gray-300 h-[350px] rounded-md mb-3"></div>
            <div class="shadow-md border border-gray-300 h-[350px] rounded-md mb-3"></div>
        </div>

    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import {userAuthStore} from '@/store/auth';

const activeButton = ref(0);

// List of button labels
const buttons = [
  'Overview',
//   '',
];

const fullName = ref('System Admin')
const startDate = ref(new Date(new Date().getFullYear(), 0, 1));
const currentDate = ref(new Date());

function setActiveButton(index) {
  activeButton.value = index;
}
onMounted(async () => {
    fullName.value = userAuthStore().user.user.first_name
});

</script>
