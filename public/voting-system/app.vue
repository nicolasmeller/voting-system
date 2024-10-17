<template>
  <div id="__nuxt">
    <!-- Integrerer layoutet -->
    <NuxtLayout>
      <!-- Rendrer siden inden i layoutet -->
      <NuxtPage />
    </NuxtLayout>
  </div>
</template>

<script setup>
import { useCookie } from '#imports';

const authToken = useCookie('auth-token', {
  secure: true,
  sameSite: 'Strict', 
});



</script>

<style scoped>
/* Eventuelle globale styles */
</style>
