export default [
    {
        path: "/login",
        name: "auth-login",
        component: () => import("@/views/Login.vue"),
        meta: {
            layout: "full",
            redirectIfLoggedIn: true,
        },
    },
    {
        path: "/register",
        name: "auth-register",
        component: () => import("@/views/Register.vue"),
        meta: {
            layout: "full",
            redirectIfLoggedIn: true,
        },
    },
];
