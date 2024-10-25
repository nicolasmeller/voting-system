<template>
  <div class="relative">
    <div v-if="isLoading" class="fixed inset-0 flex items-center justify-center z-50">
      <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none">
        <path fill="#1e293b"
          d="M12,4a8,8,0,0,1,7.89,6.7A1.53,1.53,0,0,0,21.38,12h0a1.5,1.5,0,0,0,1.48-1.75,11,11,0,0,0-21.72,0A1.5,1.5,0,0,0,2.62,12h0a1.53,1.53,0,0,0,1.49-1.3A8,8,0,0,1,12,4Z">
          <animateTransform attributeName="transform" dur="1s" repeatCount="indefinite" type="rotate"
            values="0 12 12;360 12 12" />
        </path>
      </svg>
    </div>

    <!-- Notification Section -->
    <div v-if="showNotification">
      <Notification :message="notificationMessage" :show="showNotification" @close="showNotification = false" />
    </div>

    <div v-if="!isLoading">
      <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
        <div class="mx-auto max-w-5xl">
          <div v-if="hasError" class="min-h-screen flex flex-col items-center justify-start py-10">
            <p class="text-gray-500 mt-10">Ingen survey tilgængelige.</p>
          </div>

          <template v-else>
            <h2 v-if="survey.length === 0" class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">
              Create a new survey
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
                      class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" />
                  </div>
                </div>

                <button type="submit"
                  class="flex w-full items-center justify-center rounded-lg bg-slate-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                  v-if="survey.length === 0">Create</button>

                <button type="submit" @click="updateSurvey(survey.id)"
                  class="flex w-full items-center justify-center rounded-lg bg-slate-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                  v-else>Update</button>
              </form>
            </div>

            <!-- Add Question Button -->
            <div v-if="survey && survey.id" class="mt-8 flex justify-end">
            <button @click="addQuestion"
              class="mb-4 rounded-lg bg-slate-600 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:bg-slate-700 dark:hover:bg-slate-800">
              Add Question
            </button>
          </div>

            <!-- Survey Questions Table -->
            <div v-if="questions.length > 0" class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
              <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 table-fixed">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-white">
                  <tr>
                    <th scope="col" class="px-6 py-3 w-1/5">Question</th>
                    <th scope="col" class="px-6 py-3 w-2/5">Answer</th>
                    <th scope="col" class="px-6 py-3 w-1/5">Type</th>
                    <th scope="col" class="px-6 py-3 w-1/5">Created</th>
                    <th scope="col" class="px-6 py-3 w-1/5"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="question in questions" :key="question.id"
                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 truncate dark:text-white">
                      {{ question.question }}
                    </th>
                    <td class="px-6 py-4 truncate">{{ question.answer ? question.answer : "No Answer" }}</td>
                    <td class="px-6 py-4">{{ question.type }}</td>
                    <td class="px-6 py-4">{{ formatDate(question.created_at) }}</td>
                    <td class="px-6 py-4">
                      <button @click="editQuestion(question.id)"
                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                        Edit
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <p v-else-if="survey.id || survey.questions === 0"class="text-gray-500 mt-10 text-center">No questions added.</p>
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
import notification from '~/components/notification.vue';
// Definer referencer til variabler
const authToken = useCookie('auth-token');
const survey = ref([]);
const isLoading = ref(true);
const hasError = ref(false);
const route = useRoute();

const questions = ref([]);
const name = ref('');
const description = ref('');
import moment from 'moment';
const showNotification = ref(false);
const notificationMessage = ref('');
const config = useRuntimeConfig();
// Funktion til at oprette en ny survey
const createSurvey = async () => {
  isLoading.value = true;

  // Hent router instans
  const router = useRouter(); 

  try {
    const res = await $fetch(`/survey`, {
      method: 'POST',
      baseURL: config.public.baseURL,
      body: {
        name: name.value,
        description: description.value,
      },
      headers: {
        'Authorization': `Bearer ${authToken.value}`,
      },
    });

    // Tjek om oprettelse var succesfuld
    if (res && res.id) {

      await getSurvey(res.id );
      notificationMessage.value = 'Survey created successfully!';
      showNotification.value = true;
    } else {

      notificationMessage.value = 'Failed to create survey.';
      showNotification.value = true;
    }
  } catch (error) {

    notificationMessage.value = 'Failed to create survey.';
    showNotification.value = true;
  } finally {
    isLoading.value = false;
  }

  setTimeout(() => {
      showNotification.value = false;
    }, 3000000);
};


const formatDate = (date) => {
  return moment(date).format('DD/MM/YYYY');
}

const addQuestion = () => {
  console.log("Add Question clicked");
};

const updateSurvey = async (surveyId = route.query.id) => {
  isLoading.value = true;
  try {

    const res = await $fetch(`/survey/${surveyId}`, {
      method: 'PUT',
      baseURL: config.public.baseURL,
      body: {
        name: name.value,
        description: description.value,
      },
      headers: {
        'Authorization': `Bearer ${authToken.value}`,
      },
    });

    if (res && res.id) {

      await getSurvey(surveyId);

      notificationMessage.value = 'Survey updated successfully!';
      showNotification.value = true;
    } else {
      hasError.value = true;
      console.log('Failed to update survey.');
    }
  } catch (error) {
    console.error("Failed to update survey:", error);
    hasError.value = true;
  } finally {
    isLoading.value = false;

    // Hide the notification after 3 seconds
    setTimeout(() => {
      showNotification.value = false;
    }, 3000000);
  }
};

// Funktion til at hente en eksisterende survey
const getSurvey = async (surveyId = route.query.id) => {
  try {
    const res = await $fetch(`/survey/${surveyId}`, {
      method: 'GET',
      baseURL: config.public.baseURL, // Brug den konfigurerede baseURL
      headers: {
        'Authorization': `Bearer ${authToken.value}`,
      },
    });

    // Tjek om survey data er tilgængelige
    if (res.name) {
      survey.value = res;
      name.value = res.name;
      description.value = res.description;
      questions.value = res.questions;
      console.log('Survey data:', res);
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

// Kald `getSurvey` ved komponent-mount, hvis der findes en survey ID i URL'en
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
