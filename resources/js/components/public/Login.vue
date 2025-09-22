<template>
  <div class="flex flex-col lg:flex-row min-h-screen bg-white pl-0 pt-5 pb-5">
    <div class="hidden lg:flex relative  items-center justify-center w-full lg:w-2/3 bg-cover bg-center rounded-b-2xl lg:rounded-r-2xl lg:rounded-b-none" style="background-image: url('/images/intro_bg.webp');" >
      <div class="absolute inset-0 bg-slate-900 opacity-80 rounded-b-2xl lg:rounded-r-2xl"></div>
      <div class="relative z-10 flex flex-col lg:flex-row items-center text-center lg:text-left p-6 lg:p-12 space-y-6 lg:space-y-0 lg:space-x-10">
        <div class="flex-1"  data-aos="fade-right" data-aos-delay="500" data-aos-duration="1500">
          <h2 class="text-3xl md:text-5xl font-bold text-white leading-tight drop-shadow-md">
            Empowering Your Future in <span class="text-yellow-400">ICT & Coding</span>
          </h2>
          <p class="mt-4 text-base md:text-lg text-gray-200 max-w-xl">
            Unlock your potential with our innovative IT services and Learning Management System.
            Learn to code, build projects, and transform your passion into a career.
          </p>
        </div>
        <div class="flex-shrink-0"  data-aos="fade-left" data-aos-delay="500" data-aos-duration="1500">
          <img :src="sidebanner" alt="IT Services" class="w-56 md:w-72 lg:w-80 drop-shadow-lg" />
        </div>
      </div>
    </div>

    <div class="w-full lg:w-[750px] bg-white px-6 sm:px-10 py-10 flex items-center justify-center">
      <div class="w-full max-w-md">
        <div class="block mx-auto text-center mb-10">
          <img class="h-20 md:h-24 mb-2 mx-auto" :src="logo" alt="TechKa" />
          <h1 class="text-yellow-400 font-bold text-2xl md:text-3xl shadowed-text">
            Showcase Your ICT Skills & Monetize Your Passion
          </h1>
        </div>

        <form
          @submit.prevent="submitForm"
          @keydown="form.onKeydown($event)"
          class="space-y-4"
        >
            <div v-if="!isRegister" data-aos="fade-in" data-aos-duration="1000">
                <label for="name" class="block text-sm font-medium text-gray-700" >Name</label
                >
                <div class="mt-1 flex gap-2">
                    <div class="flex-1">
                        <input v-model="form.first_name" id="first_name" name="first_name" placeholder="First Name" type="text" class="w-full rounded border px-3 py-2 text-gray-700 text-sm focus:border-indigo-400 focus:outline-none" :class="[form.errors.has('first_name') ? 'border-red-500' : 'border-gray-300']" />
                        <span class="text-red-500 text-xs mt-1 block"  v-if="form.errors.has('first_name')" >{{ form.errors.get('first_name') }}</span >
                    </div>
                    <div class="flex-1">
                        <input v-model="form.last_name" id="last_name" name="last_name" placeholder="Last Name" type="text" class="w-full rounded border px-3 py-2 text-gray-700 text-sm focus:border-indigo-400 focus:outline-none" :class="[form.errors.has('last_name') ? 'border-red-500' : 'border-gray-300']" />
                        <span class="text-red-500 text-xs mt-1 block" v-if="form.errors.has('last_name')" >{{ form.errors.get('last_name') }}</span >
                    </div>

                </div>
          </div>
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700" >Email Address</label
            >
            <div class="mt-1">
              <input v-model="form.email" id="email" name="email" type="email" class="w-full rounded border px-3 py-2 text-gray-700 text-sm focus:border-indigo-400 focus:outline-none" :class="[form.errors.has('email') ? 'border-red-500' : 'border-gray-300']" />
              <span class="text-red-500 text-xs mt-1 block" v-if="form.errors.has('email')" >{{ form.errors.get('email') }}</span >
            </div>
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700" >Password</label >
            <div class="mt-1">
              <input v-model="form.password" id="password" name="password" type="password" class="w-full rounded border px-3 py-2 text-gray-700 text-sm focus:border-indigo-400 focus:outline-none" :class="[form.errors.has('password') ? 'border-red-500' : 'border-gray-300']" />
              <span class="text-red-500 text-xs mt-1 block" v-if="form.errors.has('password')" >{{ form.errors.get('password') }}</span >
            </div>
          </div>


          <div class="flex items-center justify-between" data-aos="fade-in" data-aos-duration="1000" v-if="isRegister">
            <label class="flex items-center space-x-2">
              <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-primary border-gray-300 rounded" />
              <span class="text-sm text-gray-600">Remember me</span>
            </label>
            <a href="#" class="text-sm text-indigo-600 hover:underline" >Forgot password?</a >
          </div>


          <div class="mb-5">
            <SolidButton :type="'submit'" :isLoading="form.busy" :label="isRegister ? 'Login' : ' Register'" :icon="isRegister ? LockClosedIcon: UserPlusIcon" class="w-full" />
          </div>

        </form>

        <div class="mt-10">
          <div class="flex items-center">
            <div class="flex-grow border-t border-gray-300"></div>
            <span class="mx-2 text-gray-500 text-xs">By logging in, you agree to our</span>
            <div class="flex-grow border-t border-gray-300"></div>
          </div>
          <div class="mt-4 flex gap-2">
            <a href="#" class="flex-1 text-center py-2 border rounded text-sm text-gray-700 hover:bg-indigo-50" >Privacy Policy</a >
            <a href="#" class="flex-1 text-center py-2 border rounded text-sm text-gray-700 hover:bg-indigo-50" >Terms & Conditions</a >
          </div>
        </div>
         <div class="flex items-center justify-end pt-5">
            <a href="#" @click.prevent="isRegister = !isRegister" class="text-sm text-primary hover:underline" > {{ isRegister ? "Don't have an account? Register here." : "Already have an account? Login here." }} </a >
          </div>
      </div>
    </div>
  </div>
</template>


  <script setup>
  import { reactive, ref, onMounted } from 'vue';
  import Form from 'vform'
  import { useRoute } from 'vue-router';
  import {siteSettings} from '@/store/utils';
  import {userAuthStore} from '@/store/auth';
  import { successMessage, errorMessage } from "@/utilities/toast.js";
  import SolidButton from '@/components/parts/Buttons/SolidButton.vue';
  import { LockClosedIcon, XMarkIcon, UserPlusIcon } from '@heroicons/vue/24/outline';

  const logo = ref('/images/techka.png')
  const sidebanner = ref('/images/intro.webp')
  const route = useRoute();

    const form = reactive(new Form({
        first_name: '',
        last_name: '',
        email: '',
        password: '',
        class:'',
    }));

    const processing = ref(false)
    const url = ref('')
    const displayPreview = ref(true)
    const isRegister = ref(true)

    function preview(newURL){
        displayPreview.value = !displayPreview.value
        url.value = newURL;
    }

    function closePreview(){
        displayPreview.value = !displayPreview.value
        url.value = "";
    }

    function submitForm(){
    if (isRegister.value) {
        axios.get('/sanctum/csrf-cookie').then(response => {
            form.post("/api/login").then((data) => {

                if(data.data.success){
                userAuthStore().authenticated = true
                userAuthStore().user = data.data.data
                userAuthStore().permissions = data.data.data.permissions
                userAuthStore().redirect();
                }else{
                    errorMessage("Oops!", data.data.message, "top-right");
                }
            })
            .catch(({ response }) => {
                errorMessage("Oops!", "These credentials do not match our records.", "top-right");
            })
            .finally(() => {
            });
        });
    }else{
         form.post("/api/register").then((data) => {

                if(data.data.success){
                    userAuthStore().authenticated = true
                    userAuthStore().user = data.data.data
                    userAuthStore().redirect();
                }else{
                    errorMessage("Oops!", data.data.message, "top-right");
                }
            })
            .catch(({ response }) => {
                errorMessage("Oops!", "These credentials do not match our records.", "top-right");
            })
            .finally(() => {
            });
    }

    }


    onMounted(()=>{
       const classType = route.query.class;
       form.class = classType

    })
  </script>




<style>

.shadowed-text{
  /* text-shadow: -webkit-text-stroke: 1px #F8F8F8; */
  text-shadow: 0px 1px 1px #23430C;
}

</style>
