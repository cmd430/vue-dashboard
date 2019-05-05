<template>
  <div class="activity">
    <h1>Current Activity</h1>
    <ul>
      <activity-item
        v-for="item in activity"
        v-bind:key="item.id"
        v-bind:activity="item"
      />
    </ul>
  </div>
</template>

<script>
import ActivityItem from '@/components/Home/Activity/ActivityItem'

export default {
  name: 'Activity',
  components: {
    'activity-item': ActivityItem
  },
  methods: {
    processActivity: function () {
      fetch('/php/Home/activity.php')
      .then(response => {
        if (response.status !== 200) {
          return []
        }
        return response.json()
      })
      .then(activity => {
        this.activity = activity
      })
      .catch(err => {
        console.error('[Activity]', err)
      })
    }
  },
  data () {
    return {
      activity: null,
      update: null
    }
  },
  created () {
    this.processActivity()
  },
  mounted () {
    this.update = setInterval(() => {
      console.log('[Activity] Updating...')
      this.processActivity()
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
    width: 480px;
    height: 270px;
    position: relative;
    box-sizing: content-box;
  }
}

</style>
