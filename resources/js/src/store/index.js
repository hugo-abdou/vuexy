import Vue from 'vue'
import Vuex from 'vuex'

// Modules
import app from './app'
import auth from "./auth";
import authSettings from "./auth/authSettings";

import appConfig from "./app-config";
import verticalMenu from "./vertical-menu";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth,
        authSettings,
        app,
        appConfig,
        verticalMenu,
    },
    strict: process.env.DEV,
});
