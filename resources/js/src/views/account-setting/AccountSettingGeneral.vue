<template>
    <b-card>
        <!-- media -->
        <b-media no-body>
            <b-media-aside>
                <b-link>
                    <b-img
                        ref="previewEl"
                        rounded
                        :src="generalData.avatar"
                        height="80"
                        width="80"
                    />
                </b-link>
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
                    <b-col sm="6">
                        <validation-provider
                            #default="{ errors }"
                            name="fullName"
                            vid="fullName"
                            rules="required"
                        >
                            <b-form-group label="fullName" label-for="fullName">
                                <b-form-input
                                    :state="errors.length == 0"
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
                                    :state="errors.length == 0"
                                    name="login-email"
                                    placeholder="john@example.com"
                                />
                                <small class="text-danger">{{ errors[0] }}</small>
                            </validation-provider>
                        </b-form-group>
                    </b-col>

                    <!-- alert -->
                    <b-col cols="12" class="mt-75">
                        <b-alert show variant="warning" class="mb-50">
                            <h4 class="alert-heading">
                                Your email is not confirmed. Please check your inbox.
                            </h4>
                            <div class="alert-body">
                                <b-link class="alert-link">Resend confirmation</b-link>
                            </div>
                        </b-alert>
                    </b-col>
                    <!--/ alert -->

                    <b-col cols="12">
                        <b-button
                            type="submit"
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            variant="primary"
                            class="mt-2 mr-1"
                            :disabled="invalid"
                            >Save changes{{ invalid }}</b-button
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
} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";
import { useInputImageRenderer } from "@core/comp-functions/forms/form-utils";
import { ref } from "@vue/composition-api";
import { useForm } from "src/libs/axios";
import ToastificationContent from "src/@core/components/toastification/ToastificationContent.vue";

export default {
    components: {
        ValidationObserver,
        ValidationProvider,
        BButton,
        BForm,
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
    },
    data: () => ({ required, email }),
    directives: {
        Ripple,
    },
    props: {
        generalData: {
            type: Object,
            default: () => {},
        },
    },
    setup(props) {
        const refInputEl = ref(null);
        const previewEl = ref(null);
        const formValidator = ref(null);
        const formData = ref({ ...props.generalData });
        const profileFile = null;

        function renderImg(result) {
            formData.value.avatar = refInputEl.value.files[0];
            previewEl.value.src = result;
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
                        this.$toast(
                            {
                                component: ToastificationContent,
                                position: "top-right",
                                props: {
                                    title: `Congratulations`,
                                    icon: "CoffeeIcon",
                                    variant: "success",
                                    text: `You are successfully changed your informations`,
                                },
                            },
                            5000
                        );
                        this.$store.dispatch("auth/updateAuth");
                    })
                    .catch((error) => {
                        this.$refs.formValidator.setErrors(error.response.data.errors);
                    });
            });
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
        };
    },
};
</script>
