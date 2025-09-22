<template>
  <div class="bg-gray-50 min-h-screen p-6">
    <div class="max-w-7xl mx-auto flex gap-6">
      <!-- Left Sidebar -->
      <aside class="w-1/3 bg-white shadow rounded-xl p-5 space-y-6">
        <!-- Profile Header -->
        <div class="flex items-center gap-3 relative ">
          <img :src="form.avatar ? form.avatar : avatar" alt="Profile" class="w-24 h-24 rounded-full border" />
          <div>
            <h2 class="font-bold text-lg text-primary">{{ form.first_name }} {{ form.last_name }}</h2>
            <p class="text-sm text-gray-500 uppercase">{{ cityName }}, {{ provinceName }}</p>
          </div>
          <div @click.prevent="showPrimaryDetailsModal" class="rounded-full border-2 border-primary absolute right-0 top-0 hover:bg-gray-100 cursor-pointer">
            <PencilIcon class="p-1 h-6 w-6 text-primary"></PencilIcon>
          </div>
        </div>

        <!-- Sidebar Sections -->
        <div>
          <h3 class="font-semibold text-sm text-primary mb-2">Website</h3>
          <p class="text-gray-600 text-sm mb-2" >🌐 https:://techkaph.com</p>
        </div>
        <div>
          <h3 class="font-semibold text-sm text-primary mb-2">Industry</h3>
          <p class="text-gray-600 text-sm mb-2" >🏭 Computer Software & Networking</p>
        </div>
        <div>
          <h3 class="font-semibold text-sm text-primary mb-2">Company Size</h3>
          <p class="text-gray-600 text-sm mb-2" >🧑‍🤝‍🧑 51-100</p>
        </div>

        <div>
          <h3 class="font-semibold text-sm text-primary mb-2">Address</h3>
          <div v-for="item in form.education" class="mb-3">
                <p class="text-gray-600 text-sm">📍 Jose Catolico Sr. Ave., General Santos City (Dadiangas), 9500 South Cotabato</p>

          </div>

        </div>
      </aside>

      <!-- Right Content -->
      <main class="flex-1 bg-white shadow rounded-xl p-6 space-y-6">
        <!-- Title + Rate -->
        <div class="relative mb-2 pr-10" >
            <div class="flex justify-between items-center">
                <!-- <h1 class="text-sm font-bold">Company Name</h1> -->
                <!-- <p class="text-lg font-semibold text-green-600">₱150.00/hr</p> -->
            </div>

            <!-- About -->
            <div class=" mx-auto space-y-10">
                <!-- Header -->
                <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    About <span class="text-blue-600">TechKa Solutions</span>
                </h1>
                <p class="text-gray-600 text-sm">
                    Your trusted partner in Programming & Networking IT Services
                </p>
                </div>

                <!-- Intro -->
                <section>
                <p class="text-gray-700 leading-relaxed">
                    At <span class="font-semibold">TechNova Solutions</span>, we are a full-service IT company
                    dedicated to helping businesses and organizations thrive in today’s fast-paced digital world.
                    With a strong foundation in both programming and networking, we provide end-to-end technology
                    services designed to empower enterprises, streamline operations, and drive sustainable growth.
                </p>
                </section>

                <!-- Programming Services -->
                <section>
                <h2 class="text-sm font-semibold text-gray-900 mb-3">💻 Programming Services</h2>
                <p class="text-gray-700 leading-relaxed">
                    Our programming services cover the entire software development lifecycle — from ideation
                    and architecture design to coding, testing, deployment, and ongoing support. We specialize
                    in building custom web applications, enterprise software, mobile apps, and cloud-based
                    platforms that are secure, scalable, and user-friendly.
                </p>
                <ul class="list-disc ml-6 mt-3 text-gray-700 space-y-1">
                    <li>Custom web & mobile applications</li>
                    <li>Enterprise software development</li>
                    <li>Cloud-based platforms</li>
                    <li>E-commerce websites & API integrations</li>
                </ul>
                </section>

                <!-- Networking Services -->
                <section>
                <h2 class="text-sm font-semibold text-gray-900 mb-3">🌐 Networking Services</h2>
                <p class="text-gray-700 leading-relaxed">
                    On the networking side, we provide robust infrastructure solutions that form the backbone
                    of reliable digital ecosystems. Our expertise includes setting up secure networks,
                    configuring firewalls, implementing cloud and on-premises servers, managing VPNs,
                    and ensuring network optimization for speed and reliability.
                </p>
                <p class="text-gray-700 mt-2">
                    We place a strong emphasis on <span class="font-semibold">cybersecurity</span>, safeguarding
                    clients against evolving threats with advanced monitoring, data encryption, and intrusion
                    prevention strategies.
                </p>
                </section>

                <!-- Approach -->
                <section>
                <h2 class="text-sm font-semibold text-gray-900 mb-3">🚀 Our Approach</h2>
                <p class="text-gray-700 leading-relaxed">
                    What sets us apart is our holistic approach — we don’t just provide standalone services,
                    but integrate programming and networking expertise to deliver seamless, interconnected systems.
                    From optimized infrastructures to tailored software solutions, we ensure our technology
                    works as one powerful ecosystem.
                </p>
                </section>

                <!-- Mission -->
                <section>
                <h2 class="text-sm font-semibold text-gray-900 mb-3">🎯 Our Mission</h2>
                <p class="text-gray-700 leading-relaxed">
                    Our mission is to be more than just a service provider; we strive to be a trusted
                    <span class="font-semibold">technology partner</span> for businesses across industries.
                    Whether it’s helping startups establish their digital presence or assisting enterprises
                    in modernizing legacy systems, we deliver innovative solutions that improve productivity,
                    reduce costs, and open doors to new opportunities.
                </p>
                </section>

                <!-- Closing -->
                <section class="text-center">
                <p class="text-gray-800 font-medium leading-relaxed">
                    At <span class="text-blue-600 font-semibold">TechNova Solutions</span>, we combine
                    technical excellence, customer-focused strategies, and continuous innovation to keep
                    our clients ahead in a world where technology never stops evolving.
                </p>
                </section>
            </div>
            <div @click.prevent="showSkillSummaryModal" class="rounded-full border-2 border-primary absolute right-0 top-0 hover:bg-gray-100 cursor-pointer">
                <PencilIcon class="p-1 h-6 w-6 text-primary"></PencilIcon>
            </div>
        </div>


        <!-- Skills -->
        <section>
        <div class="flex justify-between mb-3">
            <h2 class="text-lg font-semibold text-primary">Our Services</h2>
            <div @click.prevent="showPrimaryDetailsModal" class="rounded-full border-2 border-primary hover:bg-gray-100 cursor-pointer">
                <PencilIcon class="p-1 h-6 w-6 text-primary"></PencilIcon>
            </div>
        </div>
          <div class="flex flex-wrap gap-2">
            <span class="px-3 py-1 bg-gray-100 rounded-full text-sm">Application Development & Maintenance</span>
            <span class="px-3 py-1 bg-gray-100 rounded-full text-sm">Embedded System</span>
            <span class="px-3 py-1 bg-gray-100 rounded-full text-sm">Quality Assurance & Testing</span>
            <span class="px-3 py-1 bg-gray-100 rounded-full text-sm">Legacy Migration</span>
            <span class="px-3 py-1 bg-gray-100 rounded-full text-sm">Package Implementation</span>
          </div>
        </section>



        <section>
          <div class="flex justify-between mb-3">
            <h2 class="text-lg font-semibold text-primary">Reviews</h2>

          </div>
          <div class="border-l-4 border-green-500 pl-4 mb-4">
            <h3 class="font-semibold">Good environment, mix of fun and knowledge</h3>
            <div class="flex items-center space-x-1">
                <button v-for="star in 5" :key="star" @click="rating = star" class="focus:outline-none" >
                <svg
                    class="w-4 h-4"
                    :class="rating >= star ? 'text-yellow-400' : 'text-yellow-300'"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                >
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                </button>
            </div>
            <p class="text-xs text-gray-500">System analyst</p>

            <p class="text-sm text-gray-600">
              The flexible schedule gives good benefit
            </p>
          </div>
          <div class="border-l-4 border-green-500 pl-4">
            <h3 class="font-semibold">Recommended specially for new hires and experienced alike</h3>
            <div class="flex items-center space-x-1">
                <button v-for="star in 5" :key="star" @click="rating = star" class="focus:outline-none" >
                <svg
                    class="w-4 h-4"
                    :class="rating >= star ? 'text-yellow-400' : 'text-yellow-300'"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                >
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                </button>
            </div>
            <p class="text-xs text-gray-500">Software Development Engineer</p>
            <p class="text-sm text-gray-600">
              The good things, Very Good Working Environment, Pleasant People and Good Work Arrangements
              The challengesNew Projects, Responsibilities and Opportunities, which is a good thing
            </p>
          </div>
        </section>

      </main>
    </div>
  </div>
<Teleport to="body">
        <Drawer :id="'user-form'" :title="'Update Profile'" :isShowing="editPrimaryDetails" customClass="w-[650px]">
            <template #content>
                <form @submit.prevent="updatePrimaryDetails()">
                    <div class="p-3  rounded-md mb-2">
                        <div class="flex items-center justify-center">
                            <div class="flex-initial w-[200px]" for="file-upload">
                                <label for="file-upload" class=" cursor-pointer">
                                    <img class="block mx-auto w-32 h-32 rounded-full border-2 border-stroke-gray" :src="form.avatar || avatar" alt="">
                                </label>
                                <input id="file-upload" name="file-upload" type="file" class="sr-only" @change="handleFileChange($event)" accept=".jpeg,.jpg,.png" />
                            </div>

                            <div class="flex-1">
                                <div class="w-full mb-2">
                                    <FloatingInput v-model="form.first_name" label="First Name" id="first-name" placeholder="" :error="form.errors.has('first_name')" :errorMsg="form.errors.get('first_name')"></FloatingInput>
                                </div>
                                <div class="w-full mb-2">
                                    <FloatingInput v-model="form.last_name" label="Last Name" id="last-name" placeholder="" :error="form.errors.has('last_name')" :errorMsg="form.errors.get('last_name')"></FloatingInput>
                                </div>
                                <div class="w-full mb-2">
                                    <FloatingInput v-model="form.middle_name" label="Middle Name/Middle Initial" id="middle-name" placeholder=""></FloatingInput>
                                </div>
                            </div>
                        </div>
                        <Legend label="Contact Details" :labelCss="'text-xs pr-4 font-medium text-aside'"></Legend>
                        <div class="flex items-start justify-center mb-4">
                            <div class="w-full mr-1">
                                <FloatingInput v-model="form.mobile" label="Mobile Number" id="mobile-number" placeholder="" :error="form.errors.has('mobile')" :errorMsg="form.errors.get('mobile')"></FloatingInput>
                            </div>
                            <div class="w-full ml-1">
                                <FloatingInput v-model="form.email" label="Email Address" id="email" placeholder="" :error="form.errors.has('email')" :errorMsg="form.errors.get('email')"></FloatingInput>
                            </div>
                        </div>
                         <Legend label="Address" :labelCss="'text-xs pr-4 font-medium text-aside'"></Legend>

                        <div class="flex items-start justify-center mb-4">
                            <div class="w-full mr-1">
                                <FloatingInput v-model="form.address" label="House No. | Street | Village"
                                    :error="form.errors.has('address')" :errorMsg="form.errors.get('address')">
                                </FloatingInput>
                            </div>
                        </div>
                        <div class="flex items-start justify-center mb-4">
                            <div class="w-full mr-1">
                                <FloatingInput id="region" type="select" v-model="form.region" label="Region"
                                    :error="form.errors.has('region')" :errorMsg="form.errors.get('region')"
                                    :options="regions" @change="fetchProvinces($event)"></FloatingInput>
                            </div>
                            <div class="w-full ml-1">
                                <FloatingInput id="province" type="select" v-model="form.province" label="Province"
                                    :error="form.errors.has('province')" :errorMsg="form.errors.get('province')"
                                    :options="provinces" @change="fetchCities($event)"></FloatingInput>
                            </div>
                        </div>
                        <div class="flex items-start justify-center mb-4">
                            <div class="w-full mr-1">
                                <FloatingInput type="select" v-model="form.city" label="City/Town"
                                    :error="form.errors.has('city')" :errorMsg="form.errors.get('city')"
                                    :options="cities" @change="fetchBarangay($event)"></FloatingInput>
                            </div>
                            <div class="w-full ml-1">
                                <FloatingInput type="select" v-model="form.barangay" label="Barangay"
                                    :error="form.errors.has('barangay')" :errorMsg="form.errors.get('barangay')"
                                    :options="barangays"></FloatingInput>
                            </div>
                        </div>

                        <Legend label="Education" :labelCss="'text-xs pr-4 font-medium text-aside'" :showButton="true" :icon="PlusIcon" @click.prevent="addEducation" :buttonClass="'border-primary hover:bg-primary py-1 px-1.5'"></Legend>
                        <div v-for="(item, index) in form.education" :key="index" class="border-b border-primary mb-2">
                            <div class="flex items-start justify-center mb-4 relative" >
                                <div class="w-full mr-1">
                                    <FloatingInput v-model="item.school_name" label="School Name" id="school_name" placeholder="" :error="form.errors.has('school_name')" :errorMsg="form.errors.get('school_name')"></FloatingInput>
                                </div>
                                <div class="w-full ml-1 flex gap-2">
                                    <FloatingInput v-model="item.from_year" label="From Year" id="from_year" placeholder="2001" :error="form.errors.has('from_year')" :errorMsg="form.errors.get('from_year')"></FloatingInput>
                                    <FloatingInput v-model="item.to_year" label="To Year" id="to_year" placeholder="2007" :error="form.errors.has('to_year')" :errorMsg="form.errors.get('to_year')"></FloatingInput>
                                </div>
                                <div class="w-20">
                                    <button v-if="form.education.length > 1" @click.prevent="removeEducation(index)" class="absolute right-0 top-0 text-red-500 hover:text-red-700 border rounded border-red-600">
                                        <XMarkIcon class="h-5 w-5" />
                                    </button>
                                </div>
                            </div>
                            <div class="flex items-start justify-center mb-4" >
                                <div class="w-full mr-1">
                                    <FloatingInput v-model="item.degree" label="Degree(Optional)" id="degree" placeholder="" :error="form.errors.has('degree')" :errorMsg="form.errors.get('degree')"></FloatingInput>
                                </div>
                                <div class="w-full ml-1">
                                    <FloatingInput v-model="item.area_study" label="Area of Study (Optional)" id="area_study" placeholder="" :error="form.errors.has('area_study')" :errorMsg="form.errors.get('area_study')"></FloatingInput>
                                </div>
                            </div>
                        </div>
                        <Legend label="Language" :labelCss="'text-xs pr-4 font-medium text-aside'" :showButton="true" :icon="PlusIcon" @click.prevent="addLanguage" :buttonClass="'border-primary hover:bg-primary py-1 px-1.5'"></Legend>
                        <div v-for="(item, index) in form.languages" :key="index" class="border-b border-primary mb-4">
                            <div class="flex items-start justify-center mb-4 relative" >
                                <div class="w-full mr-1">
                                    <FloatingInput v-model="item.language" label="Language" id="language" placeholder="" :error="form.errors.has('language')" :errorMsg="form.errors.get('language')"></FloatingInput>
                                </div>
                                <div class="w-full ml-1">
                                    <FloatingInput v-model="item.proficiency_level" :type="'select'" :options="proficiencyLevels" label="Proficiency Level" id="proficiency_level" placeholder="" :error="form.errors.has('proficiency_level')" :errorMsg="form.errors.get('proficiency_level')"></FloatingInput>
                                </div>
                                <div class="w-20">
                                    <button v-if="form.languages.length > 1" @click.prevent="removeLanguages(index)" class="absolute right-0 top-0 text-red-500 hover:text-red-700 border rounded border-red-600">
                                        <XMarkIcon class="h-5 w-5" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-5">
                    <div class="flex justify-between items-center">
                        <div class="w-32 ">
                            <SolidButton @click="showPrimaryDetailsModal" :type="'button'" label="Close" :icon="XMarkIcon" :customClass="'text-white bg-gray-500 border-gray-600 hover:bg-gray-400'" ></SolidButton>
                        </div>
                        <div class="w-32 ">
                            <SolidButton :isLoading="form.busy" :type="'submit'" :label="'Update' " :icon="Square3Stack3DIcon" :customClass="'text-white bg-primary border-primary hover:bg-green-600'" ></SolidButton>
                        </div>
                    </div>
                </form>
            </template>
        </Drawer>
        <Drawer :id="'user-form'" :title="'Update Profile Overview'" :isShowing="editSkillsSummary" customClass="w-[650px]">
            <template #content>
                <form @submit.prevent="updatePrimaryDetails()">
                    <div class="p-3  rounded-md mb-2">
                        <Legend label="Profile overview" :labelCss="'text-xs pr-4 font-medium text-aside'"></Legend>
                        <p class="text-xs mb-2 text-gray-500">Enter a single sentence description of your professional skills/experience (e.g. Versatile Full-Stack Developer with 5+ Years of Experience) </p>
                        <div class="flex items-start justify-center mb-4">
                            <FloatingInput v-model="formOverview.title" label="Title" id="mobile-number" placeholder="" :error="formOverview.errors.has('title')" :errorMsg="formOverview.errors.get('title')"></FloatingInput>
                        </div>
                        <Legend label="Salary Expectation" :labelCss="'text-xs pr-4 font-medium text-aside'"></Legend>
                        <div class="flex items-start justify-center mb-4">
                            <div class="w-full mr-1">
                                <FloatingInput v-model="formOverview.rate" label="Rate" id="rate" placeholder="" :error="formOverview.errors.has('rate')" :errorMsg="formOverview.errors.get('rate')"></FloatingInput>
                            </div>
                            <div class="w-full ml-1">
                                <FloatingInput v-model="formOverview.frequency" type="select" :options="hireFrequency" label="Duration" id="frequency" placeholder="" :error="formOverview.errors.has('frequency')" :errorMsg="formOverview.errors.get('frequency')"></FloatingInput>
                            </div>
                        </div>
                        <Legend label="Overview Summary" :labelCss="'text-xs pr-4 font-medium text-aside'"></Legend>
                        <p class="text-xs mb-2 text-gray-500">Show clients your skills, experience, and achievements by highlighting your strengths, key projects, and education in a clear and concise way.</p>

                        <div class="flex items-start justify-center mb-4">
                            <div class="w-full mr-1">
                                <FloatingInput v-model="form.address" type="textarea" :rows="10" label="" :error="form.errors.has('address')" :errorMsg="form.errors.get('address')"> </FloatingInput>
                            </div>
                        </div>

                    </div>
                    <hr class="my-5">
                    <div class="flex justify-between items-center">
                        <div class="w-32 ">
                            <SolidButton @click="showSkillSummaryModal" :type="'button'" label="Close" :icon="XMarkIcon" :customClass="'text-white bg-gray-500 border-gray-600 hover:bg-gray-400'" ></SolidButton>
                        </div>
                        <div class="w-32 ">
                            <SolidButton :isLoading="form.busy" :type="'submit'" :label="'Update' " :icon="Square3Stack3DIcon" :customClass="'text-white bg-primary border-primary hover:bg-green-600'" ></SolidButton>
                        </div>
                    </div>
                </form>
            </template>
        </Drawer>
    </Teleport>
</template>

<script setup>
import { onMounted, reactive, ref, watch, computed, provide, inject, onUpdated, nextTick   } from "vue";
import Form from 'vform'
import { UserIcon, BuildingOffice2Icon, PencilIcon, UsersIcon, BuildingOfficeIcon, ListBulletIcon, Cog8ToothIcon, XMarkIcon, PlusIcon, } from "@heroicons/vue/24/outline";
import Drawer from '@/components/parts/Modals/Drawer.vue';
import SolidButton from '@/components/parts/Buttons/SolidButton.vue';
import Select from '@/components/parts/Forms/Select.vue';
import FloatingInput from '@/components/parts/Forms/FloatingInput.vue';
import Legend from '@/components/parts/Banner/Legend.vue';
import { successMessage, errorMessage } from "@/utilities/toast.js";
import {userAuthStore} from '@/store/auth';

const avatar = ref('/images/login-bg-image-2025-03-21-10-27-45-7219.png')
const sample1 = ref('/images/sample1.jpg')
const sample2 = ref('/images/sample2.jpg')
const certificate1 = ref('/images/certificate1.jpg')
const certificate2 = ref('/images/certificate2.jpg')

const editPrimaryDetails = ref(false)
const editSkillsSummary = ref(false)
const regions = ref([])
const provinces = ref([])
const cities = ref([])
const barangays = ref([])
const cityName = ref('')
const provinceName = ref('')

const proficiencyLevels = ref([
    {value: 'Basic', label: 'Basic'},
    {value: 'Conversational', label: 'Conversational'},
    {value: 'Fluent', label: 'Fluent'},
    {value: 'Native or Bilingual', label: 'Native or Bilingual'},
])

const hireFrequency = ref([
    {value: 'Hourly', label: 'Hourly'},
    {value: 'Monthly', label: 'Monthly'},
    {value: 'Annual', label: 'Annual'},
])

const form = reactive(new Form({
    id: null,
    avatar:'',
    first_name:'',
    last_name:'',
    middle_name: '',
    email:'',
    mobile:'',
    status:true,
    address: '',
    region: '',
    province: '',
    city: '',
    barangay: '',
    education: [{
        school_name : '',
        from_year : '',
        to_year : '',
        degree : '',
        area_study: '',
    }],
    languages: [{
        language: '',
        proficiency_level: '',
    }],
}));

const formOverview = reactive(new Form({
    id: null,
    title:'',
    rate:0,
    frequency:'',
    summary: '',
}));

function addEducation() {
  form.education.push({
    school_name : '',
    from_year : '',
    to_year : '',
    degree : '',
    area_study: '',
  })
}
function addLanguage(){
    form.languages.push({
        language: '',
        proficiency_level: '',
    })
}

function removeEducation(index){
    if (form.education.length > 1) {
        form.education.splice(index, 1);
    }
}
function removeLanguages(index){
    if (form.languages.length > 1) {
        form.languages.splice(index, 1);
    }
}

function fetchUserDetails(){
   var userID = userAuthStore().user.user.id;

   axios.get('/api/fetch-user?id='+ userID).then((response) => {
        form.fill(response.data.data);

        form.region = response.data.data.region.region_code
        form.province = response.data.data.province.province_code
        form.city = response.data.data.city.city_code
        form.barangay = response.data.data.barangay.id
        form.avatar = '/logo/100x100/' + response.data.data.avatar
        cityName.value = response.data.data.city.city
        provinceName.value = response.data.data.province.province

        if (response.data.data.educations && response.data.data.educations.length > 0) {
            form.education = response.data.data.educations;
        } else {
            form.education = [{
                school_name: '',
                from_year: '',
                to_year: '',
                degree: '',
                area_study: '',
            }];
        }

        if (response.data.data.languages && response.data.data.languages.length > 0) {
            form.languages = response.data.data.languages;
        } else {
            form.languages = [{
                language: '',
                proficiency_level: '',
            }];
        }

         setTimeout(async () => {
            await setProvinces(response.data.data.region.region_code, response.data.data.province.province_code);
            await setCities(response.data.data.province.province_code, response.data.data.city.city_code);
            await setBarangay(response.data.data.city.city_code, response.data.data.barangay.id);
        }, 300);
   })

}

function updatePrimaryDetails(){
    form.post('/api/update-primary-details').then((response) => {
        successMessage('Success!', 'Profile details has been updated successfully.', "top-right");
    }).catch((error) => {
         errorMessage("Oops!", "Something went wrong in updating profile details.", "top-right");
    })
}

function handleFileChange(event) {
    const file = event.target.files[0];

    if (file) {

        const maxSize = 3 * 1024 * 1024;

        if (file.size > maxSize) {
            errorMessage("Oops!", "Image size exceeds the limit of 3MB.", "top-right");
            return;
        }

        const reader = new FileReader();
        reader.onload = (e) => {
            form.avatar = e.target.result;
            console.log(e.target.result);
        };
        reader.readAsDataURL(file);
    }
}

function showPrimaryDetailsModal(){
    editPrimaryDetails.value = !editPrimaryDetails.value
}
function showSkillSummaryModal(){
    editSkillsSummary.value = !editSkillsSummary.value
}

async function setProvinces(regionID, provinceID) {
    try {
        const response = await axios.get('/api/fetch-province?region=' + regionID);
        provinces.value = response.data.data;
        form.province = provinceID
    } catch (error) {
        errorMessage("Oops!", "Something went wrong when fetching provinces.", "top-right");
    }
}

async function setCities(provinceID, cityID) {
    try {
        const response = await axios.get('/api/fetch-cities?province=' + provinceID);
        cities.value = response.data.data;
        form.city = cityID
    } catch (error) {
        errorMessage("Oops!", "Something went wrong when fetching cities.", "top-right");
    }
}

async function setBarangay(cityID, barangayID) {
    try {
        const response = await axios.get('/api/fetch-barangays?city=' + cityID);
        barangays.value = response.data.data;
        form.barangay = barangayID
    } catch (error) {
        errorMessage("Oops!", "Something went wrong when fetching barangays.", "top-right");
    }
}

async function fetchBarangay(event) {
    let cityID = event
    try {
        const response = await axios.get('/api/fetch-barangays?city=' + cityID);
        barangays.value = response.data.data;
    } catch (error) {
        errorMessage("Oops!", "Something went wrong when fetching barangays.", "top-right");
    }
}

async function fetchCities(event) {
    let provinceID = event
    try {
        const response = await axios.get('/api/fetch-cities?province=' + provinceID);
        cities.value = response.data.data;
    } catch (error) {
        errorMessage("Oops!", "Something went wrong when fetching cities.", "top-right");
    }
}

async function fetchProvinces(event) {

    let regionID = event
    try {
        const response = await axios.get('/api/fetch-province?region=' + regionID);
        provinces.value = response.data.data;
    } catch (error) {
        errorMessage("Oops!", "Something went wrong when fetching provinces.", "top-right");
    }
}

async function getRegions() {
    try {
        const response = await axios.get('/api/fetch-regions');
        regions.value = response.data.data;
    } catch (error) {
        errorMessage("Oops!", "Something went wrong when fetching regions.", "top-right");
    }
}

onMounted(async () => {
    await getRegions();
    await fetchUserDetails();
});

</script>
