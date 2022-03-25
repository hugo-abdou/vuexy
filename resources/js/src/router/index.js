import { isUserLoggedIn, getHomeRouteForLoggedInUser } from "@/auth/utils";
import { canNavigate } from "@/libs/acl/routeProtection";
import Vue from "vue";
import VueRouter from "vue-router";
import auth from "./auth";
import protectedRoutes from "./protectedRoutes";

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
    // if (!canNavigate(to)) {
    //     // Redirect to login if not logged in
    //     if (!isLoggedIn) return next({ name: "auth-login" });

    //     // If logged in => not authorized
    //     return next({ name: "misc-not-authorized" });
    // }

    // Redirect if logged in
    if (to.meta.redirectIfLoggedIn && isLoggedIn) {
        next(getHomeRouteForLoggedInUser("admin"));
    }
    // Redirect to login if not logged in
    if (to.meta.redirectIfNotLoggedIn && !isLoggedIn) {
        return next({ name: "auth-login" });
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
