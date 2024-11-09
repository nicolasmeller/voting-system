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
          
          <!-- Search Input Field -->
          <div class="flex items-center space-x-4">
            <input type="text" v-model="searchQuery" placeholder="Search surveys..." 
              class="px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-white dark:placeholder-gray-400">
            <button type="submit" @click="createSurvey()"
              class="text-white hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-slate-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-slate-600 dark:hover:bg-slate-700 dark:focus:ring-slate-800">
              Create
            </button>
          </div>
        </div>
        
        <!-- Check if there are filtered results -->
        <div v-if="filteredSurveys.length > 0"  class="relative overflow-x-auto shadow-md sm:rounded-lg">
          <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 table-fixed">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-white">
              <tr>
                <th scope="col" class="px-6 py-3 w-1/5">Name</th>
                <th scope="col" class="px-6 py-3 w-2/5">Description</th>
                <th scope="col" class="px-6 py-3 w-1/5">Questions</th>
                <th scope="col" class="px-6 py-3 w-1/5">Created</th>
                <th scope="col" class="px-6 py-3 w-1/5"></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="survey in filteredSurveys" :key="survey.id"
                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 truncate dark:text-white">
                  {{ survey.name }}
                </th>
                <td class="px-6 py-4 truncate">{{ survey.description }}</td>
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

        <!-- No Matching Results Message -->
        <p v-else class="text-gray-500 mt-10 text-center">There is no available survey on that search criteria.</p>

        <!-- Pagination Controls -->
        <div v-if="filteredSurveys.length > 0" class="flex justify-center items-center mt-4 space-x-2">
          <button @click="prevPage" :disabled="currentPage === 1"
            class="px-4 py-2 text-white bg-slate-600 hover:bg-slate-700 rounded disabled:bg-slate-400"
            :class="{ 'cursor-not-allowed opacity-50': currentPage === 1 }">
            Previous
          </button>
          <span class="text-gray-600">Page {{ currentPage }} of {{ totalPages }}</span>
          <button @click="nextPage" :disabled="currentPage === totalPages"
            class="px-4 py-2 text-white bg-slate-600 hover:bg-slate-700 rounded disabled:bg-slate-400"
            :class="{ 'cursor-not-allowed opacity-50': currentPage === totalPages }">
            Next
          </button>
        </div>
      </div>
    </transition>
    <div v-else>
      <button type="submit" @click="createSurvey()"
              class="text-white hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-slate-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-slate-600 dark:hover:bg-slate-700 dark:focus:ring-slate-800">
              Create
            </button>
      <!-- No Surveys Available Message -->
      <p  class="text-gray-500 mt-10">Ingen surveys tilgængelige.</p>
      
    </div>
  </div>
</template>


<script setup>
import { ref, computed, onMounted } from 'vue';
import { useCookie } from '#imports';
import { useRouter } from 'vue-router';  
import moment from 'moment';

const surveys = ref([]);
const isLoading = ref(true); 
const currentPage = ref(1);  
const surveysPerPage = 10;   
const searchQuery = ref(''); 

const authToken = useCookie('auth-token');
const router = useRouter();  
const config = useRuntimeConfig();
const getSurveys = async () => {
  try {
    const res = await $fetch('/survey', {
      method: 'GET',
      baseURL: config.public.baseURL,
      headers: {
        'Authorization': `Bearer ${authToken.value}`,
      },
    });

    surveys.value = res; 
  } catch (error) {
    console.error('Failed to fetch surveys:', error);
  } finally {
    isLoading.value = false; 
  }
};

const filteredSurveys = computed(() => {
  return surveys.value.filter(survey =>
    survey.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    survey.description.toLowerCase().includes(searchQuery.value.toLowerCase())
  ).slice((currentPage.value - 1) * surveysPerPage, currentPage.value * surveysPerPage);
});

const totalPages = computed(() => {
  const filteredCount = surveys.value.filter(survey =>
    survey.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    survey.description.toLowerCase().includes(searchQuery.value.toLowerCase())
  ).length;
  
  return Math.ceil(filteredCount / surveysPerPage);
});

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
};

const prevPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
};

const formatDate = (date) => {
  return moment(date).format('DD/MM/YYYY'); 
}

const createSurvey = () => {
  router.push({ path: "/survey"});
};

const getSurvey = (id) => {
  router.push({ path: "/survey", query: { id: id } });
};

onMounted(() => {
  getSurveys();
});
</script>


<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 1s;
}

.fade-enter,
.fade-leave-to {
  opacity: 0;
}

button:disabled {
  cursor: not-allowed;
  opacity: 0.5;
}

/* Make table layout fixed to maintain consistent column width */
.table-fixed {
  table-layout: fixed;
}

/* Ensures text in cells is properly truncated */
th, td {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
</style>
