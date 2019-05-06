export default {
  install (Vue, options) {
    Vue.filter('DataUnit', function (value, speed = false) {
      let units
      let dataUnits = [
        'B',
        'KB',
        'MB',
        'GB',
        'TB',
        'PB',
        'EB'
      ]
      let speedUnits = [
        'bps',
        'kbps',
        'mbps',
        'gbps',
        'tbps',
        'pbps',
        'ebps'
      ]
      if (speed) {
        units = speedUnits
      } else {
        units = dataUnits
      }
      if (value < 0) {
        return 'Unknown'
      }
      let i = 0
      while (value >= 1024.0 && i < 6) {
        value /= 1024.0
        ++i
      }
      function UnitPrecision (sizeUnit) {
        if (sizeUnit <= 2) {
          return 1 // KiB, MiB
        } else if (sizeUnit === 3) {
          return 2 // GiB
        } else {
          // return 3 // TiB, PiB, EiB
          return 2
        }
      }
      let ret
      if (i === 0) {
        ret = value + ' ' + units[i]
      } else {
        let precision = UnitPrecision(i)
        let offset = Math.pow(10, precision)
        ret = (Math.floor(offset * value) / offset).toFixed(precision) + ' ' + units[i]
      }
      return ret
    })
    Vue.filter('HumanizedDuration', function (value) {
      let seconds = value / 1000
      let levels = [
        [Math.floor(seconds / 31536000), 'years'],
        [Math.floor((seconds % 31536000) / 86400), 'days'],
        [Math.floor(((seconds % 31536000) % 86400) / 3600), 'hours'],
        [Math.floor((((seconds % 31536000) % 86400) % 3600) / 60), 'minutes'],
        [(((seconds % 31536000) % 86400) % 3600) % 60, 'seconds']
      ]
      let returntext = ''
      for (let i = 0, max = (levels.length > 3 ? 3 : levels.length); i < max; i++) {
        if (levels[i][0] === 0) continue
        returntext += ' ' + levels[i][0] + ' ' + (levels[i][0] === 1 ? levels[i][1].substr(0, levels[i][1].length - 1) : levels[i][1])
      }
      return returntext.trim()
    })
    Vue.filter('MediaTime', function (value, forceHours = false) {
      let hours
      let minutes
      let seconds = value / 1000
      let result = ''
      hours = Math.floor(seconds / 3600)
      seconds -= hours * 3600
      if (hours || forceHours) {
        result = hours < 10 ? '0' + hours + ':' : hours + ':'
      }
      minutes = Math.floor(seconds / 60)
      seconds -= minutes * 60
      result += minutes < 10 ? '0' + minutes + ':' : minutes + ':'
      seconds = Math.floor(seconds % 60)
      result += seconds < 10 ? '0' + seconds : seconds
      return result
    })
  }
}
