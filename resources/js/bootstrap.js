import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
window.axios.defaults.headers.common["Content-Type"] = "application/json";
// axios.defaults.withCredentials = true;
// axios.defaults.withXSRFToken = true;

axios.interceptors.request.use((config) => {
    const token = localStorage.getItem("auth_token");
    config.headers.Authorization = `Bearer ${token}`;
    return config;
});
