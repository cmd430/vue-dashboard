<template>
<li>
  <section>
    <div>
      <p>Total Used Bandwidth:  <span>{{ friendlyUnit(bandwidth.total) }}</span></p>
      <p>Current Local Bandwidth:  <span>{{ friendlyUnit(bandwidth.live.local, true) }}</span></p>
      <p>Current Remote Bandwidth: <span>{{ friendlyUnit(bandwidth.live.remote, true) }}</span></p>
    </div>
  </section>
</li>
</template>

<script>
export default {
  name: 'bandwidth',
  props: [
    'bandwidth'
  ],
  methods: {
    friendlyUnit: function (value, perSecond = false) {
      let units = [
        'B',
        'KB',
        'MB',
        'GB',
        'TB',
        'PB',
        'EB'
      ]
      if (perSecond) {
        value = (value * 8 == 24 ? 0 : value * 8)
        units = [
          'bps',
          'kbps',
          'mbps',
          'gbps',
          'tbps',
          'pbps',
          'ebps'
        ]
      }
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