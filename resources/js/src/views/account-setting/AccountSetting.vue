<template>
    <b-tabs
        vertical
        content-class="col-12 col-md-9 mt-1 mt-md-0"
        pills
        nav-wrapper-class="col-md-3 col-12"
        nav-class="nav-left"
    >
        <!-- general tab -->
        <b-tab active>
            <!-- title -->
            <template #title>
                <feather-icon icon="UserIcon" size="18" class="mr-50" />
                <span class="font-weight-bold">General</span>
            </template>
            <account-setting-general
                @updated="updated"
                v-if="options.general"
                :general-data="options.general"
            />
        </b-tab>
        <!--/ general tab -->

        <!-- change password tab -->
        <b-tab>
            <!-- title -->
            <template #title>
                <feather-icon icon="LockIcon" size="18" class="mr-50" />
                <span class="font-weight-bold">Change Password</span>
            </template>

            <account-setting-password />
        </b-tab>
        <!--/ change password tab -->
    </b-tabs>
</template>

<script>
import { BTabs, BTab } from "bootstrap-vue";
import AccountSettingGeneral from "./AccountSettingGeneral.vue";
import AccountSettingPassword from "./AccountSettingPassword.vue";
import AccountSettingSocial from "./AccountSettingSocial.vue";
import AccountSettingNotification from "./AccountSettingNotification.vue";
import axiosIns from "src/libs/axios";
import ToastificationContent from "src/@core/components/toastification/ToastificationContent.vue";

export default {
    components: {
        BTabs,
        BTab,
        AccountSettingGeneral,
        AccountSettingPassword,
        AccountSettingSocial,
        AccountSettingNotification,
    },
    data() {
        return {
            options: {},
        };
    },
    created() {
        this.getDetails();
    },
    methods: {
        updated() {
            this.$toast({
                component: ToastificationContent,
                position: "top-right",
                props: {
                    title: `Congratulations`,
                    icon: "CoffeeIcon",
                    variant: "success",
                    text: `You are successfully changed your informations`,
                },
            });
            this.getDetails();
            this.$store.dispatch("auth/updateAuth");
        },
        getDetails() {
            axiosIns.get("auth/details").then((res) => {
                this.options = res.data;
            });
        },
    },
};
</script>
