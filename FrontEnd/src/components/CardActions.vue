<template>
  <div class="actions-section p-2 border-t border-gray-200 flex-shrink-0 flex justify-around items-center">
    <button
      @click.stop="$emit('toggle-favorite')"
      :title="isFavorite ? 'Remover dos Favoritos' : 'Adicionar aos Favoritos'"
      class="p-2 rounded-full hover:bg-kh-purple-light transition-colors focus:outline-none"
      :aria-pressed="isFavorite.toString()"
    >
      <svg v-if="isFavorite" xmlns="http://www.w3.org/2000/svg" viewBox="0 1.25 29.1 22" fill="currentColor" class="w-6 h-6 text-kh-purple">
        <path d="M26.5093 6.36596C27.3828 6.50228 28.2442 6.65299 29.0933 6.8181L23.9531 23.1954C21.4854 21.8085 18.18 20.9639 14.5485 20.9639C10.9171 20.9639 7.60784 21.8085 5.14139 23.1954L0 6.81937C0.850791 6.65426 1.7138 6.50355 2.58902 6.36723C3.93217 9.9945 5.56721 12.1218 7.33239 12.1218C9.23403 12.1218 10.9904 9.64777 12.3866 5.48582C12.8099 4.2272 13.2003 2.81109 13.5541 1.2629C13.8826 1.2629 14.2128 1.26078 14.5447 1.25655C14.8766 1.25232 15.2068 1.25443 15.5354 1.2629C15.853 2.68955 16.2426 4.09901 16.7029 5.48582C18.1029 9.64777 19.8554 12.1218 21.7571 12.1218C23.5273 12.1218 25.1649 9.99449 26.5093 6.36596Z"/>
      </svg>
      <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 1.25 29.1 22" fill="currentColor" class="w-6 h-6 text-gray-400 hover:text-kh-purple transition-colors">
        <path d="M26.5093 6.36596C27.3828 6.50228 28.2442 6.65299 29.0933 6.8181L23.9531 23.1954C21.4854 21.8085 18.18 20.9639 14.5485 20.9639C10.9171 20.9639 7.60784 21.8085 5.14139 23.1954L0 6.81937C0.850791 6.65426 1.7138 6.50355 2.58902 6.36723C3.93217 9.9945 5.56721 12.1218 7.33239 12.1218C9.23403 12.1218 10.9904 9.64777 12.3866 5.48582C12.8099 4.2272 13.2003 2.81109 13.5541 1.2629C13.8826 1.2629 14.2128 1.26078 14.5447 1.25655C14.8766 1.25232 15.2068 1.25443 15.5354 1.2629C15.853 2.68955 16.2426 4.09901 16.7029 5.48582C18.1029 9.64777 19.8554 12.1218 21.7571 12.1218C23.5273 12.1218 25.1649 9.99449 26.5093 6.36596Z"/>
      </svg>
    </button>

    <div
      class="rating-stars flex items-center"
      :class="{ 'opacity-50 cursor-not-allowed': !isFavorite }"
      @mouseleave="isFavorite ? (localHoverRating = 0) : null"
      role="group"
      aria-label="Avaliação do filme"
    >
      <button
        v-for="starIndex in 5"
        :key="starIndex"
        @click.stop="isFavorite ? $emit('rate-movie', starIndex) : null"
        @mouseenter="isFavorite ? (localHoverRating = starIndex) : null"
        :disabled="!isFavorite"
        class="p-0.5 disabled:cursor-not-allowed focus:outline-none"
        :title="isFavorite ? `Avaliar com ${starIndex} estrela(s)` : 'Adicione aos favoritos para poder avaliar'"
        :aria-label="`Avaliar com ${starIndex} estrela(s)`"
        :aria-checked="currentRating === starIndex"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24"
          fill="currentColor"
          class="w-5 h-5 transition-colors"
          :class="[
            (localHoverRating >= starIndex || (!localHoverRating && currentRating >= starIndex)) && isFavorite
              ? 'text-kh-purple'
              : 'text-gray-300',
            isFavorite && !((localHoverRating >= starIndex || (!localHoverRating && currentRating >= starIndex)))
              ? 'hover:text-kh-purple'
              : '',
          ]"
        >
          <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434L10.788 3.21z" clip-rule="evenodd" />
        </svg>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CardActions',
  props: {
    isFavorite: {
      type: Boolean,
      required: true,
    },
    currentRating: {
      type: Number,
      required: true,
    },
  },
  emits: ['toggle-favorite', 'rate-movie'],
  data() {
    return {
      localHoverRating: 0,
    };
  },
    watch: {
    isFavorite(newVal) {
      if (!newVal) {
        this.localHoverRating = 0;
      }
    }
  }
};
</script>
