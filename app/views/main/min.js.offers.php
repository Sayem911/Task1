<script type = "text/javascript"> 
$(document).ready(function () {
        moment.locale();
        var i,
        o,
        d = $("#balance-history-chart"),
        l = $("#positions-list"),
        n = $("#trades-list"),
        q = $("#anleihen-list"),
        fl = $("#funds-list"),
        dl = $("#fixed-deposit-list"),
        s = parseInt("{{ @OFFERS.BONDS_PER_PAGE }}", 10),
        c = parseInt("{{ @OFFERS.FUNDS_PER_PAGE }}", 11),
        u = "{{ @USER.currency }}",
        m = $("body").css("backgroundColor"),
        f = $("#main-menu").css("backgroundColor"),
        b = "#000";
        "rgb(0, 0, 0)" == m && (f = "#fff", b = "#fff");
        var g = {
            rules: [{
                    type: "number",
                    prompt: "{{ @portfolio.price.edit.validation }}"
                }
            ]
        };
        var j = {
            rules: [{
                    type: "number",
                    prompt: "{{ @portfolio.quantity.edit.validation }}"
                }
            ]
        };
        var v = {
            rules: [{
                    type: "number",
                    prompt: "{{ @portfolio.rate.edit.validation }}"
                }
            ]
        };
        var w = {
            rules: [{
                    type: "number",
                    prompt: "{{ @portfolio.total.edit.validation }}"
                }
            ]
        };
        function a() {
            var b = $("#tab-positions").find(".ui.user.search"),
            t = b.data("user"),
            r = b.data("balance") ? floatVal(b.data("balance")) : floatVal("{{ @USER.is_admin ? '0' : @USER.balance }}");
            console.log(t);
            $("#total-cash").text(r.formatNumber()).data("value", r),
            $.ajax({
                url: "{{ @BASE }}/api/data/positions" + (t ? "/" + t : ""),
                method: "GET",
                dataType: "json",
                async: !0,
                cache: !1,
                success: function (a) {
                    if (l.destroyDataTable(), l.find("tbody").empty(), a && a.length) {
                        var t;
                        $.each(a, function (a, e) {
                            console.log(e.currency, u)
                            t += 
                '<tr>'+
                '<td><div class="ui labeled button" tabindex="0"><a class="ui right pointing {{ @SITE.MAIN_COLOR}} basic label">' + e.symbol + '</a></div></td>'+
                '<td class="left aligned" data-order="' + e.name + '">' + e.name + '</td>'+
                '<td class="center aligned" data-order="' + e.quantity + '">' + e.quantity.formatNumber(0) + '</td>'+
                '<td class="center aligned live-data" data-symbol="' + e.symbol + '" data-field="regularMarketPrice" data-format="fmtDecimal"><i class="euro sign icon"></i></td>'+
                '<td class="center aligned">' + (e.currency == 'EUR' ? '<i class="euro icon"></i>' : '<i class="dollar icon"></i>') + ' <i class="arrow alternate circle right outline icon"></i></td>' + (
                e.currency != u 
                ? '<td class="center aligned currency-' + e.currency + u + ' live-data" data-symbol="' + e.currency + u + '=X" data-field="regularMarketPrice" data-format="fmtLongDecimal"></td>' 
                : '<td class="center aligned">' + 1..formatNumber(4) + "</td>") + 
                '<td class="center aligned historical-cost" data-order="' + e.total + '">' + e.total.formatNumber() + '</td>'+
                '<td class="center aligned live-data market-value" data-symbol="' + e.symbol + '" data-field="regularMarketPrice" data-format="fmtMarketValue" data-format-args="' + ["regularMarketPrice", e.quantity, e.currency, u, e.nominal].join(",") + '"><i class="euro sign icon"></i></td>'+
                '<td class="center aligned live-data unrealized-pnl" data-symbol="' + e.symbol + '" data-field="regularMarketPrice" data-format="fmtUnrealizedPnL" data-format-args="' + ["regularMarketPrice", e.quantity, e.currency, u, e.total, e.nominal, "abs"].join(",") + '"></td>' +
                '<td class="center aligned live-data unrealized-pnl-pct" data-symbol="' + e.symbol + '" data-field="regularMarketPrice" data-format="fmtUnrealizedPnL" data-format-args="' + ["regularMarketPrice", e.quantity, e.currency, u, e.total, e.nominal, "pct"].join(",") + '"></td>' +
                '</tr>'
                        }),
                        l.find("tbody").append(t),
                        getLiveQuotes(function () {
                            l.initDataTable(c, [[8, "desc"]], !0, e, []);
                        })
                    } else {
                        l.initDataTable(c, [[8, "desc"]], !0, e, []);
                    }
                },
                error: handleAjaxError
            })
        }
        function t() {
            var u = $("#tab-trades").find(".ui.user.search"),
            a = u.data("user");
            $.ajax({
                url: "{{ @BASE }}/api/data/trades" + (a ? "/" + a : ""),
                method: "GET",
                dataType: "json",
                async: !0,
                cache: !1,
                success: function (a) {
                    if (n.destroyDataTable(), n.find("tbody").empty(), a && a.length) {
                        var t = "";
                        $.each(a, function (a, e) {
                            t += 
                            '<tr class="' + (e.direction > 0 ? "positive" : "negative") + '">'+
                            '<td><div class="ui labeled button" tabindex="0"><a class="ui right pointing {{ @SITE.MAIN_COLOR}} basic label">' + e.symbol + '</a></div></td>'+
                            "<td>" + e.name + '<div class="trade-exchange"><i class="' + e.exchange_country_code + ' flag"></i>' + e.exchange_name + "</div></td>"+
                            "<td>" + (e.direction > 0 ? "{{ @portfolio.trades.buy.trades }}" : "{{ @portfolio.trades.sell }}") + '</td>'+
                            '<td class="center aligned" data-order="' + e.quantity + '">' + e.quantity.formatNumber(0) + '</td>'+
                            '<td class="center aligned" data-order="' + e.price + '">' + e.price.formatNumber() + '</td>'+
                            '<td class="center aligned" data-order="' + e.fx_rate + '">' + (null == e.fx_rate ? '': e.fx_rate) + '</td>'+
                            '<td class="center aligned" data-order="' + e.total + '">' + e.total.formatNumber() + '</td>'+
                            '<td class="center aligned" data-order="' + e.start_date + '">' + moment(e.start_date).format('DD.MM.YYYY') + '</td>'+
                            '<td class="center aligned" data-order="' + e.end_date + '">' + moment(e.end_date).format('DD.MM.YYYY') + '</td>'+
                            '<td class="center aligned" data-order="' + e.duration + '">' + (null == e.duration ? '' : e.duration) + '</td>'+
                            '<check if="{{ @USER.is_admin }}">'+
                                '<td class="users-actions">'+
                                '<div class="button-container">'+
                                    '<button class="ui basic circular icon edit-portfolio-button button" '+
                                            'data-trade-id="' + e.id.replace("id", "") + '" '+
                                            'data-user-id="' + e.user_id + '" '+
                                            'data-quantity="' + e.quantity + '" '+
                                            'data-price="' + e.price + '" '+
                                            'data-currency="' + e.currency + '" '+
                                            'data-rate="' + e.fx_rate + '" '+
                                            'data-total="' + e.total + '" '+
                                            'data-start="' + e.start_date + '" '+
                                            'data-end="' + e.end_date + '" '+
                                            'data-duration="' + e.duration + '">'+
                                        '<i class="pencil icon"></i>'+
                                    '</button>'+
                                '</div>'+
                                '<div class="button-container">'+
                                    '<button class="ui basic circular icon delete-portfolio button" data-id="'+e.id.replace("id", "")+'"><i class="trash icon"></i></button>'+
                                '</div>'+
                            '</td>'+
                            '</check>'+'</tr>'
                        }),
                        n.find("tbody").append(t)
                    }
                    n.initDataTable(s, [[0, "desc"]], !0, null, [])
                },
                error: handleAjaxError
            })
        }
        function anleihenz() {
            var u = $("#tab-anleihen").find(".ui.user.search"),
            a = u.data("user");
            $.ajax({
                url: "{{ @BASE }}/api/data/offersanleihen" + (a ? "/" + a : ""),
                method: "GET",
                dataType: "json",
                async: !0,
                cache: !1,
                success: function (a) {
                    if (q.destroyDataTable(), q.find("tbody").empty(), a && a.length) {
                        var t, d, fa, rowNum=1;
                        $.each(a, function (a, e) {
                            // last column
                            if(e.interest_date){
                                var c = "<h3 class='ui dividing header centered'>{{ @offers.anleihen.interest_date }}</h3><div class='content'>", 
                                    j = e.interest_date;
                                if(j){
                                    var o = JSON.parse(j);
                                    $.each(o, function(i,v){
                                        c += "<div><span class='ui {{ @SITE.MAIN_COLOR}} tiny circular label'>" + (i+1) + "</span> &nbsp;&nbsp; " + moment(v.date).format('DD.MM.YYYY') + "&nbsp;&nbsp;&nbsp;&nbsp;" + floatVal(v.price).formatNumber(2) + " {{ @USER.currency}} </div><div class='ui divider'></div>";
                                    });
                                }
                                c += "</div>";
                                d = '<button title="{{ @offers.anleihen.interest_tooltip }}" class="interest-date ui icon {{ @SITE.MAIN_COLOR}} button" data-html="'+c+'"><i class="table icon"></i></button>';
                            } else {
                                d = '<button class="ui icon {{ @SITE.MAIN_COLOR}} button button disabled"><i class="table icon"></i></button>';
                            }
                            if(e.notes && e.notes != ''){
                                var w = e.notes.toString().replace("\n", "<br />");
                                fa = '<button title="{{ @offers.anleihen.notes_tooltip }}" class="anleihen-notes ui icon {{ @SITE.MAIN_COLOR}} button" data-notes="' + w + '"><i class="info icon"></i></button>';
                            } else {
                                fa = '<div class="six wide column"></div>'
                            }
                            
                            rowNum++;
                            t += 
                            "<tr class='positive'>"+
                            "<td class='center aligned' data-order='" + e.rowno + "'>" + e.rowno + "</td>"+
                            "<td class='left aligned'>" + e.category + "</td>"+
                            /*
                            "<td>"+
                            "<div class='row'>" + e.category + "</div>"+
                            "<div class='row'>"+
                            "<br><div class='ui labeled button' tabindex='0'><div class='ui basic {{ @SITE.MAIN_COLOR}} button'>BANK</div><a class='ui basic left pointing blue label'>" + e.symbol + "</a></div><br><br>"+
                            "<div class='row trade-exchange'><i class='" + e.exchange_country_code + " flag'></i>" + e.exchange_name + "</div>"+
                            "</td>" + 
                            */
                            "<td class='center aligned' data-order='" + e.ISIN + "'>" + e.ISIN + "</td>"+
                            "<td class='center aligned' data-order='" + e.issuer + "'>" + e.issuer + "</td>"+
                            "<td class='center aligned' data-order='" + e.coupon + "'>" + e.coupon.formatNumber(2) + "</td>"+
                            "<td class='center aligned' data-order='" + moment(e.maturity).format('YYYY.MM.DD') + "'>" + moment(e.maturity).format('DD.MM.YYYY') + "</td>"+
                            "<td class='center aligned' data-order='" + e.rating + "'>" + e.rating + "</td>"+
                            "<td class='center aligned' data-order='" + e.currency + "'>" + e.currency + "</td>"+
                            "<td class='center aligned' data-order='" + e.denomination + "'>" + e.denomination.formatNumber(2) + "</td>"+
                            "<td class='center aligned' data-order='" + e.minamount + "'>" + e.minamount.formatNumber(2) + "</td>"+
                            /*"<td class='center aligned' ><div class='ui centered grid'>" + d + fa + "</div></td>"+*/
                            "<check if='{{ @USER.is_admin }}'>"+
                            "<td class='center aligned bonds-actions'>"+
                                "<div class='button-container'>"+
                                    "<button class='ui basic circular icon edit-anleihen-button button' "+
                                        "data-symbol='" + e.symbol + "' " +
                                        "data-anleihen-id='" + e.id.replace("id", "") + "' " + 
                                        "data-user-id='" + e.user_id + "' " +
                                        "data-quantity='" + e.quantity + "' " +
                                        "data-price='" + e.price + "' " +
                                        "data-currency='" + e.currency + "' "+
                                        "data-fx-rate='" + e.fx_rate + "' " +
                                        "data-current-fx='" + e.current_fx + "' "+
                                        "data-current-price='" + e.current_price + "' "+
                                        "data-total='" + e.total + "' "+
                                        "data-start-date='" + e.start_date + "' "+
                                        "data-end-date='" + e.end_date + "' "+
                                        "data-interest-date='" + e.interest_date + "' "+
                                        "data-notes='" + e.notes + "'>"+
                                        "<i class='pencil icon'></i>"+
                                    "</button>"+
                                "</div>"+
                                "<div class='button-container'>"+
                                    "<button class='ui basic circular icon delete-anleihen button' data-id='"+e.id.replace('id', '') + "'><i class='trash icon'></i></button>"+
                                "</div>"+
                            "</td>"+
                            "</check>"+
                            "</tr>";
                        }),
                        q.find("tbody").append(t)
                    }
                    q.initDataTable(s, [[0, "asc"]], !0, null,[]),
                    $('.interest-date').popup({on: 'click'});
                    
                },
                error: handleAjaxError
            })
        }
        function fundsff() {
            var u = $("#tab-funds").find(".ui.user.search"),
            a = u.data("user");
            $.ajax({
                url: "{{ @BASE }}/api/data/offersfunds" + (a ? "/" + a : ""),
                method: "GET",
                dataType: "json",
                async: !0,
                cache: !1,
                success: function (a) {
                    if (fl.destroyDataTable(), fl.find("tbody").empty(), a && a.length) {
                        var t, d, fa;
                        $.each(a, function (a, e) {
                            if(e.interest_date){
                                var c = "<h3 class='ui dividing header centered'>{{ @portfolio.funds.interest_date }}</h3><div class='content'>", 
                                    j = e.interest_date;
                                if(j){
                                    var o = JSON.parse(j);
                                    $.each(o, function(i, v){
                                        c += "<div><span class='ui {{ @SITE.MAIN_COLOR }} tiny circular label'>" + (i+1) + "</span> &nbsp;&nbsp; " + moment(v.date).format('DD.MM.YYYY') + "&nbsp;&nbsp;&nbsp;&nbsp;" + floatVal(v.price).formatNumber(2) + " {{ @USER.currency}}" + "</div><div class='ui divider'></div>";
                                    });
                                }
                                c += "</div>";
                                d = "<button title='{{ @portfolio.funds.interest_tooltip }}' class='interest-date ui icon {{ @SITE.MAIN_COLOR}} button' data-html=\"" + c + "\"><i class='table icon'></i></button>";
                            } else {
                                d = "<button class='ui icon {{ @SITE.MAIN_COLOR}} button disabled'><i class='table icon'></i></button>";
                            }
                            if(e.notes && e.notes != ''){
                                var w = e.notes.toString().replace('\n', '<br />');
                                fa = "<button title='{{ @portfolio.funds.notes_tooltip }}' class='funds-notes ui icon {{ @SITE.MAIN_COLOR}} button' data-notes='" + w + "'><i class='info icon'></i></button>";
                            } else {
                                fa = "<div class='six wide column'></div>";
                            }
                            t += 
                            "<tr class='positive'>"+
                            "<td><div class='row'>" + e.name + '</div><br><div class="ui labeled button" tabindex="0"><div class="ui basic {{ @SITE.MAIN_COLOR}} button">BANK</div><a class="ui basic left pointing blue label">' + e.symbol + '</a></div><br><br><div class="row trade-exchange"><i class="' + e.exchange_country_code + ' flag"></i>' + e.exchange_name + "</div></td>" +
                            "<td class='center aligned' data-order='" + e.quantity + "'>" + e.quantity.formatNumber(2) + " </td>" + 
                            "<td class='center aligned' data-order='" + e.price + "'>" + e.price.formatNumber(2) + "</td>" + 
                            "<td class='center aligned' data-order='" + e.issue_price + "' data-issue-price='"+e.issue_price+"'>" + moment(e.issue_price).format('DD.MM.YYYY') + " </td>" + 
                            "<td class='center aligned' data-order='" + e.current_price + "' data-current-price='"+e.current_price+"'>" + moment(e.current_price).format('DD.MM.YYYY') + " </td>" + 
                            "<td class='center aligned' data-order='" + e.total_price + "'>" + e.total_price.formatNumber() + " </td>" + 
                            "<td class='center aligned' ><div class='ui centered grid'>" + d + fa + "</div></td>"+
                            "<check if='{{ @USER.is_admin }}'>" + 
                            "<td class='funds-actions center aligned'>" + 
                            "<div class='button-container'>"+
                            "<button class='ui basic circular icon edit-fund button' " + 
                                "data-symbol='" + e.symbol + "' " +
                                "data-fund-id='" + e.id.replace("id", "") + "' " +
                                "data-user-id='" + e.user_id + "' " +
                                "data-quantity='" + e.quantity + "' " +
                                "data-price='" + e.price + "' " +
                                "data-issue-price='" + e.issue_price + "' " +
                                "data-current-price='" + e.current_price + "' " +
                                "data-total-price='" + e.total_price + "' " +
                                "data-value='" + e.value + "' " +
                                "data-interest-date='" + e.interest_date + "' "+
                                "data-notes='" + e.notes + "'>" + 
                            "<i class='pencil icon'></i>" + 
                            "</button></div>" + 
                            "<div class='button-container'>"+
                                "<button class='ui basic circular icon delete-fund button' data-id='" + e.id.replace("id", "") + "'>" + 
                                    "<i class='trash icon'></i>" + 
                                "</button>"+
                            "</div>"+
                            "</td>"+
                            "</check>"+
                            "</tr>"
                        }),
                        fl.find("tbody").append(t)
                    }
                    fl.initDataTable(s, [[0, "desc"]], !0, null,[]),
                    $('.interest-date').popup({on: 'click'});
                },
                error: handleAjaxError
            })
        }
        function fd() {
            var u = $("#tab-fixed-deposit").find(".ui.user.search"),
            a = u.data("user");
            $.ajax({
                url: "{{ @BASE }}/api/data/deposits" + (a ? "/" + a : ""),
                method: "GET",
                dataType: "json",
                async: !0,
                cache: !1,
                success: function (a) {
                    if (dl.destroyDataTable(), dl.find("tbody").empty(), a && a.length) {
                        var t, d, fa;
                        $.each(a, function (a, e) {
                            t += 
                            "<tr class='positive'>"+
                            "<td><div class='row'>" + e.name + '</div><br><div class="ui labeled button" tabindex="0"><div class="ui basic {{ @SITE.MAIN_COLOR}} button">BANK</div><a class="ui basic left pointing blue label">' + e.symbol + '</a></div><br><br><div class="row trade-exchange"><i class="' + e.exchange_country_code + ' flag"></i>' + e.exchange_name + "</div></td>" +
                            "<td class='center aligned' data-order='" + e.amount + "'>" + e.amount.formatNumber(0) + "</td>" + 
                            "<td class='center aligned' data-order='" + e.interest_rate + "'>" + floatVal(e.interest_rate).formatNumber(2) + " </td>" + 
                            "<td class='center aligned' data-order='" + e.total + "'>" + floatVal(e.total).formatNumber(2) + " </td>" +  
                            "<td class='center aligned' data-order='" + e.building + "'>% " + floatVal(e.building).formatNumber(2) + " </td>" + 
                            "<td class='center aligned' data-order='" + e.totalvalue + "'>" + floatVal(e.totalvalue).formatNumber(2) + " </td>" + 
                            "<check if='{{ @USER.is_admin }}'>" + 
                            "<td class='fixed-deposit-actions center aligned'>" + 
                            "<div class='button-container'>"+
                            "<button "+
                            "class='ui basic circular icon edit-fixed-deposit button' " + 
                            "data-symbol='" + e.symbol + "' " +
                            "data-deposit-id='" + e.id.replace("id", "") +  "' " + 
                            "data-user-id='" + e.user_id +  "' " +
                            "data-amount='" + e.amount +  "' " +
                            "data-total='" + e.total +  "' " +
                            "data-interest-rate='" + e.interest_rate +  "' " +
                            "data-building='" + e.building +  "' " +
                            "data-totalvalue='" + e.totalvalue + "'>" + 
                            "<i class='pencil icon'></i>" + 
                            "</button>"+
                            "</div>" + 
                            "<div class='button-container'>"+
                                "<button class='ui basic circular icon delete-fixed-deposit button' data-id='" + e.id.replace("id", "") + "'>" + 
                                    "<i class='trash icon'></i>" + 
                                "</button>"+
                            "</div>"+
                            "</td>"+
                            "</check>"+
                            "</tr>"
                        }),
                        dl.find("tbody").append(t)
                    }
                    dl.initDataTable(s, [[0, "desc"]], !0, null, []);
                    $('.interest-date').popup({on: 'click'});
                },
                error: handleAjaxError
            })
        }
        
        function e(a, t, e, r, i) {
            var o = this.api(),
            d = {},
            l = {
                6: "#total-historical-cost",
                7: "#total-market-value",
                8: "#total-unrealized-pnl"
            };
            $.each(l, function (a, t) {
                var e = o.column(a).data().reduce(function (a, t) {
                        return floatVal(a) + floatVal(t)
                    }, 0);
                d[a] = e,
                $(t).text(e.formatNumber())
            }),
            $("#net-assets").text(($("#total-cash").data("value") + d[7]).formatNumber())
        }
        anleihenz() /*a()*/,
        refreshTradesList = function () {
            t()
        },
        refreshAnleihenList = function () {
            anleihenz()
        },
        refreshPositionsList = function () {
            a()
        },
        refreshFundsList = function () {
            fundsff()
        },
        refreshFixedDepositList = function () {
            fd()
        },
        n.on("click", ".edit-portfolio-button", function () {
            var a = $(this),
            t = $("#modal-edit-portfolio");
            t.modal("show"),
            t.find('input[name="trade_id"]').val(a.data("trade-id")),
            t.find('input[name="user_id"]').val(a.data("user-id")),
            t.find('input[name="total"]').val(a.data("total")),
            t.find('input[name="price"]').val(a.data("price")),
            t.find('input[name="quantity"]').val(a.data("quantity")),
            t.find('input[name="rate"]').val(a.data("rate")),
            t.find('input[name="start_date"]').val(moment(a.data("start")).format('YYYY-MM-DD')),
            t.find('input[name="end_date"]').val(moment(a.data("end")).format('YYYY-MM-DD')),
            t.find('input[name="duration"]').val(a.data("duration"))
        }),
        $("#modal-edit-portfolio").form({
            on: "blur",
            fields: {
                total: w
            }
        }).on("submit", function (a) {
            a.preventDefault();
            var e = $(this);
            if (e.form("is valid") && !e.hasClass("submitting")) {
                e.addClass("submitting");
                var r = e.find(".ui.result.message"),
                i = {};
                r.hide(),
                e.find(".submit.button").addClass("disabled loading"),
                e.find("input").each(function (a, t) {
                    var r = e.form("get value", t.name);
                    i[t.name] = "boolean" != typeof r || r ? r : ""
                }),
                $.ajax({
                    url: "{{ @BASE }}/api/actions/portfolio/update/all",
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
                            t.hide()
                        }, 3e3),
                        e.removeClass("submitting"),
                        t()
                    },
                    error: handleAjaxError
                })
            }
        });
        n.on("click", "button.delete-portfolio", function () {
            var e = $(this),
            a = $("#modal-delete-portfolio");
            a.modal("show"),
            a.find('input[name="id"]').val(e.data("id"))
        }),
        $("#modal-delete-portfolio").form().on("submit", function (a) {
            a.preventDefault();
            var e = $(this);
            if (e.form("is valid") && !e.hasClass("submitting")) {
                e.addClass("submitting");
                var r = e.find(".ui.result.message"),
                i = {};
                r.hide(),
                e.find(".submit.button").addClass("disabled loading"),
                e.find("input").each(function (a, t) {
                    if(t.name){
                        var r = e.form("get value", t.name);
                        i[t.name] = "boolean" != typeof r || r ? r : ""
                    }
                }),
                $.ajax({
                    url: "{{ @BASE }}/api/actions/portfolio/delete",
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
                            t.hide()
                        }, 3e3),
                        e.removeClass("submitting"),
                        t(),
                        a()
                    },
                    error: handleAjaxError
                })
            }
        });
        q.on("click", "button.anleihen-notes", function () {
            var a = $(this),
            m = $("#modal-anleihen-notes"),
            c = a.data("notes"),
            v = m.find("div.notes-area").html(c);
            m.modal("show");
        });       
        q.on("click", ".edit-anleihen-button", function () {
            var a = $(this),
            t = $("#modal-edit-anleihen"),
            s = a.data("interest-date");
            t.modal({
                onHidden: function(){
                    t.find('.add-interest').off('click');
                    t.find('.remove-interest').off('click');
                }
            }).modal("show"),
            t.find('input[name="anleihen_id"]').val(a.data("anleihen-id")),
            t.find('input[name="user_id"]').val(a.data("user-id")),
            t.find('input[name="trade_id"]').val(a.data("trade-id")),
            t.find('input[name="user_id"]').val(a.data("user-id")),
            t.find('input[name="quantity"]').val(a.data("quantity")),
            t.find('input[name="fx_rate"]').val(a.data("fx-rate")),
            t.find('input[name="price"]').val(a.data("price")),
            t.find('input[name="start_date"]').val(moment(a.data("start-date")).format('YYYY-MM-DD')),
            t.find('input[name="end_date"]').val(moment(a.data("end-date")).format('YYYY-MM-DD')),
            t.find('input[name="current_fx"]').val(a.data("current-fx")),
            t.find('input[name="total"]').val(a.data("total")),
            t.find('input[name="current_price"]').val(a.data("current-price")),
            t.find('textarea').val(a.data("notes")),
            t.find('.interest-container').find('.interest-line').not(':first').remove();
            if(s){
                var l = null, n = t.find('.interest-container');
                $.each(s, function(i,v){
                    l = n.find('.interest-line').last();
                    var f = l.find('input[name="interest_price"]'),
                        i = l.find('input[name="interest_date"]');
                    if(n.children().length < 5){
                        f.val(v.price);
                        i.val(moment(v.date).format('YYYY-MM-DD'));
                        l.clone(true).appendTo(n);
                    }
                });
                l.remove();
            }
            var i = t.find('input[name="interest_date"]'),
            f = t.find('input[name="interest_price"]'),
            c = t.find('input[name="notes"]'),
            j = t.find('input[name="quantity"]'),
            k = t.find('input[name="fx_rate"]'),
            m = t.find('input[name="price"]'),
            n = t.find('input[name="total"]'),
            p = t.find('input[name="current_fx"]'),
            r = t.find('input[name="current_price"]');
            $(k,j).focusout((e) => {
                var x = 0;
                f = t.find('input[name="interest_price"]');
                m.val(parseInt(j.val()) * floatVal(k.val()));
                n.val(floatVal(m.val()) * floatVal(p.val()));
                $.each(f, (z,v) => x += $(v).val() ? floatVal($(v).val()) : 0);
                r.val(floatVal(m.val()) + floatVal(x));            
            });
            $(p).focusout(() => {
                n.val(floatVal(m.val()) * floatVal(p.val()));
            });
            f.focusout((e)=>{
                var x = 0;
                f = t.find('input[name="interest_price"]');
                $.each(f, (z,v) => x += $(v).val() ? floatVal($(v).val()) : 0);
                r.val(floatVal(m.val()) + floatVal(x));
            });
            i.keypress(function(e){
                var v = this.value;
                e.which != 8 && isNaN(String.fromCharCode(e.which)) ? e.preventDefault() : null,
                this.value.length > 9 ? e.preventDefault() : null,
                v.match(/^\d{2}$/) !== null ? this.value = v + '.' : v.match(/^\d{2}\.\d{2}$/) !== null ? this.value = v + '.' : null
            });
            t.find('.add-interest').on('click', function(a){
                var n = t.find('.interest-container'),
                l = n.find('.interest-line').last();
                if(n.children().length<4){
                    l.clone(true).appendTo(n);
                    l = n.find('.interest-line').last();
                    l.find('input').val('');
                    l.find('input').first().focus();
                }
                console.log(n.children().length);
            });
            t.find('.remove-interest').on('click', function(a){
                var n = t.find('.interest-container'),
                l = n.find('.interest-line').last(),
                f = l.find('input[name="interest_price"]');
                r.val(floatVal(r.val()) - floatVal(f.val() ? f.val() : 0));
                if(n.children().length>1){
                    l.prev().find('input').first().focus();
                    l.remove();
                }else{
                    n.find('.interest-line').last().find('input').val('');
                }
                console.log(n.children().length);
            });
            y = t.find(".ui.dropdown");
            $.ajax({
                url: "{{ @BASE }}/api/data/anleihen/assets/all",
                method: "GET",
                dataType: "json",
                async: !0,
                cache: !1,
                success: function (d) {
                    var w = [];
                    $.each(d.results, function (k, v) {
                        var o = new Object();
                        o.value = v.symbol;
                        o.name = '<i class="'+v.country_code+' flag"></i>' + v.name;
                        w.push(o);
                    })
                    y.dropdown({
                        'values': w, 
                        'placeholder': '{{ @portfolio.anleihen.select }}'
                    });
                    y.dropdown('set selected', a.data("symbol"));

                },
                error: handleAjaxError
            });
            
        }),
        $("#modal-edit-anleihen").form({
            on: "blur"
        }).on("submit", function (a) {
            a.preventDefault();
            var e = $(this), c = [];
            e.find('.interest-container').children().each(function(i,v){
                d = $(v).find('input[name="interest_date"]'),
                p = $(v).find('input[name="interest_price"]');
                if(''!= d.val() && '' != p.val()){
                    o = new Object();
                    o.date = d.val();
                    o.price = p.val();
                    c.push(o);
                }
            });
            if (e.form("is valid") && !e.hasClass("submitting")) {
                e.addClass("submitting");
                var r = e.find(".ui.result.message"),
                i = {};
                r.hide(),
                e.find(".submit.button").addClass("disabled loading"),
                e.find("input").each(function (a, t) {
                    if(t.name){
                        var r = e.form("get value", t.name);
                        i[t.name] = "boolean" != typeof r || r ? r : ""
                    }
                });
                i['interest_date'] = c.length > 0 ? JSON.stringify(c) : null;
                i['notes'] = e.find("textarea").val();
                $.ajax({
                    url: "{{ @BASE }}/api/actions/anleihen/edit",
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
                        anleihenz()
                    },
                    error: handleAjaxError
                })
            }
        });
        $("#add-anleihen").on('click', function(){
            var x = $("#modal-add-anleihen"),
            y = x.find('.ui.dropdown'),
            u = $("#tab-anleihen").find(".ui.user.search").data("user"),
            i = x.find('input[name="interest_date"]'),
            f = x.find('input[name="interest_price"]'),
            j = x.find('input[name="quantity"]'),
            k = x.find('input[name="fx_rate"]'),
            m = x.find('input[name="price"]'),
            n = x.find('input[name="total"]'),
            p = x.find('input[name="current_fx"]'),
            r = x.find('input[name="current_price"]'),
            d = x.find('.interest-controls'),
            c = x.find('.interest-container');
            x.find('input[name="user_id"]').val(u);
            c.children().not(':first').remove();            

            x.modal({
                onHidden: function(){
                    d.find('.add-interest').off('click');
                    d.find('.remove-interest').off('click');
                }
            }).modal("show");
            
            i.keypress(function(e){
                var v = this.value;
                e.which != 8 && isNaN(String.fromCharCode(e.which)) ? e.preventDefault() : null,
                this.value.length > 9 ? e.preventDefault() : null,
                v.match(/^\d{2}$/) !== null ? this.value = v + '.' : v.match(/^\d{2}\.\d{2}$/) !== null ? this.value = v + '.' : null
            });
            
            $(k,j).focusout((e) => {
                var y = 0;
                f = x.find('input[name="interest_price"]');
                m.val(parseInt(j.val()) * floatVal(k.val()));
                n.val(floatVal(m.val()) * floatVal(p.val()));
                $.each(f, (z,v) => y += $(v).val() ? floatVal($(v).val()) : 0);
                r.val(floatVal(m.val()) + floatVal(y));
            });

            p.focusout(() => n.val(floatVal(m.val()) * floatVal(p.val())));

            f.focusout((e)=>{
                var y = 0;
                f = x.find('input[name="interest_price"]');
                $.each(f, (z,v) => y += $(v).val() ? floatVal($(v).val()) : 0);
                r.val(floatVal(m.val()) + floatVal(y));
            });
            
            d.find('.add-interest').on('click', function(a){
                var o = $("#modal-add-anleihen"),
                n = o.find('.interest-container'),
                l = n.find('.interest-line:last');
                if(n.children().length < 4){
                    l.clone(true).appendTo(n);
                    l = n.children().last();
                    l.find('input').val('');
                    l.find('input').first().focus();
                }
            });
            
            d.find('.remove-interest').on('click', function(a){
                var o = $("#modal-add-anleihen"),
                n = o.find('.interest-container'),
                l = n.find('.interest-line:nth-last-child(1)'),
                p = n.find('.interest-line:nth-last-child(2)'),
                f = l.find('input[name="interest_price"]');
                r.val(floatVal(r.val()) - floatVal(f.val() ? f.val() : 0));
                if(n.children().length > 1){
                    p.find('input').first().focus();
                    l.remove();
                }else{
                    n.find('.interest-line:last-child()').find('input').val('');
                }
            });
            $.ajax({
                url: "{{ @BASE }}/api/data/anleihen/assets/all",
                method: "GET",
                dataType: "json",
                async: !0,
                cache: !1,
                success: function (d) {
                    var w = [];
                    $.each(d.results, function (k, v) {
                        var wx = new Object();
                        wx.value = v.symbol;
                        wx.name = '<i class="'+v.country_code+' flag"></i>' + v.name;
                        w.push(wx);
                    });
                    y.dropdown({
                        'values': w, 
                        'placeholder': '{{ @portfolio.anleihen.select }}'
                    });
                },
                error: handleAjaxError
            });
        });
        $("#modal-add-anleihen").form({
            on: "blur"
        }).on("submit", function (a) {
            a.preventDefault();
            var e = $(this),
            n = e.find('.interest-container'),
            t = [];
            n.children().each(function(i,v){
                var a = $(v), 
                d = a.find('input[name="interest_date"]'),
                p = a.find('input[name="interest_price"]');
                if(''!= d && '' != p){
                    o = new Object();
                    o.date = d.val();
                    o.price = p.val();
                    t.push(o);
                }
            });
            if (!e.hasClass("submitting")) {
                e.addClass("submitting");
                var r = e.find(".ui.result.message"),
                i = {};
                r.hide(),
                e.find(".submit.button").addClass("disabled loading"),
                e.find("input:not(input[name='interest_date']):not(input[name='interest_price'])").each(function (k, v) {
                    if(v.name){
                        var r = e.form("get value", v.name);
                        i[v.name] = "boolean" != typeof r || r ? r : ""
                    }
                });
                i['interest_date'] = t.length > 0 ? JSON.stringify(t) : null;
                i['notes'] = e.find("textarea").val();
                $.ajax({
                    url: "{{ @BASE }}/api/actions/anleihen/add",
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
                        anleihenz()
                    },
                    error: handleAjaxError
                })
            }
        });
        q.on("click", "button.delete-anleihen", function () {
            var e = $(this),
            a = $("#modal-delete-anleihen");
            a.modal("show"),
            a.find('input[name="id"]').val(e.data("id"))
        }),
        $("#modal-delete-anleihen").form().on("submit", function (a) {
            a.preventDefault();
            var e = $(this);
            if (e.form("is valid") && !e.hasClass("submitting")) {
                e.addClass("submitting");
                var r = e.find(".ui.result.message"),
                i = {};
                r.hide(),
                e.find(".submit.button").addClass("disabled loading"),
                e.find("input").each(function (a, t) {
                    if(t.name){
                        var r = e.form("get value", t.name);
                        i[t.name] = "boolean" != typeof r || r ? r : ""
                    }
                }),
                $.ajax({
                    url: "{{ @BASE }}/api/actions/anleihen/delete",
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
                            $("#modal-delete-anleihen").hide()
                        }, 3e3),
                        e.removeClass("submitting"),
                        anleihenz()
                    },
                    error: handleAjaxError
                })
            }
        });
        
        $("#add-fund").on('click', function(){
            var x = $("#modal-add-fund"),
            y = x.find('.ui.dropdown'),
            u = $("#tab-funds").find(".ui.user.search").data("user"),
            i = x.find('input[name="interest_date"]'),
            j = x.find('input[name="quantity"]'),
            m = x.find('input[name="price"]'),
            n = x.find('input[name="total_price"]'),
            p = x.find('input[name="value"]'),
            r = x.find('input[name="notes"]'),
            d = x.find('.interest-controls'),
            c = x.find('.interest-container');
            x.find('input[name="user_id"]').val(u);
            x.modal({
                onHidden: function(){
                    d.find('.add-interest').off('click');
                    d.find('.remove-interest').off('click');
                }
            }).modal("show");

            d.find('.add-interest').on('click', function(a){
                var o = $("#modal-add-fund"),
                n = o.find('.interest-container'),
                l = n.find('.interest-line:last');
                if(n.children().length < 4){
                    l.clone(true).appendTo(n);
                    l = n.children().last();
                    l.find('input').val('');
                    l.find('input').first().focus();
                }
            });
            
            d.find('.remove-interest').on('click', function(a){
                var o = $("#modal-add-fund"),
                n = o.find('.interest-container'),
                l = n.find('.interest-line:nth-last-child(1)'),
                p = n.find('.interest-line:nth-last-child(2)'),
                f = l.find('input[name="interest_price"]');
                r.val(floatVal(r.val()) - floatVal(f.val() ? f.val() : 0));
                if(n.children().length > 1){
                    p.find('input').first().focus();
                    l.remove();
                }else{
                    n.find('.interest-line:last-child()').find('input').val('');
                }
            });
            
            $(j).on("keyup", function(e) {
                var quantity = e.target.value ? floatVal(e.target.value) : 0,
                price = $(m).val() ? floatVal($(m).val()) : 0;
                var total = floatVal(quantity * price);
                $(n).val(total);
            });
            $(m).on("keyup", function(e) {
                var quantity = e.target.value ? floatVal(e.target.value) : 0,
                price = $(j).val() ? floatVal($(j).val()) : 0;
                var total = floatVal(quantity * price);
                $(n).val(total);
            });
            
            $.ajax({
                url: "{{ @BASE }}/api/data/funds/assets/all",
                method: "GET",
                dataType: "json",
                async: !0,
                cache: !1,
                success: function (d) {
                    var w = [];
                    $.each(d.results, function (k, v) {
                        var o = new Object();
                        o.value = v.symbol;
                        o.name = '<i class="'+v.country_code+' flag"></i>' + v.name;
                        w.push(o);
                    });
                    y.dropdown({
                        'values': w, 
                        'placeholder': '{{ @portfolio.funds.select }}'
                    });
                },
                error: handleAjaxError
            });
        });
        $("#modal-add-fund").form({
            on: "blur"
        }).on("submit", function (a) {
            a.preventDefault();
            var e = $(this),
            n = e.find('.interest-container'),
            t = [];
            n.children().each(function(i,v){
                var a = $(v), 
                d = a.find('input[name="interest_date"]'),
                p = a.find('input[name="interest_price"]');
                if(''!= d && '' != p){
                    o = new Object();
                    o.date = d.val();
                    o.price = p.val();
                    t.push(o);
                }
            });            
            if (!e.hasClass("submitting")) {
                e.addClass("submitting");
                var r = e.find(".ui.result.message"),
                i = {};
                r.hide(),
                e.find(".submit.button").addClass("disabled loading"),
                e.find("input:not(input[name='interest_date']):not(input[name='interest_price'])").each(function (k, v) {
                    if(v.name){
                        var r = e.form("get value", v.name);
                        i[v.name] = "boolean" != typeof r || r ? r : ""
                    }
                });
                i['interest_date'] = t.length > 0 ? JSON.stringify(t) : null;                
                i["notes"] = e.find("textarea").val();
                $.ajax({
                    url: "{{ @BASE }}/api/actions/fund/add",
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
                        fundsff()
                    },
                    error: handleAjaxError
                })
            }
        });
        fl.on("click", "button.edit-fund", function () {
            var a = $(this),
            t = $("#modal-edit-fund");
            s = a.data("interest-date");
            t.modal({
                onHidden: function(){
                    t.find('.add-interest').off('click');
                    t.find('.remove-interest').off('click');
                }
            }).modal("show"),
            t.find('input[name="fund_id"]').val(a.data("fund-id")),
            t.find('input[name="user_id"]').val(a.data("user-id")),
            t.find('input[name="quantity"]').val(a.data("quantity")),
            t.find('input[name="price"]').val(a.data("price")),
            t.find('input[name="issue_price"]').val(moment(a.data("issue-price")).format('YYYY-MM-DD')),
            t.find('input[name="current_price"]').val(moment(a.data("current-price")).format('YYYY-MM-DD')),
            t.find('input[name="total_price"]').val(a.data("total-price")),
            t.find('input[name="value"]').val(a.data("value")),
            t.find('textarea[name="notes"]').val(a.data("notes")),
            t.find('.interest-container').find('.interest-line').not(':first').remove();
            
            var i = t.find('input[name="interest_date"]'),
            j = t.find('input[name="quantity"]'),
            k = t.find('input[name="price"]'),
            m = t.find('input[name="issue_price"]'),
            o = t.find('input[name="total_price"]'),
            p = t.find('input[name="value"]'),
            c = t.find('input[name="notes"]'),
            r = t.find('input[name="current_price"]');

            $(j).on("keyup", function(e) {
                var quantity = e.target.value ? floatVal(e.target.value) : 0,
                price = $(k).val() ? floatVal($(k).val()) : 0;
                var total = floatVal(quantity * price);
                $(o).val(total);
            });
            $(k).on("keyup", function(e) {
                var price = e.target.value ? floatVal(e.target.value) : 0,
                quantity = $(j).val() ? floatVal($(j).val()) : 0;
                var total = floatVal(quantity * price);
                $(o).val(total);
            });
            
            if(s){
                var l = null, n = t.find('.interest-container');
                $.each(s, function(i,v){
                    l = n.find('.interest-line').last();
                    var f = l.find('input[name="interest_price"]'),
                    i = l.find('input[name="interest_date"]');
                    if(n.children().length < 5){
                        f.val(v.price);
                        i.val(v.date);
                        l.clone(true).appendTo(n);
                    }
                });
                l.remove();
            }
            
            t.find('.add-interest').on('click', function(a){
                var n = t.find('.interest-container'),
                l = n.find('.interest-line').last();
                if(n.children().length<4){
                    l.clone(true).appendTo(n);
                    l = n.find('.interest-line').last();
                    l.find('input').val('');
                    l.find('input').first().focus();
                }
                console.log(n.children().length);
            });
            t.find('.remove-interest').on('click', function(a){
                var n = t.find('.interest-container'),
                l = n.find('.interest-line').last(),
                f = l.find('input[name="interest_price"]');
                r.val(floatVal(r.val()) - floatVal(f.val() ? f.val() : 0));
                if(n.children().length>1){
                    l.prev().find('input').first().focus();
                    l.remove();
                }else{
                    n.find('.interest-line').last().find('input').val('');
                }
                console.log(n.children().length);
            });
        
            y = t.find(".ui.dropdown");
            $.ajax({
                url: "{{ @BASE }}/api/data/funds/assets/all",
                method: "GET",
                dataType: "json",
                async: !0,
                cache: !1,
                success: function (d) {
                    var w = [];
                    $.each(d.results, function (k, v) {
                        var o = new Object();
                        o.value = v.symbol;
                        o.name = '<i class="'+v.country_code+' flag"></i>' + v.name;
                        w.push(o);
                    })
                    y.dropdown({
                        'values': w, 
                        'placeholder': '{{ @portfolio.funds.select }}'
                    });
                    y.dropdown('set selected', a.data("symbol"));

                },
                error: handleAjaxError
            });
        }),
        $("#modal-edit-fund").form({
            on: "blur"
        }).on("submit", function (a) {
            a.preventDefault();
            var e = $(this), c = [];
            e.find('.interest-container').children().each(function(i,v){
                d = $(v).find('input[name="interest_date"]'),
                p = $(v).find('input[name="interest_price"]');
                if(''!= d.val() && '' != p.val()){
                    o = new Object();
                    o.date = d.val();
                    o.price = p.val();
                    c.push(o);
                }
            });
            if (e.form("is valid") && !e.hasClass("submitting")) {
                e.addClass("submitting");
                var r = e.find(".ui.result.message"),
                i = {};
                r.hide(),
                e.find(".submit.button").addClass("disabled loading"),
                e.find("input:not(input[name='interest_date']):not(input[name='interest_price'])").each(function (k, v) {
                    if(v.name){
                        var r = e.form("get value", v.name);
                        i[v.name] = "boolean" != typeof r || r ? r : ""
                    }
                });
                i['interest_date'] = c.length > 0 ? JSON.stringify(c) : null;
                i["notes"] = e.find("textarea").val();
                $.ajax({
                    url: "{{ @BASE }}/api/actions/fund/edit",
                    method: "POST",
                    data: i,
                    dataType: "json",
                    async: !0,
                    cache: !1,
                    success: function (a) {
                        a && a.success ? r.text(a.message).removeClass("negative").addClass("positive").show() : r.text(a.message).removeClass("positive").addClass("negative").show()
                        $(".submit.button").removeClass("disabled loading")
                        setTimeout(function () {
                            r.hide("slow")
                            e.hide()
                        }, 3e3),
                        e.removeClass("submitting"),
                        fundsff()
                    },
                    error: handleAjaxError
                })
            }
        });
        fl.on("click", "button.delete-fund", function () {
            var e = $(this),
            a = $("#modal-delete-fund");
            a.modal("show"),
            a.find('input[name="id"]').val(e.data("id"))
        }),
        $("#modal-delete-fund").form().on("submit", function (a) {
            a.preventDefault();
            var e = $(this);
            if (e.form("is valid") && !e.hasClass("submitting")) {
                e.addClass("submitting");
                var r = e.find(".ui.result.message"),
                i = {};
                r.hide(),
                e.find(".submit.button").addClass("disabled loading"),
                i["id"] = e.find("input[name='id']").val();
                $.ajax({
                    url: "{{ @BASE }}/api/actions/fund/delete",
                    method: "POST",
                    data: i,
                    dataType: "json",
                    async: !0,
                    cache: !1,
                    success: function (a) {
                        a && a.success ? r.text(a.message).removeClass("negative").addClass("positive").show() : r.text(a.message).removeClass("positive").addClass("negative").show(),
                        $(".submit.button").removeClass("disabled loading"),
                        setTimeout(function () {
                            r.hide("slow")
                        }, 3e3),
                        setTimeout(function () {
                            $("#modal-delete-fund").hide()
                        }, 3e4),
                        e.removeClass("submitting"),
                        fundsff()
                    },
                    error: handleAjaxError
                })
            }
        });
        fl.on("click", "button.funds-notes", function () {
            var a = $(this),
            m = $("#modal-funds-notes"),
            c = a.data("notes"),
            v = m.find("div.notes-area").html(c);
            m.modal("show");
        });        
    
        $("#add-fixed-deposit").on('click', function(){
            var x = $("#modal-add-fixed-deposit"),
            y = x.find('.ui.dropdown'),
            u = $("#tab-fixed-deposit").find(".ui.user.search").data("user");
            x.find('input[name="user_id"]').val(u);
            x.modal("show");

            var 
            j = x.find('input[name="amount"]'),
            k = x.find('input[name="interest_rate"]'),
            o = x.find('input[name="total"]'),
            w = x.find('input[name="building"]'),
            s = x.find('input[name="totalvalue"]');
            
            $(j).on("keyup", function(e) {
                var 
                amount = e.target.value ? floatVal(e.target.value) : 0,
                interest_rate = $(k).val() ? floatVal($(k).val()) : 0,
                building = $(w).val() ? floatVal($(w).val()) : 0;
                building = (building / 100.0) + 1.0;
                var
                total = amount * interest_rate,
                totalvalue = total * building;
                
                $(o).val(floatVal(total).formatNumber(2));
                $(s).val(floatVal(totalvalue).formatNumber(2));
            });
            $(k).on("keyup", function(e) {
                var 
                amount = $(j).val() ? floatVal($(j).val()) : 0,
                interest_rate = e.target.value ? floatVal(e.target.value) : 0,
                building = $(w).val() ? floatVal($(w).val()) : 0;
                building = (building / 100.0) + 1.0;
                var
                total = amount * interest_rate,
                totalvalue = total * building;
                
                $(o).val(floatVal(total).formatNumber(2));
                $(s).val(floatVal(totalvalue).formatNumber(2));
            });

            $(w).on("keyup", function(e) {
                var 
                amount = $(j).val() ? floatVal($(j).val()) : 0,
                interest_rate = $(k).val() ? floatVal($(k).val()) : 0,
                building = e.target.value ? floatVal(e.target.value) : 0;
                building = (building / 100.0) + 1.0;
                var
                total = amount * interest_rate,
                totalvalue = total * building;
                
                $(o).val(floatVal(total).formatNumber(2));
                $(s).val(floatVal(totalvalue).formatNumber(2));
            });
            
            $.ajax({
                url: "{{ @BASE }}/api/data/deposits/assets/all",
                method: "GET",
                dataType: "json",
                async: !0,
                cache: !1,
                success: function (d) {
                    var w = [];
                    $.each(d.results, function (k, v) {
                        var o = new Object();
                        o.value = v.symbol;
                        o.name = '<i class="'+v.country_code+' flag"></i>' + v.name;
                        w.push(o);
                    });
                    y.dropdown({
                        'values': w, 
                        'placeholder': '{{ @portfolio.fixed_deposit.select }}'
                    });
                },
                error: handleAjaxError
            });
        });
        $("#modal-add-fixed-deposit").form({
            on: "blur"
        }).on("submit", function (a) {
            a.preventDefault();
            var e = $(this),
            t = [];
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
                    url: "{{ @BASE }}/api/actions/deposit/add",
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
                        fd()
                    },
                    error: handleAjaxError
                })
            }
        });
        dl.on("click", "button.edit-fixed-deposit", function () {
            var a = $(this),
            t = $("#modal-edit-fixed-deposit"),
            s = a.data("interest-date");
            t.modal("show"),
            t.find('input[name="deposit_id"]').val(a.data("deposit-id")),
            t.find('input[name="user_id"]').val(a.data("user-id")),
            t.find('input[name="amount"]').val(a.data("amount")),
            t.find('input[name="total"]').val(a.data("total")),
            t.find('input[name="interest_rate"]').val(a.data("interest-rate")),
            t.find('input[name="building"]').val(a.data("building")),
            t.find('input[name="totalvalue"]').val(a.data("totalvalue"));

            var 
            j = t.find('input[name="amount"]'),
            k = t.find('input[name="interest_rate"]'),
            o = t.find('input[name="total"]'),
            w = t.find('input[name="building"]'),
            s = t.find('input[name="totalvalue"]');
            
            $(j).on("keyup", function(e) {
                var 
                amount = e.target.value ? floatVal(e.target.value) : 0,
                interest_rate = $(k).val() ? floatVal($(k).val()) : 0,
                building = $(w).val() ? floatVal($(w).val()) : 0;
                building = (building / 100.0) + 1.0;
                var
                total = amount * interest_rate,
                totalvalue = total * building;
                
                $(o).val(floatVal(total).formatNumber(2));
                $(s).val(floatVal(totalvalue).formatNumber(2));
            });
            $(k).on("keyup", function(e) {
                var 
                amount = $(j).val() ? floatVal($(j).val()) : 0,
                interest_rate = e.target.value ? floatVal(e.target.value) : 0,
                building = $(w).val() ? floatVal($(w).val()) : 0;
                building = (building / 100.0) + 1.0;
                var
                total = amount * interest_rate,
                totalvalue = total * building;
                
                $(o).val(floatVal(total).formatNumber(2));
                $(s).val(floatVal(totalvalue).formatNumber(2));
            });

            $(w).on("keyup", function(e) {
                var 
                amount = $(j).val() ? floatVal($(j).val()) : 0,
                interest_rate = $(k).val() ? floatVal($(k).val()) : 0,
                building = e.target.value ? floatVal(e.target.value) : 0;
                building = (building / 100.0) + 1.0;
                var
                total = amount * interest_rate,
                totalvalue = total * building;
                
                $(o).val(floatVal(total).formatNumber(2));
                $(s).val(floatVal(totalvalue).formatNumber(2));
            });

            y = t.find(".ui.dropdown");
            $.ajax({
                url: "{{ @BASE }}/api/data/deposits/assets/all",
                method: "GET",
                dataType: "json",
                async: !0,
                cache: !1,
                success: function (d) {
                    var w = [];
                    $.each(d.results, function (k, v) {
                        var o = new Object();
                        o.value = v.symbol;
                        o.name = '<i class="'+v.country_code+' flag"></i>' + v.name;
                        w.push(o);
                    })
                    y.dropdown({
                        'values': w, 
                        'placeholder': '{{ @portfolio.fixed_deposit.select }}'
                    });
                    y.dropdown('set selected', a.data("symbol"));

                },
                error: handleAjaxError
            });
        }),
        $("#modal-edit-fixed-deposit").form({
            on: "blur"
        }).on("submit", function (a) {
            a.preventDefault();
            var e = $(this);
            if (e.form("is valid") && !e.hasClass("submitting")) {
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
                    url: "{{ @BASE }}/api/actions/deposit/edit",
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
                        fd()
                    },
                    error: handleAjaxError
                })
            }
        });
        dl.on("click", "button.delete-fixed-deposit", function () {
            var e = $(this),
            a = $("#modal-delete-fixed-deposit");
            a.modal("show"),
            a.find('input[name="id"]').val(e.data("id"))
        }),
        $("#modal-delete-fixed-deposit").form().on("submit", function (a) {
            a.preventDefault();
            var e = $(this);
            if (e.form("is valid") && !e.hasClass("submitting")) {
                e.addClass("submitting");
                var r = e.find(".ui.result.message"),
                i = {};
                r.hide(),
                e.find(".submit.button").addClass("disabled loading"),
                i["id"] = e.find("input[name='id']").val();
                $.ajax({
                    url: "{{ @BASE }}/api/actions/deposit/delete",
                    method: "POST",
                    data: i,
                    dataType: "json",
                    async: !0,
                    cache: !1,
                    success: function (a) {
                        a && a.success ? r.text(a.message).removeClass("negative").addClass("positive").show() : r.text(a.message).removeClass("positive").addClass("negative").show(),
                        $(".submit.button").removeClass("disabled loading"),
                        setTimeout(function () {
                            r.hide("slow")
                        }, 3e3),
                        setTimeout(function () {
                            $("#modal-delete-fixed-deposit").hide()
                        }, 3e4),
                        e.removeClass("submitting"),
                        fd()
                    },
                    error: handleAjaxError
                })
            }
        });
        dl.on("click", "button.fixed-notes", function () {
            var a = $(this),
            m = $("#modal-fixed-notes"),
            c = a.data("notes"),
            v = m.find("div.notes-area").html(c);
            m.modal("show");
        });        
        
        $("#portfolio-menu .item").tab({
            onLoad: function (a) {
                i = a,
                "tab-trades" == i && 0 == n.find("tbody").children().length ? t() : 
                "tab-anleihen" == i && 0 == q.find("tbody").children().length ? anleihenz() : 
                "tab-funds" == i && 0 == fl.find("tbody").children().length ? fundsff() : 
                "tab-fixed-deposit" == i && 0 == dl.find("tbody").children().length ? fd() : null;
            },
            onVisible: function () {
                $(".ui.sticky").sticky("refresh")
            }
        })
    });
</script>