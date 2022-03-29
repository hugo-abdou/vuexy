<template>
    <b-card>
        <!-- form -->
        <validation-observer ref="formValidator" #default="{ invalid }">
            <b-form @submit.prevent="updatePassword">
                <b-row>
                    <!-- Current Password -->
                    <b-col md="6">
                        <validation-provider
                            #default="{ errors }"
                            name="Current Password"
                            vid="current_password"
                            rules="required"
                        >
                            <b-form-group
                                label="Current Password"
                                label-for="account-current-password"
                            >
                                <b-input-group
                                    class="input-group-merge"
                                    :class="errors.length > 0 ? 'is-invalid' : null"
                                >
                                    <b-form-input
                                        id="account-current-password"
                                        :class="errors.length > 0 ? 'is-invalid' : null"
                                        v-model="passwordValueOld"
                                        name="current_password"
                                        :type="passwordFieldTypeOld"
                                        placeholder="Current Password"
                                    />
                                    <b-input-group-append is-text>
                                        <feather-icon
                                            :icon="passwordToggleIconOld"
                                            class="cursor-pointer"
                                            @click="togglePasswordOld"
                                        />
                                    </b-input-group-append>
                                </b-input-group>
                                <small class="text-danger">{{ errors[0] }}</small>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <!--/ Current Password -->
                </b-row>
                <b-row>
                    <!-- new password -->
                    <b-col md="6">
                        <validation-provider
                            #default="{ errors }"
                            name="password"
                            vid="password"
                            rules="required"
                        >
                            <b-form-group
                                label-for="account-new-password"
                                label="New Password"
                            >
                                <b-input-group
                                    class="input-group-merge"
                                    :class="errors.length > 0 ? 'is-invalid' : null"
                                >
                                    <b-form-input
                                        :class="errors.length > 0 ? 'is-invalid' : null"
                                        id="account-new-password"
                                        v-model="newPasswordValue"
                                        :type="passwordFieldTypeNew"
                                        name="password"
                                        placeholder="New Password"
                                    />
                                    <b-input-group-append is-text>
                                        <feather-icon
                                            :icon="passwordToggleIconNew"
                                            class="cursor-pointer"
                                            @click="togglePasswordNew"
                                        />
                                    </b-input-group-append>
                                </b-input-group>
                                <small class="text-danger">{{ errors[0] }}</small>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <!--/ new password -->

                    <!-- retype password -->
                    <b-col md="6">
                        <validation-provider
                            #default="{ errors }"
                            name="Password Confirmation"
                            vid="password_confirmation"
                            rules="required|confirmed:password"
                        >
                            <b-form-group
                                label-for="password_confirmation"
                                label="Retype New Password"
                            >
                                <b-input-group
                                    class="input-group-merge"
                                    :class="errors.length > 0 ? 'is-invalid' : null"
                                >
                                    <b-form-input
                                        :class="errors.length > 0 ? 'is-invalid' : null"
                                        id="password_confirmation"
                                        v-model="RetypePassword"
                                        :type="passwordFieldTypeRetype"
                                        name="password_confirmation"
                                        placeholder="New Password"
                                    />
                                    <b-input-group-append is-text>
                                        <feather-icon
                                            :icon="passwordToggleIconRetype"
                                            class="cursor-pointer"
                                            @click="togglePasswordRetype"
                                        />
                                    </b-input-group-append>
                                </b-input-group>
                                <small class="text-danger">{{ errors[0] }}</small>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <!--/ retype password -->

                    <!-- buttons -->
                    <b-col cols="12">
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            variant="primary"
                            class="mt-1 mr-1"
                            :disabled="invalid"
                            type="submit"
                        >
                            Save changes
                        </b-button>
                        <b-button
                            v-ripple.400="'rgba(186, 191, 199, 0.15)'"
                            type="reset"
                            variant="outline-secondary"
                            class="mt-1"
                        >
                            Reset
                        </b-button>
                    </b-col>
                    <!--/ buttons -->
                </b-row>
            </b-form>
        </validation-observer>
    </b-card>
</template>

<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";
import { required } from "@validations";
import {
    BButton,
    BForm,
    BFormGroup,
    BFormInput,
    BRow,
    BCol,
    BCard,
    BInputGroup,
    BInputGroupAppend,
} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";
import axiosIns from "src/libs/axios";
import ToastificationContent from "src/@core/components/toastification/ToastificationContent.vue";

export default {
    components: {
        BButton,
        BForm,
        BFormGroup,
        BFormInput,
        BRow,
        BCol,
        BCard,
        BInputGroup,
        BInputGroupAppend,
        ValidationProvider,
        ValidationObserver,
    },
    directives: {
        Ripple,
    },
    data() {
        return {
            required,
            passwordValueOld: "",
            newPasswordValue: "",
            RetypePassword: "",
            passwordFieldTypeOld: "password",
            passwordFieldTypeNew: "password",
            passwordFieldTypeRetype: "password",
        };
    },
    computed: {
        passwordToggleIconOld() {
            return this.passwordFieldTypeOld === "password" ? "EyeIcon" : "EyeOffIcon";
        },
        passwordToggleIconNew() {
            return this.passwordFieldTypeNew === "password" ? "EyeIcon" : "EyeOffIcon";
        },
        passwordToggleIconRetype() {
            return this.passwordFieldTypeRetype === "password" ? "EyeIcon" : "EyeOffIcon";
        },
    },
    methods: {
        togglePasswordOld() {
            this.passwordFieldTypeOld =
                this.passwordFieldTypeOld === "password" ? "text" : "password";
        },
        togglePasswordNew() {
            this.passwordFieldTypeNew =
                this.passwordFieldTypeNew === "password" ? "text" : "password";
        },
        togglePasswordRetype() {
            this.passwordFieldTypeRetype =
                this.passwordFieldTypeRetype === "password" ? "text" : "password";
        },
        updatePassword() {
            this.$refs.formValidator.validate().then((success) => {
                axiosIns
                    .post("/auth/update?action=password", {
                        current_password: this.passwordValueOld,
                        password: this.newPasswordValue,
                        password_confirmation: this.RetypePassword,
                    })
                    .then((res) => {
                        this.$toast(
                            {
                                component: ToastificationContent,
                                position: "top-right",
                                props: {
                                    title: `Congratulations`,
                                    icon: "CoffeeIcon",
                                    variant: "success",
                                    text: `You are successfully changed your password`,
                                },
                            },
                            5000
                        );
                    })
                    .catch((error) => {
                        this.$refs.formValidator.setErrors(error.response.data.errors);
                    });
            });
        },
    },
};
</script>
