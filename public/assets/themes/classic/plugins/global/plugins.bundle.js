/*!
 * jQuery JavaScript Library v3.7.1
 * https://jquery.com/
 *
 * Copyright OpenJS Foundation and other contributors
 * Released under the MIT license
 * https://jquery.org/license
 *
 * Date: 2023-08-28T13:37Z
 */
! function(e, t) {
  "use strict";
  "object" == typeof module && "object" == typeof module.exports ? module.exports = e.document ? t(e, !0) : function(e) {
      if (!e.document) throw new Error("jQuery requires a window with a document");
      return t(e)
  } : t(e)
}("undefined" != typeof window ? window : this, (function(e, t) {
  "use strict";
  var n = [],
      i = Object.getPrototypeOf,
      r = n.slice,
      s = n.flat ? function(e) {
          return n.flat.call(e)
      } : function(e) {
          return n.concat.apply([], e)
      },
      a = n.push,
      o = n.indexOf,
      l = {},
      c = l.toString,
      u = l.hasOwnProperty,
      d = u.toString,
      h = d.call(Object),
      f = {},
      p = function(e) {
          return "function" == typeof e && "number" != typeof e.nodeType && "function" != typeof e.item
      },
      m = function(e) {
          return null != e && e === e.window
      },
      g = e.document,
      v = {
          type: !0,
          src: !0,
          nonce: !0,
          noModule: !0
      };

  function y(e, t, n) {
      var i, r, s = (n = n || g).createElement("script");
      if (s.text = e, t)
          for (i in v)(r = t[i] || t.getAttribute && t.getAttribute(i)) && s.setAttribute(i, r);
      n.head.appendChild(s).parentNode.removeChild(s)
  }

  function b(e) {
      return null == e ? e + "" : "object" == typeof e || "function" == typeof e ? l[c.call(e)] || "object" : typeof e
  }
  var x = "3.7.1",
      _ = /HTML$/i,
      w = function(e, t) {
          return new w.fn.init(e, t)
      };

  function k(e) {
      var t = !!e && "length" in e && e.length,
          n = b(e);
      return !p(e) && !m(e) && ("array" === n || 0 === t || "number" == typeof t && t > 0 && t - 1 in e)
  }

  function M(e, t) {
      return e.nodeName && e.nodeName.toLowerCase() === t.toLowerCase()
  }
  w.fn = w.prototype = {
      jquery: x,
      constructor: w,
      length: 0,
      toArray: function() {
          return r.call(this)
      },
      get: function(e) {
          return null == e ? r.call(this) : e < 0 ? this[e + this.length] : this[e]
      },
      pushStack: function(e) {
          var t = w.merge(this.constructor(), e);
          return t.prevObject = this, t
      },
      each: function(e) {
          return w.each(this, e)
      },
      map: function(e) {
          return this.pushStack(w.map(this, (function(t, n) {
              return e.call(t, n, t)
          })))
      },
      slice: function() {
          return this.pushStack(r.apply(this, arguments))
      },
      first: function() {
          return this.eq(0)
      },
      last: function() {
          return this.eq(-1)
      },
      even: function() {
          return this.pushStack(w.grep(this, (function(e, t) {
              return (t + 1) % 2
          })))
      },
      odd: function() {
          return this.pushStack(w.grep(this, (function(e, t) {
              return t % 2
          })))
      },
      eq: function(e) {
          var t = this.length,
              n = +e + (e < 0 ? t : 0);
          return this.pushStack(n >= 0 && n < t ? [this[n]] : [])
      },
      end: function() {
          return this.prevObject || this.constructor()
      },
      push: a,
      sort: n.sort,
      splice: n.splice
  }, w.extend = w.fn.extend = function() {
      var e, t, n, i, r, s, a = arguments[0] || {},
          o = 1,
          l = arguments.length,
          c = !1;
      for ("boolean" == typeof a && (c = a, a = arguments[o] || {}, o++), "object" == typeof a || p(a) || (a = {}), o === l && (a = this, o--); o < l; o++)
          if (null != (e = arguments[o]))
              for (t in e) i = e[t], "__proto__" !== t && a !== i && (c && i && (w.isPlainObject(i) || (r = Array.isArray(i))) ? (n = a[t], s = r && !Array.isArray(n) ? [] : r || w.isPlainObject(n) ? n : {}, r = !1, a[t] = w.extend(c, s, i)) : void 0 !== i && (a[t] = i));
      return a
  }, w.extend({
      expando: "jQuery" + (x + Math.random()).replace(/\D/g, ""),
      isReady: !0,
      error: function(e) {
          throw new Error(e)
      },
      noop: function() {},
      isPlainObject: function(e) {
          var t, n;
          return !(!e || "[object Object]" !== c.call(e)) && (!(t = i(e)) || "function" == typeof(n = u.call(t, "constructor") && t.constructor) && d.call(n) === h)
      },
      isEmptyObject: function(e) {
          var t;
          for (t in e) return !1;
          return !0
      },
      globalEval: function(e, t, n) {
          y(e, {
              nonce: t && t.nonce
          }, n)
      },
      each: function(e, t) {
          var n, i = 0;
          if (k(e))
              for (n = e.length; i < n && !1 !== t.call(e[i], i, e[i]); i++);
          else
              for (i in e)
                  if (!1 === t.call(e[i], i, e[i])) break;
          return e
      },
      text: function(e) {
          var t, n = "",
              i = 0,
              r = e.nodeType;
          if (!r)
              for (; t = e[i++];) n += w.text(t);
          return 1 === r || 11 === r ? e.textContent : 9 === r ? e.documentElement.textContent : 3 === r || 4 === r ? e.nodeValue : n
      },
      makeArray: function(e, t) {
          var n = t || [];
          return null != e && (k(Object(e)) ? w.merge(n, "string" == typeof e ? [e] : e) : a.call(n, e)), n
      },
      inArray: function(e, t, n) {
          return null == t ? -1 : o.call(t, e, n)
      },
      isXMLDoc: function(e) {
          var t = e && e.namespaceURI,
              n = e && (e.ownerDocument || e).documentElement;
          return !_.test(t || n && n.nodeName || "HTML")
      },
      merge: function(e, t) {
          for (var n = +t.length, i = 0, r = e.length; i < n; i++) e[r++] = t[i];
          return e.length = r, e
      },
      grep: function(e, t, n) {
          for (var i = [], r = 0, s = e.length, a = !n; r < s; r++) !t(e[r], r) !== a && i.push(e[r]);
          return i
      },
      map: function(e, t, n) {
          var i, r, a = 0,
              o = [];
          if (k(e))
              for (i = e.length; a < i; a++) null != (r = t(e[a], a, n)) && o.push(r);
          else
              for (a in e) null != (r = t(e[a], a, n)) && o.push(r);
          return s(o)
      },
      guid: 1,
      support: f
  }), "function" == typeof Symbol && (w.fn[Symbol.iterator] = n[Symbol.iterator]), w.each("Boolean Number String Function Array Date RegExp Object Error Symbol".split(" "), (function(e, t) {
      l["[object " + t + "]"] = t.toLowerCase()
  }));
  var S = n.pop,
      A = n.sort,
      L = n.splice,
      T = "[\\x20\\t\\r\\n\\f]",
      C = new RegExp("^" + T + "+|((?:^|[^\\\\])(?:\\\\.)*)" + T + "+$", "g");
  w.contains = function(e, t) {
      var n = t && t.parentNode;
      return e === n || !(!n || 1 !== n.nodeType || !(e.contains ? e.contains(n) : e.compareDocumentPosition && 16 & e.compareDocumentPosition(n)))
  };
  var D = /([\0-\x1f\x7f]|^-?\d)|^-$|[^\x80-\uFFFF\w-]/g;

  function E(e, t) {
      return t ? "\0" === e ? "�" : e.slice(0, -1) + "\\" + e.charCodeAt(e.length - 1).toString(16) + " " : "\\" + e
  }
  w.escapeSelector = function(e) {
      return (e + "").replace(D, E)
  };
  var O = g,
      P = a;
  ! function() {
      var t, i, s, a, l, c, d, h, p, m, g = P,
          v = w.expando,
          y = 0,
          b = 0,
          x = ee(),
          _ = ee(),
          k = ee(),
          D = ee(),
          E = function(e, t) {
              return e === t && (l = !0), 0
          },
          Y = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",
          I = "(?:\\\\[\\da-fA-F]{1,6}" + T + "?|\\\\[^\\r\\n\\f]|[\\w-]|[^\0-\\x7f])+",
          N = "\\[" + T + "*(" + I + ")(?:" + T + "*([*^$|!~]?=)" + T + "*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" + I + "))|)" + T + "*\\]",
          H = ":(" + I + ")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|" + N + ")*)|.*)\\)|)",
          j = new RegExp(T + "+", "g"),
          F = new RegExp("^" + T + "*," + T + "*"),
          R = new RegExp("^" + T + "*([>+~]|" + T + ")" + T + "*"),
          z = new RegExp(T + "|>"),
          B = new RegExp(H),
          V = new RegExp("^" + I + "$"),
          W = {
              ID: new RegExp("^#(" + I + ")"),
              CLASS: new RegExp("^\\.(" + I + ")"),
              TAG: new RegExp("^(" + I + "|[*])"),
              ATTR: new RegExp("^" + N),
              PSEUDO: new RegExp("^" + H),
              CHILD: new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + T + "*(even|odd|(([+-]|)(\\d*)n|)" + T + "*(?:([+-]|)" + T + "*(\\d+)|))" + T + "*\\)|)", "i"),
              bool: new RegExp("^(?:" + Y + ")$", "i"),
              needsContext: new RegExp("^" + T + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + T + "*((?:-\\d)?\\d*)" + T + "*\\)|)(?=[^-]|$)", "i")
          },
          q = /^(?:input|select|textarea|button)$/i,
          U = /^h\d$/i,
          $ = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,
          X = /[+~]/,
          G = new RegExp("\\\\[\\da-fA-F]{1,6}" + T + "?|\\\\([^\\r\\n\\f])", "g"),
          Z = function(e, t) {
              var n = "0x" + e.slice(1) - 65536;
              return t || (n < 0 ? String.fromCharCode(n + 65536) : String.fromCharCode(n >> 10 | 55296, 1023 & n | 56320))
          },
          K = function() {
              le()
          },
          J = he((function(e) {
              return !0 === e.disabled && M(e, "fieldset")
          }), {
              dir: "parentNode",
              next: "legend"
          });
      try {
          g.apply(n = r.call(O.childNodes), O.childNodes), n[O.childNodes.length].nodeType
      } catch (e) {
          g = {
              apply: function(e, t) {
                  P.apply(e, r.call(t))
              },
              call: function(e) {
                  P.apply(e, r.call(arguments, 1))
              }
          }
      }

      function Q(e, t, n, i) {
          var r, s, a, o, l, u, d, m = t && t.ownerDocument,
              y = t ? t.nodeType : 9;
          if (n = n || [], "string" != typeof e || !e || 1 !== y && 9 !== y && 11 !== y) return n;
          if (!i && (le(t), t = t || c, h)) {
              if (11 !== y && (l = $.exec(e)))
                  if (r = l[1]) {
                      if (9 === y) {
                          if (!(a = t.getElementById(r))) return n;
                          if (a.id === r) return g.call(n, a), n
                      } else if (m && (a = m.getElementById(r)) && Q.contains(t, a) && a.id === r) return g.call(n, a), n
                  } else {
                      if (l[2]) return g.apply(n, t.getElementsByTagName(e)), n;
                      if ((r = l[3]) && t.getElementsByClassName) return g.apply(n, t.getElementsByClassName(r)), n
                  }
              if (!(D[e + " "] || p && p.test(e))) {
                  if (d = e, m = t, 1 === y && (z.test(e) || R.test(e))) {
                      for ((m = X.test(e) && oe(t.parentNode) || t) == t && f.scope || ((o = t.getAttribute("id")) ? o = w.escapeSelector(o) : t.setAttribute("id", o = v)), s = (u = ue(e)).length; s--;) u[s] = (o ? "#" + o : ":scope") + " " + de(u[s]);
                      d = u.join(",")
                  }
                  try {
                      return g.apply(n, m.querySelectorAll(d)), n
                  } catch (t) {
                      D(e, !0)
                  } finally {
                      o === v && t.removeAttribute("id")
                  }
              }
          }
          return ye(e.replace(C, "$1"), t, n, i)
      }

      function ee() {
          var e = [];
          return function t(n, r) {
              return e.push(n + " ") > i.cacheLength && delete t[e.shift()], t[n + " "] = r
          }
      }

      function te(e) {
          return e[v] = !0, e
      }

      function ne(e) {
          var t = c.createElement("fieldset");
          try {
              return !!e(t)
          } catch (e) {
              return !1
          } finally {
              t.parentNode && t.parentNode.removeChild(t), t = null
          }
      }

      function ie(e) {
          return function(t) {
              return M(t, "input") && t.type === e
          }
      }

      function re(e) {
          return function(t) {
              return (M(t, "input") || M(t, "button")) && t.type === e
          }
      }

      function se(e) {
          return function(t) {
              return "form" in t ? t.parentNode && !1 === t.disabled ? "label" in t ? "label" in t.parentNode ? t.parentNode.disabled === e : t.disabled === e : t.isDisabled === e || t.isDisabled !== !e && J(t) === e : t.disabled === e : "label" in t && t.disabled === e
          }
      }

      function ae(e) {
          return te((function(t) {
              return t = +t, te((function(n, i) {
                  for (var r, s = e([], n.length, t), a = s.length; a--;) n[r = s[a]] && (n[r] = !(i[r] = n[r]))
              }))
          }))
      }

      function oe(e) {
          return e && void 0 !== e.getElementsByTagName && e
      }

      function le(e) {
          var t, n = e ? e.ownerDocument || e : O;
          return n != c && 9 === n.nodeType && n.documentElement ? (d = (c = n).documentElement, h = !w.isXMLDoc(c), m = d.matches || d.webkitMatchesSelector || d.msMatchesSelector, d.msMatchesSelector && O != c && (t = c.defaultView) && t.top !== t && t.addEventListener("unload", K), f.getById = ne((function(e) {
              return d.appendChild(e).id = w.expando, !c.getElementsByName || !c.getElementsByName(w.expando).length
          })), f.disconnectedMatch = ne((function(e) {
              return m.call(e, "*")
          })), f.scope = ne((function() {
              return c.querySelectorAll(":scope")
          })), f.cssHas = ne((function() {
              try {
                  return c.querySelector(":has(*,:jqfake)"), !1
              } catch (e) {
                  return !0
              }
          })), f.getById ? (i.filter.ID = function(e) {
              var t = e.replace(G, Z);
              return function(e) {
                  return e.getAttribute("id") === t
              }
          }, i.find.ID = function(e, t) {
              if (void 0 !== t.getElementById && h) {
                  var n = t.getElementById(e);
                  return n ? [n] : []
              }
          }) : (i.filter.ID = function(e) {
              var t = e.replace(G, Z);
              return function(e) {
                  var n = void 0 !== e.getAttributeNode && e.getAttributeNode("id");
                  return n && n.value === t
              }
          }, i.find.ID = function(e, t) {
              if (void 0 !== t.getElementById && h) {
                  var n, i, r, s = t.getElementById(e);
                  if (s) {
                      if ((n = s.getAttributeNode("id")) && n.value === e) return [s];
                      for (r = t.getElementsByName(e), i = 0; s = r[i++];)
                          if ((n = s.getAttributeNode("id")) && n.value === e) return [s]
                  }
                  return []
              }
          }), i.find.TAG = function(e, t) {
              return void 0 !== t.getElementsByTagName ? t.getElementsByTagName(e) : t.querySelectorAll(e)
          }, i.find.CLASS = function(e, t) {
              if (void 0 !== t.getElementsByClassName && h) return t.getElementsByClassName(e)
          }, p = [], ne((function(e) {
              var t;
              d.appendChild(e).innerHTML = "<a id='" + v + "' href='' disabled='disabled'></a><select id='" + v + "-\r\\' disabled='disabled'><option selected=''></option></select>", e.querySelectorAll("[selected]").length || p.push("\\[" + T + "*(?:value|" + Y + ")"), e.querySelectorAll("[id~=" + v + "-]").length || p.push("~="), e.querySelectorAll("a#" + v + "+*").length || p.push(".#.+[+~]"), e.querySelectorAll(":checked").length || p.push(":checked"), (t = c.createElement("input")).setAttribute("type", "hidden"), e.appendChild(t).setAttribute("name", "D"), d.appendChild(e).disabled = !0, 2 !== e.querySelectorAll(":disabled").length && p.push(":enabled", ":disabled"), (t = c.createElement("input")).setAttribute("name", ""), e.appendChild(t), e.querySelectorAll("[name='']").length || p.push("\\[" + T + "*name" + T + "*=" + T + "*(?:''|\"\")")
          })), f.cssHas || p.push(":has"), p = p.length && new RegExp(p.join("|")), E = function(e, t) {
              if (e === t) return l = !0, 0;
              var n = !e.compareDocumentPosition - !t.compareDocumentPosition;
              return n || (1 & (n = (e.ownerDocument || e) == (t.ownerDocument || t) ? e.compareDocumentPosition(t) : 1) || !f.sortDetached && t.compareDocumentPosition(e) === n ? e === c || e.ownerDocument == O && Q.contains(O, e) ? -1 : t === c || t.ownerDocument == O && Q.contains(O, t) ? 1 : a ? o.call(a, e) - o.call(a, t) : 0 : 4 & n ? -1 : 1)
          }, c) : c
      }
      for (t in Q.matches = function(e, t) {
              return Q(e, null, null, t)
          }, Q.matchesSelector = function(e, t) {
              if (le(e), h && !D[t + " "] && (!p || !p.test(t))) try {
                  var n = m.call(e, t);
                  if (n || f.disconnectedMatch || e.document && 11 !== e.document.nodeType) return n
              } catch (e) {
                  D(t, !0)
              }
              return Q(t, c, null, [e]).length > 0
          }, Q.contains = function(e, t) {
              return (e.ownerDocument || e) != c && le(e), w.contains(e, t)
          }, Q.attr = function(e, t) {
              (e.ownerDocument || e) != c && le(e);
              var n = i.attrHandle[t.toLowerCase()],
                  r = n && u.call(i.attrHandle, t.toLowerCase()) ? n(e, t, !h) : void 0;
              return void 0 !== r ? r : e.getAttribute(t)
          }, Q.error = function(e) {
              throw new Error("Syntax error, unrecognized expression: " + e)
          }, w.uniqueSort = function(e) {
              var t, n = [],
                  i = 0,
                  s = 0;
              if (l = !f.sortStable, a = !f.sortStable && r.call(e, 0), A.call(e, E), l) {
                  for (; t = e[s++];) t === e[s] && (i = n.push(s));
                  for (; i--;) L.call(e, n[i], 1)
              }
              return a = null, e
          }, w.fn.uniqueSort = function() {
              return this.pushStack(w.uniqueSort(r.apply(this)))
          }, i = w.expr = {
              cacheLength: 50,
              createPseudo: te,
              match: W,
              attrHandle: {},
              find: {},
              relative: {
                  ">": {
                      dir: "parentNode",
                      first: !0
                  },
                  " ": {
                      dir: "parentNode"
                  },
                  "+": {
                      dir: "previousSibling",
                      first: !0
                  },
                  "~": {
                      dir: "previousSibling"
                  }
              },
              preFilter: {
                  ATTR: function(e) {
                      return e[1] = e[1].replace(G, Z), e[3] = (e[3] || e[4] || e[5] || "").replace(G, Z), "~=" === e[2] && (e[3] = " " + e[3] + " "), e.slice(0, 4)
                  },
                  CHILD: function(e) {
                      return e[1] = e[1].toLowerCase(), "nth" === e[1].slice(0, 3) ? (e[3] || Q.error(e[0]), e[4] = +(e[4] ? e[5] + (e[6] || 1) : 2 * ("even" === e[3] || "odd" === e[3])), e[5] = +(e[7] + e[8] || "odd" === e[3])) : e[3] && Q.error(e[0]), e
                  },
                  PSEUDO: function(e) {
                      var t, n = !e[6] && e[2];
                      return W.CHILD.test(e[0]) ? null : (e[3] ? e[2] = e[4] || e[5] || "" : n && B.test(n) && (t = ue(n, !0)) && (t = n.indexOf(")", n.length - t) - n.length) && (e[0] = e[0].slice(0, t), e[2] = n.slice(0, t)), e.slice(0, 3))
                  }
              },
              filter: {
                  TAG: function(e) {
                      var t = e.replace(G, Z).toLowerCase();
                      return "*" === e ? function() {
                          return !0
                      } : function(e) {
                          return M(e, t)
                      }
                  },
                  CLASS: function(e) {
                      var t = x[e + " "];
                      return t || (t = new RegExp("(^|" + T + ")" + e + "(" + T + "|$)")) && x(e, (function(e) {
                          return t.test("string" == typeof e.className && e.className || void 0 !== e.getAttribute && e.getAttribute("class") || "")
                      }))
                  },
                  ATTR: function(e, t, n) {
                      return function(i) {
                          var r = Q.attr(i, e);
                          return null == r ? "!=" === t : !t || (r += "", "=" === t ? r === n : "!=" === t ? r !== n : "^=" === t ? n && 0 === r.indexOf(n) : "*=" === t ? n && r.indexOf(n) > -1 : "$=" === t ? n && r.slice(-n.length) === n : "~=" === t ? (" " + r.replace(j, " ") + " ").indexOf(n) > -1 : "|=" === t && (r === n || r.slice(0, n.length + 1) === n + "-"))
                      }
                  },
                  CHILD: function(e, t, n, i, r) {
                      var s = "nth" !== e.slice(0, 3),
                          a = "last" !== e.slice(-4),
                          o = "of-type" === t;
                      return 1 === i && 0 === r ? function(e) {
                          return !!e.parentNode
                      } : function(t, n, l) {
                          var c, u, d, h, f, p = s !== a ? "nextSibling" : "previousSibling",
                              m = t.parentNode,
                              g = o && t.nodeName.toLowerCase(),
                              b = !l && !o,
                              x = !1;
                          if (m) {
                              if (s) {
                                  for (; p;) {
                                      for (d = t; d = d[p];)
                                          if (o ? M(d, g) : 1 === d.nodeType) return !1;
                                      f = p = "only" === e && !f && "nextSibling"
                                  }
                                  return !0
                              }
                              if (f = [a ? m.firstChild : m.lastChild], a && b) {
                                  for (x = (h = (c = (u = m[v] || (m[v] = {}))[e] || [])[0] === y && c[1]) && c[2], d = h && m.childNodes[h]; d = ++h && d && d[p] || (x = h = 0) || f.pop();)
                                      if (1 === d.nodeType && ++x && d === t) {
                                          u[e] = [y, h, x];
                                          break
                                      }
                              } else if (b && (x = h = (c = (u = t[v] || (t[v] = {}))[e] || [])[0] === y && c[1]), !1 === x)
                                  for (;
                                      (d = ++h && d && d[p] || (x = h = 0) || f.pop()) && (!(o ? M(d, g) : 1 === d.nodeType) || !++x || (b && ((u = d[v] || (d[v] = {}))[e] = [y, x]), d !== t)););
                              return (x -= r) === i || x % i == 0 && x / i >= 0
                          }
                      }
                  },
                  PSEUDO: function(e, t) {
                      var n, r = i.pseudos[e] || i.setFilters[e.toLowerCase()] || Q.error("unsupported pseudo: " + e);
                      return r[v] ? r(t) : r.length > 1 ? (n = [e, e, "", t], i.setFilters.hasOwnProperty(e.toLowerCase()) ? te((function(e, n) {
                          for (var i, s = r(e, t), a = s.length; a--;) e[i = o.call(e, s[a])] = !(n[i] = s[a])
                      })) : function(e) {
                          return r(e, 0, n)
                      }) : r
                  }
              },
              pseudos: {
                  not: te((function(e) {
                      var t = [],
                          n = [],
                          i = ve(e.replace(C, "$1"));
                      return i[v] ? te((function(e, t, n, r) {
                          for (var s, a = i(e, null, r, []), o = e.length; o--;)(s = a[o]) && (e[o] = !(t[o] = s))
                      })) : function(e, r, s) {
                          return t[0] = e, i(t, null, s, n), t[0] = null, !n.pop()
                      }
                  })),
                  has: te((function(e) {
                      return function(t) {
                          return Q(e, t).length > 0
                      }
                  })),
                  contains: te((function(e) {
                      return e = e.replace(G, Z),
                          function(t) {
                              return (t.textContent || w.text(t)).indexOf(e) > -1
                          }
                  })),
                  lang: te((function(e) {
                      return V.test(e || "") || Q.error("unsupported lang: " + e), e = e.replace(G, Z).toLowerCase(),
                          function(t) {
                              var n;
                              do {
                                  if (n = h ? t.lang : t.getAttribute("xml:lang") || t.getAttribute("lang")) return (n = n.toLowerCase()) === e || 0 === n.indexOf(e + "-")
                              } while ((t = t.parentNode) && 1 === t.nodeType);
                              return !1
                          }
                  })),
                  target: function(t) {
                      var n = e.location && e.location.hash;
                      return n && n.slice(1) === t.id
                  },
                  root: function(e) {
                      return e === d
                  },
                  focus: function(e) {
                      return e === function() {
                          try {
                              return c.activeElement
                          } catch (e) {}
                      }() && c.hasFocus() && !!(e.type || e.href || ~e.tabIndex)
                  },
                  enabled: se(!1),
                  disabled: se(!0),
                  checked: function(e) {
                      return M(e, "input") && !!e.checked || M(e, "option") && !!e.selected
                  },
                  selected: function(e) {
                      return e.parentNode && e.parentNode.selectedIndex, !0 === e.selected
                  },
                  empty: function(e) {
                      for (e = e.firstChild; e; e = e.nextSibling)
                          if (e.nodeType < 6) return !1;
                      return !0
                  },
                  parent: function(e) {
                      return !i.pseudos.empty(e)
                  },
                  header: function(e) {
                      return U.test(e.nodeName)
                  },
                  input: function(e) {
                      return q.test(e.nodeName)
                  },
                  button: function(e) {
                      return M(e, "input") && "button" === e.type || M(e, "button")
                  },
                  text: function(e) {
                      var t;
                      return M(e, "input") && "text" === e.type && (null == (t = e.getAttribute("type")) || "text" === t.toLowerCase())
                  },
                  first: ae((function() {
                      return [0]
                  })),
                  last: ae((function(e, t) {
                      return [t - 1]
                  })),
                  eq: ae((function(e, t, n) {
                      return [n < 0 ? n + t : n]
                  })),
                  even: ae((function(e, t) {
                      for (var n = 0; n < t; n += 2) e.push(n);
                      return e
                  })),
                  odd: ae((function(e, t) {
                      for (var n = 1; n < t; n += 2) e.push(n);
                      return e
                  })),
                  lt: ae((function(e, t, n) {
                      var i;
                      for (i = n < 0 ? n + t : n > t ? t : n; --i >= 0;) e.push(i);
                      return e
                  })),
                  gt: ae((function(e, t, n) {
                      for (var i = n < 0 ? n + t : n; ++i < t;) e.push(i);
                      return e
                  }))
              }
          }, i.pseudos.nth = i.pseudos.eq, {
              radio: !0,
              checkbox: !0,
              file: !0,
              password: !0,
              image: !0
          }) i.pseudos[t] = ie(t);
      for (t in {
              submit: !0,
              reset: !0
          }) i.pseudos[t] = re(t);

      function ce() {}

      function ue(e, t) {
          var n, r, s, a, o, l, c, u = _[e + " "];
          if (u) return t ? 0 : u.slice(0);
          for (o = e, l = [], c = i.preFilter; o;) {
              for (a in n && !(r = F.exec(o)) || (r && (o = o.slice(r[0].length) || o), l.push(s = [])), n = !1, (r = R.exec(o)) && (n = r.shift(), s.push({
                      value: n,
                      type: r[0].replace(C, " ")
                  }), o = o.slice(n.length)), i.filter) !(r = W[a].exec(o)) || c[a] && !(r = c[a](r)) || (n = r.shift(), s.push({
                  value: n,
                  type: a,
                  matches: r
              }), o = o.slice(n.length));
              if (!n) break
          }
          return t ? o.length : o ? Q.error(e) : _(e, l).slice(0)
      }

      function de(e) {
          for (var t = 0, n = e.length, i = ""; t < n; t++) i += e[t].value;
          return i
      }

      function he(e, t, n) {
          var i = t.dir,
              r = t.next,
              s = r || i,
              a = n && "parentNode" === s,
              o = b++;
          return t.first ? function(t, n, r) {
              for (; t = t[i];)
                  if (1 === t.nodeType || a) return e(t, n, r);
              return !1
          } : function(t, n, l) {
              var c, u, d = [y, o];
              if (l) {
                  for (; t = t[i];)
                      if ((1 === t.nodeType || a) && e(t, n, l)) return !0
              } else
                  for (; t = t[i];)
                      if (1 === t.nodeType || a)
                          if (u = t[v] || (t[v] = {}), r && M(t, r)) t = t[i] || t;
                          else {
                              if ((c = u[s]) && c[0] === y && c[1] === o) return d[2] = c[2];
                              if (u[s] = d, d[2] = e(t, n, l)) return !0
                          } return !1
          }
      }

      function fe(e) {
          return e.length > 1 ? function(t, n, i) {
              for (var r = e.length; r--;)
                  if (!e[r](t, n, i)) return !1;
              return !0
          } : e[0]
      }

      function pe(e, t, n, i, r) {
          for (var s, a = [], o = 0, l = e.length, c = null != t; o < l; o++)(s = e[o]) && (n && !n(s, i, r) || (a.push(s), c && t.push(o)));
          return a
      }

      function me(e, t, n, i, r, s) {
          return i && !i[v] && (i = me(i)), r && !r[v] && (r = me(r, s)), te((function(s, a, l, c) {
              var u, d, h, f, p = [],
                  m = [],
                  v = a.length,
                  y = s || function(e, t, n) {
                      for (var i = 0, r = t.length; i < r; i++) Q(e, t[i], n);
                      return n
                  }(t || "*", l.nodeType ? [l] : l, []),
                  b = !e || !s && t ? y : pe(y, p, e, l, c);
              if (n ? n(b, f = r || (s ? e : v || i) ? [] : a, l, c) : f = b, i)
                  for (u = pe(f, m), i(u, [], l, c), d = u.length; d--;)(h = u[d]) && (f[m[d]] = !(b[m[d]] = h));
              if (s) {
                  if (r || e) {
                      if (r) {
                          for (u = [], d = f.length; d--;)(h = f[d]) && u.push(b[d] = h);
                          r(null, f = [], u, c)
                      }
                      for (d = f.length; d--;)(h = f[d]) && (u = r ? o.call(s, h) : p[d]) > -1 && (s[u] = !(a[u] = h))
                  }
              } else f = pe(f === a ? f.splice(v, f.length) : f), r ? r(null, a, f, c) : g.apply(a, f)
          }))
      }

      function ge(e) {
          for (var t, n, r, a = e.length, l = i.relative[e[0].type], c = l || i.relative[" "], u = l ? 1 : 0, d = he((function(e) {
                  return e === t
              }), c, !0), h = he((function(e) {
                  return o.call(t, e) > -1
              }), c, !0), f = [function(e, n, i) {
                  var r = !l && (i || n != s) || ((t = n).nodeType ? d(e, n, i) : h(e, n, i));
                  return t = null, r
              }]; u < a; u++)
              if (n = i.relative[e[u].type]) f = [he(fe(f), n)];
              else {
                  if ((n = i.filter[e[u].type].apply(null, e[u].matches))[v]) {
                      for (r = ++u; r < a && !i.relative[e[r].type]; r++);
                      return me(u > 1 && fe(f), u > 1 && de(e.slice(0, u - 1).concat({
                          value: " " === e[u - 2].type ? "*" : ""
                      })).replace(C, "$1"), n, u < r && ge(e.slice(u, r)), r < a && ge(e = e.slice(r)), r < a && de(e))
                  }
                  f.push(n)
              }
          return fe(f)
      }

      function ve(e, t) {
          var n, r = [],
              a = [],
              o = k[e + " "];
          if (!o) {
              for (t || (t = ue(e)), n = t.length; n--;)(o = ge(t[n]))[v] ? r.push(o) : a.push(o);
              o = k(e, function(e, t) {
                  var n = t.length > 0,
                      r = e.length > 0,
                      a = function(a, o, l, u, d) {
                          var f, p, m, v = 0,
                              b = "0",
                              x = a && [],
                              _ = [],
                              k = s,
                              M = a || r && i.find.TAG("*", d),
                              A = y += null == k ? 1 : Math.random() || .1,
                              L = M.length;
                          for (d && (s = o == c || o || d); b !== L && null != (f = M[b]); b++) {
                              if (r && f) {
                                  for (p = 0, o || f.ownerDocument == c || (le(f), l = !h); m = e[p++];)
                                      if (m(f, o || c, l)) {
                                          g.call(u, f);
                                          break
                                      }
                                  d && (y = A)
                              }
                              n && ((f = !m && f) && v--, a && x.push(f))
                          }
                          if (v += b, n && b !== v) {
                              for (p = 0; m = t[p++];) m(x, _, o, l);
                              if (a) {
                                  if (v > 0)
                                      for (; b--;) x[b] || _[b] || (_[b] = S.call(u));
                                  _ = pe(_)
                              }
                              g.apply(u, _), d && !a && _.length > 0 && v + t.length > 1 && w.uniqueSort(u)
                          }
                          return d && (y = A, s = k), x
                      };
                  return n ? te(a) : a
              }(a, r)), o.selector = e
          }
          return o
      }

      function ye(e, t, n, r) {
          var s, a, o, l, c, u = "function" == typeof e && e,
              d = !r && ue(e = u.selector || e);
          if (n = n || [], 1 === d.length) {
              if ((a = d[0] = d[0].slice(0)).length > 2 && "ID" === (o = a[0]).type && 9 === t.nodeType && h && i.relative[a[1].type]) {
                  if (!(t = (i.find.ID(o.matches[0].replace(G, Z), t) || [])[0])) return n;
                  u && (t = t.parentNode), e = e.slice(a.shift().value.length)
              }
              for (s = W.needsContext.test(e) ? 0 : a.length; s-- && (o = a[s], !i.relative[l = o.type]);)
                  if ((c = i.find[l]) && (r = c(o.matches[0].replace(G, Z), X.test(a[0].type) && oe(t.parentNode) || t))) {
                      if (a.splice(s, 1), !(e = r.length && de(a))) return g.apply(n, r), n;
                      break
                  }
          }
          return (u || ve(e, d))(r, t, !h, n, !t || X.test(e) && oe(t.parentNode) || t), n
      }
      ce.prototype = i.filters = i.pseudos, i.setFilters = new ce, f.sortStable = v.split("").sort(E).join("") === v, le(), f.sortDetached = ne((function(e) {
          return 1 & e.compareDocumentPosition(c.createElement("fieldset"))
      })), w.find = Q, w.expr[":"] = w.expr.pseudos, w.unique = w.uniqueSort, Q.compile = ve, Q.select = ye, Q.setDocument = le, Q.tokenize = ue, Q.escape = w.escapeSelector, Q.getText = w.text, Q.isXML = w.isXMLDoc, Q.selectors = w.expr, Q.support = w.support, Q.uniqueSort = w.uniqueSort
  }();
  var Y = function(e, t, n) {
          for (var i = [], r = void 0 !== n;
              (e = e[t]) && 9 !== e.nodeType;)
              if (1 === e.nodeType) {
                  if (r && w(e).is(n)) break;
                  i.push(e)
              }
          return i
      },
      I = function(e, t) {
          for (var n = []; e; e = e.nextSibling) 1 === e.nodeType && e !== t && n.push(e);
          return n
      },
      N = w.expr.match.needsContext,
      H = /^<([a-z][^\/\0>:\x20\t\r\n\f]*)[\x20\t\r\n\f]*\/?>(?:<\/\1>|)$/i;

  function j(e, t, n) {
      return p(t) ? w.grep(e, (function(e, i) {
          return !!t.call(e, i, e) !== n
      })) : t.nodeType ? w.grep(e, (function(e) {
          return e === t !== n
      })) : "string" != typeof t ? w.grep(e, (function(e) {
          return o.call(t, e) > -1 !== n
      })) : w.filter(t, e, n)
  }
  w.filter = function(e, t, n) {
      var i = t[0];
      return n && (e = ":not(" + e + ")"), 1 === t.length && 1 === i.nodeType ? w.find.matchesSelector(i, e) ? [i] : [] : w.find.matches(e, w.grep(t, (function(e) {
          return 1 === e.nodeType
      })))
  }, w.fn.extend({
      find: function(e) {
          var t, n, i = this.length,
              r = this;
          if ("string" != typeof e) return this.pushStack(w(e).filter((function() {
              for (t = 0; t < i; t++)
                  if (w.contains(r[t], this)) return !0
          })));
          for (n = this.pushStack([]), t = 0; t < i; t++) w.find(e, r[t], n);
          return i > 1 ? w.uniqueSort(n) : n
      },
      filter: function(e) {
          return this.pushStack(j(this, e || [], !1))
      },
      not: function(e) {
          return this.pushStack(j(this, e || [], !0))
      },
      is: function(e) {
          return !!j(this, "string" == typeof e && N.test(e) ? w(e) : e || [], !1).length
      }
  });
  var F, R = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]+))$/;
  (w.fn.init = function(e, t, n) {
      var i, r;
      if (!e) return this;
      if (n = n || F, "string" == typeof e) {
          if (!(i = "<" === e[0] && ">" === e[e.length - 1] && e.length >= 3 ? [null, e, null] : R.exec(e)) || !i[1] && t) return !t || t.jquery ? (t || n).find(e) : this.constructor(t).find(e);
          if (i[1]) {
              if (t = t instanceof w ? t[0] : t, w.merge(this, w.parseHTML(i[1], t && t.nodeType ? t.ownerDocument || t : g, !0)), H.test(i[1]) && w.isPlainObject(t))
                  for (i in t) p(this[i]) ? this[i](t[i]) : this.attr(i, t[i]);
              return this
          }
          return (r = g.getElementById(i[2])) && (this[0] = r, this.length = 1), this
      }
      return e.nodeType ? (this[0] = e, this.length = 1, this) : p(e) ? void 0 !== n.ready ? n.ready(e) : e(w) : w.makeArray(e, this)
  }).prototype = w.fn, F = w(g);
  var z = /^(?:parents|prev(?:Until|All))/,
      B = {
          children: !0,
          contents: !0,
          next: !0,
          prev: !0
      };

  function V(e, t) {
      for (;
          (e = e[t]) && 1 !== e.nodeType;);
      return e
  }
  w.fn.extend({
      has: function(e) {
          var t = w(e, this),
              n = t.length;
          return this.filter((function() {
              for (var e = 0; e < n; e++)
                  if (w.contains(this, t[e])) return !0
          }))
      },
      closest: function(e, t) {
          var n, i = 0,
              r = this.length,
              s = [],
              a = "string" != typeof e && w(e);
          if (!N.test(e))
              for (; i < r; i++)
                  for (n = this[i]; n && n !== t; n = n.parentNode)
                      if (n.nodeType < 11 && (a ? a.index(n) > -1 : 1 === n.nodeType && w.find.matchesSelector(n, e))) {
                          s.push(n);
                          break
                      }
          return this.pushStack(s.length > 1 ? w.uniqueSort(s) : s)
      },
      index: function(e) {
          return e ? "string" == typeof e ? o.call(w(e), this[0]) : o.call(this, e.jquery ? e[0] : e) : this[0] && this[0].parentNode ? this.first().prevAll().length : -1
      },
      add: function(e, t) {
          return this.pushStack(w.uniqueSort(w.merge(this.get(), w(e, t))))
      },
      addBack: function(e) {
          return this.add(null == e ? this.prevObject : this.prevObject.filter(e))
      }
  }), w.each({
      parent: function(e) {
          var t = e.parentNode;
          return t && 11 !== t.nodeType ? t : null
      },
      parents: function(e) {
          return Y(e, "parentNode")
      },
      parentsUntil: function(e, t, n) {
          return Y(e, "parentNode", n)
      },
      next: function(e) {
          return V(e, "nextSibling")
      },
      prev: function(e) {
          return V(e, "previousSibling")
      },
      nextAll: function(e) {
          return Y(e, "nextSibling")
      },
      prevAll: function(e) {
          return Y(e, "previousSibling")
      },
      nextUntil: function(e, t, n) {
          return Y(e, "nextSibling", n)
      },
      prevUntil: function(e, t, n) {
          return Y(e, "previousSibling", n)
      },
      siblings: function(e) {
          return I((e.parentNode || {}).firstChild, e)
      },
      children: function(e) {
          return I(e.firstChild)
      },
      contents: function(e) {
          return null != e.contentDocument && i(e.contentDocument) ? e.contentDocument : (M(e, "template") && (e = e.content || e), w.merge([], e.childNodes))
      }
  }, (function(e, t) {
      w.fn[e] = function(n, i) {
          var r = w.map(this, t, n);
          return "Until" !== e.slice(-5) && (i = n), i && "string" == typeof i && (r = w.filter(i, r)), this.length > 1 && (B[e] || w.uniqueSort(r), z.test(e) && r.reverse()), this.pushStack(r)
      }
  }));
  var W = /[^\x20\t\r\n\f]+/g;

  function q(e) {
      return e
  }

  function U(e) {
      throw e
  }

  function $(e, t, n, i) {
      var r;
      try {
          e && p(r = e.promise) ? r.call(e).done(t).fail(n) : e && p(r = e.then) ? r.call(e, t, n) : t.apply(void 0, [e].slice(i))
      } catch (e) {
          n.apply(void 0, [e])
      }
  }
  w.Callbacks = function(e) {
      e = "string" == typeof e ? function(e) {
          var t = {};
          return w.each(e.match(W) || [], (function(e, n) {
              t[n] = !0
          })), t
      }(e) : w.extend({}, e);
      var t, n, i, r, s = [],
          a = [],
          o = -1,
          l = function() {
              for (r = r || e.once, i = t = !0; a.length; o = -1)
                  for (n = a.shift(); ++o < s.length;) !1 === s[o].apply(n[0], n[1]) && e.stopOnFalse && (o = s.length, n = !1);
              e.memory || (n = !1), t = !1, r && (s = n ? [] : "")
          },
          c = {
              add: function() {
                  return s && (n && !t && (o = s.length - 1, a.push(n)), function t(n) {
                      w.each(n, (function(n, i) {
                          p(i) ? e.unique && c.has(i) || s.push(i) : i && i.length && "string" !== b(i) && t(i)
                      }))
                  }(arguments), n && !t && l()), this
              },
              remove: function() {
                  return w.each(arguments, (function(e, t) {
                      for (var n;
                          (n = w.inArray(t, s, n)) > -1;) s.splice(n, 1), n <= o && o--
                  })), this
              },
              has: function(e) {
                  return e ? w.inArray(e, s) > -1 : s.length > 0
              },
              empty: function() {
                  return s && (s = []), this
              },
              disable: function() {
                  return r = a = [], s = n = "", this
              },
              disabled: function() {
                  return !s
              },
              lock: function() {
                  return r = a = [], n || t || (s = n = ""), this
              },
              locked: function() {
                  return !!r
              },
              fireWith: function(e, n) {
                  return r || (n = [e, (n = n || []).slice ? n.slice() : n], a.push(n), t || l()), this
              },
              fire: function() {
                  return c.fireWith(this, arguments), this
              },
              fired: function() {
                  return !!i
              }
          };
      return c
  }, w.extend({
      Deferred: function(t) {
          var n = [
                  ["notify", "progress", w.Callbacks("memory"), w.Callbacks("memory"), 2],
                  ["resolve", "done", w.Callbacks("once memory"), w.Callbacks("once memory"), 0, "resolved"],
                  ["reject", "fail", w.Callbacks("once memory"), w.Callbacks("once memory"), 1, "rejected"]
              ],
              i = "pending",
              r = {
                  state: function() {
                      return i
                  },
                  always: function() {
                      return s.done(arguments).fail(arguments), this
                  },
                  catch: function(e) {
                      return r.then(null, e)
                  },
                  pipe: function() {
                      var e = arguments;
                      return w.Deferred((function(t) {
                          w.each(n, (function(n, i) {
                              var r = p(e[i[4]]) && e[i[4]];
                              s[i[1]]((function() {
                                  var e = r && r.apply(this, arguments);
                                  e && p(e.promise) ? e.promise().progress(t.notify).done(t.resolve).fail(t.reject) : t[i[0] + "With"](this, r ? [e] : arguments)
                              }))
                          })), e = null
                      })).promise()
                  },
                  then: function(t, i, r) {
                      var s = 0;

                      function a(t, n, i, r) {
                          return function() {
                              var o = this,
                                  l = arguments,
                                  c = function() {
                                      var e, c;
                                      if (!(t < s)) {
                                          if ((e = i.apply(o, l)) === n.promise()) throw new TypeError("Thenable self-resolution");
                                          c = e && ("object" == typeof e || "function" == typeof e) && e.then, p(c) ? r ? c.call(e, a(s, n, q, r), a(s, n, U, r)) : (s++, c.call(e, a(s, n, q, r), a(s, n, U, r), a(s, n, q, n.notifyWith))) : (i !== q && (o = void 0, l = [e]), (r || n.resolveWith)(o, l))
                                      }
                                  },
                                  u = r ? c : function() {
                                      try {
                                          c()
                                      } catch (e) {
                                          w.Deferred.exceptionHook && w.Deferred.exceptionHook(e, u.error), t + 1 >= s && (i !== U && (o = void 0, l = [e]), n.rejectWith(o, l))
                                      }
                                  };
                              t ? u() : (w.Deferred.getErrorHook ? u.error = w.Deferred.getErrorHook() : w.Deferred.getStackHook && (u.error = w.Deferred.getStackHook()), e.setTimeout(u))
                          }
                      }
                      return w.Deferred((function(e) {
                          n[0][3].add(a(0, e, p(r) ? r : q, e.notifyWith)), n[1][3].add(a(0, e, p(t) ? t : q)), n[2][3].add(a(0, e, p(i) ? i : U))
                      })).promise()
                  },
                  promise: function(e) {
                      return null != e ? w.extend(e, r) : r
                  }
              },
              s = {};
          return w.each(n, (function(e, t) {
              var a = t[2],
                  o = t[5];
              r[t[1]] = a.add, o && a.add((function() {
                  i = o
              }), n[3 - e][2].disable, n[3 - e][3].disable, n[0][2].lock, n[0][3].lock), a.add(t[3].fire), s[t[0]] = function() {
                  return s[t[0] + "With"](this === s ? void 0 : this, arguments), this
              }, s[t[0] + "With"] = a.fireWith
          })), r.promise(s), t && t.call(s, s), s
      },
      when: function(e) {
          var t = arguments.length,
              n = t,
              i = Array(n),
              s = r.call(arguments),
              a = w.Deferred(),
              o = function(e) {
                  return function(n) {
                      i[e] = this, s[e] = arguments.length > 1 ? r.call(arguments) : n, --t || a.resolveWith(i, s)
                  }
              };
          if (t <= 1 && ($(e, a.done(o(n)).resolve, a.reject, !t), "pending" === a.state() || p(s[n] && s[n].then))) return a.then();
          for (; n--;) $(s[n], o(n), a.reject);
          return a.promise()
      }
  });
  var X = /^(Eval|Internal|Range|Reference|Syntax|Type|URI)Error$/;
  w.Deferred.exceptionHook = function(t, n) {
      e.console && e.console.warn && t && X.test(t.name) && e.console.warn("jQuery.Deferred exception: " + t.message, t.stack, n)
  }, w.readyException = function(t) {
      e.setTimeout((function() {
          throw t
      }))
  };
  var G = w.Deferred();

  function Z() {
      g.removeEventListener("DOMContentLoaded", Z), e.removeEventListener("load", Z), w.ready()
  }
  w.fn.ready = function(e) {
      return G.then(e).catch((function(e) {
          w.readyException(e)
      })), this
  }, w.extend({
      isReady: !1,
      readyWait: 1,
      ready: function(e) {
          (!0 === e ? --w.readyWait : w.isReady) || (w.isReady = !0, !0 !== e && --w.readyWait > 0 || G.resolveWith(g, [w]))
      }
  }), w.ready.then = G.then, "complete" === g.readyState || "loading" !== g.readyState && !g.documentElement.doScroll ? e.setTimeout(w.ready) : (g.addEventListener("DOMContentLoaded", Z), e.addEventListener("load", Z));
  var K = function(e, t, n, i, r, s, a) {
          var o = 0,
              l = e.length,
              c = null == n;
          if ("object" === b(n))
              for (o in r = !0, n) K(e, t, o, n[o], !0, s, a);
          else if (void 0 !== i && (r = !0, p(i) || (a = !0), c && (a ? (t.call(e, i), t = null) : (c = t, t = function(e, t, n) {
                  return c.call(w(e), n)
              })), t))
              for (; o < l; o++) t(e[o], n, a ? i : i.call(e[o], o, t(e[o], n)));
          return r ? e : c ? t.call(e) : l ? t(e[0], n) : s
      },
      J = /^-ms-/,
      Q = /-([a-z])/g;

  function ee(e, t) {
      return t.toUpperCase()
  }

  function te(e) {
      return e.replace(J, "ms-").replace(Q, ee)
  }
  var ne = function(e) {
      return 1 === e.nodeType || 9 === e.nodeType || !+e.nodeType
  };

  function ie() {
      this.expando = w.expando + ie.uid++
  }
  ie.uid = 1, ie.prototype = {
      cache: function(e) {
          var t = e[this.expando];
          return t || (t = {}, ne(e) && (e.nodeType ? e[this.expando] = t : Object.defineProperty(e, this.expando, {
              value: t,
              configurable: !0
          }))), t
      },
      set: function(e, t, n) {
          var i, r = this.cache(e);
          if ("string" == typeof t) r[te(t)] = n;
          else
              for (i in t) r[te(i)] = t[i];
          return r
      },
      get: function(e, t) {
          return void 0 === t ? this.cache(e) : e[this.expando] && e[this.expando][te(t)]
      },
      access: function(e, t, n) {
          return void 0 === t || t && "string" == typeof t && void 0 === n ? this.get(e, t) : (this.set(e, t, n), void 0 !== n ? n : t)
      },
      remove: function(e, t) {
          var n, i = e[this.expando];
          if (void 0 !== i) {
              if (void 0 !== t) {
                  n = (t = Array.isArray(t) ? t.map(te) : (t = te(t)) in i ? [t] : t.match(W) || []).length;
                  for (; n--;) delete i[t[n]]
              }(void 0 === t || w.isEmptyObject(i)) && (e.nodeType ? e[this.expando] = void 0 : delete e[this.expando])
          }
      },
      hasData: function(e) {
          var t = e[this.expando];
          return void 0 !== t && !w.isEmptyObject(t)
      }
  };
  function ge(e, t, n, i) {
      var r, s, a = 20,
          o = i ? function() {
              return i.cur()
          } : function() {
              return w.css(e, t, "")
          },
          l = o(),
          c = n && n[3] || (w.cssNumber[t] ? "" : "px"),
          u = e.nodeType && (w.cssNumber[t] || "px" !== c && +l) && ue.exec(w.css(e, t));
      if (u && u[3] !== c) {
          for (l /= 2, c = c || u[3], u = +l || 1; a--;) w.style(e, t, u + c), (1 - s) * (1 - (s = o() / l || .5)) <= 0 && (a = 0), u /= s;
          u *= 2, w.style(e, t, u + c), n = n || []
      }
      return n && (u = +u || +l || 0, r = n[1] ? u + (n[1] + 1) * n[2] : +n[2], i && (i.unit = c, i.start = u, i.end = r)), r
  }
  var ve = {};

  function ye(e) {
      var t, n = e.ownerDocument,
          i = e.nodeName,
          r = ve[i];
      return r || (t = n.body.appendChild(n.createElement(i)), r = w.css(t, "display"), t.parentNode.removeChild(t), "none" === r && (r = "block"), ve[i] = r, r)
  }

  function be(e, t) {
      for (var n, i, r = [], s = 0, a = e.length; s < a; s++)(i = e[s]).style && (n = i.style.display, t ? ("none" === n && (r[s] = re.get(i, "display") || null, r[s] || (i.style.display = "")), "" === i.style.display && me(i) && (r[s] = ye(i))) : "none" !== n && (r[s] = "none", re.set(i, "display", n)));
      for (s = 0; s < a; s++) null != r[s] && (e[s].style.display = r[s]);
      return e
  }
  w.fn.extend({
      show: function() {
          return be(this, !0)
      },
      hide: function() {
          return be(this)
      },
      toggle: function(e) {
          return "boolean" == typeof e ? e ? this.show() : this.hide() : this.each((function() {
              me(this) ? w(this).show() : w(this).hide()
          }))
      }
  });
  var xe, _e, we = /^(?:checkbox|radio)$/i,
      ke = /<([a-z][^\/\0>\x20\t\r\n\f]*)/i,
      Me = /^$|^module$|\/(?:java|ecma)script/i;
  xe = g.createDocumentFragment().appendChild(g.createElement("div")), (_e = g.createElement("input")).setAttribute("type", "radio"), _e.setAttribute("checked", "checked"), _e.setAttribute("name", "t"), xe.appendChild(_e), f.checkClone = xe.cloneNode(!0).cloneNode(!0).lastChild.checked, xe.innerHTML = "<textarea>x</textarea>", f.noCloneChecked = !!xe.cloneNode(!0).lastChild.defaultValue, xe.innerHTML = "<option></option>", f.option = !!xe.lastChild;
  var Se = {
      thead: [1, "<table>", "</table>"],
      col: [2, "<table><colgroup>", "</colgroup></table>"],
      tr: [2, "<table><tbody>", "</tbody></table>"],
      td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
      _default: [0, "", ""]
  };

  function Ae(e, t) {
      var n;
      return n = void 0 !== e.getElementsByTagName ? e.getElementsByTagName(t || "*") : void 0 !== e.querySelectorAll ? e.querySelectorAll(t || "*") : [], void 0 === t || t && M(e, t) ? w.merge([e], n) : n
  }

  function Le(e, t) {
      for (var n = 0, i = e.length; n < i; n++) re.set(e[n], "globalEval", !t || re.get(t[n], "globalEval"))
  }
  Se.tbody = Se.tfoot = Se.colgroup = Se.caption = Se.thead, Se.th = Se.td, f.option || (Se.optgroup = Se.option = [1, "<select multiple='multiple'>", "</select>"]);
  var Te = /<|&#?\w+;/;

  function Ce(e, t, n, i, r) {
      for (var s, a, o, l, c, u, d = t.createDocumentFragment(), h = [], f = 0, p = e.length; f < p; f++)
          if ((s = e[f]) || 0 === s)
              if ("object" === b(s)) w.merge(h, s.nodeType ? [s] : s);
              else if (Te.test(s)) {
          for (a = a || d.appendChild(t.createElement("div")), o = (ke.exec(s) || ["", ""])[1].toLowerCase(), l = Se[o] || Se._default, a.innerHTML = l[1] + w.htmlPrefilter(s) + l[2], u = l[0]; u--;) a = a.lastChild;
          w.merge(h, a.childNodes), (a = d.firstChild).textContent = ""
      } else h.push(t.createTextNode(s));
      for (d.textContent = "", f = 0; s = h[f++];)
          if (i && w.inArray(s, i) > -1) r && r.push(s);
          else if (c = fe(s), a = Ae(d.appendChild(s), "script"), c && Le(a), n)
          for (u = 0; s = a[u++];) Me.test(s.type || "") && n.push(s);
      return d
  }
  var De = /^([^.]*)(?:\.(.+)|)/;

  function Ee() {
      return !0
  }

  function Oe() {
      return !1
  }

  function Pe(e, t, n, i, r, s) {
      var a, o;
      if ("object" == typeof t) {
          for (o in "string" != typeof n && (i = i || n, n = void 0), t) Pe(e, o, n, i, t[o], s);
          return e
      }
      if (null == i && null == r ? (r = n, i = n = void 0) : null == r && ("string" == typeof n ? (r = i, i = void 0) : (r = i, i = n, n = void 0)), !1 === r) r = Oe;
      else if (!r) return e;
      return 1 === s && (a = r, r = function(e) {
          return w().off(e), a.apply(this, arguments)
      }, r.guid = a.guid || (a.guid = w.guid++)), e.each((function() {
          w.event.add(this, t, r, i, n)
      }))
  }

  function je(e, t) {
      return M(e, "table") && M(11 !== t.nodeType ? t : t.firstChild, "tr") && w(e).children("tbody")[0] || e
  }

  function Fe(e) {
      return e.type = (null !== e.getAttribute("type")) + "/" + e.type, e
  }

  function Re(e) {
      return "true/" === (e.type || "").slice(0, 5) ? e.type = e.type.slice(5) : e.removeAttribute("type"), e
  }

  function ze(e, t) {
      var n, i, r, s, a, o;
      if (1 === t.nodeType) {
          if (re.hasData(e) && (o = re.get(e).events))
              for (r in re.remove(t, "handle events"), o)
                  for (n = 0, i = o[r].length; n < i; n++) w.event.add(t, r, o[r][n]);
          se.hasData(e) && (s = se.access(e), a = w.extend({}, s), se.set(t, a))
      }
  }

  function Be(e, t) {
      var n = t.nodeName.toLowerCase();
      "input" === n && we.test(e.type) ? t.checked = e.checked : "input" !== n && "textarea" !== n || (t.defaultValue = e.defaultValue)
  }

  function Ke(e, t) {
      return {
          get: function() {
              if (!e()) return (this.get = t).apply(this, arguments);
              delete this.get
          }
      }
  }! function() {
      function t() {
          if (u) {
              c.style.cssText = "position:absolute;left:-11111px;width:60px;margin-top:1px;padding:0;border:0", u.style.cssText = "position:relative;display:block;box-sizing:border-box;overflow:scroll;margin:auto;border:1px;padding:1px;width:60%;top:1%", he.appendChild(c).appendChild(u);
              var t = e.getComputedStyle(u);
              i = "1%" !== t.top, l = 12 === n(t.marginLeft), u.style.right = "60%", a = 36 === n(t.right), r = 36 === n(t.width), u.style.position = "absolute", s = 12 === n(u.offsetWidth / 3), he.removeChild(c), u = null
          }
      }

      function n(e) {
          return Math.round(parseFloat(e))
      }
      var i, r, s, a, o, l, c = g.createElement("div"),
          u = g.createElement("div");
      u.style && (u.style.backgroundClip = "content-box", u.cloneNode(!0).style.backgroundClip = "", f.clearCloneStyle = "content-box" === u.style.backgroundClip, w.extend(f, {
          boxSizingReliable: function() {
              return t(), r
          },
          pixelBoxStyles: function() {
              return t(), a
          },
          pixelPosition: function() {
              return t(), i
          },
          reliableMarginLeft: function() {
              return t(), l
          },
          scrollboxSize: function() {
              return t(), s
          },
          reliableTrDimensions: function() {
              var t, n, i, r;
              return null == o && (t = g.createElement("table"), n = g.createElement("tr"), i = g.createElement("div"), t.style.cssText = "position:absolute;left:-11111px;border-collapse:separate", n.style.cssText = "box-sizing:content-box;border:1px solid", n.style.height = "1px", i.style.height = "9px", i.style.display = "block", he.appendChild(t).appendChild(n).appendChild(i), r = e.getComputedStyle(n), o = parseInt(r.height, 10) + parseInt(r.borderTopWidth, 10) + parseInt(r.borderBottomWidth, 10) === n.offsetHeight, he.removeChild(t)), o
          }
      }))
  }();
  var Je = ["Webkit", "Moz", "ms"],
      Qe = g.createElement("div").style,
      et = {};

  function tt(e) {
      var t = w.cssProps[e] || et[e];
      return t || (e in Qe ? e : et[e] = function(e) {
          for (var t = e[0].toUpperCase() + e.slice(1), n = Je.length; n--;)
              if ((e = Je[n] + t) in Qe) return e
      }(e) || e)
  }
  var nt = /^(none|table(?!-c[ea]).+)/,
      it = {
          position: "absolute",
          visibility: "hidden",
          display: "block"
      },
      rt = {
          letterSpacing: "0",
          fontWeight: "400"
      };

  function st(e, t, n) {
      var i = ue.exec(t);
      return i ? Math.max(0, i[2] - (n || 0)) + (i[3] || "px") : t
  }

  function at(e, t, n, i, r, s) {
      var a = "width" === t ? 1 : 0,
          o = 0,
          l = 0,
          c = 0;
      if (n === (i ? "border" : "content")) return 0;
      for (; a < 4; a += 2) "margin" === n && (c += w.css(e, n + de[a], !0, r)), i ? ("content" === n && (l -= w.css(e, "padding" + de[a], !0, r)), "margin" !== n && (l -= w.css(e, "border" + de[a] + "Width", !0, r))) : (l += w.css(e, "padding" + de[a], !0, r), "padding" !== n ? l += w.css(e, "border" + de[a] + "Width", !0, r) : o += w.css(e, "border" + de[a] + "Width", !0, r));
      return !i && s >= 0 && (l += Math.max(0, Math.ceil(e["offset" + t[0].toUpperCase() + t.slice(1)] - s - l - o - .5)) || 0), l + c
  }

  function ot(e, t, n) {
      var i = $e(e),
          r = (!f.boxSizingReliable() || n) && "border-box" === w.css(e, "boxSizing", !1, i),
          s = r,
          a = Ze(e, t, i),
          o = "offset" + t[0].toUpperCase() + t.slice(1);
      if (qe.test(a)) {
          if (!n) return a;
          a = "auto"
      }
      return (!f.boxSizingReliable() && r || !f.reliableTrDimensions() && M(e, "tr") || "auto" === a || !parseFloat(a) && "inline" === w.css(e, "display", !1, i)) && e.getClientRects().length && (r = "border-box" === w.css(e, "boxSizing", !1, i), (s = o in e) && (a = e[o])), (a = parseFloat(a) || 0) + at(e, t, n || (r ? "border" : "content"), s, i, a) + "px"
  }


  function pt() {
      return e.setTimeout((function() {
          ct = void 0
      })), ct = Date.now()
  }

  w.param = function(e, t) {
      var n, i = [],
          r = function(e, t) {
              var n = p(t) ? t() : t;
              i[i.length] = encodeURIComponent(e) + "=" + encodeURIComponent(null == n ? "" : n)
          };
      if (null == e) return "";
      if (Array.isArray(e) || e.jquery && !w.isPlainObject(e)) w.each(e, (function() {
          r(this.name, this.value)
      }));
      else
          for (n in e) It(n, e[n], t, r);
      return i.join("&")
  }, w.fn.extend({
      serialize: function() {
          return w.param(this.serializeArray())
      },
      serializeArray: function() {
          return this.map((function() {
              var e = w.prop(this, "elements");
              return e ? w.makeArray(e) : this
          })).filter((function() {
              var e = this.type;
              return this.name && !w(this).is(":disabled") && Yt.test(this.nodeName) && !Pt.test(e) && (this.checked || !we.test(e))
          })).map((function(e, t) {
              var n = w(this).val();
              return null == n ? null : Array.isArray(n) ? w.map(n, (function(e) {
                  return {
                      name: t.name,
                      value: e.replace(Ot, "\r\n")
                  }
              })) : {
                  name: t.name,
                  value: n.replace(Ot, "\r\n")
              }
          })).get()
      }
  });
  var Nt = /%20/g,
      Ht = /#.*$/,
      jt = /([?&])_=[^&]*/,
      Ft = /^(.*?):[ \t]*([^\r\n]*)$/gm,
      Rt = /^(?:GET|HEAD)$/,
      zt = /^\/\//,
      Bt = {},
      Vt = {},
      Wt = "*/".concat("*"),
      qt = g.createElement("a");

  function Ut(e) {
      return function(t, n) {
          "string" != typeof t && (n = t, t = "*");
          var i, r = 0,
              s = t.toLowerCase().match(W) || [];
          if (p(n))
              for (; i = s[r++];) "+" === i[0] ? (i = i.slice(1) || "*", (e[i] = e[i] || []).unshift(n)) : (e[i] = e[i] || []).push(n)
      }
  }

  function $t(e, t, n, i) {
      var r = {},
          s = e === Vt;

      function a(o) {
          var l;
          return r[o] = !0, w.each(e[o] || [], (function(e, o) {
              var c = o(t, n, i);
              return "string" != typeof c || s || r[c] ? s ? !(l = c) : void 0 : (t.dataTypes.unshift(c), a(c), !1)
          })), l
      }
      return a(t.dataTypes[0]) || !r["*"] && a("*")
  }

  function Xt(e, t) {
      var n, i, r = w.ajaxSettings.flatOptions || {};
      for (n in t) void 0 !== t[n] && ((r[n] ? e : i || (i = {}))[n] = t[n]);
      return i && w.extend(!0, e, i), e
  }
  qt.href = At.href, w.extend({
      active: 0,
      lastModified: {},
      etag: {},
      ajaxSettings: {
          url: At.href,
          type: "GET",
          isLocal: /^(?:about|app|app-storage|.+-extension|file|res|widget):$/.test(At.protocol),
          global: !0,
          processData: !0,
          async: !0,
          contentType: "application/x-www-form-urlencoded; charset=UTF-8",
          accepts: {
              "*": Wt,
              text: "text/plain",
              html: "text/html",
              xml: "application/xml, text/xml",
              json: "application/json, text/javascript"
          },
          contents: {
              xml: /\bxml\b/,
              html: /\bhtml/,
              json: /\bjson\b/
          },
          responseFields: {
              xml: "responseXML",
              text: "responseText",
              json: "responseJSON"
          },
          converters: {
              "* text": String,
              "text html": !0,
              "text json": JSON.parse,
              "text xml": w.parseXML
          },
          flatOptions: {
              url: !0,
              context: !0
          }
      },
      ajaxSetup: function(e, t) {
          return t ? Xt(Xt(e, w.ajaxSettings), t) : Xt(w.ajaxSettings, e)
      },
      ajaxPrefilter: Ut(Bt),
      ajaxTransport: Ut(Vt),
      ajax: function(t, n) {
          "object" == typeof t && (n = t, t = void 0), n = n || {};
          var i, r, s, a, o, l, c, u, d, h, f = w.ajaxSetup({}, n),
              p = f.context || f,
              m = f.context && (p.nodeType || p.jquery) ? w(p) : w.event,
              v = w.Deferred(),
              y = w.Callbacks("once memory"),
              b = f.statusCode || {},
              x = {},
              _ = {},
              k = "canceled",
              M = {
                  readyState: 0,
                  getResponseHeader: function(e) {
                      var t;
                      if (c) {
                          if (!a)
                              for (a = {}; t = Ft.exec(s);) a[t[1].toLowerCase() + " "] = (a[t[1].toLowerCase() + " "] || []).concat(t[2]);
                          t = a[e.toLowerCase() + " "]
                      }
                      return null == t ? null : t.join(", ")
                  },
                  getAllResponseHeaders: function() {
                      return c ? s : null
                  },
                  setRequestHeader: function(e, t) {
                      return null == c && (e = _[e.toLowerCase()] = _[e.toLowerCase()] || e, x[e] = t), this
                  },
                  overrideMimeType: function(e) {
                      return null == c && (f.mimeType = e), this
                  },
                  statusCode: function(e) {
                      var t;
                      if (e)
                          if (c) M.always(e[M.status]);
                          else
                              for (t in e) b[t] = [b[t], e[t]];
                      return this
                  },
                  abort: function(e) {
                      var t = e || k;
                      return i && i.abort(t), S(0, t), this
                  }
              };
          if (v.promise(M), f.url = ((t || f.url || At.href) + "").replace(zt, At.protocol + "//"), f.type = n.method || n.type || f.method || f.type, f.dataTypes = (f.dataType || "*").toLowerCase().match(W) || [""], null == f.crossDomain) {
              l = g.createElement("a");
              try {
                  l.href = f.url, l.href = l.href, f.crossDomain = qt.protocol + "//" + qt.host != l.protocol + "//" + l.host
              } catch (e) {
                  f.crossDomain = !0
              }
          }
          if (f.data && f.processData && "string" != typeof f.data && (f.data = w.param(f.data, f.traditional)), $t(Bt, f, n, M), c) return M;
          for (d in (u = w.event && f.global) && 0 == w.active++ && w.event.trigger("ajaxStart"), f.type = f.type.toUpperCase(), f.hasContent = !Rt.test(f.type), r = f.url.replace(Ht, ""), f.hasContent ? f.data && f.processData && 0 === (f.contentType || "").indexOf("application/x-www-form-urlencoded") && (f.data = f.data.replace(Nt, "+")) : (h = f.url.slice(r.length), f.data && (f.processData || "string" == typeof f.data) && (r += (Tt.test(r) ? "&" : "?") + f.data, delete f.data), !1 === f.cache && (r = r.replace(jt, "$1"), h = (Tt.test(r) ? "&" : "?") + "_=" + Lt.guid++ + h), f.url = r + h), f.ifModified && (w.lastModified[r] && M.setRequestHeader("If-Modified-Since", w.lastModified[r]), w.etag[r] && M.setRequestHeader("If-None-Match", w.etag[r])), (f.data && f.hasContent && !1 !== f.contentType || n.contentType) && M.setRequestHeader("Content-Type", f.contentType), M.setRequestHeader("Accept", f.dataTypes[0] && f.accepts[f.dataTypes[0]] ? f.accepts[f.dataTypes[0]] + ("*" !== f.dataTypes[0] ? ", " + Wt + "; q=0.01" : "") : f.accepts["*"]), f.headers) M.setRequestHeader(d, f.headers[d]);
          if (f.beforeSend && (!1 === f.beforeSend.call(p, M, f) || c)) return M.abort();
          if (k = "abort", y.add(f.complete), M.done(f.success), M.fail(f.error), i = $t(Vt, f, n, M)) {
              if (M.readyState = 1, u && m.trigger("ajaxSend", [M, f]), c) return M;
              f.async && f.timeout > 0 && (o = e.setTimeout((function() {
                  M.abort("timeout")
              }), f.timeout));
              try {
                  c = !1, i.send(x, S)
              } catch (e) {
                  if (c) throw e;
                  S(-1, e)
              }
          } else S(-1, "No Transport");

          function S(t, n, a, l) {
              var d, h, g, x, _, k = n;
              c || (c = !0, o && e.clearTimeout(o), i = void 0, s = l || "", M.readyState = t > 0 ? 4 : 0, d = t >= 200 && t < 300 || 304 === t, a && (x = function(e, t, n) {
                  for (var i, r, s, a, o = e.contents, l = e.dataTypes;
                      "*" === l[0];) l.shift(), void 0 === i && (i = e.mimeType || t.getResponseHeader("Content-Type"));
                  if (i)
                      for (r in o)
                          if (o[r] && o[r].test(i)) {
                              l.unshift(r);
                              break
                          }
                  if (l[0] in n) s = l[0];
                  else {
                      for (r in n) {
                          if (!l[0] || e.converters[r + " " + l[0]]) {
                              s = r;
                              break
                          }
                          a || (a = r)
                      }
                      s = s || a
                  }
                  if (s) return s !== l[0] && l.unshift(s), n[s]
              }(f, M, a)), !d && w.inArray("script", f.dataTypes) > -1 && w.inArray("json", f.dataTypes) < 0 && (f.converters["text script"] = function() {}), x = function(e, t, n, i) {
                  var r, s, a, o, l, c = {},
                      u = e.dataTypes.slice();
                  if (u[1])
                      for (a in e.converters) c[a.toLowerCase()] = e.converters[a];
                  for (s = u.shift(); s;)
                      if (e.responseFields[s] && (n[e.responseFields[s]] = t), !l && i && e.dataFilter && (t = e.dataFilter(t, e.dataType)), l = s, s = u.shift())
                          if ("*" === s) s = l;
                          else if ("*" !== l && l !== s) {
                      if (!(a = c[l + " " + s] || c["* " + s]))
                          for (r in c)
                              if ((o = r.split(" "))[1] === s && (a = c[l + " " + o[0]] || c["* " + o[0]])) {
                                  !0 === a ? a = c[r] : !0 !== c[r] && (s = o[0], u.unshift(o[1]));
                                  break
                              }
                      if (!0 !== a)
                          if (a && e.throws) t = a(t);
                          else try {
                              t = a(t)
                          } catch (e) {
                              return {
                                  state: "parsererror",
                                  error: a ? e : "No conversion from " + l + " to " + s
                              }
                          }
                  }
                  return {
                      state: "success",
                      data: t
                  }
              }(f, x, M, d), d ? (f.ifModified && ((_ = M.getResponseHeader("Last-Modified")) && (w.lastModified[r] = _), (_ = M.getResponseHeader("etag")) && (w.etag[r] = _)), 204 === t || "HEAD" === f.type ? k = "nocontent" : 304 === t ? k = "notmodified" : (k = x.state, h = x.data, d = !(g = x.error))) : (g = k, !t && k || (k = "error", t < 0 && (t = 0))), M.status = t, M.statusText = (n || k) + "", d ? v.resolveWith(p, [h, k, M]) : v.rejectWith(p, [M, k, g]), M.statusCode(b), b = void 0, u && m.trigger(d ? "ajaxSuccess" : "ajaxError", [M, f, d ? h : g]), y.fireWith(p, [M, k]), u && (m.trigger("ajaxComplete", [M, f]), --w.active || w.event.trigger("ajaxStop")))
          }
          return M
      },
      getJSON: function(e, t, n) {
          return w.get(e, t, n, "json")
      },
      getScript: function(e, t) {
          return w.get(e, void 0, t, "script")
      }
  }), w.each(["get", "post"], (function(e, t) {
      w[t] = function(e, n, i, r) {
          return p(n) && (r = r || i, i = n, n = void 0), w.ajax(w.extend({
              url: e,
              type: t,
              dataType: r,
              data: n,
              success: i
          }, w.isPlainObject(e) && e))
      }
  })), w.ajaxPrefilter((function(e) {
      var t;
      for (t in e.headers) "content-type" === t.toLowerCase() && (e.contentType = e.headers[t] || "")
  })), w._evalUrl = function(e, t, n) {
      return w.ajax({
          url: e,
          type: "GET",
          dataType: "script",
          cache: !0,
          async: !1,
          global: !1,
          converters: {
              "text script": function() {}
          },
          dataFilter: function(e) {
              w.globalEval(e, t, n)
          }
      })
  }, w.fn.extend({
      wrapAll: function(e) {
          var t;
          return this[0] && (p(e) && (e = e.call(this[0])), t = w(e, this[0].ownerDocument).eq(0).clone(!0), this[0].parentNode && t.insertBefore(this[0]), t.map((function() {
              for (var e = this; e.firstElementChild;) e = e.firstElementChild;
              return e
          })).append(this)), this
      },
      wrapInner: function(e) {
          return p(e) ? this.each((function(t) {
              w(this).wrapInner(e.call(this, t))
          })) : this.each((function() {
              var t = w(this),
                  n = t.contents();
              n.length ? n.wrapAll(e) : t.append(e)
          }))
      },
      wrap: function(e) {
          var t = p(e);
          return this.each((function(n) {
              w(this).wrapAll(t ? e.call(this, n) : e)
          }))
      },
      unwrap: function(e) {
          return this.parent(e).not("body").each((function() {
              w(this).replaceWith(this.childNodes)
          })), this
      }
  }), w.expr.pseudos.hidden = function(e) {
      return !w.expr.pseudos.visible(e)
  }, w.expr.pseudos.visible = function(e) {
      return !!(e.offsetWidth || e.offsetHeight || e.getClientRects().length)
  }, w.ajaxSettings.xhr = function() {
      try {
          return new e.XMLHttpRequest
      } catch (e) {}
  };
  var Gt = {
          0: 200,
          1223: 204
      },
      Zt = w.ajaxSettings.xhr();
  f.cors = !!Zt && "withCredentials" in Zt, f.ajax = Zt = !!Zt, w.ajaxTransport((function(t) {
      var n, i;
      if (f.cors || Zt && !t.crossDomain) return {
          send: function(r, s) {
              var a, o = t.xhr();
              if (o.open(t.type, t.url, t.async, t.username, t.password), t.xhrFields)
                  for (a in t.xhrFields) o[a] = t.xhrFields[a];
              for (a in t.mimeType && o.overrideMimeType && o.overrideMimeType(t.mimeType), t.crossDomain || r["X-Requested-With"] || (r["X-Requested-With"] = "XMLHttpRequest"), r) o.setRequestHeader(a, r[a]);
              n = function(e) {
                  return function() {
                      n && (n = i = o.onload = o.onerror = o.onabort = o.ontimeout = o.onreadystatechange = null, "abort" === e ? o.abort() : "error" === e ? "number" != typeof o.status ? s(0, "error") : s(o.status, o.statusText) : s(Gt[o.status] || o.status, o.statusText, "text" !== (o.responseType || "text") || "string" != typeof o.responseText ? {
                          binary: o.response
                      } : {
                          text: o.responseText
                      }, o.getAllResponseHeaders()))
                  }
              }, o.onload = n(), i = o.onerror = o.ontimeout = n("error"), void 0 !== o.onabort ? o.onabort = i : o.onreadystatechange = function() {
                  4 === o.readyState && e.setTimeout((function() {
                      n && i()
                  }))
              }, n = n("abort");
              try {
                  o.send(t.hasContent && t.data || null)
              } catch (e) {
                  if (n) throw e
              }
          },
          abort: function() {
              n && n()
          }
      }
  })), w.ajaxPrefilter((function(e) {
      e.crossDomain && (e.contents.script = !1)
  })), w.ajaxSetup({
      accepts: {
          script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"
      },
      contents: {
          script: /\b(?:java|ecma)script\b/
      },
      converters: {
          "text script": function(e) {
              return w.globalEval(e), e
          }
      }
  }), w.ajaxPrefilter("script", (function(e) {
      void 0 === e.cache && (e.cache = !1), e.crossDomain && (e.type = "GET")
  })), w.ajaxTransport("script", (function(e) {
      var t, n;
      if (e.crossDomain || e.scriptAttrs) return {
          send: function(i, r) {
              t = w("<script>").attr(e.scriptAttrs || {}).prop({
                  charset: e.scriptCharset,
                  src: e.url
              }).on("load error", n = function(e) {
                  t.remove(), n = null, e && r("error" === e.type ? 404 : 200, e.type)
              }), g.head.appendChild(t[0])
          },
          abort: function() {
              n && n()
          }
      }
  }));
  var Kt, Jt = [],
      Qt = /(=)\?(?=&|$)|\?\?/;
  w.ajaxSetup({
      jsonp: "callback",
      jsonpCallback: function() {
          var e = Jt.pop() || w.expando + "_" + Lt.guid++;
          return this[e] = !0, e
      }
  }), w.ajaxPrefilter("json jsonp", (function(t, n, i) {
      var r, s, a, o = !1 !== t.jsonp && (Qt.test(t.url) ? "url" : "string" == typeof t.data && 0 === (t.contentType || "").indexOf("application/x-www-form-urlencoded") && Qt.test(t.data) && "data");
      if (o || "jsonp" === t.dataTypes[0]) return r = t.jsonpCallback = p(t.jsonpCallback) ? t.jsonpCallback() : t.jsonpCallback, o ? t[o] = t[o].replace(Qt, "$1" + r) : !1 !== t.jsonp && (t.url += (Tt.test(t.url) ? "&" : "?") + t.jsonp + "=" + r), t.converters["script json"] = function() {
          return a || w.error(r + " was not called"), a[0]
      }, t.dataTypes[0] = "json", s = e[r], e[r] = function() {
          a = arguments
      }, i.always((function() {
          void 0 === s ? w(e).removeProp(r) : e[r] = s, t[r] && (t.jsonpCallback = n.jsonpCallback, Jt.push(r)), a && p(s) && s(a[0]), a = s = void 0
      })), "script"
  })), f.createHTMLDocument = ((Kt = g.implementation.createHTMLDocument("").body).innerHTML = "<form></form><form></form>", 2 === Kt.childNodes.length), w.parseHTML = function(e, t, n) {
      return "string" != typeof e ? [] : ("boolean" == typeof t && (n = t, t = !1), t || (f.createHTMLDocument ? ((i = (t = g.implementation.createHTMLDocument("")).createElement("base")).href = g.location.href, t.head.appendChild(i)) : t = g), s = !n && [], (r = H.exec(e)) ? [t.createElement(r[1])] : (r = Ce([e], t, s), s && s.length && w(s).remove(), w.merge([], r.childNodes)));
      var i, r, s
  }, w.fn.load = function(e, t, n) {
      var i, r, s, a = this,
          o = e.indexOf(" ");
      return o > -1 && (i = wt(e.slice(o)), e = e.slice(0, o)), p(t) ? (n = t, t = void 0) : t && "object" == typeof t && (r = "POST"), a.length > 0 && w.ajax({
          url: e,
          type: r || "GET",
          dataType: "html",
          data: t
      }).done((function(e) {
          s = arguments, a.html(i ? w("<div>").append(w.parseHTML(e)).find(i) : e)
      })).always(n && function(e, t) {
          a.each((function() {
              n.apply(this, s || [e.responseText, t, e])
          }))
      }), this
  }, w.expr.pseudos.animated = function(e) {
      return w.grep(w.timers, (function(t) {
          return e === t.elem
      })).length
  }, w.offset = {
      setOffset: function(e, t, n) {
          var i, r, s, a, o, l, c = w.css(e, "position"),
              u = w(e),
              d = {};
          "static" === c && (e.style.position = "relative"), o = u.offset(), s = w.css(e, "top"), l = w.css(e, "left"), ("absolute" === c || "fixed" === c) && (s + l).indexOf("auto") > -1 ? (a = (i = u.position()).top, r = i.left) : (a = parseFloat(s) || 0, r = parseFloat(l) || 0), p(t) && (t = t.call(e, n, w.extend({}, o))), null != t.top && (d.top = t.top - o.top + a), null != t.left && (d.left = t.left - o.left + r), "using" in t ? t.using.call(e, d) : u.css(d)
      }
  }, w.fn.extend({
      offset: function(e) {
          if (arguments.length) return void 0 === e ? this : this.each((function(t) {
              w.offset.setOffset(this, e, t)
          }));
          var t, n, i = this[0];
          return i ? i.getClientRects().length ? (t = i.getBoundingClientRect(), n = i.ownerDocument.defaultView, {
              top: t.top + n.pageYOffset,
              left: t.left + n.pageXOffset
          }) : {
              top: 0,
              left: 0
          } : void 0
      },
      position: function() {
          if (this[0]) {
              var e, t, n, i = this[0],
                  r = {
                      top: 0,
                      left: 0
                  };
              if ("fixed" === w.css(i, "position")) t = i.getBoundingClientRect();
              else {
                  for (t = this.offset(), n = i.ownerDocument, e = i.offsetParent || n.documentElement; e && (e === n.body || e === n.documentElement) && "static" === w.css(e, "position");) e = e.parentNode;
                  e && e !== i && 1 === e.nodeType && ((r = w(e).offset()).top += w.css(e, "borderTopWidth", !0), r.left += w.css(e, "borderLeftWidth", !0))
              }
              return {
                  top: t.top - r.top - w.css(i, "marginTop", !0),
                  left: t.left - r.left - w.css(i, "marginLeft", !0)
              }
          }
      },
      offsetParent: function() {
          return this.map((function() {
              for (var e = this.offsetParent; e && "static" === w.css(e, "position");) e = e.offsetParent;
              return e || he
          }))
      }
  }), w.each({
      scrollLeft: "pageXOffset",
      scrollTop: "pageYOffset"
  }, (function(e, t) {
      var n = "pageYOffset" === t;
      w.fn[e] = function(i) {
          return K(this, (function(e, i, r) {
              var s;
              if (m(e) ? s = e : 9 === e.nodeType && (s = e.defaultView), void 0 === r) return s ? s[t] : e[i];
              s ? s.scrollTo(n ? s.pageXOffset : r, n ? r : s.pageYOffset) : e[i] = r
          }), e, i, arguments.length)
      }
  })), w.each(["top", "left"], (function(e, t) {
      w.cssHooks[t] = Ke(f.pixelPosition, (function(e, n) {
          if (n) return n = Ze(e, t), qe.test(n) ? w(e).position()[t] + "px" : n
      }))
  })), w.each({
      Height: "height",
      Width: "width"
  }, (function(e, t) {
      w.each({
          padding: "inner" + e,
          content: t,
          "": "outer" + e
      }, (function(n, i) {
          w.fn[i] = function(r, s) {
              var a = arguments.length && (n || "boolean" != typeof r),
                  o = n || (!0 === r || !0 === s ? "margin" : "border");
              return K(this, (function(t, n, r) {
                  var s;
                  return m(t) ? 0 === i.indexOf("outer") ? t["inner" + e] : t.document.documentElement["client" + e] : 9 === t.nodeType ? (s = t.documentElement, Math.max(t.body["scroll" + e], s["scroll" + e], t.body["offset" + e], s["offset" + e], s["client" + e])) : void 0 === r ? w.css(t, n, o) : w.style(t, n, r, o)
              }), t, a ? r : void 0, a)
          }
      }))
  })), w.each(["ajaxStart", "ajaxStop", "ajaxComplete", "ajaxError", "ajaxSuccess", "ajaxSend"], (function(e, t) {
      w.fn[t] = function(e) {
          return this.on(t, e)
      }
  })), w.fn.extend({
      bind: function(e, t, n) {
          return this.on(e, null, t, n)
      },
      unbind: function(e, t) {
          return this.off(e, null, t)
      },
      delegate: function(e, t, n, i) {
          return this.on(t, e, n, i)
      },
      undelegate: function(e, t, n) {
          return 1 === arguments.length ? this.off(e, "**") : this.off(t, e || "**", n)
      },
      hover: function(e, t) {
          return this.on("mouseenter", e).on("mouseleave", t || e)
      }
  }), w.each("blur focus focusin focusout resize scroll click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup contextmenu".split(" "), (function(e, t) {
      w.fn[t] = function(e, n) {
          return arguments.length > 0 ? this.on(t, null, e, n) : this.trigger(t)
      }
  }));
  var en = /^[\s\uFEFF\xA0]+|([^\s\uFEFF\xA0])[\s\uFEFF\xA0]+$/g;
  w.proxy = function(e, t) {
      var n, i, s;
      if ("string" == typeof t && (n = e[t], t = e, e = n), p(e)) return i = r.call(arguments, 2), s = function() {
          return e.apply(t || this, i.concat(r.call(arguments)))
      }, s.guid = e.guid = e.guid || w.guid++, s
  }, w.holdReady = function(e) {
      e ? w.readyWait++ : w.ready(!0)
  }, w.isArray = Array.isArray, w.parseJSON = JSON.parse, w.nodeName = M, w.isFunction = p, w.isWindow = m, w.camelCase = te, w.type = b, w.now = Date.now, w.isNumeric = function(e) {
      var t = w.type(e);
      return ("number" === t || "string" === t) && !isNaN(e - parseFloat(e))
  }, w.trim = function(e) {
      return null == e ? "" : (e + "").replace(en, "$1")
  }, "function" == typeof define && define.amd && define("jquery", [], (function() {
      return w
  }));
  var tn = e.jQuery,
      nn = e.$;
  return w.noConflict = function(t) {
      return e.$ === w && (e.$ = nn), t && e.jQuery === w && (e.jQuery = tn), w
  }, void 0 === t && (e.jQuery = e.$ = w), w
})),

/*!
* smooth-scroll v16.1.3
* Animate scrolling to anchor links
* (c) 2020 Chris Ferdinandi
* MIT License
* http://github.com/cferdinandi/smooth-scroll
*/
function(e, t) {
  "function" == typeof define && define.amd ? define([], (function() {
      return t(e)
  })) : "object" == typeof exports ? module.exports = t(e) : e.SmoothScroll = t(e)
}("undefined" != typeof global ? global : "undefined" != typeof window ? window : this, (function(e) {
  "use strict";
  var t = {
          ignore: "[data-scroll-ignore]",
          header: null,
          topOnEmptyHash: !0,
          speed: 500,
          speedAsDuration: !1,
          durationMax: null,
          durationMin: null,
          clip: !0,
          offset: 0,
          easing: "easeInOutCubic",
          customEasing: null,
          updateURL: !0,
          popstate: !0,
          emitEvents: !0
      },
      n = function() {
          var e = {};
          return Array.prototype.forEach.call(arguments, (function(t) {
              for (var n in t) {
                  if (!t.hasOwnProperty(n)) return;
                  e[n] = t[n]
              }
          })), e
      },
      i = function(e) {
          "#" === e.charAt(0) && (e = e.substr(1));
          for (var t, n = String(e), i = n.length, r = -1, s = "", a = n.charCodeAt(0); ++r < i;) {
              if (0 === (t = n.charCodeAt(r))) throw new InvalidCharacterError("Invalid character: the input contains U+0000.");
              t >= 1 && t <= 31 || 127 == t || 0 === r && t >= 48 && t <= 57 || 1 === r && t >= 48 && t <= 57 && 45 === a ? s += "\\" + t.toString(16) + " " : s += t >= 128 || 45 === t || 95 === t || t >= 48 && t <= 57 || t >= 65 && t <= 90 || t >= 97 && t <= 122 ? n.charAt(r) : "\\" + n.charAt(r)
          }
          return "#" + s
      },
      r = function() {
          return Math.max(document.body.scrollHeight, document.documentElement.scrollHeight, document.body.offsetHeight, document.documentElement.offsetHeight, document.body.clientHeight, document.documentElement.clientHeight)
      },
      s = function(t) {
          return t ? (n = t, parseInt(e.getComputedStyle(n).height, 10) + t.offsetTop) : 0;
          var n
      },
      a = function(t, n, i) {
          0 === t && document.body.focus(), i || (t.focus(), document.activeElement !== t && (t.setAttribute("tabindex", "-1"), t.focus(), t.style.outline = "none"), e.scrollTo(0, n))
      },
      o = function(t, n, i, r) {
          if (n.emitEvents && "function" == typeof e.CustomEvent) {
              var s = new CustomEvent(t, {
                  bubbles: !0,
                  detail: {
                      anchor: i,
                      toggle: r
                  }
              });
              document.dispatchEvent(s)
          }
      };
  return function(l, c) {
      var u, d, h, f, p = {};
      p.cancelScroll = function(e) {
          cancelAnimationFrame(f), f = null, e || o("scrollCancel", u)
      }, p.animateScroll = function(i, l, c) {
          p.cancelScroll();
          var d = n(u || t, c || {}),
              m = "[object Number]" === Object.prototype.toString.call(i),
              g = m || !i.tagName ? null : i;
          if (m || g) {
              var v = e.pageYOffset;
              d.header && !h && (h = document.querySelector(d.header));
              var y, b, x, _ = s(h),
                  w = m ? i : function(t, n, i, s) {
                      var a = 0;
                      if (t.offsetParent)
                          do {
                              a += t.offsetTop, t = t.offsetParent
                          } while (t);
                      return a = Math.max(a - n - i, 0), s && (a = Math.min(a, r() - e.innerHeight)), a
                  }(g, _, parseInt("function" == typeof d.offset ? d.offset(i, l) : d.offset, 10), d.clip),
                  k = w - v,
                  M = r(),
                  S = 0,
                  A = function(e, t) {
                      var n = t.speedAsDuration ? t.speed : Math.abs(e / 1e3 * t.speed);
                      return t.durationMax && n > t.durationMax ? t.durationMax : t.durationMin && n < t.durationMin ? t.durationMin : parseInt(n, 10)
                  }(k, d),
                  L = function(t) {
                      y || (y = t), S += t - y, x = v + k * function(e, t) {
                              var n;
                              return "easeInQuad" === e.easing && (n = t * t), "easeOutQuad" === e.easing && (n = t * (2 - t)), "easeInOutQuad" === e.easing && (n = t < .5 ? 2 * t * t : (4 - 2 * t) * t - 1), "easeInCubic" === e.easing && (n = t * t * t), "easeOutCubic" === e.easing && (n = --t * t * t + 1), "easeInOutCubic" === e.easing && (n = t < .5 ? 4 * t * t * t : (t - 1) * (2 * t - 2) * (2 * t - 2) + 1), "easeInQuart" === e.easing && (n = t * t * t * t), "easeOutQuart" === e.easing && (n = 1 - --t * t * t * t), "easeInOutQuart" === e.easing && (n = t < .5 ? 8 * t * t * t * t : 1 - 8 * --t * t * t * t), "easeInQuint" === e.easing && (n = t * t * t * t * t), "easeOutQuint" === e.easing && (n = 1 + --t * t * t * t * t), "easeInOutQuint" === e.easing && (n = t < .5 ? 16 * t * t * t * t * t : 1 + 16 * --t * t * t * t * t), e.customEasing && (n = e.customEasing(t)), n || t
                          }(d, b = (b = 0 === A ? 0 : S / A) > 1 ? 1 : b), e.scrollTo(0, Math.floor(x)),
                          function(t, n) {
                              var r = e.pageYOffset;
                              if (t == n || r == n || (v < n && e.innerHeight + r) >= M) return p.cancelScroll(!0), a(i, n, m), o("scrollStop", d, i, l), y = null, f = null, !0
                          }(x, w) || (f = e.requestAnimationFrame(L), y = t)
                  };
              0 === e.pageYOffset && e.scrollTo(0, 0),
                  function(e, t, n) {
                      t || history.pushState && n.updateURL && history.pushState({
                          smoothScroll: JSON.stringify(n),
                          anchor: e.id
                      }, document.title, e === document.documentElement ? "#top" : "#" + e.id)
                  }(i, m, d), "matchMedia" in e && e.matchMedia("(prefers-reduced-motion)").matches ? a(i, Math.floor(w), !1) : (o("scrollStart", d, i, l), p.cancelScroll(!0), e.requestAnimationFrame(L))
          }
      };
      var m = function(t) {
              if (!t.defaultPrevented && !(0 !== t.button || t.metaKey || t.ctrlKey || t.shiftKey) && "closest" in t.target && (d = t.target.closest(l)) && "a" === d.tagName.toLowerCase() && !t.target.closest(u.ignore) && d.hostname === e.location.hostname && d.pathname === e.location.pathname && /#/.test(d.href)) {
                  var n, r;
                  try {
                      n = i(decodeURIComponent(d.hash))
                  } catch (e) {
                      n = i(d.hash)
                  }
                  if ("#" === n) {
                      if (!u.topOnEmptyHash) return;
                      r = document.documentElement
                  } else r = document.querySelector(n);
                  (r = r || "#top" !== n ? r : document.documentElement) && (t.preventDefault(), function(t) {
                      if (history.replaceState && t.updateURL && !history.state) {
                          var n = e.location.hash;
                          n = n || "", history.replaceState({
                              smoothScroll: JSON.stringify(t),
                              anchor: n || e.pageYOffset
                          }, document.title, n || e.location.href)
                      }
                  }(u), p.animateScroll(r, d))
              }
          },
          g = function(e) {
              if (null !== history.state && history.state.smoothScroll && history.state.smoothScroll === JSON.stringify(u)) {
                  var t = history.state.anchor;
                  "string" == typeof t && t && !(t = document.querySelector(i(history.state.anchor))) || p.animateScroll(t, null, {
                      updateURL: !1
                  })
              }
          };
      p.destroy = function() {
          u && (document.removeEventListener("click", m, !1), e.removeEventListener("popstate", g, !1), p.cancelScroll(), u = null, d = null, h = null, f = null)
      };
      return function() {
          if (!("querySelector" in document && "addEventListener" in e && "requestAnimationFrame" in e && "closest" in e.Element.prototype)) throw "Smooth Scroll: This browser does not support the required JavaScript methods and browser APIs.";
          p.destroy(), u = n(t, c || {}), h = u.header ? document.querySelector(u.header) : null, document.addEventListener("click", m, !1), u.updateURL && u.popstate && e.addEventListener("popstate", g, !1)
      }(), p
  }
}))