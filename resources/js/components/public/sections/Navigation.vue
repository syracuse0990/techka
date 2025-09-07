<template>
  <header :class="[ 'fixed top-0 left-0 w-full flex justify-between items-center px-6 lg:px-60 py-4 z-50 transition-all duration-300', isScrolled ? 'bg-white shadow-md animate-slideDown' : 'bg-white' ]" >
    <div class="flex items-center space-x-2">
      <img :src="logoBlack" alt="TechKa" class="h-16" />
    </div>

    <!-- Desktop Menu -->
    <nav class="hidden md:flex space-x-6 font-medium text-gray-700">
      <a href="#" class="hover:text-indigo-600">Home</a>
      <a href="#" class="hover:text-indigo-600">Services</a>
      <a href="#" class="hover:text-indigo-600">Job Post</a>
      <a href="#" class="hover:text-indigo-600">Techkalista</a>
      <a href="#" class="hover:text-indigo-600">Contact</a>
    </nav>

    <!-- Desktop Login -->
    <router-link :to="'/login'" class="hidden md:block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
      Login
    </router-link>

    <!-- Mobile Hamburger -->
    <button
      @click="toggleDrawer"
      class="md:hidden flex items-center justify-center w-10 h-10 rounded focus:outline-none"
    >
      <svg
        v-if="!drawerOpen"
        xmlns="http://www.w3.org/2000/svg"
        class="h-6 w-6 text-gray-700"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M4 6h16M4 12h16M4 18h16" />
      </svg>
      <svg
        v-else
        xmlns="http://www.w3.org/2000/svg"
        class="h-6 w-6 text-gray-700"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>
  </header>
    <transition name="slide">
    <div
      v-if="drawerOpen"
      class="fixed inset-0 z-40 bg-black bg-opacity-50"
      @click.self="toggleDrawer"
    >
      <div
        class="fixed top-0 left-0 h-full w-64 bg-white shadow-lg p-6 flex flex-col space-y-6 z-50"
      >
        <!-- Logo inside drawer -->
        <div class="flex items-center space-x-2 mb-6">
          <img :src="logo" alt="TechKa" class="h-10" />
          <span class="font-bold text-xl">TechKaPH</span>
        </div>

        <!-- Drawer Menu -->
        <nav class="flex flex-col space-y-4 font-medium text-gray-700">
          <a href="#" class="hover:text-indigo-600" @click="toggleDrawer">Home</a>
          <a href="#" class="hover:text-indigo-600" @click="toggleDrawer">Categories</a>
          <a href="#" class="hover:text-indigo-600" @click="toggleDrawer">Services</a>
          <a href="#" class="hover:text-indigo-600" @click="toggleDrawer">About</a>
        </nav>

        <!-- Drawer Login Button -->
        <button class="mt-auto px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
          Login
        </button>
      </div>
    </div>
  </transition>
</template>

<script setup>
    import { reactive, ref, onMounted, onUnmounted } from 'vue';
    const logo = ref('/images/techka.png')
    const logoBlack = ref('/images/logo-2025-03-12-02-04-10-3476.png')
    const sidebanner = ref('/images/intro.webp')

    const isScrolled = ref(false);
    const drawerOpen = ref(false);

    const handleScroll = () => {
    isScrolled.value = window.scrollY > 50;
    };

    const toggleDrawer = () => {
    drawerOpen.value = !drawerOpen.value;
    };

    onMounted(() => {
    window.addEventListener("scroll", handleScroll);
    });

    onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
    });
</script>


<style scoped>
/* Slide down animation for navbar */
@keyframes slideDown {
  from {
    transform: translateY(-100%);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}
.animate-slideDown {
  animation: slideDown 0.4s ease forwards;
}

/* Drawer transition */
.slide-enter-from {
  transform: translateX(-100%);
}
.slide-enter-to {
  transform: translateX(0);
}
.slide-leave-from {
  transform: translateX(0);
}
.slide-leave-to {
  transform: translateX(-100%);
}
.slide-enter-active,
.slide-leave-active {
  transition: transform 0.3s ease;
}
</style>
