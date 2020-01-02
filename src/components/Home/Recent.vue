<template>
  <div class="recent">
    <h1>Recently Added</h1>
    <ul>
      <recent-item
        v-for="item in recent"
        :key="item.id"
        :recent="item"
      />
    </ul>
  </div>
</template>

<script>
import RecentItem from '@/components/Home/Recent/RecentItem'

export default {
  name: 'Recent',
  components: {
    'recent-item': RecentItem
  },
  data () {
    return {
      recent: null,
      update: null
    }
  },
  methods: {
    processRecent: function () {
      fetch(`/php/Home/recent.php?limit=${this.$store.state.cache.maxHomeItems}`)
        .then(response => {
          if (response.status !== 200) {
            return []
          }
          return response.json()
        })
        .then(recent => {
          this.recent = recent
        })
        .catch(err => {
          console.error('[Recent]', err)
        })
    }
  },
  created () {
    this.processRecent()
  },
  mounted () {
    this.update = setInterval(() => {
      console.log('[Recent] Updating...')
      this.processRecent()
    }, 10000)
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
