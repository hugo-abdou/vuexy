<template>
    <b-card>
        <!-- about -->
        <div
            v-for="(data, key, index) in aboutData"
            :key="data"
            :class="index ? 'mt-2' : ''"
            v-if="data"
        >
            <h5 class="text-capitalize mb-75">
                {{ key }}
            </h5>
            <b-card-text>
                {{ data }}
            </b-card-text>
        </div>
    </b-card>
</template>

<script>
import { BCard, BCardText } from "bootstrap-vue";
import { mapGetters } from "vuex";

export default {
    components: {
        BCard,
        BCardText,
    },

    computed: {
        ...mapGetters({ aboutData: "profile/userAbout" }),
    },
    async created() {
        this.$store.dispatch("profile/getProfileData", "userAbout");
    },
};
</script>
