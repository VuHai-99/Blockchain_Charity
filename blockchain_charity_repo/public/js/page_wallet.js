/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 6);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/pages/wallet/index.js":
/*!********************************************!*\
  !*** ./resources/js/pages/wallet/index.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var check = false;
  var otpUser;
  $('.fa-eye').on('click', function () {
    var input = $("input[name='private_key']");
    input.attr('type', 'password');
    $(this).hide();
    $('.fa-eye-slash').show();
  });
  $('#confirm-password').submit(function (e) {
    e.preventDefault();
    var password = $("input[name='password']").val();
    axios.post(laroute.route('api.verify.password', {
      'password': password
    })).then(function (response) {
      if (response.data.check == true) {
        $("input[name='password']").val('');
        axios.get(laroute.route('api.send.otp')).then(function (response) {
          otpUser = response.data.otp;
        });
        $('.fa-eye-slash').click();
        $('#control-modal-otp').click();
      } else {
        $('.error-password').html('Mật khẩu không chính xác');
      }
    });
  });
  $('#confirm-otp').submit(function (e) {
    e.preventDefault();
    var otp = $("input[name='otp']").val();

    if (otp != otpUser) {
      $('.error-otp').html("Mã OTP không chính xác.");
      setTimeout(function () {
        $('#control-modal-otp').click();
        $('.modal-backdrop').hide();
      }, 1000);
    } else {
      $("input[name='otp']").val('');
      $('#control-modal-otp').click();
      $('.modal-backdrop').hide();
      $("input[name='private_key']").attr('type', 'text');
      $('.fa-eye-slash').hide();
      $('.fa-eye').show();
      check = true;
    }
  });
});

/***/ }),

/***/ 6:
/*!**************************************************!*\
  !*** multi ./resources/js/pages/wallet/index.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! F:\xampp\htdocs\blockchain_charity_repo1\blockchain_charity_repo\resources\js\pages\wallet\index.js */"./resources/js/pages/wallet/index.js");


/***/ })

/******/ });