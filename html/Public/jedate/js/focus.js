define(
function(t) {	
	t("indexFocus");
	$(".scrollLoading").scrollLoading(),
	$("#indexFocus").indexFocus({
		autoStart: !0,
		showBtnImg: !0,
		showScrollBtn: !0
	})
});
define("indexFocus", [],
function() { (function(t) {
		t.indexFocus = function(i, o) {
			var e, a = 0,
			s = this,
			n = t(i).find("li").eq(0).width(),
			c = t(i).find("li").eq(0).height(),
			r = t(i).find("li").length;
			s.opts = t.extend({},
			t.indexFocus.defaults, o),
			s.init = function() {
				if (s.focusUl = t(i).find("ul"), s.focusLi = t(i).find("li"), s.focusUl.width(n * r), s.opts.autoStart && s.startFocus(a), s.opts.showNum) {
					var o = "";
					o += '<div class="indexFocusNum">';
					for (var c = 0; r > c; c++) o += 0 == c ? '<a href="javascript:void(0)" target="_self" class="ui-ifNumBtn hover">' + (c + 1) + "</a>": '<a href="javascript:void(0)" class="ui-ifNumBtn" target="_self">' + (c + 1) + "</a>";
					o += "</div>",
					t(i).append(o),
					t(i).delegate(".indexFocusNum a.ui-ifNumBtn", "mouseenter mouseleave",
					function(i) {
						a = t(this).index(),
						"mouseenter" == i.type && (clearTimeout(s.timeout), s.curImg(), s.moveFocus())
					})
				}
				if (s.opts.showBtn) {
					var l = nextImg = "";
					if (s.opts.showBtnImg) {
						var u = s.focusLi.find("img").eq(r - 1).attr("data-url"),
						d = s.focusLi.find("img").eq(a + 1).attr("data-url");
						l = '<img class="ui-prevImg" width="100" height="80" src="' + u + '" />',
						nextImg = '<img class="ui-nextImg" width="100" height="80" src="' + d + '" />'
					}
					var p = '<div class="ui-ifPrevWrap"><a href="javascript:void(0)" class="ui-ifPrevBtn" target="_self">向上</a>' + l + '</div><div class="ui-ifNextWrap"><a href="javascript:void(0)" class="ui-ifNextBtn" target="_self">向下</a>' + nextImg + "</div>";
					t(i).append(p);
					var h = t(i).find(".ui-ifPrevWrap"),
					m = t(i).find(".ui-ifNextWrap");
					h.on("click mouseenter mouseleave",
					function(i) {
						"click" == i.type ? (a--, 0 > a && (a = r - 1), s.opts.showBtnImg && s.curImg(), s.goPlayFocus(a)) : "mouseenter" == i.type ? (clearTimeout(s.timeout), t(this).addClass("cur"), s.moveFocus()) : t(this).removeClass("cur")
					}),
					m.on("click mouseenter mouseleave",
					function(i) {
						"click" == i.type ? (a++, a == r && (a = 0), s.opts.showBtnImg && s.curImg(), s.goPlayFocus(a)) : "mouseenter" == i.type ? (clearTimeout(s.timeout), t(this).addClass("cur"), s.moveFocus()) : t(this).removeClass("cur")
					})
				}
				s.focusLi.find("img").eq(0).load(function() {
					t(i).show()
				}),
				t(i).on("mouseenter mouseleave",
				function(t) {
					"mouseenter" == t.type ? (s.opts.showScrollBtn || (h.show(), m.show()), s.opts.autoStart && clearInterval(e)) : (s.opts.showScrollBtn || (h.hide(), m.hide()), s.startFocus(a))
				})
			},
			s.curImg = function() {
				var o = s.focusLi.find("img").eq(a - 1).attr("data-url"),
				e = s.focusLi.find("img").eq(a == r - 1 ? 0 : a + 1).attr("data-url");
				t(i).find(".ui-prevImg").attr("src", o),
				t(i).find(".ui-nextImg").attr("src", e)
			},
			s.moveFocus = function() {
				s.timeout = setTimeout(function() {
					t(s.$numLi).addClass("hover").siblings().removeClass("hover"),
					s.goPlayFocus(a)
				},
				s.opts.intevalTime)
			},
			s.PlayFocus = function() {
				r - 1 >= a && a++,
				a = a > r - 1 ? 0 : a,
				s.opts.showBtnImg && s.curImg(),
				s.goPlayFocus(a)
			},
			s.goPlayFocus = function(o) {
				s.focusNum = t(i).find("a.ui-ifNumBtn"),
				s.focusNum.eq(o).addClass("hover").siblings().removeClass("hover");
				var e = s.focusLi.eq(o).find("img").attr("data-url");
				s.focusLi.eq(o).find("img").attr("src", e),
				"left" == s.opts.switchPath ? (s.focusLi.css({
					"float": "left"
				}), s.focusUl.css({
					width: r * n
				}), o = -(o * n) + "px", s.focusUl.stop(), s.focusUl.stop(!0, !1).animate({
					left: o
				},
				s.opts.switchTime)) : "up" == s.opts.switchPath && (o = -(o * c) + "px", s.focusUl.stop(), s.focusUl.stop(!0, !1).animate({
					top: o
				},
				s.opts.switchTime))
			},
			s.startFocus = function() {
				s.opts.autoStart && (e = setInterval(s.PlayFocus, s.opts.time))
			},
			s.init()
		},
		t.indexFocus.defaults = {
			autoStart: !1,
			switchPath: "left",
			showBtn: !0,
			showBtnImg: !1,
			showScrollBtn: !1,
			showTxt: !0,
			showNum: !0,
			time: 5e3,
			switchTime: 500,
			intevalTime: 200
		},
		t.fn.indexFocus = function(i) {
			return this.each(function() {
				new t.indexFocus(this, i)
			})
		}
	})(jQuery)
})
