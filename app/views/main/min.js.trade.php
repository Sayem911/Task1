<script type="text/javascript"> 
$(document).ready(function () {
    
        var p,
        m = "{{ @BASE }}/api/data/history/",
        v = "https://query.yahooapis.com/v1/public/yql?q={0}&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys",
        f = "http://{{ @vars.yahoo_rss_lang_domain }}finance.yahoo.com/rss/headline?s=",
        b = $("#symbol-search input").val(),
        g = $("#symbol-search input").data("exchange-code"),
        y = $("#tab-news .items"),
        S = $("#stock-chart"),
        k = $("#stock-chart-loader"),
        C = $("#stock-comparison-form"),
        x = [],
        A = $("#trade-form"),
        w = $("body").css("backgroundColor"),
        E = $("#main-menu").css("backgroundColor"),
        T = "#000";
        "rgb(0, 0, 0)" == w && (E = "#fff", T = "#fff");
        var F = {
            apiSettings: {
                url: "{{ @BASE }}/api/search/asset/{query}"
            },
            cache: !1,
            error: {
                noResults: "{{ @trade.symbol.search.no_results }}"
            },
            type: "stocks",
            templates: {
                stocks: n
            },
            onSelect: e,
            minCharacters: 2,
            maxResults: 25
        },
        _ = {
            apiSettings: {
                url: "{{ @BASE }}/api/search/asset/{query}"
            },
            error: {
                noResults: "{{ @trade.symbol.search.no_results }}"
            },
            type: "stocks",
            templates: {
                stocks: n
            },
            onSelect: i,
            minCharacters: 2,
            maxResults: 25
        };
    
        function e(e, t) {
            b = e.symbol,
            g = e.exchange_code,
            $("#stock-exchange-name").html('<i class="' + e.exchange_country_code + ' flag"></i>' + e.exchange_name),
            $(".stock-exchange-name").html('<i class="' + e.exchange_country_code + ' flag"></i>' + e.exchange_name);
            $(".info-panel .symbol").html(e.symbol),
            $(".ui.statistic .live-data").text(""),
            $(".live-data").not(".ui.statistic .live-data").html('<div class="ui active inline loader"></div>'),
            $(".live-data.selected-symbol").each(function () {
                $(this).data("symbol", b)
            }),
            a(),
            e.watched > 0 ? $(".add-to-watchlist").removeClass("basic loading disabled").addClass("watching").html('<i class="star icon"></i> {{ @trade.symbol.watching }}') : $(".add-to-watchlist").removeClass("loading disabled watching").addClass("basic").html('<i class="star icon"></i> {{ @trade.symbol.watch }}'),
            getLiveQuotes(),
            u(),
            c()
        }
        function a() {
            $.ajax({
                url: "{{ @BASE }}/api/actions/symbol/set/" + b,
                dataType: "json",
                async: !0,
                cache: !1
            })
        }
        function t() {
            $(".ui.stock-comparison.checkbox").checkbox({
                onChecked: function () {
                    var e = $(this);
                    l(e.data("symbol"), e.parent())
                },
                onUnchecked: function () {
                    var e = $(this);
                    r(e.data("symbol"))
                }
            })
        }
        function s() {
            k.addClass("active")
        }
        function o() {
            k.removeClass("active")
        }
        function i(e, a) {
            var s = e.symbol,
            o = C.find('.field input[data-symbol="' + s + '"]');
            if (0 == o.length) {
                var i = C.find(".inline.fields").append('<div class="field"><div class="ui stock-comparison checkbox"><input type="checkbox" data-symbol="' + s + '" class="hidden"><label>' + s + "</label></div></div>").find(".stock-comparison.checkbox").last();
                t()
            } else
                var i = o.closest(".stock-comparison.checkbox");
            i.checkbox("set checked"),
            l(s, i)
        }
        function l(e, a) {
            if ("undefined" != typeof p)
                if (s(), $.inArray(e, x) == -1)
                    x.push(e), $.getJSON(m + e, function (t) {
                        if (log("chartData", t), t.length) {
                            var s = {
                                title: e,
                                compared: !0,
                                fieldMappings: [{
                                        fromField: "value",
                                        toField: "value"
                                    }, {
                                        fromField: "volume",
                                        toField: "volume"
                                    }
                                ],
                                dataProvider: t,
                                categoryField: "date"
                            };
                            p.dataSets.push(s),
                            p.comparedDataSets.push(s),
                            p.validateData(),
                            o()
                        } else
                            deleteFromArray(x, e), setTimeout(function () {
                                a.checkbox("set unchecked"),
                                o()
                            }, 3e3)
                    });
                else {
                    for (var t = 0; t < p.dataSets.length; t++)
                        p.dataSets[t].title == e && (p.dataSets[t].compared = !0);
                    p.validateData(),
                    o()
                }
        }
        function r(e) {
            for (var a = 0; a < p.dataSets.length; a++)
                p.dataSets[a].title == e && (p.dataSets[a].compared = !1);
            p.validateData()
        }
        function d() {
            p = AmCharts.makeChart(S.attr("id"), q)
        }
        function c() {
            "undefined" != typeof p.dataSets[0].dataProvider && 0 != p.dataSets[0].dataProvider.length && p.dataSets[0].title == b || (s(), p.dataSets[0].title = b, $.getJSON(m + b, function (e) {
                    e.length && (log("chartData", e), p.dataSets[0].dataProvider = e, p.validateData(), C.show()),
                    o()
                }))
        }
        function n(e) {
            var a = "";
            return "undefined" != typeof e.results && e.results.length && $.each(e.results, function (e, t) {
                a += '<a class="result"><div class="content"><div class="price"><i class="' + t.exchange_country_code + ' flag"></i>' + t.exchange_code + '</div><div class="title">' + t.symbol + (parseInt(t.watched) ? ' <i class="yellow star icon"></i>' : "") + '</div><div class="description">' + t.name + "</div></div></a>"
            }),
            a
        }
        function u() {
            var e = String.format(v, encodeURIComponent('SELECT * FROM feed WHERE url="' + f + b + '"'));
            console.log(e);
            console.log(v);
            $.ajax({
                url: e,
                dataType: "json",
                async: !0,
                cache: !1,
                success: h,
                error: handleAjaxError
            })
        }
        function h(e) {
            log("displaySymbolNews", e);
            var a = "";
            y.empty(),
            "undefined" != typeof e.query && "undefined" != typeof e.query.count && e.query.count > 0 && e.query.results.item.length > 0 ? ($.each(e.query.results.item, function (e, t) {
                    a += '<div class="item"><div class="content"><div class="meta">' + moment(t.pubDate.replace("GMT", "+0000"), NEWS_DATE_TIME_FORMAT).tz(USER_TIMEZONE).format(DATE_TIME_FORMAT) + '</div><h3 class="header">' + t.title + '</h3><div class="description"><p>' + (null != t.description && t.description.length > 10 ? t.description : "") + '</p> <a href="' + t.link + '" target="_blank">{{ @trade.news.read.more }}</a></div></div></div>'
                }), y.append(a)) : y.append("<h4>{{ @trade.news.empty }}</h4>")
        }
        $("#stock-tabs-menu .item").tab({
            onLoad: function (e) {},
            onVisible: function () {
                $(".ui.sticky").sticky("refresh")
            }
        });
        $(".add-to-watchlist").on("click", function () {
            var e = $(this);
            if (!e.hasClass("disabled")) {
                var a = e.hasClass("watching") ? "remove" : "add";
                e.addClass("disabled loading"),
                $.ajax({
                    url: "{{ @BASE }}/api/actions/watchlist/" + a + "/" + b,
                    dataType: "json",
                    async: !0,
                    cache: !1,
                    success: function (t) {
                        t && t.success ? "add" == a ? (e.removeClass("basic loading disabled").addClass("watching"), e.html('<i class="star icon"></i> {{ @trade.symbol.watching }}')) : "remove" == a && (e.removeClass("loading disabled watching").addClass("basic"), e.html('<i class="star icon"></i> {{ @trade.symbol.watch }}')) : e.removeClass("loading disabled")
                    },
                    error: handleAjaxError
                })
            }
        });
        $(".stock-op.dropdown").dropdown({transition: 'drop', action: 'select'});
        var q = {
            type: "stock",
            categoryAxesSettings: {
                minPeriod: "DD",
                color: T,
                gridColor: E,
                gridAlpha: .1,
                gridThickness: 1,
                equalSpacing: !0
            },
            dataSets: [{
                    title: b,
                    fieldMappings: [{
                            fromField: "value",
                            toField: "value"
                        }, {
                            fromField: "volume",
                            toField: "volume"
                        }
                    ],
                    categoryField: "date"
                }
            ],
            panelsSettings: {
                usePrefixes: !0,
                creditsPosition: "bottom-left"
            },
            panels: [{
                    showCategoryAxis: !0,
                    title: "{{ @trade.chart.title.price }}",
                    percentHeight: 70,
                    precision: 2,
                    drawingIconsEnabled: !0,
                    eraseAll: !0,
                    stockGraphs: [{
                            id: "g1",
                            type: "smoothedLine",
                            valueField: "value",
                            lineColor: E,
                            fillAlphas: 0,
                            lineThickness: 2,
                            comparable: !0,
                            compareField: "value",
                            balloonText: "[[title]]: <b>[[value]]</b>",
                            compareGraphBalloonText: "[[title]]: <b>[[value]]</b>",
                            useDataSetColors: !1
                        }
                    ],
                    stockLegend: {
                        periodValueTextComparing: "[[percents.value.close]]%",
                        periodValueTextRegular: "[[value.close]]",
                        color: T
                    },
                    valueAxes: [{
                            position: "right",
                            color: T,
                            gridColor: E,
                            gridAlpha: .1,
                            gridThickness: 1
                        }
                    ]
                }, {
                    title: "{{ @trade.chart.title.volume }}",
                    percentHeight: 30,
                    precision: 0,
                    stockGraphs: [{
                            valueField: "volume",
                            type: "column",
                            showBalloon: !1,
                            lineColor: E,
                            fillAlphas: .3,
                            useDataSetColors: !1
                        }
                    ],
                    stockLegend: {
                        periodValueTextRegular: "[[value.close]]"
                    },
                    valueAxes: [{
                            position: "right"
                        }
                    ]
                }
            ],
            chartScrollbarSettings: {
                graph: "g1"
            },
            chartCursorSettings: {
                valueBalloonsEnabled: !0,
                graphBulletSize: 1,
                valueLineBalloonEnabled: !0,
                valueLineEnabled: !0,
                valueLineAlpha: 1,
                categoryBalloonColor: E,
                categoryBalloonAlpha: .8,
                cursorColor: E,
                cursorAlpha: .8
            },
            periodSelector: {
                position: "top",
                periodsText: "",
                inputFieldsEnabled: !1,
                periods: [{
                        period: "MM",
                        count: 1,
                        label: "{{ @trade.chart.periods[0] }}",
                        selected: !0
                    }, {
                        period: "MM",
                        count: 3,
                        label: "{{ @trade.chart.periods[1] }}",
                        selected: !0
                    }, {
                        period: "MM",
                        count: 6,
                        label: "{{ @trade.chart.periods[2] }}",
                        selected: !0
                    }, {
                        period: "YTD",
                        label: "{{ @trade.chart.periods[3] }}"
                    }, {
                        period: "YYYY",
                        count: 1,
                        label: "{{ @trade.chart.periods[4] }}"
                    }, {
                        period: "YYYY",
                        count: 3,
                        label: "{{ @trade.chart.periods[5] }}"
                    }, {
                        period: "MAX",
                        label: "{{ @trade.chart.periods[6] }}"
                    }
                ]
            },
            dataSetSelector: {
                position: ""
            },
            comparedDataSets: [],
            "export": {
                enabled: !0
            }
        };
        getLiveQuotes(),
        u(),
        t(),
        d(),
        c(),
        $("#symbol-search").search(F),
        $("#symbol-comparison-search").search(_),
        A.form({
            on: "blur",
            fields: {
                quantity: {
                    rules: [{
                            type: "empty",
                            prompt: "{{ @trade.form.quantity.error }}"
                        }, {
                            type: "integer",
                            prompt: "{{ @trade.form.quantity.error }}"
                        }
                    ]
                }
            }
        }),
        setTimeout(function () {
            $(".ui.basic.modal").modal("show")
        }, 3e3),
        $("button.trade").on("click", function () {
            var e = $(this);
            if (!e.hasClass("disabled") && A.form("is valid")) {
                var a = $("button.trade");
                a.addClass("loading disabled");
                var t = e.data("action"),
                s = parseInt($("#trade-quantity").val()),
                o = $("#user-search").data("user");
                $.ajax({
                    url: "{{ @BASE }}/api/actions/trade",
                    method: "POST",
                    data: {
                        symbol: b,
                        quantity: s,
                        action: t,
                        user: o
                    },
                    dataType: "json",
                    async: !0,
                    cache: !1,
                    success: function (e) {
                        log("trade", e);
                        var t = $("#trade-result-message");
                        t.find("p").text(e.message),
                        e && e.success ? (o || $("#user-balance").text(e.balance.formatNumber() + " {{ @USER.currency }}").transition("flash"), t.find(".header").text("{{ @trade.form.trade.success.title }}"), t.removeClass("error").addClass("success")) : (t.find(".header").text("{{ @trade.form.trade.failure }}"), t.removeClass("success").addClass("error")),
                        a.removeClass("loading"),
                        t.transition("fade down"),
                        setTimeout(function () {
                            a.removeClass("disabled"),
                            t.transition("fade up")
                        }, 6e3)
                    },
                    error: handleAjaxError
                })
            }
        }),
        $("div.stock-edit").on("click", function () {
            var a = $(this),
            t = $("#modal-stock-edit"),
            y = t.find(".market-name.dropdown"),
            i = t.find("input[name='id']"),
            b = t.find("input[name='symbol']"),
            c = t.find("input[name='name']"),
            e = t.find("input[name='currency']"),
            f = t.find("input[name='nominal']"),
            s = $('#symbol-search input');
            y.dropdown(),
            $.ajax({
                url: "{{ @BASE }}/api/data/market/all",
                method: "GET",
                dataType: "json",
                async: !0,
                cache: !1,
                success: function (d) {
                    var w = [];
                    $.each(d.results, function (k, v) {
                        var x = new Object();
                        x.value = v.id;
                        x.name = '<i class="'+v.country_code+' flag"></i>' + v.code + ' - ' + v.name;
                        w.push(x);
                    });
                    y.dropdown({'values': w,});
                    $.ajax({
                        url: "{{ @BASE }}/api/data/asset/info/"+s.val(),
                        method: "GET",
                        dataType: "json",
                        async: !0,
                        cache: !1,
                        success: function (d) {
                            y.dropdown('set selected', d.results.market_id);
                            i.val(d.results.id);
                            b.val(d.results.symbol);
                            c.val(d.results.name);
                            e.val(d.results.currency);
                            f.val(d.results.nominal);
                        },
                        error: handleAjaxError
                    });
                },
                error: handleAjaxError
            });
            t.modal({'transition':'fly up'}).modal("show")
        }),
        $("div.stock-add").on("click", function () {
            var a = $(this),
            t = $("#modal-stock-add"),
            y = t.find(".market-name.dropdown");
            t.modal({'transition':'fly up'}).modal("show"),
            y.dropdown(),
            $.ajax({
                url: "{{ @BASE }}/api/data/market/all",
                method: "GET",
                dataType: "json",
                async: !0,
                cache: !1,
                success: function (d) {
                    var w = [];
                    $.each(d.results, function (k, v) {
                        var x = new Object();
                        x.value = v.id;
                        x.name = '<i class="'+v.country_code+' flag"></i>' + v.code + ' - ' + v.name;
                        w.push(x);
                    });
                    y.dropdown({'values': w,});
                },
                error: handleAjaxError
            });
        }),
        $("div.stock-delete").on("click", function () {
            var t = $("#modal-stock-delete"),
            s = $('#symbol-search input'),
            b = t.find("input[name='symbol']");
            b.val(s.val());
            t.modal({'transition':'fly up'}).modal("show");
        }),
        $("#modal-stock-add").form().on("submit", function (a) {
            a.preventDefault();
            var e = $(this);
            if (!e.hasClass("submitting")) {
                e.addClass("submitting");
                var r = e.find(".ui.result.message"),
                i = {};
                r.hide(),
                e.find(".submit.button").addClass("disabled loading"),
                e.find("input").each(function (k, v) {
                    if(v.name){
                        var r = e.form("get value", v.name);
                        i[v.name] = "boolean" != typeof r || r ? r : ""
                    }
                });
                $.ajax({
                    url: "{{ @BASE }}/api/actions/asset/add",
                    method: "POST",
                    data: i,
                    dataType: "json",
                    async: !0,
                    cache: !1,
                    success: function (a) {
                        a && a.success ? r.text(a.message).removeClass("negative").addClass("positive").show() : r.text(a.message).removeClass("positive").addClass("negative").show(),
                        $(".submit.button").removeClass("disabled loading"),
                        setTimeout(function () {
                            r.hide("slow"),
                            e.hide()
                        }, 3e3),
                        e.removeClass("submitting"),
                        z()
                    },
                    error: handleAjaxError
                })
            }
        });
        $("#modal-stock-edit").form().on("submit", function (a) {
            a.preventDefault();
            var e = $(this);
            if (!e.hasClass("submitting")) {
                e.addClass("submitting");
                var r = e.find(".ui.result.message"),
                i = {};
                r.hide(),
                e.find(".submit.button").addClass("disabled loading"),
                e.find("input").each(function (k, v) {
                    if(v.name){
                        var r = e.form("get value", v.name);
                        i[v.name] = "boolean" != typeof r || r ? r : ""
                    }
                });
                $.ajax({
                    url: "{{ @BASE }}/api/actions/asset/update",
                    method: "POST",
                    data: i,
                    dataType: "json",
                    async: !0,
                    cache: !1,
                    success: function (a) {
                        a && a.success ? r.text(a.message).removeClass("negative").addClass("positive").show() : r.text(a.message).removeClass("positive").addClass("negative").show(),
                        $(".submit.button").removeClass("disabled loading"),
                        setTimeout(function () {
                            r.hide("slow"),
                            e.hide()
                        }, 3e3),
                        e.removeClass("submitting"),
                        z()
                    },
                    error: handleAjaxError
                })
            }
        });
        $("#modal-stock-delete").form().on("submit", function (a) {
            a.preventDefault();
            var e = $(this);
            if (!e.hasClass("submitting")) {
                e.addClass("submitting");
                var r = e.find(".ui.result.message"),
                i = {};
                r.hide(),
                e.find(".submit.button").addClass("disabled loading"),
                e.find("input").each(function (k, v) {
                    if(v.name){
                        var r = e.form("get value", v.name);
                        i[v.name] = "boolean" != typeof r || r ? r : ""
                    }
                });
                $.ajax({
                    url: "{{ @BASE }}/api/actions/asset/delete",
                    method: "POST",
                    data: i,
                    dataType: "json",
                    async: !0,
                    cache: !1,
                    success: function (a) {
                        a && a.success ? r.text(a.message).removeClass("negative").addClass("positive").show() : r.text(a.message).removeClass("positive").addClass("negative").show(),
                        $(".submit.button").removeClass("disabled loading"),
                        setTimeout(function () {
                            r.hide("slow"),
                            e.hide()
                        }, 3e3),
                        e.removeClass("submitting"),
                        z()
                    },
                    error: handleAjaxError
                })
            }
        });
        $("button.limit-order").on("click", function () {
            var a = $(this),
            t = $("#modal-limit-order"),
            y = t.find(".ui.dropdown"),
            z = t.find(".limit-type"),
            u = {
                0: () => {
                    t.find('.limit-amount, .limit-price, .total').show().find('input').val(''),
                    t.find('.market-price, .market-amount, .stop-price').hide()
                },
                1: () => {
                    t.find('.market-amount').val('').show().find('input').val(''),
                    t.find('.limit-amount, .limit-price, .total, .stop-price, .market-price').hide()
                },
                2: () => {
                    t.find('.limit-amount, .stop-price, .total').val('').show().find('input').val(''),
                    t.find('.limit-price, .market-price, .market-amount').hide()
                },
                3: () => {
                    t.find('.limit-amount, .limit-price, .total, .stop-price').show().find('input').val(''),
                    t.find('.market-amount, .market-price').hide()
                }
            };
            u[0](),
            t.modal({'transition':'fly up'}).modal("show"),
            t.find('input[name="user_id"]').val(a.data("user-id")),
            y.dropdown(),
            z.dropdown({ onChange: (v, t, $i) => u[v]() });
            b = t.find('input[name="stop_price"]'),
            d = t.find('input[name="limit_price"]'),
            f = t.find('input[name="limit_amount"]'),
            i = t.find('input[name="market_amount"]'),
            j = t.find(".limit-type").find("input"),
            k = t.find(".info-panel .current-price").text().trim(),
            v = t.find(".total").find("input");
            $([f.get(),b.get(),d.get(),i.get()].flat()).on('change keyup input', function() {
                j.val() == 0 ? v.val(floatVal(floatVal(d.val() || 0) * floatVal(f.val() || 0)).formatNumber()) :
                j.val() == 1 ? v.val(floatVal(floatVal(k.val() || 0) * floatVal(i.val() || 0)).formatNumber()) :
                j.val() == 2 ? v.val(floatVal(floatVal(b.val() || 0) * floatVal(f.val() || 0)).formatNumber()) :
                j.val() == 3 ? v.val(floatVal(floatVal(k.val() || 0) * floatVal(i.val() || 0)).formatNumber()) : null
                
            })
        }),
        $(".limit-order-form").form().on("submit", function (a) {
            a.preventDefault();
            var e = $(this),
            c = e.data('action'),
            o = $("#user-search").data("user"),
            d = floatVal(e.find(".info-panel .current-price").text().trim()),
            b = e.find(".info-panel .symbol").text().trim(),
            i = e.find(".market-amount").find("input")
            if (e.form("is valid") && !e.hasClass("submitting")) {
                e.addClass("submitting");
                var r = e.find(".ui.result.message"),
                i = {};
                r.hide(),
                e.find(".submit.button").addClass("disabled loading"),
                e.find("input").each(function (a, t) {
                    if(t && t.name){
                        var r = e.form("get value", t.name);
                        i[t.name] = "boolean" != typeof r || r ? r : ""
                    }
                }),
                i['current_price'] = d,
                i['symbol'] = b,
                i['user'] = o || "{{ @USER.id }}",
                $.ajax({
                    url: "{{ @BASE }}/api/actions/signal/" + c,
                    method: "POST",
                    data: i,
                    dataType: "json",
                    async: !0,
                    cache: !1,
                    success: function (a) {
                        a && a.success ? r.text(a.message).removeClass("negative").addClass("positive").show() : r.text(a.message).removeClass("positive").addClass("negative").show(),
                        $(".submit.button").removeClass("disabled loading"),
                        setTimeout(function () {
                            r.hide("slow"),
                            e.hide()
                        }, 3e3),
                        e.removeClass("submitting")
                    },
                    error: handleAjaxError
                })
            }
        });
});
</script>