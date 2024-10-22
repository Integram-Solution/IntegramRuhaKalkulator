<script setup>
import Calculator from "./components/Calculator/Calculator.vue";
console.log("test");
</script>

<template>
  <Calculator />
</template>

<style>
:root {
  --font: "Space Mono", monospace;
}
body {
  background-color: hsl(185, 41%, 84%);
  font-family: var(--font) !important;
}
#app {
  font-family:  Helvetica;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}
</style>
