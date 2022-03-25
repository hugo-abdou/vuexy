import useJwt from "@core/auth/jwt/useJwt";
import axios from "@axios";

const { jwt } = useJwt(axios, {
    loginEndpoint: "/login",
    registerEndpoint: "/register",
    refreshEndpoint: "/refresh-token",
    logoutEndpoint: "/logout",
});
export default jwt;
