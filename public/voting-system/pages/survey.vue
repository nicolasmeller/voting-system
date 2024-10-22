<template>
  <!-- Wrapper for spinner and form -->
  <div class="relative ">
    <!-- Spinner -->
    <div v-if="isLoading" class="fixed inset-0 flex items-center justify-center z-50 bg-gray-100 bg-opacity-75">
      <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none">
        <path fill="#1e293b"
          d="M12,4a8,8,0,0,1,7.89,6.7A1.53,1.53,0,0,0,21.38,12h0a1.5,1.5,0,0,0,1.48-1.75,11,11,0,0,0-21.72,0A1.5,1.5,0,0,0,2.62,12h0a1.53,1.53,0,0,0,1.49-1.3A8,8,0,0,1,12,4Z">
          <animateTransform attributeName="transform" dur="1s" repeatCount="indefinite" type="rotate"
            values="0 12 12;360 12 12" />
        </path>
      </svg>
    </div>

    <div v-if="!isLoading" class="">
      <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
        <div class="mx-auto max-w-5xl">
          <div v-if="hasError" class="min-h-screen flex flex-col items-center justify-start py-10">
            <p class="text-gray-500 mt-10">Ingen survey tilgængelige.</p>
          </div>
          <template v-else>
            <h2 v-if="survey.length == 0" class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">
              Create survey
            </h2>
            <h2 v-else class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Survey</h2>
            <div class="mt-6 sm:mt-8 lg:flex lg:items-start lg:gap-12">
              <form @submit.prevent="createSurvey"
                class="w-full rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                <div class="mb-6 grid grid-cols-2 gap-4">
                  <div class="col-span-2 sm:col-span-1">
                    <label for="name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Name</label>
                    <input type="text" id="name" v-model="name"
                      class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                      placeholder="Survey Name" required />
                  </div>

                  <div class="col-span-2 sm:col-span-1">
                    <label for="description" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                      Description </label>
                    <input type="text" id="description" v-model="description"
                      class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 pe-10 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" />
                  </div>
                </div>

                <button type="submit"
                  class="flex w-full items-center justify-center rounded-lg bg-slate-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                  v-if="survey.length == 0">Create</button>

                <button type="submit"
                  class="flex w-full items-center justify-center rounded-lg bg-slate-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                  v-else>Update</button>
              </form>
            </div>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>


<script setup>
import { ref, onMounted } from 'vue';
import { useCookie } from '#imports';
import { useRoute } from 'vue-router';

const authToken = useCookie('auth-token');
const survey = ref([]);
const isLoading = ref(true);
const hasError = ref(false); 
const route = useRoute();

const name = ref('');
const description = ref('');

const createSurvey = async () => {
  isLoading.value = true;
  console.log('Auth Token:', authToken.value); 
  console.log('Creating Survey with Name:', name.value);
  console.log('Creating Survey with Description:', description.value);
  try {
    const res = await $fetch(`http://127.0.0.1:8000/api/survey`, {
      method: 'POST',
      body: { 
        name: name.value,
        description: description.value,
      },  
      headers: {
        'Authorization': `Bearer ${authToken.value}`,
      },
    });

    if (res && res.id) {
      survey.value = res; // Save the new survey data
      console.log('Survey created:', res);
    } else {
      hasError.value = true;
      console.log('Failed to create survey.');
    }
  } catch (error) {
    console.error("Failed to create survey:", error);
    hasError.value = true; 
  } finally {
    isLoading.value = false;
  }
};


const getSurvey = async (surveyId = route.query.id) => {
  try {
    const res = await $fetch(`http://127.0.0.1:8000/api/survey/${surveyId}`, {
      method: 'GET',
      headers: {
        'Authorization': `Bearer ${authToken.value}`,
      },
    });

    if (res.name) {
      survey.value = res;
      name.value = res.name; // Pre-fill form with existing survey data
      description.value = res.description;
    } else {
      hasError.value = true;
    }
  } catch (error) {
    console.error("Failed to fetch survey:", error);
    hasError.value = true; 
  } finally {
    isLoading.value = false;
  }
};

onMounted(() => {
  if (route.query.id) {
    getSurvey();
  } else {
    isLoading.value = false;
  }
});
</script>


<style scoped>
.fixed {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: transparent; 
}

.absolute {
  background: transparent;
}
</style>
