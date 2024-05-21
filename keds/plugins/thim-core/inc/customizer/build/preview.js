/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/postmessage/index.ts":
/*!**********************************!*\
  !*** ./src/postmessage/index.ts ***!
  \**********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ ThimPostMessageOutput; }
/* harmony export */ });
/* harmony import */ var _wordpress_hooks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/hooks */ "@wordpress/hooks");
/* harmony import */ var _wordpress_hooks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_hooks__WEBPACK_IMPORTED_MODULE_0__);

const thimPostMessage = {
  fields: {},
  styleTag: {
    add: function (id) {
      id = id.replace(/[^\w\s]/gi, '-');

      if (null === document.getElementById('thim-postmessage-' + id) || 'undefined' === typeof document.getElementById('thim-postmessage-' + id)) {
        jQuery('head').append('<style id="thim-customizer-postmessage-' + id + '"></style>');
      }
    },
    addData: function (id, styles) {
      id = id.replace('[', '-').replace(']', '');
      thimPostMessage.styleTag.add(id);
      jQuery('#thim-customizer-postmessage-' + id).text(styles);
    }
  },
  util: {
    processValue: function (output, value) {
      var self = this,
          settings = window.parent.wp.customize.get(),
          excluded = false;

      if ('object' === typeof value) {
        _.each(value, function (subValue, key) {
          value[key] = self.processValue(output, subValue);
        });

        return value;
      }

      output = _.defaults(output, {
        prefix: '',
        units: '',
        suffix: '',
        value_pattern: '$',
        pattern_replace: {},
        exclude: []
      });

      if (1 <= output.exclude.length) {
        _.each(output.exclude, function (exclusion) {
          if (value == exclusion) {
            excluded = true;
          }
        });
      }

      if (excluded) {
        return false;
      }

      value = output.value_pattern.replace(new RegExp('\\$', 'g'), value);

      _.each(output.pattern_replace, function (id, placeholder) {
        if (!_.isUndefined(settings[id])) {
          value = value.replace(placeholder, settings[id]);
        }
      });

      return output.prefix + value + output.units + output.suffix;
    },
    backgroundImageValue: function (url) {
      return -1 === url.indexOf('url(') ? 'url(' + url + ')' : url;
    }
  },
  css: {
    fromOutput: function (output, value, controlType) {
      var styles = '',
          mediaQuery = false,
          processedValue;

      try {
        value = JSON.parse(value);
      } catch (e) {}

      if (output.js_callback && 'function' === typeof window[output.js_callback]) {
        value = window[output.js_callback[0]](value, output.js_callback[1]);
      }

      styles = (0,_wordpress_hooks__WEBPACK_IMPORTED_MODULE_0__.applyFilters)('thimCustomizerPostMessageStylesOutput', styles, value, output, controlType);

      if ('' === styles) {
        switch (controlType) {
          case 'thim-multicolor':
          case 'thim-sortable':
            styles += output.element + '{';

            _.each(value, function (val, key) {
              if (output.choice && key !== output.choice) {
                return;
              }

              processedValue = thimPostMessage.util.processValue(output, val);

              if ('' === processedValue) {
                if ('background-color' === output.property) {
                  processedValue = 'unset';
                } else if ('background-image' === output.property) {
                  processedValue = 'none';
                }
              }

              var customProperty = controlType === 'thim-sortable' ? output.property + '-' + key : output.property;

              if (false !== processedValue) {
                styles += output.property ? customProperty + ":" + processedValue + ";" : key + ":" + processedValue + ";";
              }
            });

            styles += '}';
            break;

          default:
            if ('thim-image' === controlType) {
              value = !_.isUndefined(value.url) ? thimPostMessage.util.backgroundImageValue(value.url) : thimPostMessage.util.backgroundImageValue(value);
            }

            if (_.isObject(value)) {
              styles += output.element + '{';

              _.each(value, function (val, key) {
                var property;

                if (output.choice && key !== output.choice) {
                  return;
                }

                processedValue = thimPostMessage.util.processValue(output, val);
                property = output.property ? output.property : key;

                if ('' === processedValue) {
                  if ('background-color' === property) {
                    processedValue = 'unset';
                  } else if ('background-image' === property) {
                    processedValue = 'none';
                  }
                }

                if (false !== processedValue) {
                  styles += property + ':' + processedValue + ';';
                }
              });

              styles += '}';
            } else {
              processedValue = thimPostMessage.util.processValue(output, value);

              if ('' === processedValue) {
                if ('background-color' === output.property) {
                  processedValue = 'unset';
                } else if ('background-image' === output.property) {
                  processedValue = 'none';
                }
              }

              if (false !== processedValue) {
                styles += output.element + '{' + output.property + ':' + processedValue + ';}';
              }
            }

            break;
        }
      }

      if (output.media_query && 'string' === typeof output.media_query && !_.isEmpty(output.media_query)) {
        mediaQuery = output.media_query;

        if (-1 === mediaQuery.indexOf('@media')) {
          mediaQuery = '@media ' + mediaQuery;
        }
      }

      if (mediaQuery) {
        return mediaQuery + '{' + styles + '}';
      }

      return styles;
    }
  },
  html: {
    fromOutput: function (output, value) {
      if (output.js_callback && 'function' === typeof window[output.js_callback]) {
        value = window[output.js_callback[0]](value, output.js_callback[1]);
      }

      if (_.isObject(value) || _.isArray(value)) {
        if (!output.choice) {
          return;
        }

        _.each(value, function (val, key) {
          if (output.choice && key !== output.choice) {
            return;
          }

          value = val;
        });
      }

      value = thimPostMessage.util.processValue(output, value);

      if (output.attr) {
        jQuery(output.element).attr(output.attr, value);
      } else {
        jQuery(output.element).html(value);
      }
    }
  },
  toggleClass: {
    fromOutput: function (output, value) {
      if ('undefined' === typeof output.class || 'undefined' === typeof output.value) {
        return;
      }

      if (value === output.value && !jQuery(output.element).hasClass(output.class)) {
        jQuery(output.element).addClass(output.class);
      } else {
        jQuery(output.element).removeClass(output.class);
      }
    }
  }
};
function ThimPostMessageOutput() {
  let styles = '';

  _.each(thimPostMessageFields, function (field) {
    var fieldSetting = field.id;

    if ("option" === field.option_type && field.option_name && 0 !== fieldSetting.indexOf(field.option_name + '[')) {
      fieldSetting = field.option_name + "[" + fieldSetting + "]";
    }

    wp.customize(fieldSetting, function (value) {
      value.bind(function (newVal) {
        styles = '';

        _.each(field.js_vars, function (output) {
          output.function = !output.function || 'undefined' === typeof thimPostMessage[output.function] ? 'css' : output.function;
          field.type = field.choices && field.choices.parent_type ? field.choices.parent_type : field.type;

          if ('css' === output.function) {
            styles += thimPostMessage.css.fromOutput(output, newVal, field.type);
          } else {
            thimPostMessage[output.function].fromOutput(output, newVal, field.type);
          }
        });

        thimPostMessage.styleTag.addData(fieldSetting, styles);
      });
    });
  });
}
;

/***/ }),

/***/ "@wordpress/hooks":
/*!*******************************!*\
  !*** external ["wp","hooks"] ***!
  \*******************************/
/***/ (function(module) {

module.exports = window["wp"]["hooks"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
!function() {
/*!************************!*\
  !*** ./src/Preview.ts ***!
  \************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _postmessage__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./postmessage */ "./src/postmessage/index.ts");

jQuery(document).ready(function () {
  (0,_postmessage__WEBPACK_IMPORTED_MODULE_0__["default"])();
});
}();
/******/ })()
;
//# sourceMappingURL=preview.js.map