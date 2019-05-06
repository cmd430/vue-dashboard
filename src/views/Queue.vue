<template>
  <div class="queue">
    <h1>TV Download Queue</h1>
    <ul>
      <queue-item
        v-for="item in queue.series"
        :key="item.id"
        :queue="item"
      />
    </ul>
    <h1>Movie Download Queue</h1>
    <ul>
      <queue-item
        v-for="item in queue.movies"
        :key="item.id"
        :queue="item"
      />
    </ul>
  </div>
</template>

<script>
import QueueItem from '@/components/QueueItem'

export default {
  name: 'Queue',
  metaInfo: {
    title: 'Download Queue'
  },
  components: {
    'queue-item': QueueItem
  },
  methods: {
    processQueue: function () {
      fetch(`/php/queue.php`)
        .then(response => {
          if (response.status !== 200) {
            return []
          }
          return response.json()
        })
        .then(queue => {
          this.queue = queue
        })
        .catch(err => {
          console.error('[Queue]', err)
        })
    }
  },
  data () {
    return {
      queue: {
        series: null,
        movies: null
      },
      update: null
    }
  },
  created () {
    this.processQueue()
  },
  mounted () {
    this.update = setInterval(() => {
      console.log('[Queue] Updating...')
      this.processQueue()
    }, 30000)
  },
  beforeDestroy () {
    clearInterval(this.update)
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
ul {
  display: flex;
  flex-wrap: wrap;
  align-items: stretch;
  justify-content: flex-start;
  padding: 0 96px;
  list-style-type: none;
  &:empty::after {
    content: "Nothing to Show";
    width: 100%;
    font-size: 13px;
    color: rgb(153, 153, 153);
    text-align: center;
    padding: 15px;
    margin: 0 27px 0 11px;
    background: rgba(0, 0, 0, 0.1);
    border-radius: 4px;
  }
  &::v-deep li {
    display: inline-block;
    padding: 10px;
    box-sizing: border-box;
    width: 190px;
    height: 351px;
  }
}
</style>
