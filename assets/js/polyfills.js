/**
 * Array.prototype.includes polyfill.
 */
Array.prototype.includes || Object.defineProperty(Array.prototype, "includes", { value: function (r, e) { function t(r, e) { return r === e || "number" == typeof r && "number" == typeof e && isNaN(r) && isNaN(e) } if (null == this) throw new TypeError('"this" is null or not defined'); var n = Object(this), i = n.length >>> 0; if (0 === i) return !1; for (var o = 0 | e, u = Math.max(o >= 0 ? o : i - Math.abs(o), 0); i > u;) { if (t(n[u], r)) return !0; u++ } return !1 } });

/**
 * NodeList.prototype.forEach polyfill.
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/API/NodeList/forEach
 */
window.NodeList && !NodeList.prototype.forEach && (NodeList.prototype.forEach = Array.prototype.forEach);

/**
 * String.prototype.includes polyfill.
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/includes#Polyfill
 */
String.prototype.includes || (String.prototype.includes = function (t, r) { "use strict"; if (t instanceof RegExp) throw TypeError("first argument must not be a RegExp"); return void 0 === r && (r = 0), -1 !== this.indexOf(t, r) });