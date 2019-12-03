<template>
  <div style="text-align: center;">
        <aDemo :nexmo="nexmo" :demoItem="demoItem" />
  </div>
</template>

<script>
import aDemo from "../demos/opentokDemo/opentokDemo";

export default {
  name: "OTDEMO",

  components: {
    aDemo
  },
  data() {
    return {
      msg: "OPENTOK DEMO",
      tab: 1,
      nexmo: {
        phone: "1408xxxxxxx",
        region: "US",
        tokbox_key: "xxxxxxx",
      },
      demoItem: {},
      isLoading: false,
    };
  }
};
</script>
<style>
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 6px;
}
</style>