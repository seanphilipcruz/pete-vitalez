"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["Dashboard"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/ManagementSystem/AdminPanel/Index.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/ManagementSystem/AdminPanel/Index.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _store_types_dashboard__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../store/types/dashboard */ "./resources/js/store/types/dashboard.js");


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  metaInfo: function metaInfo() {
    return {
      title: 'Dashboard'
    };
  },
  methods: {
    getData: function getData() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var response;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.prev = 0;
                _context.next = 3;
                return _this.$store.dispatch(_store_types_dashboard__WEBPACK_IMPORTED_MODULE_1__.GET_DASHBOARD);

              case 3:
                response = _context.sent;
                _context.next = 9;
                break;

              case 6:
                _context.prev = 6;
                _context.t0 = _context["catch"](0);
                throw _context.t0;

              case 9:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, null, [[0, 6]]);
      }))();
    }
  },
  computed: {
    data: function data() {
      return this.$store.state.data;
    },
    sold: function sold() {
      return this.data.sold;
    },
    available: function available() {
      return this.data.available;
    },
    requests: function requests() {
      return this.data.requests;
    },
    pending: function pending() {
      return this.data.pending;
    },
    artworks_sold: function artworks_sold() {
      return this.data.artworks_sold;
    },
    most_visited: function most_visited() {
      return this.data.most_visited;
    },
    most_liked: function most_liked() {
      return this.data.most_liked;
    },
    unread: function unread() {
      return this.data.unread;
    },
    read: function read() {
      return this.data.read;
    }
  },
  created: function created() {
    var _this2 = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
        while (1) {
          switch (_context2.prev = _context2.next) {
            case 0:
              _context2.next = 2;
              return _this2.getData();

            case 2:
            case "end":
              return _context2.stop();
          }
        }
      }, _callee2);
    }))();
  }
});

/***/ }),

/***/ "./resources/js/pages/ManagementSystem/AdminPanel/Index.vue":
/*!******************************************************************!*\
  !*** ./resources/js/pages/ManagementSystem/AdminPanel/Index.vue ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_e956b0c8_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=e956b0c8&scoped=true& */ "./resources/js/pages/ManagementSystem/AdminPanel/Index.vue?vue&type=template&id=e956b0c8&scoped=true&");
/* harmony import */ var _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js& */ "./resources/js/pages/ManagementSystem/AdminPanel/Index.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Index_vue_vue_type_template_id_e956b0c8_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _Index_vue_vue_type_template_id_e956b0c8_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "e956b0c8",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/ManagementSystem/AdminPanel/Index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pages/ManagementSystem/AdminPanel/Index.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/pages/ManagementSystem/AdminPanel/Index.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/ManagementSystem/AdminPanel/Index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/ManagementSystem/AdminPanel/Index.vue?vue&type=template&id=e956b0c8&scoped=true&":
/*!*************************************************************************************************************!*\
  !*** ./resources/js/pages/ManagementSystem/AdminPanel/Index.vue?vue&type=template&id=e956b0c8&scoped=true& ***!
  \*************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_e956b0c8_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_e956b0c8_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_e956b0c8_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=template&id=e956b0c8&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/ManagementSystem/AdminPanel/Index.vue?vue&type=template&id=e956b0c8&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/ManagementSystem/AdminPanel/Index.vue?vue&type=template&id=e956b0c8&scoped=true&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/ManagementSystem/AdminPanel/Index.vue?vue&type=template&id=e956b0c8&scoped=true& ***!
  \****************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "container" }, [
    _c("div", { staticClass: "my-5" }, [
      _vm._m(0),
      _vm._v(" "),
      _c("div", { staticClass: "row mb-3" }, [
        _c(
          "div",
          { staticClass: "col fs-3 fw-bold text-center" },
          [
            _c("font-awesome-icon", {
              attrs: { icon: ["fas", "paint-brush"] },
            }),
            _vm._v("  Artworks Stats\n            "),
          ],
          1
        ),
      ]),
      _vm._v(" "),
      _c("hr", { staticClass: "my-3" }),
      _vm._v(" "),
      _c("div", { staticClass: "row mb-3" }, [
        _c("div", { staticClass: "col" }, [
          _c("div", { staticClass: "card" }, [
            _c("div", { staticClass: "card-body fs-4" }, [
              _c("div", { staticClass: "row" }, [
                _c("div", { staticClass: "col-md-6" }, [
                  _vm._v(
                    "\n                                Orders\n                            "
                  ),
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-6 text-end" }, [
                  _c("div", { staticClass: "btn-group" }, [
                    _c("button", { staticClass: "btn btn-outline-dark" }, [
                      _vm._v("Sold: " + _vm._s(_vm.sold)),
                    ]),
                    _vm._v(" "),
                    _c("button", { staticClass: "btn btn-outline-dark" }, [
                      _vm._v("Available: " + _vm._s(_vm.available)),
                    ]),
                  ]),
                ]),
              ]),
            ]),
          ]),
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col" }, [
          _c("div", { staticClass: "card" }, [
            _c("div", { staticClass: "card-body fs-4" }, [
              _c("div", { staticClass: "row" }, [
                _c("div", { staticClass: "col-md-6" }, [_vm._v("Requests")]),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-6 text-end" }, [
                  _c("div", { staticClass: "btn-group" }, [
                    _c("div", { staticClass: "btn btn-outline-dark" }, [
                      _vm._v(
                        "\n                                        Count: " +
                          _vm._s(_vm.requests) +
                          "\n                                    "
                      ),
                    ]),
                  ]),
                ]),
              ]),
            ]),
          ]),
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col" }, [
          _c("div", { staticClass: "card" }, [
            _c("div", { staticClass: "card-body fs-4" }, [
              _c("div", { staticClass: "row" }, [
                _c("div", { staticClass: "col-md-6" }, [
                  _vm._v(
                    "\n                                Artworks Sold\n                            "
                  ),
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-6 text-end" }, [
                  _c("div", { staticClass: "btn-group" }, [
                    _c("div", { staticClass: "btn btn-outline-dark" }, [
                      _vm._v(
                        "\n                                        Count: " +
                          _vm._s(_vm.artworks_sold) +
                          "\n                                    "
                      ),
                    ]),
                  ]),
                ]),
              ]),
            ]),
          ]),
        ]),
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row mb-3" }, [
        _c(
          "div",
          { staticClass: "col fs-3 fw-bold text-center" },
          [
            _c("font-awesome-icon", { attrs: { icon: ["fas", "newspaper"] } }),
            _vm._v("  Blogs/Articles Stats\n            "),
          ],
          1
        ),
      ]),
      _vm._v(" "),
      _c("hr", { staticClass: "my-3" }),
      _vm._v(" "),
      _c("div", { staticClass: "row mb-3" }, [
        _c("div", { staticClass: "col" }, [
          _c("div", { staticClass: "card" }, [
            _c("div", { staticClass: "card-body fs-4" }, [
              _c("div", { staticClass: "row" }, [
                _c("div", { staticClass: "col-md-6" }, [
                  _vm._v(
                    "\n                                Most Visited\n                            "
                  ),
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-6 text-end" }, [
                  _c(
                    "div",
                    { staticClass: "btn-group" },
                    [
                      _c(
                        "router-link",
                        {
                          staticClass: "btn btn-outline-dark",
                          attrs: {
                            to: {
                              name: "blog-view",
                              params: {
                                id: _vm.most_visited.id,
                                title: _vm.most_visited.title,
                              },
                            },
                          },
                        },
                        [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(_vm.most_visited.title) +
                              "\n                                    "
                          ),
                        ]
                      ),
                    ],
                    1
                  ),
                ]),
              ]),
            ]),
          ]),
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col" }, [
          _c("div", { staticClass: "card" }, [
            _c("div", { staticClass: "card-body fs-4" }, [
              _c("div", { staticClass: "row" }, [
                _c("div", { staticClass: "col-md-6" }, [
                  _vm._v(
                    "\n                                Most Liked\n                            "
                  ),
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-6 text-end" }, [
                  _c(
                    "div",
                    { staticClass: "btn-group" },
                    [
                      _c(
                        "router-link",
                        {
                          staticClass: "btn btn-outline-dark",
                          attrs: {
                            to: {
                              name: "blog-view",
                              params: {
                                id: _vm.most_liked.id,
                                title: _vm.most_liked.title,
                              },
                            },
                          },
                        },
                        [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(_vm.most_liked.title) +
                              "\n                                    "
                          ),
                        ]
                      ),
                    ],
                    1
                  ),
                ]),
              ]),
            ]),
          ]),
        ]),
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row mb-3" }, [
        _c(
          "div",
          { staticClass: "col fs-3 fw-bold text-center" },
          [
            _c("font-awesome-icon", { attrs: { icon: ["fas", "inbox"] } }),
            _vm._v("  Message\n            "),
          ],
          1
        ),
      ]),
      _vm._v(" "),
      _c("hr", { staticClass: "my-3" }),
      _vm._v(" "),
      _c("div", { staticClass: "row mb-3" }, [
        _c("div", { staticClass: "col" }, [
          _c("div", { staticClass: "card" }, [
            _c("div", { staticClass: "card-body fs-4" }, [
              _c("div", { staticClass: "row" }, [
                _c("div", { staticClass: "col-md-6" }, [
                  _vm._v(
                    "\n                                Unread\n                            "
                  ),
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-6 text-end" }, [
                  _c("div", { staticClass: "btn-group" }, [
                    _c("div", { staticClass: "btn btn-outline-dark" }, [
                      _vm._v(
                        "\n                                        " +
                          _vm._s(_vm.unread) +
                          "\n                                    "
                      ),
                    ]),
                  ]),
                ]),
              ]),
            ]),
          ]),
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col" }, [
          _c("div", { staticClass: "card" }, [
            _c("div", { staticClass: "card-body fs-4" }, [
              _c("div", { staticClass: "row" }, [
                _c("div", { staticClass: "col-md-6" }, [
                  _vm._v(
                    "\n                                Read\n                            "
                  ),
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-6 text-end" }, [
                  _c("div", { staticClass: "btn-group" }, [
                    _c("div", { staticClass: "btn btn-outline-dark" }, [
                      _vm._v(
                        "\n                                        " +
                          _vm._s(_vm.read) +
                          "\n                                    "
                      ),
                    ]),
                  ]),
                ]),
              ]),
            ]),
          ]),
        ]),
      ]),
    ]),
  ])
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "row mb-3" }, [
      _c("div", { staticClass: "col-12" }, [
        _c("div", { staticClass: "fs-3" }, [
          _vm._v(
            "\n                    Welcome to your dashboard\n                "
          ),
        ]),
      ]),
    ])
  },
]
render._withStripped = true



/***/ })

}]);