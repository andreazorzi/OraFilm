import './bootstrap';
import './main';

// Bootstrap
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

// jQuery
import $ from "jquery";
window.$ = $;

// Toastify
import Toastify from 'toastify-js'
window.Toastify = Toastify;

// Sweetalert
import Swal from 'sweetalert2';
window.Swal = Swal;

// Htmx.org
import htmx from "htmx.org";
window.htmx = htmx;
window.htmx.on("htmx:responseError", function (evt) {
    let error = evt.detail.xhr.responseText;
    
    try {
        error = JSON.parse(evt.detail.xhr.responseText).message;
    } catch (error) {}
    
    Toastify({
        text: error,
        escapeMarkup: false,
        duration: '-1',
        close: true,
        className: "danger",
        gravity: "bottom",
        position: "center"
    }).showToast();
    
    if(error == "CSRF token mismatch." || error == "Unauthenticated."){
        window.location.reload();
    }
});
htmx.defineExtension("ajax-header", {
  onEvent: function(name, evt) {
    if (name === "htmx:configRequest") {
      evt.detail.headers["X-Requested-With"] = "XMLHttpRequest";
    }
  }
});

// Selectize
import Selectize from "@selectize/selectize";
window.Selectize = Selectize;

// SelectSearch
import SelectSearch from "@andreazorzi/selectsearch";
window.SelectSearch = SelectSearch;

// AirDatepicker
import AirDatepicker from 'air-datepicker';
window.AirDatepicker = AirDatepicker;
import airdatepicker_it from 'air-datepicker/locale/it';
import airdatepicker_de from 'air-datepicker/locale/de';
import airdatepicker_fr from 'air-datepicker/locale/fr';
import airdatepicker_en from 'air-datepicker/locale/en';
window.airdatepicker_locales = {
    'it': airdatepicker_it.default,
    'de': airdatepicker_de.default,
    'fr': airdatepicker_fr.default,
    'en': airdatepicker_en.default
};
window.AirDatepicker.defaults.locale = airdatepicker_it;