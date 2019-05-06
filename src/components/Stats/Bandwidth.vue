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
