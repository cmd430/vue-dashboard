<template>
<li>
  <div class="img" :style="{ 'background-image': 'url(' + (queue.series ? queue.series.poster : queue.poster) + ')' }">
    <span v-if="queue.downloading.status === 'downloading'" class="downloading">
      <span>{{ queue.downloading.timeleft | duration('humanize', true) }}</span>
      <span>{{ queue.downloading.progress + '%' }}</span>
    </span>
    <!-- These next two v-if blocks might not be correct -->
    <span v-else :class="currentClass">
      <span>{{ currentText }}</span>
    </span>
  </div>
  <div class="info">
    <p v-if="queue.series" class="title">
      <span>{{ queue.series.season }}x{{ queue.series.episode }}</span>
      {{ queue.title }}
    </p>
    <p class="name">{{ (queue.series ? queue.series.title : queue.title) }}</p>
  </div>
</li>
</template>

<script>
export default {
  name: 'queue-item',
  props: [
    'queue'
  ],
  computed: {
    currentClass () {
      let completed = this.queue.downloading.status === 'completed'
      let warning = this.queue.downloading.message === 'warning'
      let stalled = this.queue.downloading.status === 'stalled'
      if (stalled || (completed && warning)) return 'warning'
      if (this.queue.downloading.status === 'queued') return 'queued'
      if (this.queue.downloading.status === 'paused') return 'paused'
      return 'unknown'
    },
    currentText () {
      if (this.currentClass === 'warning') return 'check download'
      if (this.currentClass === 'queued') return 'queued'
      if (this.currentClass === 'paused') return 'paused'
      return 'unknown status'
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
div {
  &.img {
    height: 270px;
    width: 170px;
    background:
      url(/img/placeholder.jpg),
    rgb(36, 36, 36);
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    span {
      text-align: right;
      top: 0px;
      left: 0;
      right: 0;
      width: 100%;
      display: block;
      box-sizing: border-box;
      z-index: 1;
      text-transform: uppercase;
      letter-spacing: 1px;
      font-size: 12px;
      color: rgb(238, 238, 238);
      padding: 0;
      &.downloading,
      &.queued,
      &.paused {
        background-color: rgba(143, 44, 189, 0.8);
      }
      &.warning,
      &.unknown {
        background-color: rgba(190, 102, 44, 0.8);
      }
      &.downloading span:first-child {
        padding: 5px 10px 0;
      }
      &.downloading span:last-child {
        padding: 0 10px 5px;
      }
      &.queued span,
      &.paused span,
      &.warning span,
      &.unknown span {
        padding: 10px;
      }
    }
  }
  &.info {
    text-align: center;
    p {
      width: 160px;
      margin: 5px 0 5px 5px;
      overflow: hidden;
      white-space: nowrap;
      text-overflow: ellipsis;
    }
    .title {
      font-size: 12px;
      span {
        font-weight: 700;
        font-size: 14px;
      }
    }
    .name {
      font-size: 13px;
    }
  }
}
</style>
