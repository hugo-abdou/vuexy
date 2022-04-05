import axiosIns from "src/libs/axios";
import ToastificationContentVue from "src/@core/components/toastification/ToastificationContent.vue";

export default {
    namespaced: true,
    state: {
        header: {},
        userAbout: {},
        suggestedPages: [],
        twitterFeeds: [],
        posts: [],
        latestImages: [],
        suggestions: [],
        polls: [],
    },
    getters: {
        userAbout: ({ userAbout }) => userAbout,
        header: ({ header }) => header,
        latestImages: ({ latestImages }) => latestImages,
        polls: ({ polls }) => polls,
        posts: ({ posts }) => posts,
        suggestions: ({ suggestions }) => suggestions,
        suggestedPages: ({ suggestedPages }) => suggestedPages,
        twitterFeeds: ({ twitterFeeds }) => twitterFeeds,
    },
    mutations: {},
    actions: {
        async getProfileData(store, payload) {
            return new Promise((res, rej) => {
                axiosIns
                    .get(`/auth/profile?component=${payload}`)
                    .then((result) => {
                        store.state[payload] = result.data;
                        res(result);
                    })
                    .catch((error) => {
                        if (
                            error.response.status == 400 &&
                            error.response.data.message
                        ) {
                            this._vm.$toast({
                                component: ToastificationContentVue,
                                position: "top-right",
                                props: {
                                    title: error.response.statusText,
                                    icon: "AlertCircleIcon",
                                    variant: "danger",
                                    text: `${error.response.data.message} ( ${payload} )`,
                                },
                            });
                        }
                        return rej(error);
                    });
            });
        },
    },
};
