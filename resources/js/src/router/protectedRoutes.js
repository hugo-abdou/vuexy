let protectedRoutes = [
    {
        path: "/",
        name: "home",
        component: () => import("@/views/Home.vue"),
        meta: {
            pageTitle: "Home",
            breadcrumb: [
                {
                    text: "Home",
                    active: true,
                },
            ],
        },
    },
    {
        path: "/profile",
        name: "profile",
        component: () => import("@/views/Profile/Profile.vue"),
        meta: {
            pageTitle: "Profile",
        },
    },
    {
        path: "/account-setting",
        name: "account-setting",
        component: () => import("@/views/account-setting/AccountSetting.vue"),
        meta: {
            pageTitle: "Account Setting",
        },
    },
];

protectedRoutes = protectedRoutes.map((route) => {
    route.meta.redirectIfNotLoggedIn = true;
    return route;
});

export default protectedRoutes;
