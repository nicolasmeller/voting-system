vue
<template>
  <div class="relative">
    <div v-if="isLoading" class="fixed inset-0 flex items-center justify-center z-50">
      <!-- Loader SVG -->
      <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none">
        <path fill="#1e293b" d="M12,4a8,8,0,0,1,7.89,6.7A1.53,1.53,0,0,0,21.38,12h0a1.5,1.5,0,0,0,1.48-1.75,11,11,0,0,0-21.72,0A1.5,1.5,0,0,0,2.62,12h0a1.53,1.53,0,0,0,1.49-1.3A8,8,0,0,1,12,4Z">
          <animateTransform attributeName="transform" dur="1s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12" />
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
          <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Questions</h2>
          
          <form @submit.prevent="createOrUpdateQuestion" class="w-full rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
            <div class="mb-6 grid grid-cols-2 gap-4">
              <div class="col-span-2">
                <label for="question" class="block text-sm font-medium text-gray-900 dark:text-white">Question</label>
                <input type="text" id="question" v-model="question" class="w-full rounded-lg border p-2.5" maxlength="255" required />
              </div>
              <div class="col-span-2">
                <label for="answer" class="block text-sm font-medium text-gray-900 dark:text-white">Answer</label>
                <input type="text" id="answer" v-model="answer" class="w-full rounded-lg border p-2.5" maxlength="255" />
              </div>
              <div class="col-span-2">
                <label for="type" class="block text-sm font-medium text-gray-900 dark:text-white">Type</label>
                <input type="text" id="type" v-model="type" class="w-full rounded-lg border p-2.5" maxlength="255" />
              </div>
            </div>

            <button type="submit" class="w-full rounded-lg bg-slate-700 px-5 py-2.5 text-sm font-medium text-white">Save Question</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useCookie, useRuntimeConfig } from '#imports';

const authToken = useCookie('auth-token');
const question = ref('');
const answer = ref('');
const type = ref('');
const isLoading = ref(true);
const showNotification = ref(false);
const notificationMessage = ref('');
const config = useRuntimeConfig();
const router = useRouter();
const route = useRoute();

const getQuestion = async () => {
  try {
    const res = await $fetch(`/question/${route.query.id}`, {
      method: 'GET',
      baseURL: config.public.baseURL,
      headers: {
        'Authorization': `Bearer ${authToken.value}`,
      },
    });

    if (res) {
      
      question.value = res.question;
      answer.value = res.answer;
      type.value = res.type;
    }
  } catch (error) {
    notificationMessage.value = 'Failed to load question';
    showNotification.value = true;
  } finally {
    isLoading.value = false;
  }
};

const createOrUpdateQuestion = async () => {
  isLoading.value = true;

  try {

    const survey_id = route.query.survey ?? null;
    const question_id = route.query.id ?? null;
    const method = route.query.id ? 'PUT' : 'POST'; // Determine the request method based on the presence of an ID
    const url = route.query.id ? `/question/${route.query.id}` : '/question';
    

    const res = await $fetch(url, {
      method,
      baseURL: config.public.baseURL,
      body: {
        survey_id: survey_id,
        question: question.value,
        answer: answer.value,
        type: type.value,
      },
      headers: {
        'Authorization': `Bearer ${authToken.value}`,
      },
    });

    notificationMessage.value = res ? 'Question saved successfully!' : 'Failed to save question';
    showNotification.value = true;

    if(survey_id){
      router.push({ path: "/survey", query: { id:  survey_id }  });
    }
    else {
      router.push({ path: "/question", query: { id:  question_id }  });
    }
  } catch (error) {
    notificationMessage.value = 'Failed to save question';
    showNotification.value = true;
  } finally {
    isLoading.value = false;
  }
};

onMounted(() => {
  if (route.query.id) {
    getQuestion(); // Load the question if editing
  } else {
    isLoading.value = false; // No question to load, just set loading to false
  }
});
</script>