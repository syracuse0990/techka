<template>
 <div class="flex h-screen">
        <!-- Left Column: Job List -->
        <div class="w-1/3 bg-white border-r border-gray-200 flex flex-col shadow-sm">
            <div class="p-4 border-b border-gray-200 bg-white">
                <div class="flex justify-between items-center mb-5">
                    <h1 class="text-xl font-semibold text-upwork-dark">My Job Posts</h1>
                    <div class="w-40">
                        <SolidButton @click.prevent="openPostModal" :type="'submit'" :label="'Create Post'" :icon="NewspaperIcon" :customClass="'text-white bg-primary border-primary hover:bg-blue-600'" ></SolidButton>
                    </div>

                </div>

                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-3 text-upwork-light"></i>
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Search jobs by title or keyword"
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary"
                    />
                </div>
            </div>

            <!-- Job List -->
            <ul class="overflow-y-auto flex-1 scrollbar-thin p-2">
                <li
                    v-for="job in filteredJobs"
                    :key="job.id"
                    @click="selectJob(job)"
                    class="job-item p-4 mb-2 bg-white rounded-lg border border-gray-200 hover:border-primary cursor-pointer"
                    :class="selectedJob?.id === job.id ? 'border-l-4 border-l-primary bg-green-50' : ''"
                >
                    <div class="flex justify-between items-start">
                        <h3 class="font-semibold text-upwork-dark text-lg mb-1">{{ job.title }}</h3>
                        <span class="text-sm font-medium text-primary whitespace-nowrap">₱{{ job.budget }}</span>
                    </div>
                    <p class="text-sm text-upwork-gray line-clamp-2 mb-2">
                        {{ job.description }}
                    </p>
                    <div class="flex items-center text-xs text-upwork-light">
                        <span class="mr-3"><i class="far fa-clock mr-1"></i> {{ job.type }}</span>
                        <span><i class="far fa-hourglass mr-1"></i> {{ job.level }}</span>
                    </div>
                    <div class="mt-2 flex flex-wrap gap-1">
                        <span v-for="(skill, index) in job.skills.slice(0, 3)" :key="index" class="text-xs px-2 py-1 bg-gray-100 text-upwork-gray rounded-full">
                            {{ skill }}
                        </span>
                        <span v-if="job.skills.length > 3" class="text-xs px-2 py-1 bg-gray-100 text-upwork-gray rounded-full">
                            +{{ job.skills.length - 3 }} more
                        </span>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Right Column: Job Preview -->
        <div class="w-2/3 px-2 overflow-y-auto scrollbar-thin bg-gray-50">
            <div v-if="selectedJob" class="max-w-5xl mx-auto bg-white rounded-xl shadow-sm p-6">
                <!-- Title & Budget -->
                <div class="flex justify-between items-start mb-6">
                    <h2 class="text-2xl font-bold text-primary">{{ selectedJob.title }}</h2>
                    <div class="text-right">
                        <p class="text-xl font-semibold text-primary">₱{{ selectedJob.budget }}</p>
                        <p class="text-sm text-upwork-gray">{{ selectedJob.type }}</p>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-upwork-dark mb-2">Job Description</h3>
                    <p class="text-upwork-gray leading-relaxed">{{ selectedJob.description }}</p>
                </div>

                <!-- Project Details Grid -->
                <div class="grid grid-cols-2 gap-4 mb-6 border-t border-gray-300 pt-5">
                    <div>
                        <p class="text-sm text-upwork-light">Experience Level</p>
                        <p class="font-medium text-upwork-dark">{{ selectedJob.level }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-upwork-light">Project Type</p>
                        <p class="font-medium text-upwork-dark">{{ selectedJob.projectType }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-upwork-light">Requirement</p>
                        <p class="font-medium text-upwork-dark">{{ selectedJob.requirement }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-upwork-light">Opportunity</p>
                        <p class="font-medium text-primary">{{ selectedJob.opportunity }}</p>
                    </div>
                </div>

                <!-- Skills -->
                <div class="mb-6 border-t border-gray-300 pt-5">
                    <h3 class="text-lg font-semibold text-upwork-dark mb-3">Skills and Expertise</h3>
                    <div class="flex flex-wrap gap-2">
                        <span
                            v-for="skill in selectedJob.skills"
                            :key="skill"
                            class="skill-tag px-3 py-1.5 bg-gray-100 text-upwork-dark text-sm rounded-md border border-gray-200 cursor-pointer"
                        >
                            {{ skill }}
                        </span>
                    </div>
                </div>

                <!-- Attachments -->
                <div class="mb-6 border-t border-gray-300 pt-5" v-if="selectedJob.attachments.length">
                    <h3 class="text-lg font-semibold text-upwork-dark mb-3">Attachments ({{ selectedJob.attachments.length }})</h3>
                    <div class="space-y-2">
                        <div v-for="(file, index) in selectedJob.attachments" :key="index" class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <i class="far fa-file-alt text-primary text-lg mr-3"></i>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-upwork-dark">{{ file.name }}</p>
                                <p class="text-xs text-upwork-light">{{ file.size }}</p>
                            </div>
                            <button class="text-primary hover:text-upwork-dark">
                                <i class="fas fa-download"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Screening Questions -->
                <div class="mb-6 border-t border-gray-300 pt-5">
                    <h3 class="text-lg font-semibold text-upwork-dark mb-3">Screening Questions</h3>
                    <ul class="list-decimal list-inside space-y-2 pl-2">
                        <li v-for="(q, index) in selectedJob.questions" :key="index" class="text-upwork-gray">{{ q }}</li>
                    </ul>
                </div>

                <!-- Activity -->
                <div class="border-b border-t border-gray-300 pt-5">
                    <h3 class="text-lg font-semibold text-upwork-dark mb-3">Activity on this Job</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-sm text-upwork-light">Proposals:</p>
                            <p class="font-medium text-upwork-dark">{{ selectedJob.activity.proposals }}</p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-sm text-upwork-light">Last viewed by client:</p>
                            <p class="font-medium text-upwork-dark">{{ selectedJob.activity.lastViewed }}</p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-sm text-upwork-light">Interviewing:</p>
                            <p class="font-medium text-upwork-dark">{{ selectedJob.activity.interviewing }}</p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-sm text-upwork-light">Invites sent:</p>
                            <p class="font-medium text-upwork-dark">{{ selectedJob.activity.invites }}</p>
                        </div>
                    </div>
                </div>

                <!-- Apply Button -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <button class="bg-primary hover:bg-green-600 text-white font-medium py-3 px-6 rounded-md transition duration-200">
                        Submit a Proposal
                    </button>
                    <!-- <button class="ml-4 text-primary hover:text-upwork-dark font-medium py-3 px-6 rounded-md border border-primary transition duration-200">
                        <i class="far fa-bookmark mr-2"></i> Save Job
                    </button> -->
                </div>
            </div>

            <div v-else class="flex flex-col items-center justify-center h-full text-upwork-light">
                <i class="far fa-file-alt text-5xl mb-4"></i>
                <p class="text-xl">Select a job to view details</p>
                <p class="text-sm mt-2">Browse available jobs on the left panel</p>
            </div>
        </div>
    </div>
     <Teleport to="body">
        <Drawer :id="'user-form'" :title="(editMode ? 'Update' : 'Add') +' Job Posts'" :isShowing="isCreatePost" customClass="w-[650px]">
            <template #content>
                <form @submit.prevent="editMode ? updateForm() : formSubmit()">
                    <div class="p-3  rounded-md mb-2">
                        <div class="flex justify-end items-center mb-4">
                            <ToogleInput v-model="form.status" label="Active" :labelPosition="'left'"></ToogleInput>
                        </div>

                        <Legend label="Let's start with a strong title." :labelCss="'text-sm pr-4 font-medium text-aside'"></Legend>
                        <p class="text-xs text-gray-500 mb-3">
                            Grab attention from the start, your job post’s first impression can draw in the best candidates.
                        </p>
                        <div class=" mb-4">
                            <FloatingInput v-model="form.title" label="Title" id="title" placeholder=""></FloatingInput>
                        </div>
                        <div class="my-2">
                            <label for="" class="text-aside text-sm font-medium">Job Categories</label>
                            <div class="rounded-md border border-gray-300 p-3 mt-1">
                                <div class="flex flex-wrap overflow-y-auto " :class="form.categories.length == 0 ? 'h-0' : 'h-32'">
                                    <p v-for="item in form.categories" :key="item.id" class="border border-aside py-[2px] px-2 rounded-full text-sm mr-2 mb-1 text-aside flex items-center hover:shadow-sm hover:shadow-aside flex-none self-start">
                                        {{ item.meta_name }}
                                        <span class="ml-2" @click.prevent="removeItem(item)">
                                            <XMarkIcon class="w-4 h-4 cursor-pointer"></XMarkIcon>
                                        </span>
                                    </p>
                                </div>
                                <hr class="my-3">
                                <div class="flex justify-end">
                                    <div class="relative px-1 w-80">
                                        <input v-debounce:300ms="filterCategories" type="text" id="simple-search" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  py-1.5 pl-2 pr-6 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder=""  />
                                        <div class="absolute inset-y-0 end-1 flex items-center ps-3 pointer-events-none">
                                            <MagnifyingGlassIcon class="h-4 w-5 text-gray-400 mr-1"></MagnifyingGlassIcon>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-1 my-3 overflow-y-auto h-60 p-1">
                                    <div class="space-y-1" v-for="(chunk, index) in chunkArray(categories, 5)" :key="index">
                                        <Checkbox v-for="item in chunk" :id="item.id"  :checked="isItemChecked(item)" :label="item.meta_name" @change="addCategoryItem($event, item)"></Checkbox>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <Legend label="Describe your project." :labelCss="'text-sm pr-4 font-medium text-aside'"></Legend>
                        <FloatingInput v-model="form.description" type="textarea" :rows="10" label="" id="title" placeholder=""></FloatingInput>

                        <div class="my-2">
                            <label for="" class="text-aside text-sm font-medium">Project Skills</label>
                            <p class="text-xs text-gray-500 mb-3">
                                What are the main skills required for your work?
                            </p>
                            <div class="rounded-md border border-gray-300 p-3 mt-1">
                                <div class="flex flex-wrap overflow-y-auto " :class="form.skills.length == 0 ? 'h-0' : 'h-32'">
                                    <p v-for="item in form.skills" :key="item.id" class="border border-aside py-[2px] px-2 rounded-full text-sm mr-2 mb-1 text-aside flex items-center hover:shadow-sm hover:shadow-aside flex-none self-start">
                                        {{ item.meta_name }}
                                        <span class="ml-2" @click.prevent="removeSkillsItem(item)">
                                            <XMarkIcon class="w-4 h-4 cursor-pointer"></XMarkIcon>
                                        </span>
                                    </p>
                                </div>
                                <hr class="my-3">
                                <div class="flex justify-end">
                                    <div class="relative px-1 w-80">
                                        <input v-debounce:300ms="filterSkills" type="text" id="simple-search" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  py-1.5 pl-2 pr-6 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder=""  />
                                        <div class="absolute inset-y-0 end-1 flex items-center ps-3 pointer-events-none">
                                            <MagnifyingGlassIcon class="h-4 w-5 text-gray-400 mr-1"></MagnifyingGlassIcon>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-1 my-3 overflow-y-auto h-60 p-1">
                                    <div class="space-y-1" v-for="(chunk, index) in chunkArray(skills, 5)" :key="index">
                                        <Checkbox v-for="item in chunk" :id="item.id"  :checked="isSkillItemChecked(item)" :label="item.meta_name" @change="addSkillsItem($event, item)"></Checkbox>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <Legend label="How long will your work take?" :labelCss="'text-sm pr-4 font-medium text-aside'"></Legend>

                        <Legend label="What level of experience will it need?" :labelCss="'text-sm pr-4 font-medium text-aside'"></Legend>
                        <Legend label="Is this job a contract-to-hire opportunity?" :labelCss="'text-sm pr-4 font-medium text-aside'"></Legend>
                        <Legend label="Tell us your budget." :labelCss="'text-sm pr-4 font-medium text-aside'"></Legend>


                    </div>
                    <hr class="my-5">
                    <div class="flex justify-between items-center">
                        <div class="w-32 ">
                            <SolidButton @click.prevent="openPostModal" :type="'button'" label="Close" :icon="XMarkIcon" :customClass="'text-white bg-gray-500 border-gray-600 hover:bg-gray-400'" ></SolidButton>
                        </div>
                        <div class="w-32 ">
                            <SolidButton :isLoading="form.busy" :type="'submit'" :label="editMode ? 'Update' : 'Submit'" :icon="Square3Stack3DIcon" :customClass="'text-white bg-primary border-primary hover:bg-green-600'" ></SolidButton>
                        </div>
                    </div>
                </form>
            </template>
        </Drawer>
    </Teleport>
</template>

<script setup>
import { ref, computed, reactive, onMounted } from "vue";
import Form from 'vform'
import { chunkArray, slug, emitter } from "@/utilities/functions.js";
import { PlusIcon, MinusIcon, PencilSquareIcon, NewspaperIcon } from '@heroicons/vue/24/outline'
import Drawer from '@/components/parts/Modals/Drawer.vue';
import SolidButton from '@/components/parts/Buttons/SolidButton.vue';
import Select from '@/components/parts/Forms/Select.vue';
import {  XMarkIcon, MagnifyingGlassIcon } from '@heroicons/vue/20/solid';
import ToogleInput from '@/components/parts/Forms/Toogle.vue';
import FloatingInput from '@/components/parts/Forms/FloatingInput.vue';
import Legend from '@/components/parts/Banner/Legend.vue';
import Checkbox from '@/components/parts/Forms/Checkbox.vue';

const form = reactive(new Form({
    id: null,
    title:'',
    categories:[],
    description: '',
    skills: [],
    status:true,
}));

const isCreatePost = ref(false)
const search = ref("");
const categories = ref([])
const skills = ref([])
const jobs = ref([
  {
    id: 1,
    title: "Woocommerce/WordPress NFC Card Landing Page Store",
    description:
      "High-converting WooCommerce landing page for limited edition NFC card. Must integrate WooCommerce checkout.",
    budget: 56000,
    type: "Fixed-price",
    level: "Intermediate",
    requirement: "I am looking for a mix of experience and value",
    opportunity: "Contract-to-hire opportunity",
    attachments: [
      { name: "Don't follow sheep ecom page.pdf", size: "6 MB" },
      { name: "don't follow sheep ecommerce page.png", size: "5.6 MB" },
    ],
    projectType: "Ongoing project",
    questions: [
      "Please send past work",
      "₱40 is max budget for this page, are you aware and can you complete within this budget?",
    ],
    skills: ["WooCommerce", "Web Design", "Web Development"],
    activity: {
      proposals: "Less than 5",
      lastViewed: "1 hour ago",
      interviewing: 1,
      invites: 13,
      unanswered: 11,
    },
  },
  {
    id: 2,
    title: "Software Engineer (ReactJS, Laravel, ElectronJS) – POS System Fix",
    description:
      "Troubleshoot and resolve issues in our POS system built with ReactJS frontend, Laravel backend, and ElectronJS.",
    budget: 40000,
    type: "Fixed-price",
    level: "Expert",
    requirement: "Strong debugging and problem-solving skills required",
    opportunity: "Potential long-term collaboration",
    attachments: [],
    projectType: "One-time project",
    questions: ["Describe a similar POS project you worked on."],
    skills: ["Laravel", "ReactJS", "ElectronJS", "PHP"],
    activity: {
      proposals: "5 to 10",
      lastViewed: "2 hours ago",
      interviewing: 2,
      invites: 8,
      unanswered: 3,
    },
  },
]);

const selectedJob = ref(null);

function openPostModal(){
    isCreatePost.value = !isCreatePost.value
}

const filteredJobs = computed(() => {
  if (!search.value) return jobs.value;
  return jobs.value.filter((job) =>
    job.title.toLowerCase().includes(search.value.toLowerCase())
  );
});

const selectJob = (job) => {
  selectedJob.value = job;
};

async function fetchCategories(){
    await axios.get('/api/maintenance?meta_parent=maintenance-category').then((response) => {
        categories.value = response.data.data;
    }).catch((error) => {

    });
}

async function fetchSkills(){
    await axios.get('/api/maintenance?meta_parent=maintenance-skills').then((response) => {
        skills.value = response.data.data;
    }).catch((error) => {

    });
}

function addCategoryItem(event, item){
    const isChecked = event.target.checked;

    if (isChecked) {
        form.categories.push(item)
    }else{
        const index = form.categories.findIndex(category => category.id === item.id);
        if (index !== -1) {
            form.categories.splice(index, 1);
        }
    }
}

function filterCategories(name){
    let filtered = categories.value.filter(category =>
        category.meta_name.toLowerCase().includes(name.toLowerCase())
      );

    if(name.length === 0){
        fetchCategories();
    }else{
        if(filtered.length > 0){
            categories.value = filtered;
        }else{
            fetchCategories();
        }
    }
}
function removeItem(item) {
    const index = form.categories.findIndex(category => category.id === item.id);
    if (index !== -1) {
        form.categories.splice(index, 1);
    }
}
function isItemChecked(item) {
    return form.categories.some(category => category.id === item.id);
}

function addSkillsItem(event, item){
    const isChecked = event.target.checked;

    if (isChecked) {
        form.skills.push(item)
    }else{
        const index = form.skills.findIndex(category => category.id === item.id);
        if (index !== -1) {
            form.skills.splice(index, 1);
        }
    }
}

function filterSkills(name){
    let filtered = categories.value.filter(skill =>
        skill.meta_name.toLowerCase().includes(name.toLowerCase())
      );

    if(name.length === 0){
        fetchCategories();
    }else{
        if(filtered.length > 0){
            skills.value = filtered;
        }else{
            fetchCategories();
        }
    }
}
function removeSkillsItem(item) {
    const index = form.skills.findIndex(skill => skill.id === item.id);
    if (index !== -1) {
        form.skills.splice(index, 1);
    }
}
function isSkillItemChecked(item) {
    return form.skills.some(skill => skill.id === item.id);
}

onMounted( () => {
 fetchCategories();
 fetchSkills();
});

</script>
  <style scoped>
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
        .job-item:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transform: translateY(-1px);
            transition: all 0.2s ease;
        }
        .skill-tag {
            transition: all 0.2s ease;
        }
        .skill-tag:hover {
            background-color: #e9f5e9;
        }
        .scrollbar-thin {
            scrollbar-width: thin;
            scrollbar-color: #d1d5db #f9fafb;
        }
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background-color: #d1d5db;
            border-radius: 3px;
        }
    </style>
