<template>
    <div class="navbar-container d-flex content align-items-center">
        <!-- Nav Menu Toggler -->
        <ul class="nav navbar-nav d-xl-none">
            <li class="nav-item">
                <b-link class="nav-link" @click="toggleVerticalMenuActive">
                    <feather-icon icon="MenuIcon" size="21" />
                </b-link>
            </li>
        </ul>

        <!-- Left Col -->
        <div class="bookmark-wrapper align-items-center flex-grow-1 d-none d-lg-flex">
            <dark-Toggler class="d-none d-lg-block" />
        </div>

        <b-navbar-nav class="nav align-items-center ml-auto">
            <b-nav-item-dropdown
                right
                toggle-class="d-flex align-items-center dropdown-user-link"
                class="dropdown-user"
            >
                <template #button-content>
                    <div class="d-sm-flex d-none user-nav">
                        <p class="user-name font-weight-bolder mb-0">
                            {{ auth.fullName || "" }}
                        </p>
                        <span class="user-status">{{ auth.role || "" }}</span>
                    </div>
                    <b-avatar
                        size="40"
                        variant="light-primary"
                        :src="auth.avatar || ''"
                        class="badge-minimal"
                    />
                </template>

                <b-dropdown-item
                    :to="{ name: 'profile' }"
                    link-class="d-flex align-items-center"
                >
                    <feather-icon size="16" icon="UserIcon" class="mr-50" />
                    <span>Profile</span>
                </b-dropdown-item>
                <b-dropdown-item
                    :to="{ name: 'account-setting' }"
                    link-class="d-flex align-items-center"
                >
                    <feather-icon size="16" icon="SettingsIcon" class="mr-50" />
                    <span>Settings</span>
                </b-dropdown-item>

                <b-dropdown-divider />

                <b-dropdown-item @click="logout" link-class="d-flex align-items-center">
                    <feather-icon size="16" icon="LogOutIcon" class="mr-50" />
                    <span>Logout</span>
                </b-dropdown-item>
            </b-nav-item-dropdown>
        </b-navbar-nav>
    </div>
</template>

<script>
import {
    BLink,
    BNavbarNav,
    BNavItemDropdown,
    BDropdownItem,
    BDropdownDivider,
    BAvatar,
} from "bootstrap-vue";
import DarkToggler from "@core/layouts/components/app-navbar/components/DarkToggler.vue";
import useJwt from "@/auth/jwt/useJwt";
import { mapGetters } from "vuex";

export default {
    components: {
        BLink,
        BNavbarNav,
        BNavItemDropdown,
        BDropdownItem,
        BDropdownDivider,
        BAvatar,

        // Navbar Components
        DarkToggler,
    },
    props: {
        toggleVerticalMenuActive: {
            type: Function,
            default: () => {},
        },
    },
    computed: {
        ...mapGetters({ auth: "auth/auth" }),
    },
    methods: {
        logout() {
            useJwt.logout().then((response) => {
                // Redirect to login page
                this.$store.commit("auth/SET_AUTH", null);
                this.$router.push({ name: "auth-login" });
            });
        },
    },
};
</script>
