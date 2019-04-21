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
