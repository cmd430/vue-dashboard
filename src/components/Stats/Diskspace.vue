<template>
<li>
  <section>
    <div>
      <p>Total Diskspace: <span>{{ (diskspace ? diskspace.total.bytes : 0) | DataUnit() }}</span></p>
      <p>Free Diskspace:  <span>{{ (diskspace ? diskspace.free.bytes : 0) | DataUnit() }} ({{ (diskspace ? diskspace.free.percent : 0).toFixed(1) }}%)</span></p>
      <p>Used Diskspace:  <span>{{ (diskspace ? diskspace.used.bytes : 0) | DataUnit()}} ({{ (diskspace ? diskspace.used.percent : 0).toFixed(1) }}%)</span></p>
    </div>
  </section>
</li>
</template>

<script>
export default {
  name: 'diskspace',
  props: [
    'diskspace'
  ]
}
</script>
