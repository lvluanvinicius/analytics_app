import axios from "axios";

export const application = axios.create({
    baseURL: "/app",
});
