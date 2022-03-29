import axios from "@axios";
import JwtService from "./jwtService";

export default new JwtService(axios, {
    loginEndpoint: "/login",
    registerEndpoint: "/register",
    logoutEndpoint: "/logout",
    authEndpoint: "/auth",
});
