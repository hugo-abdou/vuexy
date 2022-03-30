<template>
    <b-card>
        <!-- media -->
        <b-media no-body>
            <b-media-aside>
                <b-avatar
                    size="80"
                    rounded="sm"
                    variant="light-primary"
                    :src="generalData.avatar || ''"
                    class="badge-minimal"
                />

                <!--/ avatar -->
            </b-media-aside>

            <b-media-body class="mt-75 ml-75">
                <!-- upload button -->
                <b-button
                    v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                    variant="primary"
                    size="sm"
                    class="mb-75 mr-75"
                    @click="$refs.refInputEl.$el.click()"
                    >Upload</b-button
                >
                <b-form-file
                    ref="refInputEl"
                    v-model="profileFile"
                    accept=".jpg, .png, .gif"
                    :hidden="true"
                    plain
                    @input="inputImageRenderer"
                />
                <!--/ upload button -->

                <!-- reset -->
                <b-button
                    v-ripple.400="'rgba(186, 191, 199, 0.15)'"
                    variant="outline-secondary"
                    size="sm"
                    class="mb-75 mr-75"
                    @click="resetAvatar"
                    >Reset</b-button
                >
                <!--/ reset -->
                <b-card-text>Allowed JPG, GIF or PNG. Max size of 800kB</b-card-text>
            </b-media-body>
        </b-media>
        <!--/ media -->

        <!-- form -->
        <validation-observer ref="formValidator" #default="{ invalid }">
            <b-form class="mt-2" @submit.prevent="handelSubmit">
                <b-row>
                    <!-- alert -->
                    <b-col cols="12" class="mt-75" v-if="!generalData.emailConfirmed">
                        <b-alert show variant="warning" class="mb-50">
                            <h4 class="alert-heading">
                                Your email is not confirmed. Please check your inbox.
                            </h4>
                            <div class="alert-body">
                                <b-link
                                    @click.prevent="() => useJwt.confirmEmail()"
                                    class="alert-link"
                                    >Resend confirmation</b-link
                                >
                            </div>
                        </b-alert>
                    </b-col>
                    <!--/ alert -->
                    <b-col sm="6">
                        <validation-provider
                            #default="{ errors }"
                            name="fullName"
                            vid="fullName"
                            rules="required"
                        >
                            <b-form-group label="fullName" label-for="fullName">
                                <b-form-input
                                    :state="errors.length > 0 ? false : null"
                                    v-model="formData.fullName"
                                    name="fullName"
                                    placeholder="fullName"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col sm="6">
                        <b-form-group label="Email" label-for="login-email">
                            <validation-provider
                                #default="{ errors }"
                                name="Email"
                                vid="email"
                                rules="required|email"
                            >
                                <b-form-input
                                    id="login-email"
                                    v-model="formData.email"
                                    :state="errors.length > 0 ? false : null"
                                    name="login-email"
                                    placeholder="john@example.com"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>
                    <!-- bio -->
                    <b-col cols="12">
                        <validation-provider #default="{ errors }" name="Bio" vid="Bio">
                            <b-form-group label="Bio" label-for="bio-area">
                                <b-form-textarea
                                    id="bio-area"
                                    name="Bio"
                                    :state="errors.length > 0 ? false : null"
                                    v-model="formData.bio"
                                    rows="4"
                                    placeholder="Your bio data here..."
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <!--/ bio -->
                    <!-- birth date -->
                    <b-col md="6">
                        <validation-provider #default="{ errors }" name="date" vid="date">
                            <b-form-group
                                label-for="example-datepicker"
                                label="Birth date"
                            >
                                <flat-pickr
                                    :class="errors.length > 0 ? 'is-invalid' : null"
                                    v-model="formData.birth_date"
                                    class="form-control"
                                    name="date"
                                    placeholder="Birth date"
                                />

                                <small class="text-danger">{{ errors[0] }}</small>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <!--/ birth date -->
                    <!-- phone -->
                    <b-col md="6">
                        <validation-provider
                            #default="{ errors }"
                            name="Mobile"
                            vid="phone"
                        >
                            <b-form-group label="Mobile" label-for="phone">
                                <b-form-input
                                    :class="errors.length > 0 ? 'is-invalid' : null"
                                    id="phone"
                                    v-model="formData.phone"
                                    type="number"
                                    name="phone"
                                    placeholder="Mobile"
                                />

                                <small class="text-danger">{{ errors[0] }}</small>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <!-- phone -->
                    <!-- Country -->
                    <b-col md="6">
                        <validation-provider
                            #default="{ errors }"
                            name="country"
                            vid="country"
                        >
                            <b-form-group
                                label-for="country"
                                label="Country"
                                :class="errors.length > 0 ? 'is-invalid' : null"
                            >
                                <v-select
                                    id="country"
                                    name="country"
                                    v-model="formData.country"
                                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="countryOption"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <!--/ Country -->

                    <b-col cols="12">
                        <b-button
                            type="submit"
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            variant="primary"
                            class="mt-2 mr-1"
                            :disabled="invalid"
                            >Save changes</b-button
                        >
                        <b-button
                            v-ripple.400="'rgba(186, 191, 199, 0.15)'"
                            variant="outline-secondary"
                            type="reset"
                            class="mt-2"
                            @click.prevent="resetForm"
                            >Reset</b-button
                        >
                    </b-col>
                </b-row>
            </b-form>
        </validation-observer>
    </b-card>
</template>

<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";
import { required, email } from "@validations";
import flatPickr from "vue-flatpickr-component";

import {
    BFormFile,
    BButton,
    BForm,
    BFormGroup,
    BFormInput,
    BRow,
    BCol,
    BAlert,
    BCard,
    BCardText,
    BMedia,
    BMediaAside,
    BMediaBody,
    BLink,
    BImg,
    BAvatar,
    BFormTextarea,
    BInputGroup,
} from "bootstrap-vue";
import Cleave from "vue-cleave-component";

import Ripple from "vue-ripple-directive";
import { useInputImageRenderer } from "@core/comp-functions/forms/form-utils";
import { ref } from "@vue/composition-api";
import axiosIns, { useForm } from "src/libs/axios";
import ToastificationContent from "src/@core/components/toastification/ToastificationContent.vue";
import useJwt from "src/auth/jwt/useJwt";
import vSelect from "vue-select";

export default {
    components: {
        ValidationObserver,
        ValidationProvider,
        BButton,
        BForm,
        BFormTextarea,
        BImg,
        BFormFile,
        BFormGroup,
        BFormInput,
        BRow,
        BCol,
        BAlert,
        BCard,
        BCardText,
        BMedia,
        BMediaAside,
        BMediaBody,
        BLink,
        BAvatar,
        flatPickr,
        Cleave,
        vSelect,
        BInputGroup,
    },
    data: () => ({
        countryOption: ["USA", "India", "Canada"],
        required,
        email,
    }),
    directives: {
        Ripple,
    },
    props: {
        generalData: {
            type: Object,
            default: () => {},
        },
    },
    setup(props, { emit }) {
        const refInputEl = ref(null);
        const previewEl = ref(null);
        const formValidator = ref(null);
        const formData = ref({ ...props.generalData });
        const profileFile = null;

        function renderImg(result) {
            formData.value.avatar = refInputEl.value.files[0];
            props.generalData.avatar = result;
        }

        const { inputImageRenderer } = useInputImageRenderer(refInputEl, renderImg);

        function resetForm() {
            formData.value = props.generalData;
        }

        function handelSubmit() {
            const { post } = useForm(formData.value);
            formValidator.value.validate().then((success) => {
                post("auth/update?action=general")
                    .then((res) => {
                        emit("updated");
                    })
                    .catch((error) => {
                        error.response.status === 401 &&
                            this.$refs.formValidator.setErrors(
                                error.response.data.errors
                            );
                    });
            });
        }

        async function resetAvatar() {
            await axiosIns.post("/auth/update?action=reset_avatar");
            emit("updated");
        }

        return {
            resetForm,
            handelSubmit,
            refInputEl,
            previewEl,
            formData,
            profileFile,
            inputImageRenderer,
            formValidator,
            useJwt,
            resetAvatar,
        };
    },
};
</script>
