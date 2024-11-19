<script type="text/javascript">
$(document).ready(function () {
    moment.locale();
    function v() {
        var a = $(s).data("user");
        $.ajax({
            url: "<?php echo $BASE; ?>/api/data/signal/all" + (a && $(s).find('input').val().length > 0 ? "/" + a : ""),
            method: "GET",
            dataType: "json",
            async: !0,
            cache: !1,
            success: function (a) {
                if (log("displaySignalsHistory", a), l.destroyDataTable(), l.find("tbody").empty(), a && a.length) {
                    var t = "";
                    $.each(a, function (a, e) {
                        t += '<tr class="' + (e.approved ? 'warning' : e.order_type == -1 ? 'negative' : 'positive') + '">' + 
                        '<td data-order='+e.t_id+'>'+e.t_id.substr(13,19)+'</td>' +
                        '<td data-order='+ moment(e.date) +'>' + moment(e.date).format('DD.MM.YYYY HH:MM:SS') + '</td>' +
                        '<?php if ($USER['is_admin']): ?><td>' + e.first_name + ' ' + e.last_name + '</td><?php endif; ?>'+
                        '<td><h5 class="ui header"><a href="<?php echo $BASE; ?>/trade?s=' + e.symbol + '" target="_blank">' + e.symbol + "&nbsp;</a></h5><div>" + e.name + '</div></td>' +
                        '<td data-order='+e.current_price+'>' + floatVal(e.current_price).formatNumber() + '</td>' +
                        '<td>' + (e.order_type == -1 ? '<?php echo $signals['add']['buy']; ?>' : '<?php echo $signals['add']['sell']; ?>') + '</td>' +
                        '<td>' + (e.limit_type == 0 ? '<?php echo $signals['limit_price']['title']; ?>' : 
                                    e.limit_type == 1 ? '<?php echo $signals['market_price']['title']; ?>' : 
                                    e.limit_type == 2 ? '<?php echo $signals['stop_loss']['title']; ?>' : 
                                    e.limit_type == 3 ? '<?php echo $signals['stop_limit']['title']; ?>' : null) + '</td>' +
                        '<td class="limit-order row">' + 
                        (e.limit_type == 0 ? '<div><span class="title"><?php echo $signals['limit_price']['title']; ?></span><span class="value"> ' + floatVal(e.limit_price).formatNumber() + ' </span></div><div><span class="title"><?php echo $signals['amount']['title']; ?></span><span class="value"> ' + e.limit_amount + ' </span></div><div><span class="title"><?php echo $signals['total']['title']; ?></span><span class="value"> '+(floatVal(parseFloat(e.limit_price) * parseFloat(e.limit_amount)).formatNumber())+' </span></div>' : 
                        e.limit_type == 1 ? '<div><span class="title"><?php echo $signals['market_price']['title']; ?></span><span class="value"> ' + floatVal(e.current_price).formatNumber(3) + ' </span></div><div><span class="title"><?php echo $signals['amount']['title']; ?></span><span class="value"> ' + e.market_amount + ' </span></div><div><span class="title"><?php echo $signals['total']['title']; ?></span><span class="value"> '+(floatVal(parseFloat(e.current_price) * parseFloat(e.market_amount)).formatNumber())+' </span></div>' :
                        e.limit_type == 2 ? '<div><span class="title"><?php echo $signals['stop_price']['title']; ?></span><span class="value"> ' + floatVal(e.stop_price).formatNumber() + ' </span></div><div><span class="title"><?php echo $signals['amount']['title']; ?></span><span class="value"> ' + e.limit_amount + ' </span></div><div><span class="title"><?php echo $signals['total']['title']; ?></span><span class="value"> '+(floatVal(parseFloat(e.stop_price) * parseFloat(e.limit_amount)).formatNumber())+' </span></div>' :
                        e.limit_type == 3 ? '<div><span class="title"><?php echo $signals['limit_price']['title']; ?></span><span class="value"> ' + floatVal(e.limit_price).formatNumber() + ' </span></div><div><span class="title"><?php echo $signals['stop_price']['title']; ?></span><span class="value"> ' + floatVal(e.stop_price).formatNumber() + ' </span></div><div><span class="title"><?php echo $signals['amount']['title']; ?></span><span class="value"> ' + e.limit_amount + ' </span></div><div><span class="title"><?php echo $signals['total']['title']; ?></span><span class="value"> '+(floatVal(e.limit_price * e.limit_amount).formatNumber())+' </span></div>' : null) +
                        '</td>' +
                        '<?php if (!$USER['is_admin']): ?>'+
                        '<td class="center aligned">' + 
                        '<div class="ui basic circular icon">'+
                        (e.approved ? '<i class="checkmark icon"></i>' : '<i class="hourglass icon"></i>') +
                        '</div>'+
                        '</td>' + 
                        '<?php endif; ?>'+
                        '<td class="limit-order actions right aligned">'+
                        '<div class="button-container">'+
                        '<?php if ($USER['is_admin']): ?>'+
                        '<button class="ui basic circular icon '+ (e.approved ? '' : 'approve-signal') + ' button" data-signal-id="' + e.t_id.replace('id','') + '" '+ (e.approved ? 'disabled' : '') + '>'+
                        '<i class="checkmark icon"></i>'+
                        '</button>'+
                        '<?php endif; ?>'+
                        '<button class="ui basic circular icon delete-signal button" data-signal-id="' + e.t_id.replace('id','') + '">'+
                        '<i class="trash icon"></i>'+
                        '</button>'+
                        '</div>'+
                        '</td>'+
                        '</tr>'
                    })
                    l.find("tbody").append(t)
                }
                
                l.initDataTable(10, [[1, "desc"]], !0, null, [$.extend(!0, {}, {
                        extend: "print",
                        autoPrint: !1,
                        title: s.find('input').val() ? "<?php echo $signals['print']['title_for']; ?>" + s.find('div.title').text() : '<?php echo $signals['print']['title_all']; ?>',
                        text: "<i class='print icon'></i> <?php echo $signals['print']['button_title']; ?>",
                        exportOptions: {
                            columns: [":nth-child(n)"]
                        }
                    }
                    ), 
                    'pageLength'
                ])
            },
            error: handleAjaxError
        })
    }
    refreshSignalsList = function () {
        v()
    }    
    v();
    var l = $("#signals-list"),
    s = $(".ui.user.search");
    $(s).find('input').on('propertychange change keyup paste input', function() {
        $(this).val().length > 1 || v()
    });
    l.on("click", "button.delete-signal", function () {
        var a = $(this),
        t = $("#modal-signal-delete");
        t.find('input[name="signal_id"]').val(a.data('signal-id'))
        $(".submit.button").removeClass("disabled loading"),
        t.modal("show"),
        t.hasClass("submitting") ? t.removeClass("submitting") : null;
    });
    l.on("click", "button.approve-signal", function () {
        var a = $(this),
        t = $("#modal-signal-approve");
        t.find('input[name="signal_id"]').val(a.data('signal-id'))
        $(".submit.button").removeClass("disabled loading"),
        t.modal("show"),
        t.hasClass("submitting") ? t.removeClass("submitting") : null;
    });
    $("#modal-signal-delete").form({
        on: "blur"
    }).on("submit", function (a) {
        a.preventDefault();
        var e = $(this),
        c = e.data('action');
        f = {};
        if (!e.hasClass("submitting")) {
            e.addClass("submitting");
            e.find(".submit.button").addClass("disabled loading"),
            f['signal_id'] = e.find('input[name="signal_id"]').val();
            $.ajax({
                url: "<?php echo $BASE; ?>/api/actions/signal/" + c,
                method: "POST",
                data: f,
                dataType: "json",
                async: !0,
                cache: !1,
                success: function (a) {
                    $(".submit.button").removeClass("disabled loading"),
                    e.removeClass("submitting"),
                    setTimeout(function () {
                        e.modal('hide')
                    }, 1e3),
                    v()
                },
                error: handleAjaxError
            })
        }
    });
    $("#modal-signal-approve").form({
        on: "blur"
    }).on("submit", function (a) {
        a.preventDefault();
        var e = $(this),
        c = e.data('action');
        f = {};
        if (!e.hasClass("submitting")) {
            e.addClass("submitting");
            e.find(".submit.button").addClass("disabled loading"),
            f['signal_id'] = e.find('input[name="signal_id"]').val();
            $.ajax({
                url: "<?php echo $BASE; ?>/api/actions/signal/" + c,
                method: "POST",
                data: f,
                dataType: "json",
                async: !0,
                cache: !1,
                success: function (a) {
                    $(".submit.button").removeClass("disabled loading"),
                    e.removeClass("submitting"),
                    setTimeout(function () {
                        e.modal('hide')
                    }, 1e3),
                    v()
                },
                error: handleAjaxError
            })
        }
    });
});
</script>