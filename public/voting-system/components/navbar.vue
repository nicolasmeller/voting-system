<template>
  <Disclosure as="nav" class="bg-gray-800" v-slot="{ open }">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
      <div class="relative flex h-16 items-center justify-between">
        <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
          <DisclosureButton
            class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
            <span class="sr-only">Open main menu</span>
            <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
            <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
          </DisclosureButton>
        </div>
        <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
          <div class="flex flex-shrink-0 items-center">
            <NuxtLink class="h-8 w-auto text-gray-400 hover:text-white" to="/"> Voting </NuxtLink>
          </div>
          <div class="hidden sm:ml-6 sm:block">
            <div class="flex space-x-4">
              <NuxtLink v-for="item in navigation" :key="item.name" :href="item.href"
                :class="[isCurrentRoute(item.href) ? 'bg-gray-900 text-white' : 'text-gray-300 hover:text-white', 'rounded-md px-3 py-2 text-sm font-medium']"
                :aria-current="isCurrentRoute(item.href) ? 'page' : undefined">
                {{ item.name }}
              </NuxtLink>
            </div>
          </div>
        </div>
        <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
          <NuxtLink v-if="!isLoggedIn" to="/login"
            class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
            Log in
          </NuxtLink>
          <button v-if="isLoggedIn" @click="LogOutSubmit"
            class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
            Log Out
          </button>
        </div>
      </div>
    </div>

    <DisclosurePanel class="sm:hidden">
      <div class="space-y-1 px-2 pb-3 pt-2">
        <NuxtLink v-for="item in navigation" :key="item.name" as="a" :href="item.href"
          :class="[isCurrentRoute(item.href) ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block rounded-md px-3 py-2 text-base font-medium']"
          :aria-current="isCurrentRoute(item.href) ? 'page' : undefined">
          {{ item.name }}
        </NuxtLink>
      </div>
    </DisclosurePanel>
  </Disclosure>
</template>

<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue';
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline';
import { useCookie } from '#imports';
import { ref, onMounted, watch } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const authToken = useCookie('auth-token', {
  secure: true,
  sameSite: 'Strict', 
});

const isLoggedIn = ref(false);


const checkAuthToken = () => {
  isLoggedIn.value = !!authToken.value; 
};

watch(authToken, () => {
  checkAuthToken();
});

const LogOutSubmit = async () => {
  try {
    const token = authToken.value;

    if (token) {
      // Send logout request to backend
      const res = await $fetch('http://127.0.0.1:8000/api/logout', {
        method: 'post',
        headers: {
          'Authorization': `Bearer ${token}`, // Add Bearer token
        },
      });

     
      if (res.status === 401) {
        authToken.value = null;
      } else { 
        authToken.value = null; 
      }

      isLoggedIn.value = false;
      router.push('/login');
    }
  } catch (err) {
    console.error('Log out failed:', err);
    if (err.response && err.response.status === 401) {
      authToken.value = null; 
      isLoggedIn.value = false;
      router.push('/login'); 
    }
  }
};

onMounted(() => {
  checkAuthToken(); 
});

// Navigation items
const navigation = [
  { name: 'Home', href: '/' },
  { name: 'About', href: '/about' },
  { name: 'Survey', href: '/surveys' },
];

// Function to check if the route is active
function isCurrentRoute(href) {
  return router.currentRoute.value.path === href; // Use currentRoute to check active route
}
</script>

<style scoped>
/* Add any component-specific styles here */
</style>
