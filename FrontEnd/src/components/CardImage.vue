<template>
  <div class="image-container flex-shrink-0 h-[17.5rem] bg-violet-50 flex items-center justify-center">
    <img
      class="max-w-full max-h-full object-contain"
      :src="posterPath"
      :alt="`Capa do filme ${altText}`"
    />
  </div>
</template>

<script>
export default {
  name: 'CardImage',
  props: {
    posterPath: {
      type: String,
      required: true,
    },
    altText: {
      type: String,
      required: true,
    },
  },
};
</script>

<style scoped>
</style>
