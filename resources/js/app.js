require('./bootstrap');

// vue
import Vue from "vue";
import App from './components/App';

// router & store
import router from './router';
import store from './store';

// axios
import axios from "axios";

import VueMeta from "vue-meta";

// fontawesome
import { library } from "@fortawesome/fontawesome-svg-core";
import {
    faForward,
    faBackward,
    faCaretUp,
    faCaretDown,
    faPlus,
    faEdit,
    faTrash,
    faArrowLeft,
    faArrowCircleRight,
    faCheckCircle,
    faTimesCircle,
    faFilter,
    faSortUp,
    faSortDown,
    faSortAlphaUp,
    faSortAlphaDown,
    faSortNumericUp,
    faSortNumericDown,
    faSortAmountUp,
    faSortAmountDown,
    faPaperPlane,
    faUndoAlt,
    faWrench,
    faEnvelopeOpen,
    faPaintBrush,
    faNewspaper,
    faInbox,
    faThumbsUp
} from "@fortawesome/free-solid-svg-icons";
import { faFacebook, faTwitter, faInstagram, faLinkedinIn, faPinterest } from "@fortawesome/free-brands-svg-icons";
import { FontAwesomeIcon, FontAwesomeLayers, FontAwesomeLayersText } from "@fortawesome/vue-fontawesome";

library.add(
    faFacebook,
    faTwitter,
    faInstagram,
    faLinkedinIn,
    faPinterest,
    faForward,
    faBackward,
    faCaretUp,
    faCaretDown,
    faPlus,
    faEdit,
    faTrash,
    faArrowLeft,
    faArrowCircleRight,
    faCheckCircle,
    faTimesCircle,
    faFilter,
    faSortUp,
    faSortDown,
    faSortAlphaUp,
    faSortAlphaDown,
    faSortNumericUp,
    faSortNumericDown,
    faSortAmountUp,
    faSortAmountDown,
    faPaperPlane,
    faUndoAlt,
    faWrench,
    faEnvelopeOpen,
    faPaintBrush,
    faNewspaper,
    faInbox,
    faThumbsUp
);
Vue.component('font-awesome-icon', FontAwesomeIcon);
Vue.component('font-awesome-layers', FontAwesomeLayers);
Vue.component('font-awesome-layers-text', FontAwesomeLayersText);

// sweetalert2
import { toast, popup } from "./sweetalert";

// link sharing
import VueSocialSharing from "vue-social-sharing";
Vue.use(VueSocialSharing);

// Recaptcha
import { VueReCaptcha } from "vue-recaptcha-v3";
Vue.use(VueReCaptcha, { siteKey: process.env.MIX_RECAPTCHA_SITE_KEY });

window.Popup = popup;
window.Toast = toast;

window.fbAsyncInit = function() {
    FB.init({
        appId            : '613551129947536',
        autoLogAppEvents : true,
        xfbml            : true,
        version          : 'v12.0'
    });
};

Vue.prototype.$axios = axios;

Vue.use(VueMeta, {
    refreshOnceOnNavigation: true,
});

export default new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
});
