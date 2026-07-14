<script setup>
defineProps({
  label:    { type: String,  required: true },
  error:    { type: [String, Array], default: null },
  full:     { type: Boolean, default: false },
})
</script>

<template>
  <div class="field" :class="{ full }">
    <label>{{ label }}</label>
    <slot />
    <span class="error-msg" v-if="error">{{ Array.isArray(error) ? error[0] : error }}</span>
  </div>
</template>

<style scoped>
.field { display: flex; flex-direction: column; gap: 0.4rem; }
.field.full { grid-column: 1 / -1; }
label { font-size: 0.875rem; font-weight: 600; color: #444; }
.error-msg { font-size: 0.8rem; color: #e74c3c; }
</style>
