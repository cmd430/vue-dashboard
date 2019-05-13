<template>
  <div class="missing">
    <h1>Missing Items</h1>
    <ul>
      <missing-item
        v-for="item in missing"
        :key="item.id"
        :missing="item"
      />
    </ul>
  </div>
</template>

<script>
import MissingItem from '@/components/Home/Missing/MissingItem'

export default {
  name: 'Missing',
  components: {
    'missing-item': MissingItem
  },
  data () {
    return {
      missing: null,
      update: null
    }
  },
  methods: {
    processMissing: function () {
      fetch('/php/Home/missing.php')
        .then(response => {
          if (response.status !== 200) {
            return []
          }
          return response.json()
        })
        .then(missing => {
          this.missing = missing
        })
        .catch(err => {
          console.error('[Missing]', err)
        })
    }
  },
  created () {
    this.processMissing()
  },
  mounted () {
    this.update = setInterval(() => {
      console.log('[Missing] Updating...')
      this.processMissing()
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
