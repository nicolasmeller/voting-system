<template>
      <transition name="fade" v-if="isLoading">
      <div class="flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24">
          <path fill="#1e293b" d="M12,4a8,8,0,0,1,7.89,6.7A1.53,1.53,0,0,0,21.38,12h0a1.5,1.5,0,0,0,1.48-1.75,11,11,0,0,0-21.72,0A1.5,1.5,0,0,0,2.62,12h0a1.53,1.53,0,0,0,1.49-1.3A8,8,0,0,1,12,4Z">
            <animateTransform attributeName="transform" dur="1s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12" />
          </path>
        </svg>
      </div>
    </transition>
  <p>{{ surveys }}</p>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useCookie } from '#imports';


const authToken = useCookie('auth-token');

// Define the function to fetch surveys
import { useRoute } from 'vue-router';
const surveys = ref([]);
const isLoading = ref(true); // Initialize loading state

const route = useRoute();

const getSurvey = async (surveyId = route.query.id) => {
  try {
    // Brug backticks til at interpolere surveyId
    const res = await $fetch(`http://127.0.0.1:8000/api/survey/${surveyId}`, {
      method: 'GET',
      headers: {
        'Authorization': `Bearer ${authToken.value}`, // Tilføj Bearer token
      },
    });

    // Opdater surveys med svaret fra serveren
    surveys.value = res; // Antager at res indeholder de hentede data
    console.log(surveys.value); // Log surveys til konsollen for debugging
  } catch (error) {
    console.error('Failed to fetch surveys:', error);
  } finally {
    isLoading.value = false; // Set loading to false after the fetch
  } 
};



// Fetch surveys when the component is mounted
onMounted(() => {
  getSurvey();

});
</script>

<style scoped>
/* Fade transition styles */
.fade-enter-active, .fade-leave-active {
  transition: opacity 1s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
  opacity: 0;
}

/* Add any component-specific styles here */
</style>
