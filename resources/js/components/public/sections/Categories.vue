<template>
    <section class="py-12 bg-gray-50">
      <div class="max-w-7xl mx-auto px-6 lg:px-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Our Popular Categories</h2>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
          <div class="p-6 bg-white rounded-lg shadow hover:shadow-md"  data-aos="fade-up" data-aos-delay="50" data-aos-duration="1500">
            <img class="w-auto h-24 mx-auto" :src="web" alt="">
            <h3 class="font-semibold text-lg text-center">Web Development</h3>
            <p class="text-gray-600 mt-2 text-center">Learn to build modern web applications.</p>
          </div>
          <div class="p-6 bg-white rounded-lg shadow hover:shadow-md"  data-aos="fade-up" data-aos-delay="200" data-aos-duration="1500">
            <img class="w-auto h-24 mx-auto" :src="programming" alt="">
            <h3 class="font-semibold text-lg text-center">Programming</h3>
            <p class="text-gray-600 mt-2 text-center">Sharpen your coding skills in various languages.</p>
          </div>
          <div class="p-6 bg-white rounded-lg shadow hover:shadow-md"  data-aos="fade-up" data-aos-delay="450" data-aos-duration="1500">
            <img class="w-auto h-24 mx-auto" :src="mobile" alt="">
            <h3 class="font-semibold text-lg text-center">Mobile Development</h3>
            <p class="text-gray-600 mt-2 text-center">Sharpen your coding skills in various languages.</p>
          </div>
          <div class="p-6 bg-white rounded-lg shadow hover:shadow-md"  data-aos="fade-up" data-aos-delay="50" data-aos-duration="1500">
            <img class="w-auto h-24 mx-auto" :src="freelancing" alt="">
            <h3 class="font-semibold text-lg text-center">Freelancing</h3>
            <p class="text-gray-600 mt-2 text-center">Grow your career in ICT services.</p>
          </div>
        </div>
      </div>
    </section>

</template>

<script setup>

import { reactive, ref, onMounted, onUnmounted } from 'vue';
const web = ref('/images/category--2024-07-10-12-00-17-4763.webp')
const programming = ref('/images/category--2024-07-10-11-58-38-9116.webp')
const mobile = ref('/images/mobile.png')
const freelancing = ref('/images/category--2024-07-10-11-59-39-3517.webp')


</script>
