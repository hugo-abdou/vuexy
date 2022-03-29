<template>
    <div>
        <b-card title="Kick start your project 🚀">
            <b-card-text>All the best for your new project.</b-card-text>
            <b-card-text>
                Please make sure to read our
                <b-link href="https://pixinvent.com/demo/vuexy-vuejs-admin-dashboard-template/documentation/" target="_blank">Template Documentation</b-link>to understand where to go from here and how to use our template.
            </b-card-text>
        </b-card>
    </div>
</template>

<script>
import { BCard, BCardText, BLink } from 'bootstrap-vue'
import { BButton } from 'bootstrap-vue'
import useJwt from 'src/auth/jwt/useJwt'
import Ripple from 'vue-ripple-directive'

export default {
    components: {
        BCard,
        BCardText,
        BLink,
        BButton,
    },
    directives: {
        Ripple,
    },
}
</script>

<style>
</style>
