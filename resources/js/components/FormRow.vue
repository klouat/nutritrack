<template>
  <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-4">
    <label class="font-semibold text-[#003266] text-md">
      {{ label }}
    </label>
    <div class="sm:col-span-2">
      <slot />
    </div>
  </div>
</template>

<script setup>
defineProps({ label: String })
</script>
