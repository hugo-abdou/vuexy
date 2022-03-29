import Vue from "vue";
import VueRouter from "vue-router";
import auth from "./auth";
import protectedRoutes from "./protectedRoutes";
import { isUserLoggedIn } from "src/auth/utils";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL,
    scrollBehavior() {
        return { x: 0, y: 0 };
    },
    routes: [
        ...auth,
        ...protectedRoutes,
        {
            path: "*",
            component: () => import("@/views/error/Error404.vue"),
            meta: {
                layout: "full",
            },
        },
    ],
});

router.beforeEach((to, _, next) => {
    const isLoggedIn = isUserLoggedIn();

    // redirect to home page if page needs authentication
    if (to.meta.redirectIfNotLoggedIn && !isLoggedIn) {
        return next({ name: "auth-login" });
    }

    // redirect to home page if user loggedIn
    if (to.meta.redirectIfLoggedIn && isLoggedIn) {
        return next({ name: "home" });
    }

    return next();
});

// ? For splash screen
// Remove afterEach hook if you are not using splash screen
router.afterEach(() => {
    // Remove initial loading
    const appLoading = document.getElementById("loading-bg");
    if (appLoading) {
        appLoading.style.display = "none";
    }
});

export default router;
