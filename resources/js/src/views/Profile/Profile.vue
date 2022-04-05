<template>
    <div id="user-profile">
        <profile-header />
        <!-- profile info  -->
        <section id="profile-info">
            <b-row>
                <!-- about suggested page and twitter feed -->
                <b-col lg="3" cols="12" order="2" order-lg="1">
                    <profile-about />
                    <profile-suggested-pages />
                    <profile-twitter-feed />
                </b-col>
                <!--/ about suggested page and twitter feed -->

                <!-- post -->
                <b-col lg="6" cols="12" order="1" order-lg="2">
                    <profile-post />
                </b-col>
                <!-- post -->

                <!-- latest photos suggestion and polls -->
                <b-col lg="3" cols="12" order="3">
                    <profile-latest-photos />
                    <profile-suggestion />
                    <profile-polls />
                </b-col>
                <!--/ latest photos suggestion and polls -->

                <!-- load more  -->
                <b-col cols="12" order="4">
                    <profile-bottom />
                </b-col>
                <!--/ load more  -->
            </b-row>
        </section>
        <!--/ profile info  -->
    </div>
</template>

<script>
import { BRow, BCol } from "bootstrap-vue";

import ProfileHeader from "./ProfileHeader.vue";
import ProfileAbout from "./ProfileAbout.vue";
import ProfileSuggestedPages from "./ProfileSuggestedPages.vue";
import ProfileTwitterFeed from "./ProfileTwitterFeed.vue";
import ProfilePost from "./ProfilePost.vue";
import ProfileLatestPhotos from "./ProfileLatestPhotos.vue";
import ProfileSuggestion from "./ProfileSuggestion.vue";
import ProfilePolls from "./ProfilePolls.vue";
import profileBottom from "./profileBottom.vue";

import profileData from "./data.js";

/* eslint-disable global-require */
export default {
    components: {
        BRow,
        BCol,
        ProfileHeader,
        ProfileAbout,
        ProfileSuggestedPages,
        ProfileTwitterFeed,
        ProfilePost,
        ProfileLatestPhotos,
        ProfileSuggestion,
        ProfilePolls,
        profileBottom,
    },
    data() {
        return {
            profileData: profileData,
        };
    },
};
/* eslint-disable global-require */
</script>

<style lang="scss">
@import "~@core/scss/vue/pages/page-profile.scss";
</style>
