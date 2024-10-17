<template>
  <div>
      <Navbar></Navbar>
    <main class="min-h-screen bg-white py-1 antialiased dark:bg-gray-900 md:py-8">
      <!-- Dette er, hvor siden bliver rendret -->
      <slot />
    </main>

  </div>
</template>

<style scoped>

</style>
