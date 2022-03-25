import Vue from "vue";

// axios
import axios from "axios";
const axiosIns = axios.create({
    baseURL: "http://vuexy.test/api/",
    // timeout: 1000,
    // headers: {'X-Custom-Header': 'foobar'}
});
axiosIns.defaults.withCredentials = true;

Vue.prototype.$http = axiosIns;

export default axiosIns;
