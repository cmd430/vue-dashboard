<template>
<li>
  <section>
    <div>
      <p>Total Diskspace: <span>{{ friendlyUnit(diskspace.total) }}</span></p>
      <p>Free Diskspace:  <span>{{ friendlyUnit(diskspace.free) }} ({{ diskspace.free_percent.toFixed(1) }}%)</span></p>
      <p>Used Diskspace:  <span>{{ friendlyUnit(diskspace.used) }} ({{ diskspace.used_percent.toFixed(1) }}%)</span></p>
    </div>
  </section>
</li>
</template>

<script>
export default {
  name: 'diskspace',
  props: [
    'diskspace'
  ],
  methods: {
    friendlyUnit: function (value) {
      let units = [
        'B',
        'KB',
        'MB',
        'GB',
        'TB',
        'PB',
        'EB'
      ]
      if (value < 0) {
        return 'Unknown'
      }
      var i = 0
      while (value >= 1024.0 && i < 6) {
        value /= 1024.0
        ++i
      }
      function friendlyUnitPrecision (sizeUnit) {
        if (sizeUnit <= 2) {
          return 1 // KiB, MiB
        } else if (sizeUnit === 3) {
          return 2 // GiB
        } else {
          // return 3 // TiB, PiB, EiB
          return 2
        }
      }
      var ret
      if (i === 0) {
        ret = value + ' ' + units[i]
      } else {
        var precision = friendlyUnitPrecision(i)
        var offset = Math.pow(10, precision)
        ret = (Math.floor(offset * value) / offset).toFixed(precision) + ' ' + units[i]
      }
      return ret
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
li {
  display: inline-block;
  padding: 10px;
  position: relative;
  box-sizing: content-box;
}
p {
  display: table;
  font-size: 16px;
  user-select: none;
  color: rgb(238, 238, 238);
  text-align: left;
  margin: 0;
}
span {
  text-align: center;
  color: rgb(153, 153, 153);
}
section {
  height: 135px;
  min-width: 300px;
  margin-right: 20px;
  margin-bottom: 20px;
  display: inline-block;
  padding: 20px;
  position: relative;
  vertical-align: text-top;
}
section::before{
  content: '';
  background: rgba(0, 0, 0, 0.3);
  position: absolute;
  left: 0;
  top: 0px;
  height: 100%;
  width: 100%;
  border-radius: 4px;
}
div {
  position: relative;
}
</style>