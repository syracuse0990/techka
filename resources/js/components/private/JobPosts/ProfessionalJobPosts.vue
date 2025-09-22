<template>
 <div class="flex h-screen">
        <!-- Left Column: Job List -->
        <div class="w-1/3 bg-white border-r border-gray-200 flex flex-col shadow-sm">
            <!-- Header with Search -->
            <div class="p-4 border-b border-gray-200 bg-white">
                <h1 class="text-xl font-semibold text-upwork-dark mb-3">Find Jobs</h1>
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
</template>

<script setup>
import { ref, computed } from "vue";

const search = ref("");

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

const filteredJobs = computed(() => {
  if (!search.value) return jobs.value;
  return jobs.value.filter((job) =>
    job.title.toLowerCase().includes(search.value.toLowerCase())
  );
});

const selectJob = (job) => {
  selectedJob.value = job;
};
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
