<template>
  <div class="card-face card-back bg-kh-card-bg p-4 flex flex-col overflow-hidden rounded-lg">
    <h4 class="text-md font-bold text-kh-purple mb-2 flex-shrink-0 text-center" :title="title">
      {{ title }}
    </h4>
    <div class="description-scroll flex-grow overflow-y-auto mb-2 pr-1">
      <p class="leading-normal text-background text-balance text-sm">
        {{ overview }}
      </p>
    </div>
    <div class="mt-auto pt-2 border-t border-gray-200 flex-shrink-0 text-center">
      <span class="text-background font-semibold text-kh-purple">
        Lançamento: {{ releaseDate }}
      </span>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CardBack',
  props: {
    title: { type: String, required: true },
    overview: { type: String, required: true },
    releaseDate: { type: String, required: true },
  },
};
</script>

<style scoped>
.description-scroll {
  scrollbar-width: thin;
  scrollbar-color: var(--color-kh-purple) transparent;
}
.description-scroll::-webkit-scrollbar { width: 6px; }
.description-scroll::-webkit-scrollbar-track { background: transparent; }
.description-scroll::-webkit-scrollbar-thumb { background-color: var(--color-kh-purple); border-radius: 3px; }
</style>
