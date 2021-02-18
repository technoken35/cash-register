const axios = window.axios;

export default axios.create({
    baseURL: "https://cash-register-app.herokuapp.com/api",
});
