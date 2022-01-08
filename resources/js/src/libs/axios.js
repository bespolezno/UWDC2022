import Vue from 'vue'

// axios
import axios from 'axios'
import router from '../router';

const axiosIns = axios.create({
  // You can add your headers here
  // ================================
  baseURL: 'https://z9fly4.comp.skill17.com/api/',
  // timeout: 1000,
  headers: {'Accept': 'application/json'}
})

axiosIns.interceptors.request.use(config => {
  config.headers.Authorization = `Bearer ${localStorage.token}`

  return config;
}, error => Promise.reject(error));

axios.interceptors.response.use(response => response, error => {
  if (error.status === 401) router.push({ name: 'login' })

  return Promise.reject(error);
});


Vue.prototype.$http = axiosIns

export default axiosIns
