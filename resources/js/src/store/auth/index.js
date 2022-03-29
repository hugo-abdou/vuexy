import useJwt from "@/auth/jwt/useJwt";
import { getAuthData, isUserLoggedIn } from "src/auth/utils";

export default {
    namespaced: true,
    state: {
        auth: null,
    },
    getters: {
        auth: (state) => state.auth,
    },
    mutations: {
        SET_AUTH(state, auth) {
            state.auth = auth;
            if (!auth) {
                localStorage.removeItem("auth");
                return;
            }
            localStorage.setItem("auth", JSON.stringify(auth));
        },
    },
    actions: {
        async fetchAuth(store) {
            if (isUserLoggedIn) {
                store.state.auth = getAuthData();
            }
        },
        async updateAuth(store) {
            const {
                data: { auth },
            } = await useJwt.fetchAuth();
            store.commit("SET_AUTH", auth);
        },
    },
};
