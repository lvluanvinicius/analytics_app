import axios from 'axios'

import { env } from '@/env'

axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

export const api = axios.create({
  baseURL: env.VITE_API_URL + 'api/analytics/',
  withCredentials: true,
  withXSRFToken: true,
})