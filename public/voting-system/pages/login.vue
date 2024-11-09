<template>
  <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900 dark:text-white">Log in</h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form @submit.prevent="handleSubmit" class="space-y-6">
        <div>
          <label for="email" class="block text-sm font-medium leading-6 text-gray-900  dark:text-white">Email address</label>
          <div class="mt-2">
            <input 
              v-model="email"
              id="email"
              name="email"
              type="email"
              autocomplete="email"
              required 
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-slate-800 sm:text-sm sm:leading-6" 
            />
          </div>
        </div>

        <div>
          <div class="flex items-center justify-between">
            <label for="password" class="block text-sm font-medium leading-6 text-gray-900  dark:text-white">Password</label>
          </div>
          <div class="mt-2">
            <input 
              v-model="password"
              id="password"
              name="password"
              type="password"
              autocomplete="current-password"
              required 
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-slate-800 sm:text-sm sm:leading-6" 
            />
          </div>
        </div>
        <div>
          <button type="submit" class="flex w-full justify-center rounded-md bg-slate-900 dark:bg-slate-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-800">Log in</button>
        </div>
      </form>
      <div v-if="error" class="mt-2 text-red-600">{{ error }}</div>
      <div v-if="success" class="mt-2 text-green-600">{{ success }}</div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useCookie } from '#imports';
import { useRouter } from 'vue-router';  // Importer useRouter
const authToken = useCookie('auth-token', {
  secure: true,
  sameSite: 'strict',
});

const router = useRouter();  // Initialiser router
const email = ref('');
const password = ref('');
const error = ref(null);
const success = ref(null);

const handleSubmit = async () => {
  try {
    // Nulstil tidligere fejl og succesbeskeder
    error.value = null;
    success.value = null;

    // Hent baseURL fra runtimeConfig
    const config = useRuntimeConfig();
    const res = await $fetch('/login', {
      method: 'post',
      baseURL: config.public.baseURL, 
      body: { 
        email: email.value,
        password: password.value,
      }    
    });

    router.push('/');
    authToken.value = res.token;
    success.value = 'Login successful!';
  } catch (err) {
    // Håndter fejl fra login request
    error.value = "Email or Password is incorrect!";
    authToken.value = null;
    console.error(error.value);
  }
};


</script>
