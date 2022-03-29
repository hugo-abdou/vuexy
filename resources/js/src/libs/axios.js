import Vue from "vue";
import axios from "axios";
import { ref } from "@vue/composition-api";

const headers = {};
const axiosIns = axios.create({
    baseURL: "http://vuexy.test/api/",
    headers,
});

export const useForm = function (fields = {}) {
    const form = ref(new FormData());
    headers["Content-type"] = "multipart/form-data";
    for (const key in fields) {
        if (Object.hasOwnProperty.call(fields, key)) {
            form.value.append(key, fields[key]);
        }
    }
    function post(url, opt) {
        return axiosIns.post(url, form.value, opt);
    }
    return { post };
};

axiosIns.defaults.withCredentials = true;

Vue.prototype.$http = axiosIns;

export default axiosIns;
