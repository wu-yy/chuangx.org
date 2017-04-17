define("appSrc/include/index/aboutUs", ["jquery", "appCommon"],
function(a, b) {
    return a("#js_xy_aboutus").length ? void b(function() {
        function b() {
            "#about_us" == location.href.substring(location.href.indexOf("#")) ? (d.add(e).add(f).add(h).add(g).hide(), c.show(), i.find("li").removeClass("on").eq(0).addClass("on"), i.find("li").eq(0).html('<a href="#about_us" title="关于我们">关于我们</a>')) : "#about_us_en" == location.href.substring(location.href.indexOf("#")) ? (c.add(f).add(h).add(g).add(e).hide(), d.show(), i.find("li").removeClass("on").eq(0).addClass("on"), i.find("li").eq(0).html('<a href="#about_us_en" title="About Us">About Us</a>')) : "#leadership" == location.href.substring(location.href.indexOf("#")) ? (c.add(d).add(f).add(h).add(e).hide(), g.show(), i.find("li").removeClass("on").eq(1).addClass("on")) : "#join_us" == location.href.substring(location.href.indexOf("#")) ? (c.add(d).add(f).add(h).add(g).add(e).hide(), f.show(), i.find("li").removeClass("on").eq(2).addClass("on")) : "#contact" == location.href.substring(location.href.indexOf("#")) ? (c.add(d).add(f).add(h).add(g).add(e).hide(), e.show(), i.find("li").removeClass("on").eq(3).addClass("on")) : "#question" == location.href.substring(location.href.indexOf("#")) ? (c.add(d).add(e).add(f).add(g).hide(), h.show(), i.find("li").removeClass("on").eq(4).addClass("on")) : (e.add(d).add(f).add(h).add(g).hide(), c.show(), i.find("li").removeClass("on").eq(0).addClass("on"))
        }
        var c = a("#about_us_"),
        d = a("#about_us_en_"),
        e = a("#contact_"),
        f = a("#join_us_"),
        g = a("#leadership_"),
        h = a("#question_"),
        i = a("#a_nav"),
        j = a(window).height() - a("#header_bootstrap").height() - a("#footer_bootstrap").height() - 150;
        c.css("min-height", j),
        d.css("min-height", j),
        e.css("min-height", j),
        f.css("min-height", j),
        g.css("min-height", j),
        h.css("min-height", j),
        b(),
        a(window).on("hashchange", b)
    }) : !1
}),
define("appSrc/include/index/androidDownload", ["jquery", "analyse", "footer", "userTrack"],
function(a, b) {
    if (!a("#js_xy_client_down").length) return ! 1;
    var c = a("#img_play"),
    d = c.find("ul").eq(0),
    e = a(".download_app_ios").find("article");
    $width = c.width(),
    $btn = a("#btn_d").find("a"),
    $num = 0,
    $colors = new Array("e2d7ce", "fbd06a", "fca179", "c2a6d5"),
    $btn.on("click",
    function() {
        $num = a(this).addClass("on").siblings().removeClass("on").end().index(),
        e.css("background-color", "#" + $colors[$num]),
        d.css("left", -$num * $width)
    });
    var f = setInterval(function() {
        $btn.eq($num).trigger("click"),
        $num = ($num + 1) % $btn.length
    },
    5e3);
    c.on({
        mouseenter: function() {
            clearTimeout(f)
        },
        mouseleave: function() {
            f = setInterval(function() {
                $btn.eq($num).trigger("click"),
                $num = ($num + 1) % $btn.length
            },
            5e3)
        }
    }),
    setTimeout(b, 10)
}),
define("appSrc/include/index/consociationSchool", ["jquery", "support/transitionend", "appCommon"],
function(a, b, c) {
    return a("#js_xy_consociation_school").length ? (b(), void c(function() {
        var b = a("#banner"),
        c = b.find("ul").eq(0),
        d = c.find("li"),
        e = b.find(".txt"),
        f = "<ol>",
        g = a.support.transition,
        h = 0,
        i = ["transitionend", "webkitTransitionEnd", "MSTransitionEnd", "oTransitionEnd"],
        j = parseInt(b.width());
        c.width(d.length * j),
        d.width(j),
        a(window).on("resize",
        function() {
            j = parseInt(b.width()),
            c.width(d.length * j),
            d.width(j)
        }),
        d.each(function() {
            var b = a(this);
            b.css("background", "url(" + b.data("img") + ") no-repeat 50% 50%"),
            f += "<li></li>"
        }),
        f += "</ol>";
        var k = a(f).appendTo(b).find("li").eq(0).addClass("on").end().on("click",
        function() {
            var b = a(this);
            h = b.index(),
            c.css("left", -h * j),
            b.addClass("on").siblings().removeClass("on")
        });
        if (g) for (var l = 0,
        m = i.length; m > l; l++) c[0].addEventListener(i[l],
        function() {
            e.removeClass("txt_on").eq(h).addClass("txt_on")
        },
        !1);
        else e.addClass("txt_on");
        var n = function() {
            h = (h + 1) % k.length,
            k.eq(h).trigger("click")
        },
        o = 8e3,
        p = setInterval(n, o);
        b.on({
            mouseenter: function() {
                clearInterval(p)
            },
            mouseleave: function() {
                p = setInterval(n, o)
            }
        }),
        a(function() {
            b.css("visibility", "visible")
        })
    })) : !1
}),
function(a, b) {
    "object" == typeof exports && "undefined" != typeof module ? module.exports = b() : "function" == typeof define && define.amd ? define("moment", b) : a.moment = b()
} (this,
function() {
    function a() {
        return Hc.apply(null, arguments)
    }
    function b(a) {
        Hc = a
    }
    function c(a) {
        return "[object Array]" === Object.prototype.toString.call(a)
    }
    function d(a) {
        return a instanceof Date || "[object Date]" === Object.prototype.toString.call(a)
    }
    function e(a, b) {
        var c, d = [];
        for (c = 0; c < a.length; ++c) d.push(b(a[c], c));
        return d
    }
    function f(a, b) {
        return Object.prototype.hasOwnProperty.call(a, b)
    }
    function g(a, b) {
        for (var c in b) f(b, c) && (a[c] = b[c]);
        return f(b, "toString") && (a.toString = b.toString),
        f(b, "valueOf") && (a.valueOf = b.valueOf),
        a
    }
    function h(a, b, c, d) {
        return Ca(a, b, c, d, !0).utc()
    }
    function i() {
        return {
            empty: !1,
            unusedTokens: [],
            unusedInput: [],
            overflow: -2,
            charsLeftOver: 0,
            nullInput: !1,
            invalidMonth: null,
            invalidFormat: !1,
            userInvalidated: !1,
            iso: !1
        }
    }
    function j(a) {
        return null == a._pf && (a._pf = i()),
        a._pf
    }
    function k(a) {
        if (null == a._isValid) {
            var b = j(a);
            a._isValid = !(isNaN(a._d.getTime()) || !(b.overflow < 0) || b.empty || b.invalidMonth || b.invalidWeekday || b.nullInput || b.invalidFormat || b.userInvalidated),
            a._strict && (a._isValid = a._isValid && 0 === b.charsLeftOver && 0 === b.unusedTokens.length && void 0 === b.bigHour)
        }
        return a._isValid
    }
    function l(a) {
        var b = h(0 / 0);
        return null != a ? g(j(b), a) : j(b).userInvalidated = !0,
        b
    }
    function m(a, b) {
        var c, d, e;
        if ("undefined" != typeof b._isAMomentObject && (a._isAMomentObject = b._isAMomentObject), "undefined" != typeof b._i && (a._i = b._i), "undefined" != typeof b._f && (a._f = b._f), "undefined" != typeof b._l && (a._l = b._l), "undefined" != typeof b._strict && (a._strict = b._strict), "undefined" != typeof b._tzm && (a._tzm = b._tzm), "undefined" != typeof b._isUTC && (a._isUTC = b._isUTC), "undefined" != typeof b._offset && (a._offset = b._offset), "undefined" != typeof b._pf && (a._pf = j(b)), "undefined" != typeof b._locale && (a._locale = b._locale), Jc.length > 0) for (c in Jc) d = Jc[c],
        e = b[d],
        "undefined" != typeof e && (a[d] = e);
        return a
    }
    function n(b) {
        m(this, b),
        this._d = new Date(null != b._d ? b._d.getTime() : 0 / 0),
        Kc === !1 && (Kc = !0, a.updateOffset(this), Kc = !1)
    }
    function o(a) {
        return a instanceof n || null != a && null != a._isAMomentObject
    }
    function p(a) {
        return 0 > a ? Math.ceil(a) : Math.floor(a)
    }
    function q(a) {
        var b = +a,
        c = 0;
        return 0 !== b && isFinite(b) && (c = p(b)),
        c
    }
    function r(a, b, c) {
        var d, e = Math.min(a.length, b.length),
        f = Math.abs(a.length - b.length),
        g = 0;
        for (d = 0; e > d; d++)(c && a[d] !== b[d] || !c && q(a[d]) !== q(b[d])) && g++;
        return g + f
    }
    function s() {}
    function t(a) {
        return a ? a.toLowerCase().replace("_", "-") : a
    }
    function u(a) {
        for (var b, c, d, e, f = 0; f < a.length;) {
            for (e = t(a[f]).split("-"), b = e.length, c = t(a[f + 1]), c = c ? c.split("-") : null; b > 0;) {
                if (d = v(e.slice(0, b).join("-"))) return d;
                if (c && c.length >= b && r(e, c, !0) >= b - 1) break;
                b--
            }
            f++
        }
        return null
    }
    function v(a) {
        var b = null;
        if (!Lc[a] && "undefined" != typeof module && module && module.exports) try {
            b = Ic._abbr,
            require("./locale/" + a),
            w(b)
        } catch(c) {}
        return Lc[a]
    }
    function w(a, b) {
        var c;
        return a && (c = "undefined" == typeof b ? y(a) : x(a, b), c && (Ic = c)),
        Ic._abbr
    }
    function x(a, b) {
        return null !== b ? (b.abbr = a, Lc[a] = Lc[a] || new s, Lc[a].set(b), w(a), Lc[a]) : (delete Lc[a], null)
    }
    function y(a) {
        var b;
        if (a && a._locale && a._locale._abbr && (a = a._locale._abbr), !a) return Ic;
        if (!c(a)) {
            if (b = v(a)) return b;
            a = [a]
        }
        return u(a)
    }
    function z(a, b) {
        var c = a.toLowerCase();
        Mc[c] = Mc[c + "s"] = Mc[b] = a
    }
    function A(a) {
        return "string" == typeof a ? Mc[a] || Mc[a.toLowerCase()] : void 0
    }
    function B(a) {
        var b, c, d = {};
        for (c in a) f(a, c) && (b = A(c), b && (d[b] = a[c]));
        return d
    }
    function C(b, c) {
        return function(d) {
            return null != d ? (E(this, b, d), a.updateOffset(this, c), this) : D(this, b)
        }
    }
    function D(a, b) {
        return a._d["get" + (a._isUTC ? "UTC": "") + b]()
    }
    function E(a, b, c) {
        return a._d["set" + (a._isUTC ? "UTC": "") + b](c)
    }
    function F(a, b) {
        var c;
        if ("object" == typeof a) for (c in a) this.set(c, a[c]);
        else if (a = A(a), "function" == typeof this[a]) return this[a](b);
        return this
    }
    function G(a, b, c) {
        var d = "" + Math.abs(a),
        e = b - d.length,
        f = a >= 0;
        return (f ? c ? "+": "": "-") + Math.pow(10, Math.max(0, e)).toString().substr(1) + d
    }
    function H(a, b, c, d) {
        var e = d;
        "string" == typeof d && (e = function() {
            return this[d]()
        }),
        a && (Qc[a] = e),
        b && (Qc[b[0]] = function() {
            return G(e.apply(this, arguments), b[1], b[2])
        }),
        c && (Qc[c] = function() {
            return this.localeData().ordinal(e.apply(this, arguments), a)
        })
    }
    function I(a) {
        return a.match(/\[[\s\S]/) ? a.replace(/^\[|\]$/g, "") : a.replace(/\\/g, "")
    }
    function J(a) {
        var b, c, d = a.match(Nc);
        for (b = 0, c = d.length; c > b; b++) d[b] = Qc[d[b]] ? Qc[d[b]] : I(d[b]);
        return function(e) {
            var f = "";
            for (b = 0; c > b; b++) f += d[b] instanceof Function ? d[b].call(e, a) : d[b];
            return f
        }
    }
    function K(a, b) {
        return a.isValid() ? (b = L(b, a.localeData()), Pc[b] = Pc[b] || J(b), Pc[b](a)) : a.localeData().invalidDate()
    }
    function L(a, b) {
        function c(a) {
            return b.longDateFormat(a) || a
        }
        var d = 5;
        for (Oc.lastIndex = 0; d >= 0 && Oc.test(a);) a = a.replace(Oc, c),
        Oc.lastIndex = 0,
        d -= 1;
        return a
    }
    function M(a) {
        return "function" == typeof a && "[object Function]" === Object.prototype.toString.call(a)
    }
    function N(a, b, c) {
        dd[a] = M(b) ? b: function(a) {
            return a && c ? c: b
        }
    }
    function O(a, b) {
        return f(dd, a) ? dd[a](b._strict, b._locale) : new RegExp(P(a))
    }
    function P(a) {
        return a.replace("\\", "").replace(/\\(\[)|\\(\])|\[([^\]\[]*)\]|\\(.)/g,
        function(a, b, c, d, e) {
            return b || c || d || e
        }).replace(/[-\/\\^$*+?.()|[\]{}]/g, "\\$&")
    }
    function Q(a, b) {
        var c, d = b;
        for ("string" == typeof a && (a = [a]), "number" == typeof b && (d = function(a, c) {
            c[b] = q(a)
        }), c = 0; c < a.length; c++) ed[a[c]] = d
    }
    function R(a, b) {
        Q(a,
        function(a, c, d, e) {
            d._w = d._w || {},
            b(a, d._w, d, e)
        })
    }
    function S(a, b, c) {
        null != b && f(ed, a) && ed[a](b, c._a, c, a)
    }
    function T(a, b) {
        return new Date(Date.UTC(a, b + 1, 0)).getUTCDate()
    }
    function U(a) {
        return this._months[a.month()]
    }
    function V(a) {
        return this._monthsShort[a.month()]
    }
    function W(a, b, c) {
        var d, e, f;
        for (this._monthsParse || (this._monthsParse = [], this._longMonthsParse = [], this._shortMonthsParse = []), d = 0; 12 > d; d++) {
            if (e = h([2e3, d]), c && !this._longMonthsParse[d] && (this._longMonthsParse[d] = new RegExp("^" + this.months(e, "").replace(".", "") + "$", "i"), this._shortMonthsParse[d] = new RegExp("^" + this.monthsShort(e, "").replace(".", "") + "$", "i")), c || this._monthsParse[d] || (f = "^" + this.months(e, "") + "|^" + this.monthsShort(e, ""), this._monthsParse[d] = new RegExp(f.replace(".", ""), "i")), c && "MMMM" === b && this._longMonthsParse[d].test(a)) return d;
            if (c && "MMM" === b && this._shortMonthsParse[d].test(a)) return d;
            if (!c && this._monthsParse[d].test(a)) return d
        }
    }
    function X(a, b) {
        var c;
        return "string" == typeof b && (b = a.localeData().monthsParse(b), "number" != typeof b) ? a: (c = Math.min(a.date(), T(a.year(), b)), a._d["set" + (a._isUTC ? "UTC": "") + "Month"](b, c), a)
    }
    function Y(b) {
        return null != b ? (X(this, b), a.updateOffset(this, !0), this) : D(this, "Month")
    }
    function Z() {
        return T(this.year(), this.month())
    }
    function $(a) {
        var b, c = a._a;
        return c && -2 === j(a).overflow && (b = c[gd] < 0 || c[gd] > 11 ? gd: c[hd] < 1 || c[hd] > T(c[fd], c[gd]) ? hd: c[id] < 0 || c[id] > 24 || 24 === c[id] && (0 !== c[jd] || 0 !== c[kd] || 0 !== c[ld]) ? id: c[jd] < 0 || c[jd] > 59 ? jd: c[kd] < 0 || c[kd] > 59 ? kd: c[ld] < 0 || c[ld] > 999 ? ld: -1, j(a)._overflowDayOfYear && (fd > b || b > hd) && (b = hd), j(a).overflow = b),
        a
    }
    function _(b) {
        a.suppressDeprecationWarnings === !1 && "undefined" != typeof console && console.warn && console.warn("Deprecation warning: " + b)
    }
    function aa(a, b) {
        var c = !0;
        return g(function() {
            return c && (_(a + "\n" + (new Error).stack), c = !1),
            b.apply(this, arguments)
        },
        b)
    }
    function ba(a, b) {
        od[a] || (_(b), od[a] = !0)
    }
    function ca(a) {
        var b, c, d = a._i,
        e = pd.exec(d);
        if (e) {
            for (j(a).iso = !0, b = 0, c = qd.length; c > b; b++) if (qd[b][1].exec(d)) {
                a._f = qd[b][0];
                break
            }
            for (b = 0, c = rd.length; c > b; b++) if (rd[b][1].exec(d)) {
                a._f += (e[6] || " ") + rd[b][0];
                break
            }
            d.match(ad) && (a._f += "Z"),
            va(a)
        } else a._isValid = !1
    }
    function da(b) {
        var c = sd.exec(b._i);
        return null !== c ? void(b._d = new Date( + c[1])) : (ca(b), void(b._isValid === !1 && (delete b._isValid, a.createFromInputFallback(b))))
    }
    function ea(a, b, c, d, e, f, g) {
        var h = new Date(a, b, c, d, e, f, g);
        return 1970 > a && h.setFullYear(a),
        h
    }
    function fa(a) {
        var b = new Date(Date.UTC.apply(null, arguments));
        return 1970 > a && b.setUTCFullYear(a),
        b
    }
    function ga(a) {
        return ha(a) ? 366 : 365
    }
    function ha(a) {
        return a % 4 === 0 && a % 100 !== 0 || a % 400 === 0
    }
    function ia() {
        return ha(this.year())
    }
    function ja(a, b, c) {
        var d, e = c - b,
        f = c - a.day();
        return f > e && (f -= 7),
        e - 7 > f && (f += 7),
        d = Da(a).add(f, "d"),
        {
            week: Math.ceil(d.dayOfYear() / 7),
            year: d.year()
        }
    }
    function ka(a) {
        return ja(a, this._week.dow, this._week.doy).week
    }
    function la() {
        return this._week.dow
    }
    function ma() {
        return this._week.doy
    }
    function na(a) {
        var b = this.localeData().week(this);
        return null == a ? b: this.add(7 * (a - b), "d")
    }
    function oa(a) {
        var b = ja(this, 1, 4).week;
        return null == a ? b: this.add(7 * (a - b), "d")
    }
    function pa(a, b, c, d, e) {
        var f, g = 6 + e - d,
        h = fa(a, 0, 1 + g),
        i = h.getUTCDay();
        return e > i && (i += 7),
        c = null != c ? 1 * c: e,
        f = 1 + g + 7 * (b - 1) - i + c,
        {
            year: f > 0 ? a: a - 1,
            dayOfYear: f > 0 ? f: ga(a - 1) + f
        }
    }
    function qa(a) {
        var b = Math.round((this.clone().startOf("day") - this.clone().startOf("year")) / 864e5) + 1;
        return null == a ? b: this.add(a - b, "d")
    }
    function ra(a, b, c) {
        return null != a ? a: null != b ? b: c
    }
    function sa(a) {
        var b = new Date;
        return a._useUTC ? [b.getUTCFullYear(), b.getUTCMonth(), b.getUTCDate()] : [b.getFullYear(), b.getMonth(), b.getDate()]
    }
    function ta(a) {
        var b, c, d, e, f = [];
        if (!a._d) {
            for (d = sa(a), a._w && null == a._a[hd] && null == a._a[gd] && ua(a), a._dayOfYear && (e = ra(a._a[fd], d[fd]), a._dayOfYear > ga(e) && (j(a)._overflowDayOfYear = !0), c = fa(e, 0, a._dayOfYear), a._a[gd] = c.getUTCMonth(), a._a[hd] = c.getUTCDate()), b = 0; 3 > b && null == a._a[b]; ++b) a._a[b] = f[b] = d[b];
            for (; 7 > b; b++) a._a[b] = f[b] = null == a._a[b] ? 2 === b ? 1 : 0 : a._a[b];
            24 === a._a[id] && 0 === a._a[jd] && 0 === a._a[kd] && 0 === a._a[ld] && (a._nextDay = !0, a._a[id] = 0),
            a._d = (a._useUTC ? fa: ea).apply(null, f),
            null != a._tzm && a._d.setUTCMinutes(a._d.getUTCMinutes() - a._tzm),
            a._nextDay && (a._a[id] = 24)
        }
    }
    function ua(a) {
        var b, c, d, e, f, g, h;
        b = a._w,
        null != b.GG || null != b.W || null != b.E ? (f = 1, g = 4, c = ra(b.GG, a._a[fd], ja(Da(), 1, 4).year), d = ra(b.W, 1), e = ra(b.E, 1)) : (f = a._locale._week.dow, g = a._locale._week.doy, c = ra(b.gg, a._a[fd], ja(Da(), f, g).year), d = ra(b.w, 1), null != b.d ? (e = b.d, f > e && ++d) : e = null != b.e ? b.e + f: f),
        h = pa(c, d, e, g, f),
        a._a[fd] = h.year,
        a._dayOfYear = h.dayOfYear
    }
    function va(b) {
        if (b._f === a.ISO_8601) return void ca(b);
        b._a = [],
        j(b).empty = !0;
        var c, d, e, f, g, h = "" + b._i,
        i = h.length,
        k = 0;
        for (e = L(b._f, b._locale).match(Nc) || [], c = 0; c < e.length; c++) f = e[c],
        d = (h.match(O(f, b)) || [])[0],
        d && (g = h.substr(0, h.indexOf(d)), g.length > 0 && j(b).unusedInput.push(g), h = h.slice(h.indexOf(d) + d.length), k += d.length),
        Qc[f] ? (d ? j(b).empty = !1 : j(b).unusedTokens.push(f), S(f, d, b)) : b._strict && !d && j(b).unusedTokens.push(f);
        j(b).charsLeftOver = i - k,
        h.length > 0 && j(b).unusedInput.push(h),
        j(b).bigHour === !0 && b._a[id] <= 12 && b._a[id] > 0 && (j(b).bigHour = void 0),
        b._a[id] = wa(b._locale, b._a[id], b._meridiem),
        ta(b),
        $(b)
    }
    function wa(a, b, c) {
        var d;
        return null == c ? b: null != a.meridiemHour ? a.meridiemHour(b, c) : null != a.isPM ? (d = a.isPM(c), d && 12 > b && (b += 12), d || 12 !== b || (b = 0), b) : b
    }
    function xa(a) {
        var b, c, d, e, f;
        if (0 === a._f.length) return j(a).invalidFormat = !0,
        void(a._d = new Date(0 / 0));
        for (e = 0; e < a._f.length; e++) f = 0,
        b = m({},
        a),
        null != a._useUTC && (b._useUTC = a._useUTC),
        b._f = a._f[e],
        va(b),
        k(b) && (f += j(b).charsLeftOver, f += 10 * j(b).unusedTokens.length, j(b).score = f, (null == d || d > f) && (d = f, c = b));
        g(a, c || b)
    }
    function ya(a) {
        if (!a._d) {
            var b = B(a._i);
            a._a = [b.year, b.month, b.day || b.date, b.hour, b.minute, b.second, b.millisecond],
            ta(a)
        }
    }
    function za(a) {
        var b = new n($(Aa(a)));
        return b._nextDay && (b.add(1, "d"), b._nextDay = void 0),
        b
    }
    function Aa(a) {
        var b = a._i,
        e = a._f;
        return a._locale = a._locale || y(a._l),
        null === b || void 0 === e && "" === b ? l({
            nullInput: !0
        }) : ("string" == typeof b && (a._i = b = a._locale.preparse(b)), o(b) ? new n($(b)) : (c(e) ? xa(a) : e ? va(a) : d(b) ? a._d = b: Ba(a), a))
    }
    function Ba(b) {
        var f = b._i;
        void 0 === f ? b._d = new Date: d(f) ? b._d = new Date( + f) : "string" == typeof f ? da(b) : c(f) ? (b._a = e(f.slice(0),
        function(a) {
            return parseInt(a, 10)
        }), ta(b)) : "object" == typeof f ? ya(b) : "number" == typeof f ? b._d = new Date(f) : a.createFromInputFallback(b)
    }
    function Ca(a, b, c, d, e) {
        var f = {};
        return "boolean" == typeof c && (d = c, c = void 0),
        f._isAMomentObject = !0,
        f._useUTC = f._isUTC = e,
        f._l = c,
        f._i = a,
        f._f = b,
        f._strict = d,
        za(f)
    }
    function Da(a, b, c, d) {
        return Ca(a, b, c, d, !1)
    }
    function Ea(a, b) {
        var d, e;
        if (1 === b.length && c(b[0]) && (b = b[0]), !b.length) return Da();
        for (d = b[0], e = 1; e < b.length; ++e)(!b[e].isValid() || b[e][a](d)) && (d = b[e]);
        return d
    }
    function Fa() {
        var a = [].slice.call(arguments, 0);
        return Ea("isBefore", a)
    }
    function Ga() {
        var a = [].slice.call(arguments, 0);
        return Ea("isAfter", a)
    }
    function Ha(a) {
        var b = B(a),
        c = b.year || 0,
        d = b.quarter || 0,
        e = b.month || 0,
        f = b.week || 0,
        g = b.day || 0,
        h = b.hour || 0,
        i = b.minute || 0,
        j = b.second || 0,
        k = b.millisecond || 0;
        this._milliseconds = +k + 1e3 * j + 6e4 * i + 36e5 * h,
        this._days = +g + 7 * f,
        this._months = +e + 3 * d + 12 * c,
        this._data = {},
        this._locale = y(),
        this._bubble()
    }
    function Ia(a) {
        return a instanceof Ha
    }
    function Ja(a, b) {
        H(a, 0, 0,
        function() {
            var a = this.utcOffset(),
            c = "+";
            return 0 > a && (a = -a, c = "-"),
            c + G(~~ (a / 60), 2) + b + G(~~a % 60, 2)
        })
    }
    function Ka(a) {
        var b = (a || "").match(ad) || [],
        c = b[b.length - 1] || [],
        d = (c + "").match(xd) || ["-", 0, 0],
        e = +(60 * d[1]) + q(d[2]);
        return "+" === d[0] ? e: -e
    }
    function La(b, c) {
        var e, f;
        return c._isUTC ? (e = c.clone(), f = (o(b) || d(b) ? +b: +Da(b)) - +e, e._d.setTime( + e._d + f), a.updateOffset(e, !1), e) : Da(b).local()
    }
    function Ma(a) {
        return 15 * -Math.round(a._d.getTimezoneOffset() / 15)
    }
    function Na(b, c) {
        var d, e = this._offset || 0;
        return null != b ? ("string" == typeof b && (b = Ka(b)), Math.abs(b) < 16 && (b = 60 * b), !this._isUTC && c && (d = Ma(this)), this._offset = b, this._isUTC = !0, null != d && this.add(d, "m"), e !== b && (!c || this._changeInProgress ? bb(this, Ya(b - e, "m"), 1, !1) : this._changeInProgress || (this._changeInProgress = !0, a.updateOffset(this, !0), this._changeInProgress = null)), this) : this._isUTC ? e: Ma(this)
    }
    function Oa(a, b) {
        return null != a ? ("string" != typeof a && (a = -a), this.utcOffset(a, b), this) : -this.utcOffset()
    }
    function Pa(a) {
        return this.utcOffset(0, a)
    }
    function Qa(a) {
        return this._isUTC && (this.utcOffset(0, a), this._isUTC = !1, a && this.subtract(Ma(this), "m")),
        this
    }
    function Ra() {
        return this._tzm ? this.utcOffset(this._tzm) : "string" == typeof this._i && this.utcOffset(Ka(this._i)),
        this
    }
    function Sa(a) {
        return a = a ? Da(a).utcOffset() : 0,
        (this.utcOffset() - a) % 60 === 0
    }
    function Ta() {
        return this.utcOffset() > this.clone().month(0).utcOffset() || this.utcOffset() > this.clone().month(5).utcOffset()
    }
    function Ua() {
        if ("undefined" != typeof this._isDSTShifted) return this._isDSTShifted;
        var a = {};
        if (m(a, this), a = Aa(a), a._a) {
            var b = a._isUTC ? h(a._a) : Da(a._a);
            this._isDSTShifted = this.isValid() && r(a._a, b.toArray()) > 0
        } else this._isDSTShifted = !1;
        return this._isDSTShifted
    }
    function Va() {
        return ! this._isUTC
    }
    function Wa() {
        return this._isUTC
    }
    function Xa() {
        return this._isUTC && 0 === this._offset
    }
    function Ya(a, b) {
        var c, d, e, g = a,
        h = null;
        return Ia(a) ? g = {
            ms: a._milliseconds,
            d: a._days,
            M: a._months
        }: "number" == typeof a ? (g = {},
        b ? g[b] = a: g.milliseconds = a) : (h = yd.exec(a)) ? (c = "-" === h[1] ? -1 : 1, g = {
            y: 0,
            d: q(h[hd]) * c,
            h: q(h[id]) * c,
            m: q(h[jd]) * c,
            s: q(h[kd]) * c,
            ms: q(h[ld]) * c
        }) : (h = zd.exec(a)) ? (c = "-" === h[1] ? -1 : 1, g = {
            y: Za(h[2], c),
            M: Za(h[3], c),
            d: Za(h[4], c),
            h: Za(h[5], c),
            m: Za(h[6], c),
            s: Za(h[7], c),
            w: Za(h[8], c)
        }) : null == g ? g = {}: "object" == typeof g && ("from" in g || "to" in g) && (e = _a(Da(g.from), Da(g.to)), g = {},
        g.ms = e.milliseconds, g.M = e.months),
        d = new Ha(g),
        Ia(a) && f(a, "_locale") && (d._locale = a._locale),
        d
    }
    function Za(a, b) {
        var c = a && parseFloat(a.replace(",", "."));
        return (isNaN(c) ? 0 : c) * b
    }
    function $a(a, b) {
        var c = {
            milliseconds: 0,
            months: 0
        };
        return c.months = b.month() - a.month() + 12 * (b.year() - a.year()),
        a.clone().add(c.months, "M").isAfter(b) && --c.months,
        c.milliseconds = +b - +a.clone().add(c.months, "M"),
        c
    }
    function _a(a, b) {
        var c;
        return b = La(b, a),
        a.isBefore(b) ? c = $a(a, b) : (c = $a(b, a), c.milliseconds = -c.milliseconds, c.months = -c.months),
        c
    }
    function ab(a, b) {
        return function(c, d) {
            var e, f;
            return null === d || isNaN( + d) || (ba(b, "moment()." + b + "(period, number) is deprecated. Please use moment()." + b + "(number, period)."), f = c, c = d, d = f),
            c = "string" == typeof c ? +c: c,
            e = Ya(c, d),
            bb(this, e, a),
            this
        }
    }
    function bb(b, c, d, e) {
        var f = c._milliseconds,
        g = c._days,
        h = c._months;
        e = null == e ? !0 : e,
        f && b._d.setTime( + b._d + f * d),
        g && E(b, "Date", D(b, "Date") + g * d),
        h && X(b, D(b, "Month") + h * d),
        e && a.updateOffset(b, g || h)
    }
    function cb(a, b) {
        var c = a || Da(),
        d = La(c, this).startOf("day"),
        e = this.diff(d, "days", !0),
        f = -6 > e ? "sameElse": -1 > e ? "lastWeek": 0 > e ? "lastDay": 1 > e ? "sameDay": 2 > e ? "nextDay": 7 > e ? "nextWeek": "sameElse";
        return this.format(b && b[f] || this.localeData().calendar(f, this, Da(c)))
    }
    function db() {
        return new n(this)
    }
    function eb(a, b) {
        var c;
        return b = A("undefined" != typeof b ? b: "millisecond"),
        "millisecond" === b ? (a = o(a) ? a: Da(a), +this > +a) : (c = o(a) ? +a: +Da(a), c < +this.clone().startOf(b))
    }
    function fb(a, b) {
        var c;
        return b = A("undefined" != typeof b ? b: "millisecond"),
        "millisecond" === b ? (a = o(a) ? a: Da(a), +a > +this) : (c = o(a) ? +a: +Da(a), +this.clone().endOf(b) < c)
    }
    function gb(a, b, c) {
        return this.isAfter(a, c) && this.isBefore(b, c)
    }
    function hb(a, b) {
        var c;
        return b = A(b || "millisecond"),
        "millisecond" === b ? (a = o(a) ? a: Da(a), +this === +a) : (c = +Da(a), +this.clone().startOf(b) <= c && c <= +this.clone().endOf(b))
    }
    function ib(a, b, c) {
        var d, e, f = La(a, this),
        g = 6e4 * (f.utcOffset() - this.utcOffset());
        return b = A(b),
        "year" === b || "month" === b || "quarter" === b ? (e = jb(this, f), "quarter" === b ? e /= 3 : "year" === b && (e /= 12)) : (d = this - f, e = "second" === b ? d / 1e3: "minute" === b ? d / 6e4: "hour" === b ? d / 36e5: "day" === b ? (d - g) / 864e5: "week" === b ? (d - g) / 6048e5: d),
        c ? e: p(e)
    }
    function jb(a, b) {
        var c, d, e = 12 * (b.year() - a.year()) + (b.month() - a.month()),
        f = a.clone().add(e, "months");
        return 0 > b - f ? (c = a.clone().add(e - 1, "months"), d = (b - f) / (f - c)) : (c = a.clone().add(e + 1, "months"), d = (b - f) / (c - f)),
        -(e + d)
    }
    function kb() {
        return this.clone().locale("en").format("ddd MMM DD YYYY HH:mm:ss [GMT]ZZ")
    }
    function lb() {
        var a = this.clone().utc();
        return 0 < a.year() && a.year() <= 9999 ? "function" == typeof Date.prototype.toISOString ? this.toDate().toISOString() : K(a, "YYYY-MM-DD[T]HH:mm:ss.SSS[Z]") : K(a, "YYYYYY-MM-DD[T]HH:mm:ss.SSS[Z]")
    }
    function mb(b) {
        var c = K(this, b || a.defaultFormat);
        return this.localeData().postformat(c)
    }
    function nb(a, b) {
        return this.isValid() ? Ya({
            to: this,
            from: a
        }).locale(this.locale()).humanize(!b) : this.localeData().invalidDate()
    }
    function ob(a) {
        return this.from(Da(), a)
    }
    function pb(a, b) {
        return this.isValid() ? Ya({
            from: this,
            to: a
        }).locale(this.locale()).humanize(!b) : this.localeData().invalidDate()
    }
    function qb(a) {
        return this.to(Da(), a)
    }
    function rb(a) {
        var b;
        return void 0 === a ? this._locale._abbr: (b = y(a), null != b && (this._locale = b), this)
    }
    function sb() {
        return this._locale
    }
    function tb(a) {
        switch (a = A(a)) {
        case "year":
            this.month(0);
        case "quarter":
        case "month":
            this.date(1);
        case "week":
        case "isoWeek":
        case "day":
            this.hours(0);
        case "hour":
            this.minutes(0);
        case "minute":
            this.seconds(0);
        case "second":
            this.milliseconds(0)
        }
        return "week" === a && this.weekday(0),
        "isoWeek" === a && this.isoWeekday(1),
        "quarter" === a && this.month(3 * Math.floor(this.month() / 3)),
        this
    }
    function ub(a) {
        return a = A(a),
        void 0 === a || "millisecond" === a ? this: this.startOf(a).add(1, "isoWeek" === a ? "week": a).subtract(1, "ms")
    }
    function vb() {
        return + this._d - 6e4 * (this._offset || 0)
    }
    function wb() {
        return Math.floor( + this / 1e3)
    }
    function xb() {
        return this._offset ? new Date( + this) : this._d
    }
    function yb() {
        var a = this;
        return [a.year(), a.month(), a.date(), a.hour(), a.minute(), a.second(), a.millisecond()]
    }
    function zb() {
        var a = this;
        return {
            years: a.year(),
            months: a.month(),
            date: a.date(),
            hours: a.hours(),
            minutes: a.minutes(),
            seconds: a.seconds(),
            milliseconds: a.milliseconds()
        }
    }
    function Ab() {
        return k(this)
    }
    function Bb() {
        return g({},
        j(this))
    }
    function Cb() {
        return j(this).overflow
    }
    function Db(a, b) {
        H(0, [a, a.length], 0, b)
    }
    function Eb(a, b, c) {
        return ja(Da([a, 11, 31 + b - c]), b, c).week
    }
    function Fb(a) {
        var b = ja(this, this.localeData()._week.dow, this.localeData()._week.doy).year;
        return null == a ? b: this.add(a - b, "y")
    }
    function Gb(a) {
        var b = ja(this, 1, 4).year;
        return null == a ? b: this.add(a - b, "y")
    }
    function Hb() {
        return Eb(this.year(), 1, 4)
    }
    function Ib() {
        var a = this.localeData()._week;
        return Eb(this.year(), a.dow, a.doy)
    }
    function Jb(a) {
        return null == a ? Math.ceil((this.month() + 1) / 3) : this.month(3 * (a - 1) + this.month() % 3)
    }
    function Kb(a, b) {
        return "string" != typeof a ? a: isNaN(a) ? (a = b.weekdaysParse(a), "number" == typeof a ? a: null) : parseInt(a, 10)
    }
    function Lb(a) {
        return this._weekdays[a.day()]
    }
    function Mb(a) {
        return this._weekdaysShort[a.day()]
    }
    function Nb(a) {
        return this._weekdaysMin[a.day()]
    }
    function Ob(a) {
        var b, c, d;
        for (this._weekdaysParse = this._weekdaysParse || [], b = 0; 7 > b; b++) if (this._weekdaysParse[b] || (c = Da([2e3, 1]).day(b), d = "^" + this.weekdays(c, "") + "|^" + this.weekdaysShort(c, "") + "|^" + this.weekdaysMin(c, ""), this._weekdaysParse[b] = new RegExp(d.replace(".", ""), "i")), this._weekdaysParse[b].test(a)) return b
    }
    function Pb(a) {
        var b = this._isUTC ? this._d.getUTCDay() : this._d.getDay();
        return null != a ? (a = Kb(a, this.localeData()), this.add(a - b, "d")) : b
    }
    function Qb(a) {
        var b = (this.day() + 7 - this.localeData()._week.dow) % 7;
        return null == a ? b: this.add(a - b, "d")
    }
    function Rb(a) {
        return null == a ? this.day() || 7 : this.day(this.day() % 7 ? a: a - 7)
    }
    function Sb(a, b) {
        H(a, 0, 0,
        function() {
            return this.localeData().meridiem(this.hours(), this.minutes(), b)
        })
    }
    function Tb(a, b) {
        return b._meridiemParse
    }
    function Ub(a) {
        return "p" === (a + "").toLowerCase().charAt(0)
    }
    function Vb(a, b, c) {
        return a > 11 ? c ? "pm": "PM": c ? "am": "AM"
    }
    function Wb(a, b) {
        b[ld] = q(1e3 * ("0." + a))
    }
    function Xb() {
        return this._isUTC ? "UTC": ""
    }
    function Yb() {
        return this._isUTC ? "Coordinated Universal Time": ""
    }
    function Zb(a) {
        return Da(1e3 * a)
    }
    function $b() {
        return Da.apply(null, arguments).parseZone()
    }
    function _b(a, b, c) {
        var d = this._calendar[a];
        return "function" == typeof d ? d.call(b, c) : d
    }
    function ac(a) {
        var b = this._longDateFormat[a],
        c = this._longDateFormat[a.toUpperCase()];
        return b || !c ? b: (this._longDateFormat[a] = c.replace(/MMMM|MM|DD|dddd/g,
        function(a) {
            return a.slice(1)
        }), this._longDateFormat[a])
    }
    function bc() {
        return this._invalidDate
    }
    function cc(a) {
        return this._ordinal.replace("%d", a)
    }
    function dc(a) {
        return a
    }
    function ec(a, b, c, d) {
        var e = this._relativeTime[c];
        return "function" == typeof e ? e(a, b, c, d) : e.replace(/%d/i, a)
    }
    function fc(a, b) {
        var c = this._relativeTime[a > 0 ? "future": "past"];
        return "function" == typeof c ? c(b) : c.replace(/%s/i, b)
    }
    function gc(a) {
        var b, c;
        for (c in a) b = a[c],
        "function" == typeof b ? this[c] = b: this["_" + c] = b;
        this._ordinalParseLenient = new RegExp(this._ordinalParse.source + "|" + /\d{1,2}/.source)
    }
    function hc(a, b, c, d) {
        var e = y(),
        f = h().set(d, b);
        return e[c](f, a)
    }
    function ic(a, b, c, d, e) {
        if ("number" == typeof a && (b = a, a = void 0), a = a || "", null != b) return hc(a, b, c, e);
        var f, g = [];
        for (f = 0; d > f; f++) g[f] = hc(a, f, c, e);
        return g
    }
    function jc(a, b) {
        return ic(a, b, "months", 12, "month")
    }
    function kc(a, b) {
        return ic(a, b, "monthsShort", 12, "month")
    }
    function lc(a, b) {
        return ic(a, b, "weekdays", 7, "day")
    }
    function mc(a, b) {
        return ic(a, b, "weekdaysShort", 7, "day")
    }
    function nc(a, b) {
        return ic(a, b, "weekdaysMin", 7, "day")
    }
    function oc() {
        var a = this._data;
        return this._milliseconds = Wd(this._milliseconds),
        this._days = Wd(this._days),
        this._months = Wd(this._months),
        a.milliseconds = Wd(a.milliseconds),
        a.seconds = Wd(a.seconds),
        a.minutes = Wd(a.minutes),
        a.hours = Wd(a.hours),
        a.months = Wd(a.months),
        a.years = Wd(a.years),
        this
    }
    function pc(a, b, c, d) {
        var e = Ya(b, c);
        return a._milliseconds += d * e._milliseconds,
        a._days += d * e._days,
        a._months += d * e._months,
        a._bubble()
    }
    function qc(a, b) {
        return pc(this, a, b, 1)
    }
    function rc(a, b) {
        return pc(this, a, b, -1)
    }
    function sc(a) {
        return 0 > a ? Math.floor(a) : Math.ceil(a)
    }
    function tc() {
        var a, b, c, d, e, f = this._milliseconds,
        g = this._days,
        h = this._months,
        i = this._data;
        return f >= 0 && g >= 0 && h >= 0 || 0 >= f && 0 >= g && 0 >= h || (f += 864e5 * sc(vc(h) + g), g = 0, h = 0),
        i.milliseconds = f % 1e3,
        a = p(f / 1e3),
        i.seconds = a % 60,
        b = p(a / 60),
        i.minutes = b % 60,
        c = p(b / 60),
        i.hours = c % 24,
        g += p(c / 24),
        e = p(uc(g)),
        h += e,
        g -= sc(vc(e)),
        d = p(h / 12),
        h %= 12,
        i.days = g,
        i.months = h,
        i.years = d,
        this
    }
    function uc(a) {
        return 4800 * a / 146097
    }
    function vc(a) {
        return 146097 * a / 4800
    }
    function wc(a) {
        var b, c, d = this._milliseconds;
        if (a = A(a), "month" === a || "year" === a) return b = this._days + d / 864e5,
        c = this._months + uc(b),
        "month" === a ? c: c / 12;
        switch (b = this._days + Math.round(vc(this._months)), a) {
        case "week":
            return b / 7 + d / 6048e5;
        case "day":
            return b + d / 864e5;
        case "hour":
            return 24 * b + d / 36e5;
        case "minute":
            return 1440 * b + d / 6e4;
        case "second":
            return 86400 * b + d / 1e3;
        case "millisecond":
            return Math.floor(864e5 * b) + d;
        default:
            throw new Error("Unknown unit " + a)
        }
    }
    function xc() {
        return this._milliseconds + 864e5 * this._days + this._months % 12 * 2592e6 + 31536e6 * q(this._months / 12)
    }
    function yc(a) {
        return function() {
            return this.as(a)
        }
    }
    function zc(a) {
        return a = A(a),
        this[a + "s"]()
    }
    function Ac(a) {
        return function() {
            return this._data[a]
        }
    }
    function Bc() {
        return p(this.days() / 7)
    }
    function Cc(a, b, c, d, e) {
        return e.relativeTime(b || 1, !!c, a, d)
    }
    function Dc(a, b, c) {
        var d = Ya(a).abs(),
        e = ke(d.as("s")),
        f = ke(d.as("m")),
        g = ke(d.as("h")),
        h = ke(d.as("d")),
        i = ke(d.as("M")),
        j = ke(d.as("y")),
        k = e < le.s && ["s", e] || 1 === f && ["m"] || f < le.m && ["mm", f] || 1 === g && ["h"] || g < le.h && ["hh", g] || 1 === h && ["d"] || h < le.d && ["dd", h] || 1 === i && ["M"] || i < le.M && ["MM", i] || 1 === j && ["y"] || ["yy", j];
        return k[2] = b,
        k[3] = +a > 0,
        k[4] = c,
        Cc.apply(null, k)
    }
    function Ec(a, b) {
        return void 0 === le[a] ? !1 : void 0 === b ? le[a] : (le[a] = b, !0)
    }
    function Fc(a) {
        var b = this.localeData(),
        c = Dc(this, !a, b);
        return a && (c = b.pastFuture( + this, c)),
        b.postformat(c)
    }
    function Gc() {
        var a, b, c, d = me(this._milliseconds) / 1e3,
        e = me(this._days),
        f = me(this._months);
        a = p(d / 60),
        b = p(a / 60),
        d %= 60,
        a %= 60,
        c = p(f / 12),
        f %= 12;
        var g = c,
        h = f,
        i = e,
        j = b,
        k = a,
        l = d,
        m = this.asSeconds();
        return m ? (0 > m ? "-": "") + "P" + (g ? g + "Y": "") + (h ? h + "M": "") + (i ? i + "D": "") + (j || k || l ? "T": "") + (j ? j + "H": "") + (k ? k + "M": "") + (l ? l + "S": "") : "P0D"
    }
    var Hc, Ic, Jc = a.momentProperties = [],
    Kc = !1,
    Lc = {},
    Mc = {},
    Nc = /(\[[^\[]*\])|(\\)?(Mo|MM?M?M?|Do|DDDo|DD?D?D?|ddd?d?|do?|w[o|w]?|W[o|W]?|Q|YYYYYY|YYYYY|YYYY|YY|gg(ggg?)?|GG(GGG?)?|e|E|a|A|hh?|HH?|mm?|ss?|S{1,9}|x|X|zz?|ZZ?|.)/g,
    Oc = /(\[[^\[]*\])|(\\)?(LTS|LT|LL?L?L?|l{1,4})/g,
    Pc = {},
    Qc = {},
    Rc = /\d/,
    Sc = /\d\d/,
    Tc = /\d{3}/,
    Uc = /\d{4}/,
    Vc = /[+-]?\d{6}/,
    Wc = /\d\d?/,
    Xc = /\d{1,3}/,
    Yc = /\d{1,4}/,
    Zc = /[+-]?\d{1,6}/,
    $c = /\d+/,
    _c = /[+-]?\d+/,
    ad = /Z|[+-]\d\d:?\d\d/gi,
    bd = /[+-]?\d+(\.\d{1,3})?/,
    cd = /[0-9]*['a-z\u00A0-\u05FF\u0700-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+|[\u0600-\u06FF\/]+(\s*?[\u0600-\u06FF]+){1,2}/i,
    dd = {},
    ed = {},
    fd = 0,
    gd = 1,
    hd = 2,
    id = 3,
    jd = 4,
    kd = 5,
    ld = 6;
    H("M", ["MM", 2], "Mo",
    function() {
        return this.month() + 1
    }),
    H("MMM", 0, 0,
    function(a) {
        return this.localeData().monthsShort(this, a)
    }),
    H("MMMM", 0, 0,
    function(a) {
        return this.localeData().months(this, a)
    }),
    z("month", "M"),
    N("M", Wc),
    N("MM", Wc, Sc),
    N("MMM", cd),
    N("MMMM", cd),
    Q(["M", "MM"],
    function(a, b) {
        b[gd] = q(a) - 1
    }),
    Q(["MMM", "MMMM"],
    function(a, b, c, d) {
        var e = c._locale.monthsParse(a, d, c._strict);
        null != e ? b[gd] = e: j(c).invalidMonth = a
    });
    var md = "January_February_March_April_May_June_July_August_September_October_November_December".split("_"),
    nd = "Jan_Feb_Mar_Apr_May_Jun_Jul_Aug_Sep_Oct_Nov_Dec".split("_"),
    od = {};
    a.suppressDeprecationWarnings = !1;
    var pd = /^\s*(?:[+-]\d{6}|\d{4})-(?:(\d\d-\d\d)|(W\d\d$)|(W\d\d-\d)|(\d\d\d))((T| )(\d\d(:\d\d(:\d\d(\.\d+)?)?)?)?([\+\-]\d\d(?::?\d\d)?|\s*Z)?)?$/,
    qd = [["YYYYYY-MM-DD", /[+-]\d{6}-\d{2}-\d{2}/], ["YYYY-MM-DD", /\d{4}-\d{2}-\d{2}/], ["GGGG-[W]WW-E", /\d{4}-W\d{2}-\d/], ["GGGG-[W]WW", /\d{4}-W\d{2}/], ["YYYY-DDD", /\d{4}-\d{3}/]],
    rd = [["HH:mm:ss.SSSS", /(T| )\d\d:\d\d:\d\d\.\d+/], ["HH:mm:ss", /(T| )\d\d:\d\d:\d\d/], ["HH:mm", /(T| )\d\d:\d\d/], ["HH", /(T| )\d\d/]],
    sd = /^\/?Date\((\-?\d+)/i;
    a.createFromInputFallback = aa("moment construction falls back to js Date. This is discouraged and will be removed in upcoming major release. Please refer to https://github.com/moment/moment/issues/1407 for more info.",
    function(a) {
        a._d = new Date(a._i + (a._useUTC ? " UTC": ""))
    }),
    H(0, ["YY", 2], 0,
    function() {
        return this.year() % 100
    }),
    H(0, ["YYYY", 4], 0, "year"),
    H(0, ["YYYYY", 5], 0, "year"),
    H(0, ["YYYYYY", 6, !0], 0, "year"),
    z("year", "y"),
    N("Y", _c),
    N("YY", Wc, Sc),
    N("YYYY", Yc, Uc),
    N("YYYYY", Zc, Vc),
    N("YYYYYY", Zc, Vc),
    Q(["YYYYY", "YYYYYY"], fd),
    Q("YYYY",
    function(b, c) {
        c[fd] = 2 === b.length ? a.parseTwoDigitYear(b) : q(b)
    }),
    Q("YY",
    function(b, c) {
        c[fd] = a.parseTwoDigitYear(b)
    }),
    a.parseTwoDigitYear = function(a) {
        return q(a) + (q(a) > 68 ? 1900 : 2e3)
    };
    var td = C("FullYear", !1);
    H("w", ["ww", 2], "wo", "week"),
    H("W", ["WW", 2], "Wo", "isoWeek"),
    z("week", "w"),
    z("isoWeek", "W"),
    N("w", Wc),
    N("ww", Wc, Sc),
    N("W", Wc),
    N("WW", Wc, Sc),
    R(["w", "ww", "W", "WW"],
    function(a, b, c, d) {
        b[d.substr(0, 1)] = q(a)
    });
    var ud = {
        dow: 0,
        doy: 6
    };
    H("DDD", ["DDDD", 3], "DDDo", "dayOfYear"),
    z("dayOfYear", "DDD"),
    N("DDD", Xc),
    N("DDDD", Tc),
    Q(["DDD", "DDDD"],
    function(a, b, c) {
        c._dayOfYear = q(a)
    }),
    a.ISO_8601 = function() {};
    var vd = aa("moment().min is deprecated, use moment.min instead. https://github.com/moment/moment/issues/1548",
    function() {
        var a = Da.apply(null, arguments);
        return this > a ? this: a
    }),
    wd = aa("moment().max is deprecated, use moment.max instead. https://github.com/moment/moment/issues/1548",
    function() {
        var a = Da.apply(null, arguments);
        return a > this ? this: a
    });
    Ja("Z", ":"),
    Ja("ZZ", ""),
    N("Z", ad),
    N("ZZ", ad),
    Q(["Z", "ZZ"],
    function(a, b, c) {
        c._useUTC = !0,
        c._tzm = Ka(a)
    });
    var xd = /([\+\-]|\d\d)/gi;
    a.updateOffset = function() {};
    var yd = /(\-)?(?:(\d*)\.)?(\d+)\:(\d+)(?:\:(\d+)\.?(\d{3})?)?/,
    zd = /^(-)?P(?:(?:([0-9,.]*)Y)?(?:([0-9,.]*)M)?(?:([0-9,.]*)D)?(?:T(?:([0-9,.]*)H)?(?:([0-9,.]*)M)?(?:([0-9,.]*)S)?)?|([0-9,.]*)W)$/;
    Ya.fn = Ha.prototype;
    var Ad = ab(1, "add"),
    Bd = ab( - 1, "subtract");
    a.defaultFormat = "YYYY-MM-DDTHH:mm:ssZ";
    var Cd = aa("moment().lang() is deprecated. Instead, use moment().localeData() to get the language configuration. Use moment().locale() to change languages.",
    function(a) {
        return void 0 === a ? this.localeData() : this.locale(a)
    });
    H(0, ["gg", 2], 0,
    function() {
        return this.weekYear() % 100
    }),
    H(0, ["GG", 2], 0,
    function() {
        return this.isoWeekYear() % 100
    }),
    Db("gggg", "weekYear"),
    Db("ggggg", "weekYear"),
    Db("GGGG", "isoWeekYear"),
    Db("GGGGG", "isoWeekYear"),
    z("weekYear", "gg"),
    z("isoWeekYear", "GG"),
    N("G", _c),
    N("g", _c),
    N("GG", Wc, Sc),
    N("gg", Wc, Sc),
    N("GGGG", Yc, Uc),
    N("gggg", Yc, Uc),
    N("GGGGG", Zc, Vc),
    N("ggggg", Zc, Vc),
    R(["gggg", "ggggg", "GGGG", "GGGGG"],
    function(a, b, c, d) {
        b[d.substr(0, 2)] = q(a)
    }),
    R(["gg", "GG"],
    function(b, c, d, e) {
        c[e] = a.parseTwoDigitYear(b)
    }),
    H("Q", 0, 0, "quarter"),
    z("quarter", "Q"),
    N("Q", Rc),
    Q("Q",
    function(a, b) {
        b[gd] = 3 * (q(a) - 1)
    }),
    H("D", ["DD", 2], "Do", "date"),
    z("date", "D"),
    N("D", Wc),
    N("DD", Wc, Sc),
    N("Do",
    function(a, b) {
        return a ? b._ordinalParse: b._ordinalParseLenient
    }),
    Q(["D", "DD"], hd),
    Q("Do",
    function(a, b) {
        b[hd] = q(a.match(Wc)[0], 10)
    });
    var Dd = C("Date", !0);
    H("d", 0, "do", "day"),
    H("dd", 0, 0,
    function(a) {
        return this.localeData().weekdaysMin(this, a)
    }),
    H("ddd", 0, 0,
    function(a) {
        return this.localeData().weekdaysShort(this, a)
    }),
    H("dddd", 0, 0,
    function(a) {
        return this.localeData().weekdays(this, a)
    }),
    H("e", 0, 0, "weekday"),
    H("E", 0, 0, "isoWeekday"),
    z("day", "d"),
    z("weekday", "e"),
    z("isoWeekday", "E"),
    N("d", Wc),
    N("e", Wc),
    N("E", Wc),
    N("dd", cd),
    N("ddd", cd),
    N("dddd", cd),
    R(["dd", "ddd", "dddd"],
    function(a, b, c) {
        var d = c._locale.weekdaysParse(a);
        null != d ? b.d = d: j(c).invalidWeekday = a
    }),
    R(["d", "e", "E"],
    function(a, b, c, d) {
        b[d] = q(a)
    });
    var Ed = "Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturday".split("_"),
    Fd = "Sun_Mon_Tue_Wed_Thu_Fri_Sat".split("_"),
    Gd = "Su_Mo_Tu_We_Th_Fr_Sa".split("_");
    H("H", ["HH", 2], 0, "hour"),
    H("h", ["hh", 2], 0,
    function() {
        return this.hours() % 12 || 12
    }),
    Sb("a", !0),
    Sb("A", !1),
    z("hour", "h"),
    N("a", Tb),
    N("A", Tb),
    N("H", Wc),
    N("h", Wc),
    N("HH", Wc, Sc),
    N("hh", Wc, Sc),
    Q(["H", "HH"], id),
    Q(["a", "A"],
    function(a, b, c) {
        c._isPm = c._locale.isPM(a),
        c._meridiem = a
    }),
    Q(["h", "hh"],
    function(a, b, c) {
        b[id] = q(a),
        j(c).bigHour = !0
    });
    var Hd = /[ap]\.?m?\.?/i,
    Id = C("Hours", !0);
    H("m", ["mm", 2], 0, "minute"),
    z("minute", "m"),
    N("m", Wc),
    N("mm", Wc, Sc),
    Q(["m", "mm"], jd);
    var Jd = C("Minutes", !1);
    H("s", ["ss", 2], 0, "second"),
    z("second", "s"),
    N("s", Wc),
    N("ss", Wc, Sc),
    Q(["s", "ss"], kd);
    var Kd = C("Seconds", !1);
    H("S", 0, 0,
    function() {
        return~~ (this.millisecond() / 100)
    }),
    H(0, ["SS", 2], 0,
    function() {
        return~~ (this.millisecond() / 10)
    }),
    H(0, ["SSS", 3], 0, "millisecond"),
    H(0, ["SSSS", 4], 0,
    function() {
        return 10 * this.millisecond()
    }),
    H(0, ["SSSSS", 5], 0,
    function() {
        return 100 * this.millisecond()
    }),
    H(0, ["SSSSSS", 6], 0,
    function() {
        return 1e3 * this.millisecond()
    }),
    H(0, ["SSSSSSS", 7], 0,
    function() {
        return 1e4 * this.millisecond()
    }),
    H(0, ["SSSSSSSS", 8], 0,
    function() {
        return 1e5 * this.millisecond()
    }),
    H(0, ["SSSSSSSSS", 9], 0,
    function() {
        return 1e6 * this.millisecond()
    }),
    z("millisecond", "ms"),
    N("S", Xc, Rc),
    N("SS", Xc, Sc),
    N("SSS", Xc, Tc);
    var Ld;
    for (Ld = "SSSS"; Ld.length <= 9; Ld += "S") N(Ld, $c);
    for (Ld = "S"; Ld.length <= 9; Ld += "S") Q(Ld, Wb);
    var Md = C("Milliseconds", !1);
    H("z", 0, 0, "zoneAbbr"),
    H("zz", 0, 0, "zoneName");
    var Nd = n.prototype;
    Nd.add = Ad,
    Nd.calendar = cb,
    Nd.clone = db,
    Nd.diff = ib,
    Nd.endOf = ub,
    Nd.format = mb,
    Nd.from = nb,
    Nd.fromNow = ob,
    Nd.to = pb,
    Nd.toNow = qb,
    Nd.get = F,
    Nd.invalidAt = Cb,
    Nd.isAfter = eb,
    Nd.isBefore = fb,
    Nd.isBetween = gb,
    Nd.isSame = hb,
    Nd.isValid = Ab,
    Nd.lang = Cd,
    Nd.locale = rb,
    Nd.localeData = sb,
    Nd.max = wd,
    Nd.min = vd,
    Nd.parsingFlags = Bb,
    Nd.set = F,
    Nd.startOf = tb,
    Nd.subtract = Bd,
    Nd.toArray = yb,
    Nd.toObject = zb,
    Nd.toDate = xb,
    Nd.toISOString = lb,
    Nd.toJSON = lb,
    Nd.toString = kb,
    Nd.unix = wb,
    Nd.valueOf = vb,
    Nd.year = td,
    Nd.isLeapYear = ia,
    Nd.weekYear = Fb,
    Nd.isoWeekYear = Gb,
    Nd.quarter = Nd.quarters = Jb,
    Nd.month = Y,
    Nd.daysInMonth = Z,
    Nd.week = Nd.weeks = na,
    Nd.isoWeek = Nd.isoWeeks = oa,
    Nd.weeksInYear = Ib,
    Nd.isoWeeksInYear = Hb,
    Nd.date = Dd,
    Nd.day = Nd.days = Pb,
    Nd.weekday = Qb,
    Nd.isoWeekday = Rb,
    Nd.dayOfYear = qa,
    Nd.hour = Nd.hours = Id,
    Nd.minute = Nd.minutes = Jd,
    Nd.second = Nd.seconds = Kd,
    Nd.millisecond = Nd.milliseconds = Md,
    Nd.utcOffset = Na,
    Nd.utc = Pa,
    Nd.local = Qa,
    Nd.parseZone = Ra,
    Nd.hasAlignedHourOffset = Sa,
    Nd.isDST = Ta,
    Nd.isDSTShifted = Ua,
    Nd.isLocal = Va,
    Nd.isUtcOffset = Wa,
    Nd.isUtc = Xa,
    Nd.isUTC = Xa,
    Nd.zoneAbbr = Xb,
    Nd.zoneName = Yb,
    Nd.dates = aa("dates accessor is deprecated. Use date instead.", Dd),
    Nd.months = aa("months accessor is deprecated. Use month instead", Y),
    Nd.years = aa("years accessor is deprecated. Use year instead", td),
    Nd.zone = aa("moment().zone is deprecated, use moment().utcOffset instead. https://github.com/moment/moment/issues/1779", Oa);
    var Od = Nd,
    Pd = {
        sameDay: "[Today at] LT",
        nextDay: "[Tomorrow at] LT",
        nextWeek: "dddd [at] LT",
        lastDay: "[Yesterday at] LT",
        lastWeek: "[Last] dddd [at] LT",
        sameElse: "L"
    },
    Qd = {
        LTS: "h:mm:ss A",
        LT: "h:mm A",
        L: "MM/DD/YYYY",
        LL: "MMMM D, YYYY",
        LLL: "MMMM D, YYYY h:mm A",
        LLLL: "dddd, MMMM D, YYYY h:mm A"
    },
    Rd = "Invalid date",
    Sd = "%d",
    Td = /\d{1,2}/,
    Ud = {
        future: "in %s",
        past: "%s ago",
        s: "a few seconds",
        m: "a minute",
        mm: "%d minutes",
        h: "an hour",
        hh: "%d hours",
        d: "a day",
        dd: "%d days",
        M: "a month",
        MM: "%d months",
        y: "a year",
        yy: "%d years"
    },
    Vd = s.prototype;
    Vd._calendar = Pd,
    Vd.calendar = _b,
    Vd._longDateFormat = Qd,
    Vd.longDateFormat = ac,
    Vd._invalidDate = Rd,
    Vd.invalidDate = bc,
    Vd._ordinal = Sd,
    Vd.ordinal = cc,
    Vd._ordinalParse = Td,
    Vd.preparse = dc,
    Vd.postformat = dc,
    Vd._relativeTime = Ud,
    Vd.relativeTime = ec,
    Vd.pastFuture = fc,
    Vd.set = gc,
    Vd.months = U,
    Vd._months = md,
    Vd.monthsShort = V,
    Vd._monthsShort = nd,
    Vd.monthsParse = W,
    Vd.week = ka,
    Vd._week = ud,
    Vd.firstDayOfYear = ma,
    Vd.firstDayOfWeek = la,
    Vd.weekdays = Lb,
    Vd._weekdays = Ed,
    Vd.weekdaysMin = Nb,
    Vd._weekdaysMin = Gd,
    Vd.weekdaysShort = Mb,
    Vd._weekdaysShort = Fd,
    Vd.weekdaysParse = Ob,
    Vd.isPM = Ub,
    Vd._meridiemParse = Hd,
    Vd.meridiem = Vb,
    w("en", {
        ordinalParse: /\d{1,2}(th|st|nd|rd)/,
        ordinal: function(a) {
            var b = a % 10,
            c = 1 === q(a % 100 / 10) ? "th": 1 === b ? "st": 2 === b ? "nd": 3 === b ? "rd": "th";
            return a + c
        }
    }),
    a.lang = aa("moment.lang is deprecated. Use moment.locale instead.", w),
    a.langData = aa("moment.langData is deprecated. Use moment.localeData instead.", y);
    var Wd = Math.abs,
    Xd = yc("ms"),
    Yd = yc("s"),
    Zd = yc("m"),
    $d = yc("h"),
    _d = yc("d"),
    ae = yc("w"),
    be = yc("M"),
    ce = yc("y"),
    de = Ac("milliseconds"),
    ee = Ac("seconds"),
    fe = Ac("minutes"),
    ge = Ac("hours"),
    he = Ac("days"),
    ie = Ac("months"),
    je = Ac("years"),
    ke = Math.round,
    le = {
        s: 45,
        m: 45,
        h: 22,
        d: 26,
        M: 11
    },
    me = Math.abs,
    ne = Ha.prototype;
    ne.abs = oc,
    ne.add = qc,
    ne.subtract = rc,
    ne.as = wc,
    ne.asMilliseconds = Xd,
    ne.asSeconds = Yd,
    ne.asMinutes = Zd,
    ne.asHours = $d,
    ne.asDays = _d,
    ne.asWeeks = ae,
    ne.asMonths = be,
    ne.asYears = ce,
    ne.valueOf = xc,
    ne._bubble = tc,
    ne.get = zc,
    ne.milliseconds = de,
    ne.seconds = ee,
    ne.minutes = fe,
    ne.hours = ge,
    ne.days = he,
    ne.weeks = Bc,
    ne.months = ie,
    ne.years = je,
    ne.humanize = Fc,
    ne.toISOString = Gc,
    ne.toString = Gc,
    ne.toJSON = Gc,
    ne.locale = rb,
    ne.localeData = sb,
    ne.toIsoString = aa("toIsoString() is deprecated. Please use toISOString() instead (notice the capitals)", Gc),
    ne.lang = Cd,
    H("X", 0, 0, "unix"),
    H("x", 0, 0, "valueOf"),
    N("x", _c),
    N("X", bd),
    Q("X",
    function(a, b, c) {
        c._d = new Date(1e3 * parseFloat(a, 10))
    }),
    Q("x",
    function(a, b, c) {
        c._d = new Date(q(a))
    }),
    a.version = "2.10.6",
    b(Da),
    a.fn = Od,
    a.min = Fa,
    a.max = Ga,
    a.utc = h,
    a.unix = Zb,
    a.months = jc,
    a.isDate = d,
    a.locale = w,
    a.invalid = l,
    a.duration = Ya,
    a.isMoment = o,
    a.weekdays = lc,
    a.parseZone = $b,
    a.localeData = y,
    a.isDuration = Ia,
    a.monthsShort = kc,
    a.weekdaysMin = nc,
    a.defineLocale = x,
    a.weekdaysShort = mc,
    a.normalizeUnits = A,
    a.relativeTimeThreshold = Ec;
    var oe = a;
    return oe.defineLocale("zh-cn", {
        months: "一月_二月_三月_四月_五月_六月_七月_八月_九月_十月_十一月_十二月".split("_"),
        monthsShort: "1月_2月_3月_4月_5月_6月_7月_8月_9月_10月_11月_12月".split("_"),
        weekdays: "星期日_星期一_星期二_星期三_星期四_星期五_星期六".split("_"),
        weekdaysShort: "周日_周一_周二_周三_周四_周五_周六".split("_"),
        weekdaysMin: "日_一_二_三_四_五_六".split("_"),
        longDateFormat: {
            LT: "Ah点mm分",
            LTS: "Ah点m分s秒",
            L: "YYYY-MM-DD",
            LL: "YYYY年MMMD日",
            LLL: "YYYY年MMMD日Ah点mm分",
            LLLL: "YYYY年MMMD日ddddAh点mm分",
            l: "YYYY-MM-DD",
            ll: "YYYY年MMMD日",
            lll: "YYYY年MMMD日Ah点mm分",
            llll: "YYYY年MMMD日ddddAh点mm分"
        },
        meridiemParse: /凌晨|早上|上午|中午|下午|晚上/,
        meridiemHour: function(a, b) {
            return 12 === a && (a = 0),
            "凌晨" === b || "早上" === b || "上午" === b ? a: "下午" === b || "晚上" === b ? a + 12 : a >= 11 ? a: a + 12
        },
        meridiem: function(a, b) {
            var c = 100 * a + b;
            return 600 > c ? "凌晨": 900 > c ? "早上": 1130 > c ? "上午": 1230 > c ? "中午": 1800 > c ? "下午": "晚上"
        },
        calendar: {
            sameDay: function() {
                return 0 === this.minutes() ? "[今天]Ah[点整]": "[今天]LT"
            },
            nextDay: function() {
                return 0 === this.minutes() ? "[明天]Ah[点整]": "[明天]LT"
            },
            lastDay: function() {
                return 0 === this.minutes() ? "[昨天]Ah[点整]": "[昨天]LT"
            },
            nextWeek: function() {
                var a, b;
                return a = moment().startOf("week"),
                b = this.unix() - a.unix() >= 604800 ? "[下]": "[本]",
                0 === this.minutes() ? b + "dddAh点整": b + "dddAh点mm"
            },
            lastWeek: function() {
                var a, b;
                return a = moment().startOf("week"),
                b = this.unix() < a.unix() ? "[上]": "[本]",
                0 === this.minutes() ? b + "dddAh点整": b + "dddAh点mm"
            },
            sameElse: "LL"
        },
        ordinalParse: /\d{1,2}(日|月|周)/,
        ordinal: function(a, b) {
            switch (b) {
            case "d":
            case "D":
            case "DDD":
                return a + "日";
            case "M":
                return a + "月";
            case "w":
            case "W":
                return a + "周";
            default:
                return a
            }
        },
        relativeTime: {
            future: "%s内",
            past: "%s前",
            s: "几秒",
            m: "1 分钟",
            mm: "%d 分钟",
            h: "1 小时",
            hh: "%d 小时",
            d: "1 天",
            dd: "%d 天",
            M: "1 个月",
            MM: "%d 个月",
            y: "1 年",
            yy: "%d 年"
        },
        week: {
            dow: 1,
            doy: 4
        }
    }),
    oe
}),
function() {
    define("cs!timeStatus", ["require", "exports", "module", "moment"],
    function(a) {
        var b;
        return b = a("moment"),
        {
            enrollment: function(a, c) {
                var d, e, f;
                return e = b(),
                f = !a || b(a).isBefore(e) ? 1 : 0,
                d = !c || b(c).isAfter(e) ? 1 : 0,
                f && d ? 1 : f ? 0 : -1
            },
            courseOpen: function(a, c) {
                var d, e, f;
                return e = b(),
                f = a && b(a).isBefore(e) ? 1 : 0,
                d = !c || b(c).isAfter(e) ? 1 : 0,
                f && d ? 1 : f ? 0 : -1
            },
            main: function(a, c, d, e) {
                var f, g, h;
                if (g = this.enrollment(a, c), f = this.courseOpen(d, e), -1 === f) {
                    if ( - 1 === g) return a && (h = b(a).fromNow()),
                    {
                        state: "preStart_register",
                        time: h || "即将"
                    };
                    if (1 === g) return d && (h = b(d).fromNow()),
                    {
                        state: "preStart_course",
                        time: h || "即将"
                    };
                    if (0 === g) return d && (h = b(d).fromNow()),
                    {
                        state: "preCourse_postRegister",
                        time: h || "即将"
                    }
                } else {
                    if (1 !== f) return 1 === g ? {
                        state: "end_course"
                    }: {
                        state: "end_register"
                    };
                    if (1 === g) return d && (h = b().from(d, 1)),
                    {
                        state: "start_course",
                        time: h
                    };
                    if (0 === g) return c && (h = b().from(c, 1)),
                    {
                        state: "startCourse_postRegister",
                        time: h
                    }
                }
            }
        }
    })
}.call(this),
function(a) {
    define("simplePagination", ["jquery"],
    function() {
        return function() { !
            function(a) {
                var b = {
                    init: function(c) {
                        var d = a.extend({
                            items: 1,
                            itemsOnPage: 1,
                            pages: 0,
                            displayedPages: 5,
                            edges: 2,
                            currentPage: 0,
                            hrefTextPrefix: "#page-",
                            hrefTextSuffix: "",
                            prevText: "Prev",
                            nextText: "Next",
                            ellipseText: "&hellip;",
                            labelMap: [],
                            selectOnClick: !0,
                            nextAtFront: !1,
                            invertPageOrder: !1,
                            useStartEdge: !0,
                            useEndEdge: !0,
                            onPageClick: function() {},
                            onInit: function() {}
                        },
                        c || {}),
                        e = this;
                        return d.pages = d.pages ? d.pages: Math.ceil(d.items / d.itemsOnPage) ? Math.ceil(d.items / d.itemsOnPage) : 1,
                        d.currentPage = d.currentPage ? d.currentPage - 1 : d.invertPageOrder ? d.pages - 1 : 0,
                        d.halfDisplayed = d.displayedPages / 2,
                        this.each(function() {
                            e.addClass(d.cssStyle + " simple-pagination").data("pagination", d),
                            b._draw.call(e)
                        }),
                        d.onInit(),
                        this
                    },
                    selectPage: function(a) {
                        return b._selectPage.call(this, a - 1),
                        this
                    },
                    prevPage: function() {
                        var a = this.data("pagination");
                        return a.invertPageOrder ? a.currentPage < a.pages - 1 && b._selectPage.call(this, a.currentPage + 1) : a.currentPage > 0 && b._selectPage.call(this, a.currentPage - 1),
                        this
                    },
                    nextPage: function() {
                        var a = this.data("pagination");
                        return a.invertPageOrder ? a.currentPage > 0 && b._selectPage.call(this, a.currentPage - 1) : a.currentPage < a.pages - 1 && b._selectPage.call(this, a.currentPage + 1),
                        this
                    },
                    getPagesCount: function() {
                        return this.data("pagination").pages
                    },
                    getCurrentPage: function() {
                        return this.data("pagination").currentPage + 1
                    },
                    destroy: function() {
                        return this.empty(),
                        this
                    },
                    drawPage: function(a) {
                        var c = this.data("pagination");
                        return c.currentPage = a - 1,
                        this.data("pagination", c),
                        b._draw.call(this),
                        this
                    },
                    redraw: function() {
                        return b._draw.call(this),
                        this
                    },
                    disable: function() {
                        var a = this.data("pagination");
                        return a.disabled = !0,
                        this.data("pagination", a),
                        b._draw.call(this),
                        this
                    },
                    enable: function() {
                        var a = this.data("pagination");
                        return a.disabled = !1,
                        this.data("pagination", a),
                        b._draw.call(this),
                        this
                    },
                    updateItems: function(a) {
                        var c = this.data("pagination");
                        c.items = a,
                        c.pages = b._getPages(c),
                        this.data("pagination", c),
                        b._draw.call(this)
                    },
                    updateItemsOnPage: function(a) {
                        var c = this.data("pagination");
                        return c.itemsOnPage = a,
                        c.pages = b._getPages(c),
                        this.data("pagination", c),
                        b._selectPage.call(this, 0),
                        this
                    },
                    _draw: function() {
                        var c, d, e = this.data("pagination"),
                        f = b._getInterval(e);
                        b.destroy.call(this),
                        d = "function" == typeof this.prop ? this.prop("tagName") : this.attr("tagName");
                        var g = "UL" === d ? this: a('<ul class="pagination-sm pagination"></ul>').appendTo(this);
                        if (e.prevText && b._appendItem.call(this, e.invertPageOrder ? e.currentPage + 1 : e.currentPage - 1, {
                            text: e.prevText,
                            classes: "prev"
                        }), e.nextText && e.nextAtFront && b._appendItem.call(this, e.invertPageOrder ? e.currentPage - 1 : e.currentPage + 1, {
                            text: e.nextText,
                            classes: "next"
                        }), e.invertPageOrder) {
                            if (f.end < e.pages && e.edges > 0) {
                                if (e.useStartEdge) {
                                    var h = Math.max(e.pages - e.edges, f.end);
                                    for (c = e.pages - 1; c >= h; c--) b._appendItem.call(this, c)
                                }
                                e.pages - e.edges > f.end && e.pages - e.edges - f.end != 1 ? g.append('<li class="disabled"><span class="ellipse">' + e.ellipseText + "</span></li>") : e.pages - e.edges - f.end == 1 && b._appendItem.call(this, f.end)
                            }
                        } else if (f.start > 0 && e.edges > 0) {
                            if (e.useStartEdge) {
                                var i = Math.min(e.edges, f.start);
                                for (c = 0; i > c; c++) b._appendItem.call(this, c)
                            }
                            e.edges < f.start && f.start - e.edges != 1 ? g.append('<li class="disabled"><span class="ellipse">' + e.ellipseText + "</span></li>") : f.start - e.edges == 1 && b._appendItem.call(this, e.edges)
                        }
                        if (e.invertPageOrder) for (c = f.end - 1; c >= f.start; c--) b._appendItem.call(this, c);
                        else for (c = f.start; c < f.end; c++) b._appendItem.call(this, c);
                        if (e.invertPageOrder) {
                            if (f.start > 0 && e.edges > 0 && (e.edges < f.start && f.start - e.edges != 1 ? g.append('<li class="disabled"><span class="ellipse">' + e.ellipseText + "</span></li>") : f.start - e.edges == 1 && b._appendItem.call(this, e.edges), e.useEndEdge)) {
                                var i = Math.min(e.edges, f.start);
                                for (c = i - 1; c >= 0; c--) b._appendItem.call(this, c)
                            }
                        } else if (f.end < e.pages && e.edges > 0 && (e.pages - e.edges > f.end && e.pages - e.edges - f.end != 1 ? g.append('<li class="disabled"><span class="ellipse">' + e.ellipseText + "</span></li>") : e.pages - e.edges - f.end == 1 && b._appendItem.call(this, f.end), e.useEndEdge)) {
                            var h = Math.max(e.pages - e.edges, f.end);
                            for (c = h; c < e.pages; c++) b._appendItem.call(this, c)
                        }
                        e.nextText && !e.nextAtFront && b._appendItem.call(this, e.invertPageOrder ? e.currentPage - 1 : e.currentPage + 1, {
                            text: e.nextText,
                            classes: "next"
                        })
                    },
                    _getPages: function(a) {
                        var b = Math.ceil(a.items / a.itemsOnPage);
                        return b || 1
                    },
                    _getInterval: function(a) {
                        return {
                            start: Math.ceil(a.currentPage > a.halfDisplayed ? Math.max(Math.min(a.currentPage - a.halfDisplayed, a.pages - a.displayedPages), 0) : 0),
                            end: Math.ceil(a.currentPage > a.halfDisplayed ? Math.min(a.currentPage + a.halfDisplayed, a.pages) : Math.min(a.displayedPages, a.pages))
                        }
                    },
                    _appendItem: function(c, d) {
                        var e, f, g = this,
                        h = g.data("pagination"),
                        i = a("<li></li>"),
                        j = g.find("ul");
                        c = 0 > c ? 0 : c < h.pages ? c: h.pages - 1,
                        e = {
                            text: c + 1,
                            classes: ""
                        },
                        h.labelMap.length && h.labelMap[c] && (e.text = h.labelMap[c]),
                        e = a.extend(e, d || {}),
                        c == h.currentPage || h.disabled ? (i.addClass(h.disabled ? "disabled": "active"), f = a('<span class="current">' + e.text + "</span>")) : (f = a('<a href="' + h.hrefTextPrefix + (c + 1) + h.hrefTextSuffix + '" class="page-link">' + e.text + "</a>"), f.click(function(a) {
                            return b._selectPage.call(g, c, a)
                        })),
                        e.classes && f.addClass(e.classes),
                        i.append(f),
                        j.length ? j.append(i) : g.append(i)
                    },
                    _selectPage: function(a, c) {
                        var d = this.data("pagination");
                        return d.currentPage = a,
                        d.selectOnClick && b._draw.call(this),
                        d.onPageClick(a + 1, c)
                    }
                };
                a.fn.pagination = function(c) {
                    return b[c] && "_" != c.charAt(0) ? b[c].apply(this, Array.prototype.slice.call(arguments, 1)) : "object" != typeof c && c ? void a.error("Method " + c + " does not exist on jQuery.pagination") : b.init.apply(this, arguments)
                }
            } (jQuery)
        }.apply(a, arguments)
    })
} (this),
define("appSrc/include/index/newcourseSearch", ["jquery", "appCommon", "cs!timeStatus", "djangoAjaxPost", "simplePagination"],
function(a, b, c) {
    return a("#js_xsy_new_course_search").length ? void b(function() {
        var b = a(".mode_switch").find(".blockmode"),
        d = a(".mode_switch").find(".listmode");
        b.on("click",
        function() {
            a(this).addClass("currentbm"),
            a(this).siblings().removeClass("currentlm")
        }),
        d.on("click",
        function() {
            a(this).addClass("currentlm"),
            a(this).siblings().removeClass("currentbm")
        }),
        a("#list_style").find("[data-start]").each(function() {
            var b = a(this),
            d = b.data("start"),
            e = b.data("end"),
            f = b.data("enrollment-start"),
            g = b.data("enrollment-end"),
            h = b.html().match(/<.*\/\w*>/),
            i = c.main(f, g, d, e),
            j = "";
            j = "preStart_register" == i.state ? i.time + " 开放注册": "preStart_course" == i.state || "preCourse_postRegister" == i.state ? i.time + " 开课": "start_course" == i.state ? i.time + "前 已经开课": "课程已完结",
            b.html(h + j)
        });
        var e;
        e = a("#loginData");
        var f = a("#list_pager");
        f.pagination({
            pages: parseInt(e.data("pagecount")),
            displayedPages: 9,
            edges: 1,
            prevText: "上一页",
            nextText: "下一页",
            selectOnClick: 1 === parseInt(e.data("pagecount")) ? !1 : !0,
            currentPage: parseInt(e.data("currentpage")),
            hrefTextPrefix: e.data("href").indexOf("?") > -1 ? e.data("href") + "&page=": e.data("href") + "?page=",
            onPageClick: function() {
                return 1 === parseInt(e.data("pagecount")) ? !1 : void 0
            }
        }),
        1 === parseInt(e.data("pagecount")) && a("#list_pager").find("ul").find("li").addClass("disabled")
    }) : !1
}),
define("text!appSrc/include/index/tpl/suggestion.tpl", [],
function() {
    return '<ul>\n	<% _.each(suggestions, function(suggestion, idx) { %>\n	<li><a><%= suggestion %></a></li>\n	<% }); %>\n	<li class="hint-item">按回车键或者点击搜索，显示搜索结果</li>\n</ul>'
}),
define("appSrc/include/index/newcourseSearchresult", ["jquery", "appCommon", "text!appSrc/include/index/tpl/suggestion.tpl", "cs!timeStatus", "djangoAjaxPost", "modalPlus", "simplePagination"],
function(a, b, c, d) {
    return a("#js_xsy_new_course_search_result").length ? void b(function() {
        var b = a("#search"),
        e = b.find("input"),
        f = (b.find("button"), a(".search_bar_suggestion")),
        g = null;
        e.on("input",
        function() {
            var b = e.val(),
            d = a(".search_bar_search");
            return g && clearTimeout(g),
            "" == b ? (d.removeClass("active"), void f.hide()) : (d.addClass("active"), void(g = setTimeout(function() {
                a.ajax({
                    url: f.data("url"),
                    dataType: "json",
                    data: {
                        qt: 1,
                        query: e.val(),
                        num: 5
                    }
                }).done(function(a) {
                    if (0 == a.error_code && a.data && a.data.length > 0) {
                        var b = _.template(c)({
                            suggestions: a.data
                        });
                        f.html(b),
                        f.show()
                    } else f.html(""),
                    f.hide()
                }).fail(function(a) {
                    console.log(a),
                    f.html(""),
                    f.hide()
                })
            },
            300)))
        }).on("focus",
        function() {
            "" != e.val() && f.show()
        }).on("click",
        function() {
            return ! 1
        }).on("keydown",
        function(b) {
            if (27 == b.keyCode) return void f.hide();
            if (38 == b.keyCode) {
                if (f.is(":hidden")) return;
                var c = f.find("li:not(.hint-item)");
                if (c.length > 0) {
                    var d = c.length - 1;
                    _.each(c,
                    function(b, c) {
                        a(b).hasClass("hover") && c > 0 && (d = c - 1)
                    });
                    var g = a(c.get(d));
                    c.removeClass("hover"),
                    g.addClass("hover"),
                    e.val(g.text())
                }
                return ! 1
            }
            if (40 == b.keyCode) {
                if (f.is(":hidden")) return;
                var c = f.find("li:not(.hint-item)");
                if (c.length > 0) {
                    var h = 0;
                    _.each(c,
                    function(b, d) {
                        a(b).hasClass("hover") && d < c.length - 1 && (h = d + 1)
                    });
                    var g = a(c.get(h));
                    c.removeClass("hover"),
                    g.addClass("hover"),
                    e.val(g.text())
                }
                return ! 1
            }
        }),
        a("body").on("click",
        function() {
            f.hide()
        }),
        a("body").on("click", ".search_bar_suggestion li",
        function() {
            var b = a(this);
            b.hasClass("hint-item") || (e.val(b.text()), startsearch())
        }).on("mouseenter mouseout", ".search_bar_suggestion li",
        function(b) {
            return a(this).hasClass("hint-item") ? !1 : void("mouseenter" == b.type ? a(this).addClass("hover") : a(this).removeClass("hover"))
        }),
        a(document).on("keydown",
        function(a) {
            13 == a.keyCode && f.hide()
        }),
        a("#list_style").find("[data-start]").each(function() {
            var b = a(this),
            c = b.data("start"),
            e = b.data("end"),
            f = b.data("enrollment-start"),
            g = b.data("enrollment-end"),
            h = b.html().match(/<.*\/\w*>/),
            i = d.main(f, g, c, e),
            j = "";
            j = "preStart_register" == i.state ? i.time + " 开放注册": "preStart_course" == i.state || "preCourse_postRegister" == i.state ? i.time + " 开课": "start_course" == i.state ? i.time + "前 已经开课": "课程已完结",
            b.html(h + j)
        });
        var h = a("#list_pager");
        h.pagination({
            pages: parseInt(h.data("pagecount")),
            displayedPages: 9,
            edges: 1,
            prevText: "上一页",
            nextText: "下一页",
            selectOnClick: 1 === parseInt(h.data("pagecount")) ? !1 : !0,
            currentPage: parseInt(h.data("currentpage")),
            hrefTextPrefix: h.data("href").indexOf("?") > -1 ? h.data("href") + "&page=": h.data("href") + "?page=",
            onPageClick: function() {
                return 1 === parseInt(h.data("pagecount")) ? !1 : void 0
            }
        }),
        1 === parseInt(h.data("pagecount")) && a("#list_pager").find("ul").find("li").addClass("disabled")
    }) : !1
}),
define("appSrc/include/index/vertical", ["jquery", "appCommon"],
function(a, b) {
    return a("#js_xy_vertical").length ? void b(function() {
        var b = a("#nav"),
        c = b.find("li"),
        d = b.height(),
        e = b.offset().top,
        f = a(window),
        g = [],
        h = a("#article").find("section"),
        i = parseInt(h.eq(2).css("margin-top"));
        h.each(function(b) {
            var c = a(this);
            g[b] = 0 == b ? c.offset().top - 30 : c.offset().top + parseInt(d)
        }),
        b.on("click", "li",
        function() {
            var b = a(this);
            a("body").add("html").animate({
                scrollTop: g[b.index()] - d
            })
        }),
        f.on("scroll",
        function() {
            var h = f.scrollTop();
            h >= e ? b.addClass("scroll") : b.removeClass("scroll"),
            a.each(g,
            function(a, b) {
                h >= b - d - i && c.eq(a).addClass("on").siblings().removeClass("on")
            })
        })
    }) : !1
}),
define("ngCheckbox", ["checkbox"],
function() {
    return function() {
        return {
            scope: {
                model: "=ngModel"
            },
            priority: 10,
            link: function(a, b, c) {
                b.parents(".ui.checkbox").eq(0).checkbox(),
                "radio" == b.attr("type") && b.on("change",
                function() {
                    a.$apply(function() {
                        a.model = c.value
                    })
                })
            }
        }
    }
}),
define("ngValidatePhoneNum", [],
function() {
    var a = function(a, b) {
        return {
            require: "ngModel",
            link: function(c, d, e, f) {
                var g = b(e.validatePhoneNumLoading),
                h = b(e.validatePhoneNumMsg);
                f.$setValidity("validatePhoneNum", !1),
                f.$setValidity("pattern2", !1),
                c.$watch(e.ngModel,
                function(b, d) {
                    if (b === d) return ! 1;
                    if (/^0?(13|15|17|18|14)[0-9]{9}$/.test(b)) {
                        f.$setValidity("pattern2", !0);
                        var i = e.name + "=" + b;
                        e.validatePhoneNumAdditional && (i = i + "&" + e.validatePhoneNumAdditional),
                        g.assign(c, !0),
                        a({
                            url: e.validatePhoneUrl,
                            method: "post",
                            data: i
                        }).success(function(a) {
                            a.messages && a.messages.phone_number ? (f.$setValidity("validatePhoneNum", !1), h.assign(c, a.messages.phone_number)) : f.$setValidity("validatePhoneNum", !0),
                            g.assign(c, !1)
                        }).error(function(a) {
                            console.error(a, "----request error----"),
                            h.assign(c, "网络连接失败"),
                            g.assign(c, !1)
                        })
                    } else f.$setValidity("validatePhoneNum", !1),
                    f.$setValidity("pattern2", !1)
                })
            }
        }
    };
    return a.$inject = ["$http", "$parse"],
    a
}),
define("ngVerificationBtn", [],
function() {
    var a = function(a, b, c) {
        return {
            link: function(d, e, f) {
                var g = c(f.captchaMsg),
                h = c(f.validateImage),
                i = c(f.verificationCounting),
                j = null,
                k = e.html(),
                l = e.attr("verification-count"),
                m = 60;
                h.assign(d, !1),
                e.on("second",
                function() {
                    m = l || 60
                }),
                e.trigger("second"),
                e.on("countdown",
                function(a, c) {
                    0 == c ? (b.cancel(j), e.html(k).trigger("second"), i.assign(d, !1)) : e.html(c + "秒后重试")
                }),
                e.on("click",
                function() {
                    e.hasClass("disabled") || (i.assign(d, !0), a({
                        url: f.verificationUrl,
                        method: "post",
                        data: f.verificationSendData
                    }).success(function(a) {
                        a.sms_validate_image ? (h.assign(d, a.sms_validate_image + "?" + parseInt(1e5 * Math.random())), i.assign(d, !1), a.messages && a.messages.captcha ? g.assign(d, a.messages.captcha) : g.assign(d, "")) : (g.assign(d, ""), h.assign(d, ""), i.assign(d, !0), e.html(m + "秒后重试"), j = b(function() {
                            m--,
                            e.trigger("countdown", m)
                        },
                        1e3))
                    }))
                })
            }
        }
    };
    return a.$inject = ["$http", "$interval", "$parse"],
    a
}),
define("text!appSrc/include/retrieve_pwd/choice_type.tpl", [],
function() {
    return '<!-- 选择找回方式 -->\n<div class="retrieve_pwd_tip purple_container">\n	<div class="retrieve_pwd_title cf">\n		<em class="fl">l</em>\n		<h3 class="fl"><span class="retrieve_title">选择找回方式 </span><span class="retrieve_info"><span><i>w</i></span> 进行安全验证 <i>w</i> 重新设置密码</span></h3>\n	</div>\n	<div class="mretrieve_pwd_title cf">\n		<ul class="cf">\n			<li class="active">第一步<span class="out"></span><span class="in"></span></li>\n			<li>第二步<span class="out"></span><span class="in"></span></li>\n			<li>第三步<span class="out"></span><span class="in"></span></li>\n		</ul>\n	</div>\n	<div class="retrieve_main pc_retrieve_main">\n		<ul class="retrieve_list_way cf retrievelistway">\n			<% if(typeof(phone_number) != "undefined" && phone_number){%>\n			<li data-url="send_validation" data-id="<%= user_id %>" data-info="<%= phone_number %>" data-type="phone_number">\n				<span class="icon">M</span>\n				<p>通过手机<br><span><%= phone_number %></span></p>\n			</li>\n			<%}%>\n			<% if(typeof(email) != "undefined" && email){%>\n			<li data-url="send_validation" data-id="<%= user_id %>" data-info="<%= email %>" data-type="email" data-post="send_email_reset_password">\n				<span class="icon">c</span>\n				<p>通过邮箱<br><span><%= email %></span></p>\n			</li>\n			<%}%>\n		</ul>\n		<div class="retrieve_notice">无法通过以上方法找回密码？<a href="http://www.xuetangx.com/about#/contact" target="_blank">联系客服</a>人工帮您重置密码。</div>		\n		<div class="error_message retrieve_message">\n			<p></p>\n		</div>\n	</div>\n	<div class="mretrieve_main">\n		<p class="text">请选择您找回密码的方式</p>\n		<ul class="retrievelistway">\n			<% if(typeof(phone_number) != "undefined" && phone_number){%>\n			<li class="cf" data-url="send_validation" data-id="<%= user_id %>" data-info="<%= phone_number %>" data-type="phone_number">手机<span class="next_info"><%= phone_number %><span class="next">w</span></span></li>\n			<%}%>\n			<% if(typeof(email) != "undefined" && email){%>\n			<li class="cf" data-url="send_validation" data-id="<%= user_id %>" data-info="<%= email %>" data-type="email" data-post="send_email_reset_password">邮箱<span class="next_info"><%= email %><span class="next">w</span></span></li>\n			<%}%>\n		</ul>		\n		<div class="error_message retrieve_message">\n			<p></p>\n		</div>\n	</div>\n</div>'
}),
function(a) {
    "function" == typeof define && define.amd ? define("jquery.cookie", ["jquery"], a) : a("object" == typeof exports ? require("jquery") : jQuery)
} (function(a) {
    function b(a) {
        return h.raw ? a: encodeURIComponent(a)
    }
    function c(a) {
        return h.raw ? a: decodeURIComponent(a)
    }
    function d(a) {
        return b(h.json ? JSON.stringify(a) : String(a))
    }
    function e(a) {
        0 === a.indexOf('"') && (a = a.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, "\\"));
        try {
            return a = decodeURIComponent(a.replace(g, " ")),
            h.json ? JSON.parse(a) : a
        } catch(b) {}
    }
    function f(b, c) {
        var d = h.raw ? b: e(b);
        return a.isFunction(c) ? c(d) : d
    }
    var g = /\+/g,
    h = a.cookie = function(e, g, i) {
        if (void 0 !== g && !a.isFunction(g)) {
            if (i = a.extend({},
            h.defaults, i), "number" == typeof i.expires) {
                var j = i.expires,
                k = i.expires = new Date;
                k.setTime( + k + 864e5 * j)
            }
            return document.cookie = [b(e), "=", d(g), i.expires ? "; expires=" + i.expires.toUTCString() : "", i.path ? "; path=" + i.path: "", i.domain ? "; domain=" + i.domain: "", i.secure ? "; secure": ""].join("")
        }
        for (var l = e ? void 0 : {},
        m = document.cookie ? document.cookie.split("; ") : [], n = 0, o = m.length; o > n; n++) {
            var p = m[n].split("="),
            q = c(p.shift()),
            r = p.join("=");
            if (e && e === q) {
                l = f(r, g);
                break
            } ! e && void 0 !== (r = f(r)) && (l[q] = r)
        }
        return l
    };
    h.defaults = {},
    a.removeCookie = function(b, c) {
        return void 0 === a.cookie(b) ? !1 : (a.cookie(b, "", a.extend({},
        c, {
            expires: -1
        })), !a.cookie(b))
    }
}),
define("ngMessages", ["angular"],
function() {
    angular.module("ngMessages", []).directive("ngMessages", ["$compile", "$animate", "$templateRequest",
    function(a, b, c) {
        var d = "ng-active",
        e = "ng-inactive";
        return {
            restrict: "AE",
            controller: function() {
                this.$renderNgMessageClasses = angular.noop;
                var a = [];
                this.registerMessage = function(b, c) {
                    for (var d = 0; d < a.length; d++) if (a[d].type == c.type) {
                        if (b != d) {
                            var e = a[b];
                            a[b] = a[d],
                            b < a.length ? a[d] = e: a.splice(0, d)
                        }
                        return
                    }
                    a.splice(b, 0, c)
                },
                this.renderMessages = function(b, c) {
                    function d(a) {
                        return null !== a && a !== !1 && a
                    }
                    b = b || {};
                    var e;
                    angular.forEach(a,
                    function(a) {
                        e && !c || !d(b[a.type]) ? a.detach() : (a.attach(), e = !0)
                    }),
                    this.renderElementClasses(e)
                }
            },
            require: "ngMessages",
            link: function(f, g, h, i) {
                i.renderElementClasses = function(a) {
                    a ? b.setClass(g, d, e) : b.setClass(g, e, d)
                };
                var j, k = angular.isString(h.ngMessagesMultiple) || angular.isString(h.multiple),
                l = h.ngMessages || h["for"];
                f.$watchCollection(l,
                function(a) {
                    j = a,
                    i.renderMessages(a, k)
                });
                var m = h.ngMessagesInclude || h.include;
                m && c(m).then(function(b) {
                    var c, d = angular.element("<div/>").html(b);
                    angular.forEach(d.children(),
                    function(b) {
                        b = angular.element(b),
                        c ? c.after(b) : g.prepend(b),
                        c = b,
                        a(b)(f)
                    }),
                    i.renderMessages(j, k)
                })
            }
        }
    }]).directive("ngMessage", ["$animate",
    function(a) {
        var b = 8;
        return {
            require: "^ngMessages",
            transclude: "element",
            terminal: !0,
            restrict: "AE",
            link: function(c, d, e, f, g) {
                for (var h, i, j = d[0], k = j.parentNode, l = 0, m = 0; l < k.childNodes.length; l++) {
                    var n = k.childNodes[l];
                    if (n.nodeType == b && n.nodeValue.indexOf("ngMessage") >= 0) {
                        if (n === j) {
                            h = m;
                            break
                        }
                        m++
                    }
                }
                f.registerMessage(h, {
                    type: e.ngMessage || e.when,
                    attach: function() {
                        i || g(c,
                        function(b) {
                            a.enter(b, null, d),
                            i = b
                        })
                    },
                    detach: function() {
                        i && (a.leave(i), i = null)
                    }
                })
            }
        }
    }])
}),
define("appSrc/include/index/retrievePwd", ["appCommon", "underscore", "jquery", "ngCheckbox", "ngValidatePhoneNum", "ngVerificationBtn", "validate", "text!appSrc/include/retrieve_pwd/choice_type.tpl", "text!appSrc/include/header_second/phonecode.tpl", "jquery.cookie", "ngCommon", "ngMessages"],
function(a, b, c, d, e, f, g, h, i) {
    return c("#js_xy_select_retrievePwd").length ? void a(function() {
        var a = angular.module("retrievePwd", ["xt", "ngMessages"]);
        a.controller("ctrl", ["$scope", "selectFormType", "ajax", "$window",
        function(a, b, d, e) {
            a.selectFormType = "email",
            b(a, "selectFormType"),
            a.validatePhoneNum = c("#phone_retrieve_form").data("phone_validate_url"),
            a.phoneCodeUrl = c("#py_header_data").data("phonecode"),
            a.phoneRetrieveSubmit = function() {
                d({
                    url: c("#phone_retrieve_form").data("action_url"),
                    data: c("#phone_retrieve_form").serialize(),
                    type: "post",
                    dataType: "json"
                }).then(function(b) {
                    b.success ? e.location.href = b.next: a.phoneRetrieveMsg = b.value
                },
                function(a, b) {
                    console.error(a, b)
                })
            }
        }]),
        a.provider("selectFormType",
        function() {
            return {
                $get: function() {
                    return function(a, b) {
                        a.$watch(b,
                        function(b) {
                            "email" === b ? a.isEmailRegister = !0 : "phone" === b && (a.isEmailRegister = !1)
                        })
                    }
                }
            }
        }),
        a.directive("validatePhoneNum", e),
        a.directive("verificationBtn", f),
        a.directive("uiCheckbox", d),
        angular.bootstrap(document.getElementById("angular_bootstrap"), ["retrievePwd"]);
        var j = c(".retrieve_pwd_tip"),
        k = c(".retrieve_pwd_tip").find(".field"),
        l = new g(k, j);
        l.init();
        var m = j.find(".phoneCode").length;
        m && (l.validObj.id = c("#validateCode").val());
        var n = function(a) {
            var d = !0;
            return c.each(l.validObj,
            function(a) {
                var b;
                delete l.validObj.again,
                b = null == l.validObj[a] ? !1 : !0,
                b || "" != k.find("input[name=" + a + "]").val() || k.find("input[name=" + a + "]").parents(".field").find(".required").removeClass("hide"),
                k.find("input[name=new_password1]").val() != k.find("input[name=new_password2]").val() && (k.find("input[name=new_password2]").parents(".field").find(".same").removeClass("hide"), b = !1),
                d = d && b
            }),
            d ? (c.ajax({
                url: a,
                data: l.validObj,
                timeout: 3e4,
                type: "post",
                dataType: "json"
            }).done(function(a) {
                if (a.success) if (a.next) window.location.href = a.next;
                else {
                    a.email || (a.email = null),
                    a.phone_number || (a.phone_number = null);
                    var d = b.template(h)(a);
                    c("#retrieveFotPwd").html(d)
                } else a.error_message && c(".error_message").show().children().text(a.error_message)
            }).fail(function() {
                c(".error_message").show().children().text("网络连接失败")
            }).complete(function() {
                l.changeCode()
            }), !1) : void 0
        },
        o = function(a) {
            var b = c(this);
            a.preventDefault(),
            "email" == c(this).data("type") || c("#resetSendMail").length ? c.ajax({
                url: b.data("post"),
                data: {
                    id: b.data("id"),
                    csrfmiddlewaretoken: c.cookie("csrftoken")
                },
                type: "post",
                dataType: "json"
            }).done(function(a) {
                a.success && "email" == b.data("type") ? window.location.href = b.data("url") + "/" + b.data("id") + "/" + b.data("type") + "/" + b.data("info") : a.error_message && c(".error_message").show().children().text(a.error_message)
            }).fail(function() {
                c(".error_message").show().children().text("网络连接失败")
            }) : window.location.href = b.data("url") + "/" + b.data("id") + "/" + b.data("type") + "/" + b.data("info")
        };
        c("#retrieveFotPwd").on("click", ".retrievelistway li", o),
        c("#resetSendMail").on("click", o),
        j.find("#retrieveSumbit").on("submit",
        function(a) {
            a.preventDefault();
            var b = "retrieve_password";
            return n(b),
            !1
        }),
        j.find("#retrieveCode").on("submit",
        function(a) {
            a.preventDefault(),
            delete l.validObj.captcha;
            var b = c("#retrieveCode").data("url");
            return n(b),
            !1
        }),
        j.find("#retrievePsd").on("submit",
        function(a) {
            a.preventDefault();
            var b = c("#retrievePsd").data("url");
            return n(b),
            !1
        }),
        j.find("#retrieveResetPsd").on("submit",
        function(a) {
            a.preventDefault();
            var b = c("#py_header_data").data("retrievepsd");
            return n(b),
            !1
        }),
        c("#headerValidCode").on("click", ".phoneCode",
        function() {
            var a = c(this).parent().data("url");
            l.validObj.phone_number = c(this).parent().data("number");
            var b = c(this),
            d = 60;
            return b.hasClass("disabled") || b.hasClass("exist") ? !1 : (c.ajax({
                url: a,
                data: l.validObj,
                type: "post",
                dataType: "json"
            }).done(function(a) {
                if (a.success) var e = setInterval(function() {
                    d ? b.addClass("disabled").text(--d + "秒后重试") : (b.removeClass("disabled").text("获取验证码"), clearInterval(e), b.removeClass("exist"))
                },
                1e3);
                else a.validation ? (c("#headerPhoneCode").remove(), c(i).insertBefore(b.parents(".field")), l.validObj.captcha = "", b.removeClass("exist")) : a.messages && a.messages[b.prop("name")] && c(".error_message").show().children().text(a.messages[b.prop("name")]).removeClass("hide")
            }).fail(function() {
                b.removeClass("disabled"),
                c(".error_message").show().children().text("网络连接失败"),
                b.removeClass("exist");

            }).complete(function() {
                l.changeCode()
            }), !1)
        })
    }) : !1
}),
define("appSrc/include/index/bindSchool", ["appCommon", "underscore", "jquery", "ngCheckbox", "ngValidatePhoneNum", "ngVerificationBtn", "validate", "text!appSrc/include/retrieve_pwd/choice_type.tpl", "text!appSrc/include/header_second/phonecode.tpl", "jquery.cookie", "ngCommon", "ngMessages"],
function(a, b, c) {
    return c("#js_xy_select_bindSchool").length ? void a(function() {
        function a(a) {
            a.stopPropagation();
            var b = c("#xt_school").val();
            b = b.replace(/ /g, ""),
            "click" == a.type && (b = "");
            for (var d = "",
            e = 0; e < h.length; e++) - 1 != h[e].indexOf(b) && (d += "<li>" + h[e] + "</li>");
            d ? (c("#xt_hint_box").html(d), c("#xt_hint_box").show()) : c("#xt_hint_box").hide()
        }
        function b(a) {
            for (var b = 0; b < h.length; b++) if (a == h[b]) return ! 0;
            return ! 1
        }
        var d, e, f, g, h = bindSchoolList;
        c("#re_write").click(function() {
            c("#preview_wrap").hide()
        }),
        c("#confirm_sub").click(function() {
            c.post("/bind_school/", {
                school: d,
                entrance_time: e,
                number: f,
                name: g
            },
            function(a) {
                a.success ? location.href = "/dashboard": (c("#preview_wrap").hide(), c("#error_msg").html(a.value).stop().css("display", "block"))
            })
        }),
        c("#xt_school").on({
            input: a,
            click: a
        }),
        c(document).click(function() {
            c("#xt_hint_box").hide()
        }),
        c("#xt_hint_box").delegate("li", "click",
        function(a) {
            var b = a.target.innerHTML;
            c("#xt_school").val(b),
            c("#xt_hint_box").hide()
        }),
        c("#first_sub").click(function() {
            return d = c("#xt_school").val().replace(/ /g, ""),
            e = c("#xt_entrance_time").val(),
            f = c("#xt_number").val(),
            g = c("#xt_name").val(),
            d ? b(d) ? f ? g ? (c("#error_msg").hide(), c("#pre_school").html(d), c("#pre_entrance_time").html(e), c("#pre_number").html(f), c("#pre_name").html(g), c("#preview_wrap").show(), !1) : (c("#error_msg").html("请输入姓名").stop().show(), !1) : (c("#error_msg").html("请输入学号").stop().show(), !1) : (c("#error_msg").html("请输入正确学校名称").stop().show(), !1) : (c("#error_msg").html("请选择学校").stop().show(), !1)
        })
    }) : !1
}),
require(["appSrc/include/index/aboutUs", "appSrc/include/index/androidDownload", "appSrc/include/index/consociationSchool", "appSrc/include/index/newcourseSearch", "appSrc/include/index/newcourseSearchresult", "appSrc/include/index/vertical", "appSrc/include/index/retrievePwd", "appSrc/include/index/bindSchool", "appSrc/include/header_second/searchsuggestion"]),
define("appSrc/index",
function() {});