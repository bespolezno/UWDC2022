import Vue from 'vue'

// axios
import axios from 'axios'

const axiosIns = axios.create({
  // You can add your headers here
  // ================================
  baseURL: 'https://z9fly4.comp.skill17.com/api/',
  // timeout: 1000,
  headers: {'Accept': 'application/json'}
})

Vue.prototype.$http = axiosIns

export default axiosIns
