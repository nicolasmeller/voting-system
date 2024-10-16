<template>
  <div>
      <Navbar></Navbar>
    <main>
      <!-- Dette er, hvor siden bliver rendret -->
      <slot />
    </main>
    <footer>
    </footer>
  </div>
</template>

<style scoped>
header, footer {
  background-color: #f5f5f5;
  padding: 10px;
}
</style>
