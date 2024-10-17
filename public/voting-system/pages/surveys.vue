<template>
  <div class="min-h-screen flex flex-col items-center justify-start py-10">
    <!-- Loading Spinner -->
    <transition name="fade" v-if="isLoading">
      <div class="flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24">
          <path fill="#1e293b"
            d="M12,4a8,8,0,0,1,7.89,6.7A1.53,1.53,0,0,0,21.38,12h0a1.5,1.5,0,0,0,1.48-1.75,11,11,0,0,0-21.72,0A1.5,1.5,0,0,0,2.62,12h0a1.53,1.53,0,0,0,1.49-1.3A8,8,0,0,1,12,4Z">
            <animateTransform attributeName="transform" dur="1s" repeatCount="indefinite" type="rotate"
              values="0 12 12;360 12 12" />
          </path>
        </svg>
      </div>
    </transition>

    <!-- Surveys Section -->
    <transition name="fade" v-else-if="surveys.length > 0">
      <div class="w-full max-w-7xl px-6">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-4xl font-extrabold dark:text-slate-200">Surveys</h2>
          <button type="submit" @click="createSurvey()"
            class="text-white hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-slate-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-slate-600 dark:hover:bg-slate-700 dark:focus:ring-slate-800">Create</button>
        </div>
        <div :items="surveys" class="relative overflow-x-auto shadow-md sm:rounded-lg">

          <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-white">
              <tr>
                <th scope="col" class="px-6 py-3">Name</th>
                <th scope="col" class="px-6 py-3">Description</th>
                <th scope="col" class="px-6 py-3">Questions</th>
                <th scope="col" class="px-6 py-3">Created</th>
                <th scope="col" class="px-6 py-3"></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="survey in surveys" :key="survey.id"
                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  {{ survey.name }}
                </th>
                <td class="px-6 py-4">{{ survey.description }}</td>
                <td class="px-6 py-4 text-center">{{ survey.questions.length }}</td>
                <td class="px-6 py-4">{{ formatDate(survey.created_at) }}</td>
                <td class="px-6 py-4">
                  <button @click="getSurvey(survey.id)"
                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                    Edit
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </transition>

    <!-- No Surveys Available Message -->
    <p v-else class="text-gray-500 mt-10">Ingen surveys tilgængelige.</p>
  </div>
</template>


<script setup>
import { ref, onMounted } from 'vue';
import { useCookie } from '#imports';
import { useRouter } from 'vue-router';  // Importer useRouter
import moment from 'moment'; // Importer moment

// Declare refs for surveys and loading state
const surveys = ref([]);
const isLoading = ref(true); // Initialize loading state

// Get the auth token from cookies
const authToken = useCookie('auth-token');
const router = useRouter();  // Initialiser router

// Define the function to fetch surveys
const getSurveys = async () => {
  try {
    const res = await $fetch('http://127.0.0.1:8000/api/survey', {
      method: 'GET',
      headers: {
        'Authorization': `Bearer ${authToken.value}`, // Add Bearer token
      },
    });

    // Update surveys with the response data
    surveys.value = res; // Assuming res contains the survey data
    console.log(surveys.value); // Log surveys to console for debugging
  } catch (error) {
    console.error('Failed to fetch surveys:', error);
  } finally {
    isLoading.value = false; // Set loading to false after the fetch
  }
};

// Format date function
const formatDate = (date) => {
  console.log(date); // Log datoen for debugging
  return moment(date).format('DD/MM/YYYY'); // Brug format med AM/PM
}
const createSurvey = () => {
  router.push({ path: "/survey"});
};

// Function to fetch a specific survey
const getSurvey = (id) => {
  router.push({ path: "/survey", query: { id: id } });
};

// Fetch surveys when the component is mounted
onMounted(() => {
  getSurveys();
});
</script>

<style scoped>
/* Fade transition styles */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 1s;
}

.fade-enter,
.fade-leave-to
/* .fade-leave-active in <2.1.8 */
  {
  opacity: 0;
}

/* Add any component-specific styles here */
</style>
