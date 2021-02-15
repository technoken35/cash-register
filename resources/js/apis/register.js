const axios = window.axios;

export default axios.create({
    baseURL: "http://localhost:8000/api",
});
