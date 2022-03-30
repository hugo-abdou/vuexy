import axios from "axios";

export default class JwtService {
    // Will be used by this service for making API calls
    axiosIns = null;
    // jwtConfig <= Will be used by this service
    jwtConfig = {};

    responseErrorCallbacks = [];

    constructor(axiosIns, jwtOverrideConfig) {
        this.axiosIns = axiosIns;
        this.jwtConfig = { ...this.jwtConfig, ...jwtOverrideConfig };
        // Request Interceptor
        this.axiosIns.interceptors.request.use(
            (config) => {
                return config;
            },
            (error) => Promise.reject(error)
        );

        // Add request/response interceptor
        this.axiosIns.interceptors.response.use(
            (response) => response,
            (error) => {
                this.responseErrorCallbacks.forEach((cb) => {
                    if (typeof cb === "function") cb(error);
                });
                return Promise.reject(error);
            }
        );
    }

    login(...args) {
        return this.axiosIns.post(this.jwtConfig.loginEndpoint, ...args);
    }

    register(...args) {
        return this.axiosIns.post(this.jwtConfig.registerEndpoint, ...args);
    }

    logout(...args) {
        return this.axiosIns.post(this.jwtConfig.logoutEndpoint, ...args);
    }
    fetchAuth() {
        return this.axiosIns.get(this.jwtConfig.authEndpoint);
    }
    onResponseError(cb) {
        this.responseErrorCallbacks.push(cb);
    }
    confirmEmail() {
        this.axiosIns.post(this.jwtConfig.confirmEmailEndpoint);
    }
}
