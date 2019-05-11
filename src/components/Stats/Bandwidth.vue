<template>
<li>
  <section>
    <div>
      <p>Current Upload Rate:  <span>{{ (bandwidth ? bandwidth.total.live.upload : 0) | DataUnit(true) }}</span></p>
      <p>Current Download Rate: <span>{{ (bandwidth ? bandwidth.total.live.download : 0) | DataUnit(true) }}</span></p>
      <p>Total Data Used:  <span>{{ (bandwidth ? bandwidth.total.total : 0) | DataUnit() }}</span></p>
      <p>Total Data Uploaded:  <span>{{ (bandwidth ? bandwidth.total.upload : 0) | DataUnit() }}</span></p>
      <p>Total Data Downloaded:  <span>{{ (bandwidth ? bandwidth.total.download : 0) | DataUnit() }}</span></p>
    </div>
  </section>
</li>
</template>

<script>
export default {
  name: 'bandwidth',
  props: [
    'bandwidth'
  ]
}
</script>
