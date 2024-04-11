// /resources/js/bootstrap.js
import 'bootstrap';

/*import * as jQuery from "jquery";
window.$ = jQuery;
window.jQuery = jQuery;*/

import moment from 'moment';
window.moment = moment;

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';