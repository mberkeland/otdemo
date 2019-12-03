import Vue from "vue";
import harness from "./components/harness";
import VuePhoneNumberInput from "vue-phone-number-input";
import "vue-phone-number-input/dist/vue-phone-number-input.css";
import { parsePhoneNumberFromString } from "libphonenumber-js";

Vue.component("vue-phone-number-input", VuePhoneNumberInput);

new Vue({
  el: "#app",
  template: "<harness/>",
  components: { harness }
});
