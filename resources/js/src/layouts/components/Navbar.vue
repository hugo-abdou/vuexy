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
            <b-nav-item-dropdown right toggle-class="d-flex align-items-center dropdown-user-link" class="dropdown-user">
                <template #button-content>
                    <div class="d-sm-flex d-none user-nav">
                        <p class="user-name font-weight-bolder mb-0">John Doe</p>
                        <span class="user-status">Admin</span>
                    </div>
                    <b-avatar size="40" variant="light-primary" badge :src="require('@/assets/images/avatars/13-small.png')" class="badge-minimal" badge-variant="success" />
                </template>

                <b-dropdown-item :to="{ name: 'profile' }" link-class="d-flex align-items-center">
                    <feather-icon size="16" icon="UserIcon" class="mr-50" />
                    <span>Profile</span>
                </b-dropdown-item>
                <b-dropdown-item :to="{ name: 'account-setting' }" link-class="d-flex align-items-center">
                    <feather-icon size="16" icon="BellIcon" class="mr-50" />
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
    BLink, BNavbarNav, BNavItemDropdown, BDropdownItem, BDropdownDivider, BAvatar,
} from 'bootstrap-vue'
import DarkToggler from '@core/layouts/components/app-navbar/components/DarkToggler.vue'
import useJwt from '@/auth/jwt/useJwt'
import { initialAbility } from '@/libs/acl/config'

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
            default: () => { },
        },
    },
    methods: {
        logout() {
            // Remove userData from localStorage
            // ? You just removed token from localStorage. If you like, you can also make API call to backend to blacklist used token
            localStorage.removeItem(useJwt.jwtConfig.storageTokenKeyName)
            localStorage.removeItem(useJwt.jwtConfig.storageRefreshTokenKeyName)

            // Remove userData from localStorage
            localStorage.removeItem('userData')

            // Reset ability
            // this.$ability.update(initialAbility)

            // Redirect to login page
            this.$router.push({ name: 'auth-login' })
        },
    },
}
</script>
