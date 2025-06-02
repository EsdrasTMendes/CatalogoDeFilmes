<template>
  <div
    class="title-section px-2 py-3 text-center bg-violet-50 flex-shrink-0 h-[45px] overflow-hidden relative"
    ref="titleContainer"
  >
    <h3
      class="text-base font-semibold text-kh-purple whitespace-nowrap"
      :class="{ 'animate-title-scroll': canTitleScroll }"
      :style="canTitleScroll ? {
        '--title-scroll-offset': `-${titleScrollOffset}px`,
        '--title-animation-duration': titleAnimationDuration,
        '--kf-scroll-end-perc': kfScrollEndPerc + '%',
        '--kf-hold-end-perc': kfHoldEndPerc + '%'
      } : {
        transform: 'translateX(0px)',
        animationName: 'none'
      }"
      :title="title"
      ref="titleText"
    >
      {{ title }}
    </h3>
  </div>
</template>

<script>
export default {
  name: 'CardTitle',
  props: {
    title: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      canTitleScroll: false,
      titleScrollOffset: 0,
      titleAnimationDuration: '10s',
      kfScrollEndPerc: 40,
      kfHoldEndPerc: 60,
    };
  },
  methods: {
    checkTitleOverflow() {
      this.$nextTick(() => {
        const titleTextEl = this.$refs.titleText;
        const titleContainerEl = this.$refs.titleContainer;

        if (titleTextEl && titleContainerEl && titleContainerEl.clientWidth > 0) {
          const textWidth = titleTextEl.scrollWidth;
          const containerWidth = titleContainerEl.clientWidth;

            const hiddenTextWidth = textWidth - containerWidth;
            if( hiddenTextWidth > 0 ) {
              this.canTitleScroll = true;
              this.titleScrollOffset = hiddenTextWidth + 25;
            }

            const scrollSpeed = 35;
            const scrollDistanceToAnimate = this.titleScrollOffset;

            const scrollOutDuration = Math.max(1.5, scrollDistanceToAnimate / scrollSpeed);
            const holdAtEndDuration = 1.0;
            const scrollInDuration = Math.max(0.5, scrollDistanceToAnimate / (scrollSpeed * 2)); // Volta um pouco mais rápido

            const totalDuration = scrollOutDuration + holdAtEndDuration + scrollInDuration;

            if (totalDuration > 0.1) {
              this.titleAnimationDuration = `${totalDuration}s`;
              this.kfScrollEndPerc = (scrollOutDuration / totalDuration) * 100;
              this.kfHoldEndPerc = ((scrollOutDuration + holdAtEndDuration) / totalDuration) * 100;
            } else {
              this.canTitleScroll = false;
            }
          } else {
            this.canTitleScroll = false;
          }

        if (!this.canTitleScroll) {
            this.titleScrollOffset = 0;
        }
      });
    },
  },
  mounted() {
    this.checkTitleOverflow();
  },
  watch: {
    title: {
      handler() {
        setTimeout(this.checkTitleOverflow, 50);
      },
      immediate: true,
    },
  },
};
</script>

<style scoped>
.title-section h3 {
  display: inline-block;
}

.title-section h3.animate-title-scroll:hover {
  animation-name: scrollAndResetTitle;
  animation-duration: var(--title-animation-duration, 10s);
  animation-timing-function: linear;
  animation-iteration-count: infinite;
}

@keyframes scrollAndResetTitle {
  0% {
    transform: translateX(0px);
  }
  40% {
    transform: translateX(var(--title-scroll-offset, -50px));
  }
  60% {
    transform: translateX(var(--title-scroll-offset, -50px));
  }
  100% {
    transform: translateX(0px);
  }
}
</style>
