<?php if ($USER['is_admin']): ?>

<script type="text/javascript">
$(document).ready(function () {
    moment.locale();

    var l = $("#payments-list"),
    w = $('#tab-paymentslist'),
    s = w.find('.ui.user.search');

    function v() {
        var a = s.data("user");
        $.ajax({
            url: "<?php echo $BASE; ?>/api/data/cryptopayments" + (a ? "/" + a : ""),
            method: "GET",
            dataType: "json",
            async: !0,
            cache: !1,
            success: function (a) {
                if (l.destroyDataTable(), l.find("tbody").empty(), a && a.length) {
                    var t = "";
                    $.each(a, function (a, e) {
                        t += 
                        '<tr>'+
                            '<td>' + e.first_name + ' ' + e.last_name + '</td>'+
                            '<td class="center aligned">' + e.symbol + '</td>'+
                            '<td>' + e.wallet + '</td>'+
                            '<td>' + floatVal(e.amount).formatNumber(2) +  '</td>'+
                            '<td>' + floatVal(e.current).formatNumber(2) +  '</td>'+
                            '<td>' + floatVal(e.total).formatNumber(8) +  '</td>'+
                            '<td class="center aligned">' + moment(e.created).format('DD MMMM YYYY HH:mm') + '</td>'+
                            '<td class="payment-actions center aligned">'+
                                '<div class="button-container">'+
                                    '<button class="ui basic circular icon edit-payment-button button" '+
                                            'data-payment-id="' + e.t_id.replace('id','') + '" ' +
                                            'data-user-id="' + e.user_id + '" ' +
                                            'data-wallet="' + e.wallet + '" ' +
                                            'data-symbol="' + e.symbol + '" ' +
                                            'data-amount="' + e.amount + '" ' +
                                            'data-current="' + e.current + '" ' +
                                            'data-total="' + e.total + '" ' +
                                            'data-created="' + e.created + '" ' +
                                            'data-updated="' + e.updated + '" '+ '">'+
                                        '<i class="pencil icon"></i>'+
                                    '</button>'+
                                '</div>'+
                                '<div class="button-container">'+
                                    '<button class="ui basic circular icon delete-payment-button button" data-payment-id="' + e.t_id.replace('id','') + '">'+
                                        '<i class="trash icon"></i>'+
                                    '</button>'+
                                '</div>'+
                            '</td>'+
                        '</tr>'
                    }),
                    l.find("tbody").append(t)
                }
                l.initDataTable(10, [0, "desc"], !0, null, [])
            },
            error: handleAjaxError
        })
    }
    function u() {
        $.ajax({
            url: "<?php echo $BASE; ?>/api/data/cryptopayments",
            method: "GET",
            dataType: "json",
            async: !0,
            cache: !1,
            success: function (a) {
                if (l.destroyDataTable(), l.find("tbody").empty(), a && a.length) {
                    var t = "";
                    $.each(a, function (a, e) {
                        t += 
                        '<tr>'+
                            '<td>' + e.first_name + ' ' + e.last_name + '</td>'+
                            '<td class="center aligned">' + (e.symbol == 'BTC' ? '<i class="bitcoin big icon"></i>' : e.symbol == 'ETH' ? '<i class="ethereum big icon"></i>' : e.symbol == 'USDT' ? '<i class="dollar big icon"></i>' : e.symbol == 'USDC' ? '<i class="dollar big icon"></i>' : null) + '</td>'+
                            '<td>' + e.wallet + '</td>'+
                            '<td>' + floatVal(e.amount).formatNumber(2) +  '<i class="euro icon"></i></td>'+
                            '<td>' + floatVal(e.current).formatNumber(2) +  '</td>'+
                            '<td>' + floatVal(e.total).formatNumber(8) + ' ('+e.symbol+')' + '</td>'+
                            '<td class="center aligned">' + moment(e.created).format('DD MMMM YYYY HH:mm') + '</td>'+
                            '<td class="cryptopayment-actions right aligned">'+
                                '<div class="button-container">'+
                                    '<button class="ui basic circular icon edit-payment-button button" '+
                                            'data-payment-id="' + e.t_id.replace('id','') + '" ' +
                                            'data-user-id="' + e.user_id + '" ' +
                                            'data-wallet="' + e.wallet + '" ' +
                                            'data-symbol="' + e.symbol + '" ' +
                                            'data-amount="' + e.amount + '" ' +
                                            'data-current="' + e.current + '" ' +
                                            'data-total="' + e.total + '" ' +
                                            'data-created="' + e.created + '" ' +
                                            'data-updated="' + e.updated + '" '+ '">'+
                                        '<i class="pencil icon"></i>'+
                                    '</button>'+
                                '</div>'+
                                '<div class="button-container">'+
                                    '<button class="ui basic circular icon delete-payment-button button" data-payment-id="' + e.t_id.replace('id','') + '">'+
                                        '<i class="trash icon"></i>'+
                                    '</button>'+
                                '</div>'+
                            '</td>'+
                            '</tr>';
                    }),
                    l.find("tbody").append(t)
                }
                l.initDataTable(10, [[0, "desc"]], !0, null, [])
            },
            error: handleAjaxError
        })
    }

    l.on("click", ".delete-payment-button", function () {
        var a = $(this),
        t = $("#modal-payment-delete");
        t.find(".submit.button").removeClass("disabled loading"),
        t.modal("show"),
        t.hasClass("submitting") ? t.removeClass("submitting") : null,        
        t.find('input[name="id"]').val(a.data("payment-id"))
    });
    
    $("#modal-payment-delete").form({
        on: "blur"
    }).on("submit", function (a) {
        a.preventDefault();
        var e = $(this),
        r = e.find(".ui.result.message"),
        f = {};
        
        if (!e.hasClass("submitting")) {
            e.addClass("submitting");
            e.find(".submit.button").addClass("disabled loading"),
            f['id'] = e.find('input[name="id"]').val();
            r.hide();
            $.ajax({
                url: "<?php echo $BASE; ?>/api/actions/cryptopayment/delete",
                method: "POST",
                data: f,
                dataType: "json",
                async: !0,
                cache: !1,
                success: function (a) {
                    a && a.success ? r.text(a.message).removeClass("negative").addClass("positive").show() : r.text(a.message).removeClass("positive").addClass("negative").show(),
                    $(".submit.button").removeClass("disabled loading"),
                    e.removeClass("submitting"),
                    u(), 
                    setTimeout(function () {
                        r.hide('slow'),
                        e.modal('hide')
                    }, 1e3)
                },
                error: handleAjaxError
            })
        }
    });
    
    l.on("click", ".edit-payment-button", function () {
        var a = $(this),
        t = $("#modal-edit-payment");
        t.modal("show"),
        t.find('input[name="payment_id"]').val(a.data("payment-id")),
        t.find('input[name="symbol"]').val(a.data("symbol")),
        t.find('input[name="wallet"]').val(a.data("wallet")),
        t.find('input[name="amount"]').val(a.data("amount"));
        t.find('input[name="current"]').val(a.data("current"));
        t.find('input[name="total"]').val(a.data("total"));
    });
    
    $("#modal-edit-payment").form({
        on: "blur"
    }).on("submit", function (a) {
        a.preventDefault();
        var e = $(this),
        f = {},
        r = e.find(".ui.result.message");
        if (!e.hasClass("submitting")) {
            e.addClass("submitting");
            e.find(".submit.button").addClass("disabled loading"),
            e.find("input").each(function (a, t) {
                var r = e.form("get value", t.name);
                f[t.name] = "boolean" != typeof r || r ? r : ""
            }),
            r.hide(),
            $.ajax({
                url: "<?php echo $BASE; ?>/api/actions/cryptopayment/update",
                method: "POST",
                data: f,
                dataType: "json",
                async: !0,
                cache: !1,
                success: function (a) {
                    a && a.success ? r.text(a.message).removeClass("negative").addClass("positive").show() : r.text(a.message).removeClass("positive").addClass("negative").show(),
                    $(".submit.button").removeClass("disabled loading"),
                    setTimeout(function () {
                        r.hide("slow")
                    }, 3e3),
                    e.removeClass("submitting"),
                    u()
                },
                error: handleAjaxError
            })
        }
    });
    
    var btc = $("#modal-btc-payment"),
        eth = $("#modal-eth-payment"),
        usdt = $("#modal-usdt-payment"),
        usdc = $("#modal-usdc-payment");
        
    btc.find(".amount").on("keyup", function(e){
        var d = floatVal(btc.find(".current-price").text().trim()),
        z = floatVal(e.target.value),
        x = floatVal(z / d).formatNumber(8);
        console.log(z, d, x);
        btc.find(".total").val(x);
    });

    eth.find(".amount").on("keyup", function(e){
        var d = floatVal(eth.find(".current-price").text().trim()),
        z = floatVal(e.target.value),
        x = floatVal(z / d).formatNumber(8);
        console.log(z, d, x);
        eth.find(".total").val(x);
    });
    
    usdt.find(".amount").on("keyup", function(e){
        var d = floatVal(usdt.find(".current-price").text().trim()),
        z = floatVal(e.target.value),
        x = floatVal(z / d).formatNumber(8);
        console.log(z, d, x);
        usdt.find(".total").val(x);
    });
    
    usdc.find(".amount").on("keyup", function(e){
        var d = floatVal(usdc.find(".current-price").text().trim()),
        z = floatVal(e.target.value),
        x = floatVal(z / d).formatNumber(8);
        console.log(z, d, x);
        usdc.find(".total").val(x);
    });
    
    $(".payment-form").form({
        on: "blur"
    }).on("submit", function (a) {
        a.preventDefault();
        var e = $(this),
        i = {},
        r = e.find(".ui.result.message");

        if (!e.hasClass("submitting")) {
            e.addClass("submitting");
            e.find(".submit.button").addClass("disabled loading"),
            e.find("input").each(function (a, t) {
                var r = e.form("get value", t.name);
                i[t.name] = "boolean" != typeof r || r ? r : ""
            }),
            i['current'] = e.find('.current-price').text().trim(),
            r.hide(),
            $.ajax({
                url: "<?php echo $BASE; ?>/api/actions/cryptopayment/save",
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
                    e.removeClass("submitting"),
                    u()
                },
                error: handleAjaxError
            })
        }
    });
    
    $(".btc-card").click(function(e){
        var t = $("#modal-btc-payment");
        t.modal("show");
    });
    
    $(".eth-card").click(function(e){
        var t = $("#modal-eth-payment");
        t.modal("show");
    });
    
    $(".usdt-card").click(function(e){
        var t = $("#modal-usdt-payment");
        t.modal("show");
    });
    
    $(".usdc-card").click(function(e){
        var t = $("#modal-usdc-payment");
        t.modal("show");
    });
    
    refreshPaymentsList = function () {
        v()
    }
    u();
    
    $("#cryptopayments-menu .item").tab({})
    
});
</script>    

<?php else: ?>
<script type = "text/javascript"> 
$(document).ready(function () {
    moment.locale();
    var l = $("#payments-list"),
    w = $('#tab-paymentslist');
    function u() {
        $.ajax({
            url: "<?php echo $BASE; ?>/api/data/cryptopayments",
            method: "GET",
            dataType: "json",
            async: !0,
            cache: !1,
            success: function (a) {
                if (l.destroyDataTable(), l.find("tbody").empty(), a && a.length) {
                    var t = "";
                    $.each(a, function (a, e) {
                        t += 
                        '<tr>'+
                        '<td class="center aligned">' + e.symbol + '</td>'+
                        '<td>' + e.wallet + '</td>'+
                        '<td>' + floatVal(e.amount).formatNumber(2) +  '</td>'+
                        '<td>' + floatVal(e.current).formatNumber(8) +  '</td>'+
                        '<td>' + floatVal(e.total).formatNumber(8) +  '</td>'+
                        '<td class="center aligned">' + moment(e.created).format('DD MMMM YYYY HH:mm') + '</td>'+
                        '</tr>'
                    }),
                    l.find("tbody").append(t)
                }
                l.initDataTable(10, [5,"desc"], !0, null, [])
            },
            error: handleAjaxError
        })
    }
    
    u();

    var btc = $("#modal-btc-payment"),
        eth = $("#modal-eth-payment"),
        usdt = $("#modal-usdt-payment"),
        usdc = $("#modal-usdc-payment");
        
    btc.find(".amount").on("keyup", function(e){
        var d = floatVal(btc.find(".current-price").text().trim()),
        z = floatVal(e.target.value),
        x = floatVal(z / d).formatNumber(8);
        console.log(z, d, x);
        btc.find(".total").val(x);
    });

    eth.find(".amount").on("keyup", function(e){
        var d = floatVal(eth.find(".current-price").text().trim()),
        z = floatVal(e.target.value),
        x = floatVal(z / d).formatNumber(8);
        console.log(z, d, x);
        eth.find(".total").val(x);
    });
    
    usdt.find(".amount").on("keyup", function(e){
        var d = floatVal(usdt.find(".current-price").text().trim()),
        z = floatVal(e.target.value),
        x = floatVal(z / d).formatNumber(8);
        console.log(z, d, x);
        usdt.find(".total").val(x);
    });
    
    usdc.find(".amount").on("keyup", function(e){
        var d = floatVal(usdc.find(".current-price").text().trim()),
        z = floatVal(e.target.value),
        x = floatVal(z / d).formatNumber(8);
        console.log(z, d, x);
        usdc.find(".total").val(x);
    });
    
    $(".payment-form").form({
        on: "blur"
    }).on("submit", function (a) {
        a.preventDefault();
        var e = $(this),
        i = {},
        r = e.find(".ui.result.message");

        if (!e.hasClass("submitting")) {
            e.addClass("submitting");
            e.find(".submit.button").addClass("disabled loading"),
            e.find("input").each(function (a, t) {
                var r = e.form("get value", t.name);
                i[t.name] = "boolean" != typeof r || r ? r : ""
            }),
            i['current'] = e.find('.current-price').text().trim(),
            r.hide(),
            $.ajax({
                url: "<?php echo $BASE; ?>/api/actions/cryptopayment/save",
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
                    e.removeClass("submitting"),
                    u()
                },
                error: handleAjaxError
            })
        }
    });
    
    $("#modal-payment").form({
        on: "blur"
    }).on("submit", function (a) {
        a.preventDefault();
        var e = $(this),
        r = e.find(".ui.result.message");
        if (e.form("is valid") && !e.hasClass("submitting")) {
            e.addClass("submitting");
            e.find(".submit.button").addClass("disabled loading"),
            d = new FormData(this),
            r.hide(),
            $.ajax({
                url: "<?php echo $BASE; ?>/api/actions/cryptopayment/save",
                method: "POST",
                data: d,
                dataType: "json",
                contentType: !1,
                processData: !1,
                async: !0,
                cache: !1,
                success: function (a) {
                    a && a.success ? r.text(a.message).removeClass("negative").addClass("positive").show() : r.text(a.message).removeClass("positive").addClass("negative").show(),
                    $(".submit.button").removeClass("disabled loading"),
                    setTimeout(function () {
                        r.hide("slow"),
                        e.modal('hide')
                    }, 3e3),
                    e.removeClass("submitting"),
                    u()
                },
                error: handleAjaxError
            })
        }
    });
    
    $(".btc-card").click(function(e){
        var t = $("#modal-btc-payment");
        t.modal("show");
    });
    
    $(".eth-card").click(function(e){
        var t = $("#modal-eth-payment");
        t.modal("show");
    });
    
    $(".usdt-card").click(function(e){
        var t = $("#modal-usdt-payment");
        t.modal("show");
    });
    
    $(".usdc-card").click(function(e){
        var t = $("#modal-usdc-payment");
        t.modal("show");
    });
        
    $("#cryptopayments-menu .item").tab({})
    
});
</script>

<?php endif; ?>