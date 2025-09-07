<template>
  <div class="flex flex-col  bg-gray-50">


    <Navigation></Navigation>
    <!-- Hero -->
    <section class="relative bg-white py-12 lg:py-20 bg-cover bg-center" style="background-image: url('/images/intro_bg.webp');">
     <div class="absolute inset-0 bg-slate-900 opacity-80 rounded-b-2xl lg:rounded-r-2xl"></div>
      <div class="relative z-10  mx-auto flex flex-col-reverse lg:flex-row items-center px-6 lg:px-60">
        <div class="flex-1 text-center lg:text-left"  data-aos="fade-right" data-aos-delay="500" data-aos-duration="1500">
          <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white ">
            Showcase Your ICT Skills & Monetize Your Passion
          </h1>
          <p class="mt-4 text-lg text-gray-200">
            Learn coding, showcase your ICT services, and grow your opportunities in the digital world.
          </p>
          <div class="mt-6 flex flex-wrap justify-center lg:justify-start gap-3">
            <button class="px-6 py-3 bg-indigo-600 text-white rounded hover:bg-indigo-700">Join Now</button>
            <button class="px-6 py-3 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Learn More</button>
          </div>
        </div>
        <div class="flex-1 my-32  lg:mb-0"  data-aos="fade-left" data-aos-delay="50" data-aos-duration="1500">
          <img :src="sidebanner" alt="Hero Illustration" class="mx-auto lg:ml-auto w-80 lg:w-[400px]" />
        </div>
      </div>
    </section>

    <Categories></Categories>

    <!-- Featured Services -->
    <section class="py-12 bg-white">
      <div class="max-w-7xl mx-auto px-6 lg:px-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Featured Services</h2>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
          <div class="p-6 bg-gray-100 rounded-lg shadow hover:shadow-md">
            <h3 class="font-semibold text-lg">UI/UX Design</h3>
            <p class="text-gray-600 mt-2">Get modern designs for your app & websites.</p>
          </div>
          <div class="p-6 bg-gray-100 rounded-lg shadow hover:shadow-md">
            <h3 class="font-semibold text-lg">Custom Development</h3>
            <p class="text-gray-600 mt-2">Build solutions tailored to your needs.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Why Choose TechKa -->
    <section class="py-12 bg-indigo-600 text-white">
      <div class="max-w-7xl mx-auto px-6 lg:px-16 flex flex-col lg:flex-row items-center">
        <div class="flex-1">
          <h2 class="text-2xl lg:text-3xl font-bold">Why Choose TechKa?</h2>
          <p class="mt-4 text-gray-200">We provide an ecosystem where ICT talents showcase their skills and monetize their passion.</p>
          <div class="mt-6 flex space-x-6">
            <div>
              <p class="text-3xl font-bold">3M+</p>
              <p class="text-sm">Freelancers</p>
            </div>
            <div>
              <p class="text-3xl font-bold">7M+</p>
              <p class="text-sm">Jobs Posted</p>
            </div>
          </div>
        </div>
        <div class="flex-1 mt-8 lg:mt-0">
          <img :src="sidebanner" alt="Why Choose" class="w-72 lg:w-96 mx-auto" />
        </div>
      </div>
    </section>

    <!-- Testimonials -->
    <section class="py-12 bg-gray-50">
      <div class="max-w-7xl mx-auto px-6 lg:px-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Testimonials</h2>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
          <div class="p-6 bg-white rounded-lg shadow">
            <p class="text-gray-600 italic">"TechKaPH helped me land my first freelance project!"</p>
            <p class="mt-4 font-semibold">- John D.</p>
          </div>
          <div class="p-6 bg-white rounded-lg shadow">
            <p class="text-gray-600 italic">"The LMS is structured and easy to follow."</p>
            <p class="mt-4 font-semibold">- Maria S.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-10">
      <div class="max-w-7xl mx-auto px-6 lg:px-16 grid gap-8 lg:grid-cols-3">
        <div>
          <img :src="logo" alt="TechKa" class="h-10 mb-4" />
          <p class="text-sm">Empowering ICT professionals with opportunities to learn, grow, and earn.</p>
        </div>
        <div>
          <h3 class="font-semibold text-white mb-3">Services</h3>
          <ul class="space-y-2 text-sm">
            <li><a href="#" class="hover:text-white">Web Development</a></li>
            <li><a href="#" class="hover:text-white">Design</a></li>
            <li><a href="#" class="hover:text-white">Freelancing</a></li>
          </ul>
        </div>
        <div>
          <h3 class="font-semibold text-white mb-3">Important Links</h3>
          <ul class="space-y-2 text-sm">
            <li><a href="#" class="hover:text-white">Privacy Policy</a></li>
            <li><a href="#" class="hover:text-white">Terms & Conditions</a></li>
            <li><a href="#" class="hover:text-white">Contact Us</a></li>
          </ul>
        </div>
      </div>
      <div class="mt-10 text-center text-xs text-gray-500">
        © 2025 TechKaPH. All Rights Reserved.
      </div>
    </footer>

  </div>
</template>

<script setup>
  import { reactive, ref, onMounted, onUnmounted } from 'vue';
  import Navigation from '@/components/public/sections/Navigation.vue';
  import Categories from '@/components/public/sections/Categories.vue';
  const logo = ref('/images/techka.png')
  const sidebanner = ref('/images/intro.webp')



</script>
