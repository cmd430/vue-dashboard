export default {
  install(Vue, options) {
    Vue.mixin({
      methods: {
        friendlyDataUnit: function (value, perSecond = false) {
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
            // Value is in Bytes so we need to multiply by 8
            // to get Bytes per Second
            value = value * 8
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
        },
        friendlyTimeUnit: function (seconds) {
          let levels = [
            [Math.floor(seconds / 31536000), 'years'],
            [Math.floor((seconds % 31536000) / 86400), 'days'],
            [Math.floor(((seconds % 31536000) % 86400) / 3600), 'hours'],
            [Math.floor((((seconds % 31536000) % 86400) % 3600) / 60), 'minutes'],
            [(((seconds % 31536000) % 86400) % 3600) % 60, 'seconds']
          ]
          let returntext = ''
          for (let i = 0, max = levels.length; i < max; i++) {
            if (levels[i][0] === 0) continue
            returntext += ' ' + levels[i][0] + ' ' + (levels[i][0] === 1 ? levels[i][1].substr(0, levels[i][1].length - 1) : levels[i][1])
          }
          return returntext.trim()
        }
      }
    })
  }
}
