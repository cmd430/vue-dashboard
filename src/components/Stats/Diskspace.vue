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
