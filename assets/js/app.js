"use strict";
function getLiveQuotes(e) {
    var t = [],
    a = [],
    n = [];
    $(".live-data", "body").each(function (e, r) {
        var i = $(r),
        o = i.data("symbol"),
        d = i.data("field"),
        f = i.data("check-trading");
        $.inArray(o, t) == -1 && t.push(o),
        f && $.inArray(o, a) == -1 && a.push(o),
        $.inArray(d, n) == -1 && n.push(d)
    }),
    log("getLiveQuotes", t, n, a),
    t.length && n.length && $.ajax({
        url: LIVE_QUOTES_URI,
        data: {
            symbols: t.join(","),
            check: a.join(","),
            fields: n.join(",")
        },
        dataType: "json",
        async: !0,
        cache: !1,
        success: function (t) {
            log("live-data", t),
            $(".live-data").each(function (e, a) {
                var n = $(a),
                r = n.data("symbol"),
                i = n.data("field"),
                o = n.data("prev-value"),
                d = n.data("format"),
                f = n.data("format-args") ? n.data("format-args").toString().split(",") : "",
                s = n.data("callback"),
                u = n.data("callback-args") ? n.data("callback-args").toString().split(",") : "";
                if (t.hasOwnProperty(r) && "undefined" != t[r][i]) {
                    var l = t[r][i];
                    n.data("prev-value", l),
                    n.data("order", l);
                    var c = "undefined" != typeof o && o != l;
                    if (d) {
                        var p = window[d];
                        l = f ? p(n, t[r], f) : p(l)
                    }
                    if (s) {
                        var m = window[s];
                        u ? m(n, t[r], u) : m(n, t[r])
                    }
                    n.html(l),
                    c && n.transition("flash")
                }
            }),
            "function" == typeof e && e(),
            clearTimeout(liveQuotesTimeout),
            liveQuotesTimeout = setTimeout(function () {
                    getLiveQuotes(e)
                }, LIVE_QUOTES_INTERVAL)
        },
        error: handleAjaxError
    })
}
function fmtUpDownIndicator(e, t) {
    var a = "undefined" != typeof arguments[2][0] ? arguments[2][0] : "",
    n = "undefined" != typeof arguments[2][1] ? arguments[2][1] : "";
    if ("undefined" != typeof t[a] && "undefined" != typeof t[n]) {
        var r = parseFloat(t[a]),
        i = isNaN(t[n]) ? t[n] : t[n].toFixed(2);
        return '<i class="' + (r > 0 ? "green caret up" : r < 0 ? "red caret down" : "") + ' large icon"></i>' + i
    }
    return ""
}
function fmtGreenRedFont(e, t) {
    var a = "undefined" != typeof arguments[2][0] ? arguments[2][0] : "",
    n = "undefined" != typeof arguments[2][1] ? arguments[2][1] : "";
    if ("undefined" != typeof t[a] && "undefined" != typeof t[n]) {
        var r = t[a],
        i = isNaN(t[n]) ? t[n] : t[n].toFixed(2);
        return '<span class="' + (r > 0 ? "green" : r < 0 ? "red" : "") + '">' + i + "</span>"
    }
    return ""
}
function fmtGreenRedFontWithBraces(e, t) {
    var a = "undefined" != typeof arguments[2][0] ? arguments[2][0] : "",
    n = "undefined" != typeof arguments[2][1] ? arguments[2][1] : "";
    if ("undefined" != typeof t[a] && "undefined" != typeof t[n]) {
        var r = parseFloat(t[a]),
        i = isNaN(t[n]) ? t[n] : t[n].toFixed(2) + "%";
        return '<span class="' + (r > 0 ? "green" : r < 0 ? "red" : "") + '">(' + i + ")</span>"
    }
    return ""
}
function fmtGreenRedPointingLabel(e, t) {
    var a = "undefined" != typeof arguments[2][0] ? arguments[2][0] : "",
    n = "undefined" != typeof arguments[2][1] ? arguments[2][1] : "";
    if ("undefined" != typeof t[a] && "undefined" != typeof t[n]) {
        var r = parseFloat(t[a]),
        i = isNaN(t[n]) ? t[n] : t[n].toFixed(4) + "%";
        return '<span class="ui left pointing ' + (r > 0 ? "green" : r < 0 ? "red" : "") + ' basic label">' + i + "</span>"
    }
    return ""
}
function fmtMarketValue(e, t) {
    var a = "undefined" != typeof arguments[2][0] ? arguments[2][0] : "",
    n = "undefined" != typeof arguments[2][1] ? parseFloat(arguments[2][1]) : 0,
    r = "undefined" != typeof arguments[2][2] ? arguments[2][2] : "",
    i = "undefined" != typeof arguments[2][3] ? arguments[2][3] : "",
    o = "undefined" != typeof arguments[2][4] ? parseFloat(arguments[2][4]) : 1;
    if ("undefined" != typeof t[a] && 0 != n) {
        var d = r != i ? floatValCommaToDot($(".currency-" + r + i).first().text()) : 1,
        f = parseFloat(t[a]) * o * n * d;
        // console.log('---------------------');
        // console.log(t);
        // console.log(a);
        // console.log(t[a]);
        // console.log($(".currency-" + r + i).first().text());
        // console.log(o);
        // console.log(n);
        // console.log(d);
        // console.log(r);
        // console.log(i);
        // console.log(f);
        // console.log(f.formatNumber());
        e.data("order", f)
    } else
        f = 0;
    return f.formatNumber()
}
function fmtUnrealizedPnL(e, t) {
    var a = "undefined" != typeof arguments[2][0] ? arguments[2][0] : "",
    n = "undefined" != typeof arguments[2][1] ? parseFloat(arguments[2][1]) : 0,
    r = "undefined" != typeof arguments[2][2] ? arguments[2][2] : "",
    i = "undefined" != typeof arguments[2][3] ? arguments[2][3] : "",
    o = "undefined" != typeof arguments[2][4] ? parseFloat(arguments[2][4]) : 0,
    d = "undefined" != typeof arguments[2][5] ? parseFloat(arguments[2][5]) : 1,
    f = "undefined" != typeof arguments[2][6] ? arguments[2][6] : "abs";
    if ("undefined" != typeof t[a] && 0 != n) {
        var s = r != i ? floatValCommaToDot($(".currency-" + r + i).first().text()) : 1,
        u = parseFloat(t[a]) * d * n * s,
        l = u - o;
        l / Math.abs(o) * 100;
        "pct" == f && (l = l / Math.abs(o) * 100),
        e.data("order", l);
        var c = "";
        l > 0 ? c = "green" : l < 0 && (c = "red"),
        e.addClass(c)
        // console.log('---------------------');
        // console.log(t);
        // console.log(a);
        // console.log(t[a]);
        // console.log($(".currency-" + r + i).first().text());
        // console.log(o);
        // console.log(n);
        // console.log(d);
        // console.log(r);
        // console.log(i);
        // console.log(f);

    } else
        l = 0;
    return l.formatNumber() + ("pct" == f ? "%" : "")
}
function fmtDecimal(e) {
    var t = floatVal(e);
    return isNaN(t) ? e : t.formatNumber()
}
function fmtLongDecimal(e) {
    var t = floatVal(e);
    return isNaN(t) ? e : t.formatNumber(4)
}
function fmtDecimalPct(e) {
    var t = floatVal(e);
    return isNaN(t) ? e : t.formatNumber() + "%"
}
function fmtInteger(e) {
    var t = floatVal(e);
    return isNaN(t) ? e : t.formatNumber(0)
}
function fmtDate(e) {
    if (e) {
        var t = new Date(1e3 * e);
        return t.toLocaleDateString()
    }
    return "-"
}
function floatVal(e) {
    return "string" == typeof e ? parseFloat(e.replace(/,/g, "")) : "number" == typeof e ? e : 0
}
function floatValCommaToDot(e) {
    return "string" == typeof e ? parseFloat(e.replace(/,/g, ".")) : "number" == typeof e ? e : 0
}
function clbEnableDisableTrading(e, t) {
    "undefined" != typeof t.tradingEnabled && (t.tradingEnabled ? ($("#trade-form").show(), $("#market-closed").hide()) : ($("#trade-form").hide(), $("#market-closed").show()))
}
function copyToClipboard(e) {
    var t = $("<input>");
    $("body").append(t),
    t.val($(e).val()).select(),
    document.execCommand("copy"),
    t.remove()
}
function handleAjaxError(e, t, a) {
    log("handleAjaxError", t + "|" + a)
}
function deleteFromArray(e, t) {
    var a = $.inArray(t, e);
    e.splice(a, 1)
}
function log() {
    "undefined" != typeof DEBUG && DEBUG && console.log(arguments)
}
var liveQuotesTimeout;
$(document).ready(function () {
    $.fn.destroyDataTable = function () {
        this.hasClass("dataTable") && this.DataTable().destroy()
    },
    $.fn.initDataTable = function (e, t, a, n, r) {
        e = e || 15,
        t = t || [[0, "asc"]],
        a = a || !1,
        n = n || function () {},
        r = r || !1;
        var i,
        o = this,
        d = 0;
        if (o.hasClass("dataTable")) {
            i = o.DataTable();
            var f = i.page.info(),
            t = i.order();
            d = f.page,
            t = [[t[0][0], t[0][1]]],
            i.destroy()
        }
        return i = o.DataTable({
                bLengthChange: !1,
                pageLength: e,
                displayStart: d * e,
                bFilter: a,
                oLanguage: DATATABLES_TRANSLATIONS,
                order: t,
                footerCallback: n,
                initComplete: function (e, t) {
                    o.is(":visible") || o.show()
                },
                dom: "Bfrtip",
                buttons: r
            }),
        a && o.closest(".dataTables_wrapper").find(".dataTables_filter").addClass("ui icon small input").append('<i class="search icon"></i>'),
        r && o.closest(".dataTables_wrapper").find(".buttons-csv").addClass("ui basic icon button").prepend('<i class="file excel outline icon"></i> '),
        i
    },
    $(".message .close").on("click", function () {
        $(this).closest(".message").transition("fade")
    }),
    $("#main-menu .ui.dropdown").dropdown({
        action: "nothing"
    }),
    $("form").not(".skip-submission-check").on("submit", function (e) {
        var t = $(this);
        "undefined" == typeof t.data("submitted") && t.form("is valid") ? (t.find(".submit.button").addClass("disabled loading"), t.data("submitted", !0)) : e.preventDefault()
    }),
    $("#social-buttons").sticky({
        context: "#content-container"
    })
}), Number.prototype.formatNumber = function () {
    var e = "undefined" != typeof arguments[0] ? arguments[0] : 2,
    t = "undefined" != typeof arguments[1] ? arguments[1] : ['de-DE','de-DE'];
    return this.toLocaleString(t, {
        minimumFractionDigits: e,
        maximumFractionDigits: e
    })
}, String.format = function (e) {
    var t = Array.prototype.slice.call(arguments, 1);
    return e.replace(/{(\d+)}/g, function (e, a) {
        return "undefined" != typeof t[a] ? t[a] : e
    })
}; 