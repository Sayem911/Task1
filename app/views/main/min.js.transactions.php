<check if="{{ @USER.is_admin }}">
<script type="text/javascript">
$(document).ready(function () {
    moment.locale();
    function v() {
        var a = s.data("user");
        $.ajax({
            url: "{{ @BASE }}/api/data/depot/history" + (a ? "/" + a : ""),
            method: "GET",
            dataType: "json",
            async: !0,
            cache: !1,
            success: function (a) {
                if (log("displayTransactionsHistory", a), l.destroyDataTable(), l.find("tbody").empty(), a && a.length) {
                    var t = "";
                    $.each(a, function (a, e) {
                        t += '<tr class="' + (e.processed ? 'positive':'negative') + '"><td class="center aligned">' + (e.processed ? '<i class="check circle outline icon" title="'+moment(e.processed).format("DD MMMM YYYY HH:mm:ss")+'"></i>' : '<i class="hourglass half icon" title="{{ @depot.transactions.waiting }}"></i>')  + '</td><td>' + e.first_name + ' ' + e.last_name + '</td><td>' + (e.type == 0?'{{ @depot.transactions.withdraw }}':'{{ @depot.transactions.deposit }}') + "</td><td>" + floatVal(e.amount).formatNumber() +  "</td><td class='center aligned'>" + moment(e.date).format('DD MMMM YYYY') + '</td><td class="center aligned">' + e.time + '</td><td class="center aligned"><a href="' + 'files/docs/' + e.doc_path + '" target="_blank"><i class="download icon"></i></a></td><td class="center aligned">' + (e.processed ? moment(e.processed).format('DD MMMM YYYY HH:mm') : '{{ @depot.transactions.waiting }}')  + '</td><td class="depot-actions center aligned"><div class="button-container"><button class="ui basic circular icon edit-transaction-button button" data-depot-id="' + e.t_id.replace('id','') + '" data-user-id="' + e.user_id + '" data-type="' + e.type + '" data-amount="' + e.amount + '" data-date="' + e.date + '" data-time="' + e.time + '" data-docpath="' + e.doc_path + '" data-notes="' + e.notes + '" data-status="' + e.status + '"><i class="pencil icon"></i></button></div><div class="button-container"><button class="ui basic circular icon delete-transaction-button button" data-depot-id="' + e.t_id.replace('id','') + '"><i class="trash icon"></i></button></div></td></tr>'
                    }),
                    l.find("tbody").append(t)
                }
                l.initDataTable(10, [[7, "desc"],[4, "desc"],[5,"desc"]], !0, null, [$.extend(!0, {}, {
                        extend: "print",
                        autoPrint: !1,
                        title: "{{ @depot.transactions.printfor_title }}" + (s.find('div.title').text() ? s.find('div.title').text() : '{{ @USER.first_name." ".@USER.last_name }}'),
                        text: "<i class='print icon'></i> {{ @portfolio.positions.print }}",
                        exportOptions: {
                            columns: [":not(:nth-child(1)):not(:nth-child(7))"]
                        }
                    }
                    ), 
                    'pageLength'
                ])
            },
            error: handleAjaxError
        })
    }
    function u() {
        $.ajax({
            url: "{{ @BASE }}/api/data/depot/history",
            method: "GET",
            dataType: "json",
            async: !0,
            cache: !1,
            success: function (a) {
                if (log("displayTransactionsHistory", a), l.destroyDataTable(), l.find("tbody").empty(), a && a.length) {
                    var t = "";
                    $.each(a, function (a, e) {
                        t += '<tr class="' + (e.processed ? 'positive':'negative') + '"><td class="center aligned">' + (e.processed ? '<i class="check circle outline icon" title="'+moment(e.processed).format("DD MMMM YYYY HH:mm:ss")+'"></i>' : '<i class="hourglass half icon" title="{{ @depot.transactions.waiting }}"></i>')  + '</td><td>' + e.first_name + ' ' + e.last_name + '</td><td>' + (e.type == 0?'{{ @depot.transactions.withdraw }}':'{{ @depot.transactions.deposit }}') + "</td><td>" + floatVal(e.amount).formatNumber() +  "</td><td class='right aligned'>" + moment(e.date).format('DD MMMM YYYY') + '</td><td class="left aligned">' + e.time + '</td><td class="center aligned"><a href="' + 'files/docs/' + e.doc_path + '" target="_blank"><i class="download icon"></i></a></td><td class="center aligned">' + (e.processed ? moment(e.processed).format('DD MMMM YYYY HH:mm') : '{{ @depot.transactions.waiting }}')  + '</td><td class="depot-actions right aligned"><div class="button-container"><button class="ui basic circular icon edit-transaction-button button" data-depot-id="' + e.t_id.replace('id','') + '" data-type="' + e.type + '" data-user-id="' + e.user_id + '" data-amount="' + e.amount + '" data-date="' + e.date + '" data-time="' + e.time + '" data-docpath="' + e.doc_path + '" data-notes="' + e.notes + '" data-status="' + e.status + '"><i class="pencil icon"></i></button></div><div class="button-container"><button class="ui basic circular icon delete-transaction-button button" data-depot-id="' + e.t_id.replace('id','') + '"><i class="trash icon"></i></button></div></td></tr>'
                    }),
                    l.find("tbody").append(t)
                }
                l.initDataTable(10, [[7, "desc"],[4, "desc"],[5,"desc"]], !0, null, [$.extend(!0, {}, {
                        extend: "print",
                        autoPrint: !1,
                        title: "{{ @depot.transactions.printall_title }}",
                        text: "<i class='print icon'></i> {{ @portfolio.positions.print }}",
                        exportOptions: {
                            columns: [":not(:nth-child(1)):not(:nth-child(7))"]
                        }
                    }
                    ), 
                    'pageLength'
                ])
            },
            error: handleAjaxError
        })
    }
    function c(){
        $.ajax({
            url: "{{ @BASE }}/api/data/depot/upcount",
            method: "GET",
            dataType: "json",
            async: !0,
            cache: !1,
            success: function (a) {
                a.message && parseInt(a.message) > 0 ? (n.show(), n.text(a.message)) : n.hide()
            },
            error: handleAjaxError
        })
    }
    var l = $("#transactions-list"),
    n = $('#main-menu').find('div.ui.label.unprocessed-depot-count'),
    w = $('#transactions-wrapper'),
    s = w.find('.ui.user.search'),
    d = w.find('.ui.dropdown');
    c();
    l.on("click", ".delete-transaction-button", function () {
        var a = $(this),
        t = $("#modal-depot-delete");
        $(".submit.button").removeClass("disabled loading"),
        t.modal("show"),
        t.hasClass("submitting") ? t.removeClass("submitting") : null,        
        t.find('input[name="depot_id"]').val(a.data("depot-id"))
    });
    $("#modal-depot-delete").form({
        on: "blur"
    }).on("submit", function (a) {
        a.preventDefault();
        var e = $(this),
        f = {};
        if (!e.hasClass("submitting")) {
            e.addClass("submitting");
            e.find(".submit.button").addClass("disabled loading"),
            f['depot_id'] = e.find('input[name="depot_id"]').val();
            $.ajax({
                url: "{{ @BASE }}/api/actions/depot/delete",
                method: "POST",
                data: f,
                dataType: "json",
                async: !0,
                cache: !1,
                success: function (a) {
                    $(".submit.button").removeClass("disabled loading"),
                    e.removeClass("submitting"),
                    c(),
                    d && (d.dropdown('get value') == 'all' || d.dropdown('get value') == '') ? u() : v(), 
                    setTimeout(function () {
                        e.modal('hide')
                    }, 1e3)
                },
                error: handleAjaxError
            })
        }
    });
    $(".revert.button").click(function(e){
        var e = $("#modal-depot-update"),
        f = {};
        r = e.find(".ui.result.message");
        if (!e.hasClass("submitting")) {
            e.addClass("submitting");
            e.find(".submit.button").addClass("disabled loading"),
            f['depot_id'] = e.find('input[name="depot_id"]').val();
            f['status'] = 0;
            r.hide(),
            $.ajax({
                url: "{{ @BASE }}/api/actions/depot/update",
                method: "POST",
                data: f,
                dataType: "json",
                async: !0,
                cache: !1,
                success: function (a) {
                    a && a.success ? r.text(a.message).removeClass("negative").addClass("positive").show() : r.text(a.message).removeClass("positive").addClass("negative").show(),
                    $(".submit.button").removeClass("disabled loading"),
                    a && a.success ? ($(".submit.button").html("{{ @depot.transactions.save }} <i class='checkmark icon'></i>").removeClass("disabled"), $(".revert.button").hide()) : ($(".submit.button").html("{{ @depot.transactions.approved }} <i class='check circle outline icon'></i>").addClass("disabled"), $(".revert.button").show()),
                    setTimeout(function () {
                        r.hide("slow")
                    }, 3e3),
                    e.removeClass("submitting"),
                    c(),
                    d && (d.dropdown('get value') == 'all' || d.dropdown('get value') == '') ? u() : v()
                },
                error: handleAjaxError
            })
        }
    });
    l.on("click", ".edit-transaction-button", function () {
        var a = $(this),
        t = $("#modal-depot-update");
        t.modal("show"),
        t.find('input[name="depot_id"]').val(a.data("depot-id")),
        t.find('input[name="amount"]').val(floatVal(a.data("amount")).formatNumber()),
        t.find('a[name="doc_path"]').attr('href','files/docs/'+a.data("docpath")),
        t.find('input[name="type"]').val(a.data("type") == 0 ? 'Disbursement':'Deposit'),
        t.find('input[name="date"]').val(moment(a.data("date")).format('YYYY-MM-DD')),
        t.find('input[name="time"]').val(a.data("time")),
        t.find('textarea[name="notes"]').text(a.data("notes"));
        a.data("status") && a.data("status") == 1 ? ($(".submit.button").html("{{ @depot.transactions.approved }} <i class='check circle outline icon'></i>").addClass("disabled"), $(".revert.button").show()) : ($(".submit.button").html("{{ @depot.transactions.save }} <i class='checkmark icon'></i>").removeClass("disabled"), $(".revert.button").hide());
    });
    $("#modal-depot-update").form({
        on: "blur"
    }).on("submit", function (a) {
        a.preventDefault();
        var e = $(this),
        f = {},
        r = e.find(".ui.result.message");
        if (!e.hasClass("submitting")) {
            e.addClass("submitting");
            e.find(".submit.button").addClass("disabled loading"),
            f['depot_id'] = e.find('input[name="depot_id"]').val();
            f['status'] = 1;
            r.hide(),
            $.ajax({
                url: "{{ @BASE }}/api/actions/depot/update",
                method: "POST",
                data: f,
                dataType: "json",
                async: !0,
                cache: !1,
                success: function (a) {
                    a && a.success ? r.text(a.message).removeClass("negative").addClass("positive").show() : r.text(a.message).removeClass("positive").addClass("negative").show(),
                    $(".submit.button").removeClass("disabled loading"),
                    a && a.success ? ($(".submit.button").html("{{ @depot.transactions.approved }} <i class='check circle outline icon'></i>").addClass("disabled"), $(".revert.button").show()) : ($(".submit.button").html("{{ @depot.transactions.save }} <i class='checkmark icon'></i>").removeClass("disabled"), $(".revert.button").hide()),
                    setTimeout(function () {
                        r.hide("slow")
                    }, 3e3),
                    e.removeClass("submitting"),
                    c(),
                    d && (d.dropdown('get value') == 'all' || d.dropdown('get value') == '') ? u() : v()
                },
                error: handleAjaxError
            })
        }
    });
    refreshTransactionsList = function () {
        v()
    }
    u();
    s.hide();
    d.dropdown({
        onChange: function(v, t, $i) {
          if(v == 'all'){
            s.hide(),
            u()
          }else if(v == 'search'){
            s.show()
          }
        }
    })
});
</script>    
</check>
<check if="{{ !@USER.is_admin }}">
<script type = "text/javascript"> 
$(document).ready(function () {
    moment.locale();
    function u() {
        $.ajax({
            url: "{{ @BASE }}/api/data/depot/history",
            method: "GET",
            dataType: "json",
            async: !0,
            cache: !1,
            success: function (a) {
                if (log("displayTransactionsHistory", a), l.destroyDataTable(), l.find("tbody").empty(), a && a.length) {
                    var t = "";
                    $.each(a, function (a, e) {
                        t += '<tr class="' + (e.processed ? 'positive':'negative') + '"><td class="center aligned">' + (e.processed ? '<i class="check circle outline icon" title="'+moment(e.processed).format("DD MMMM YYYY HH:mm:ss")+'"></i>' : '<i class="hourglass half icon" title="Waiting"></i>')  + '</td><td>' + (e.type == 0?'{{ @depot.transactions.withdraw }}':'{{ @depot.transactions.deposit }}') + "</td><td>" + floatVal(e.amount).formatNumber() +  "</td><td class='right aligned'>" + moment(e.date).format('DD MMMM YYYY') + '</td><td class="left aligned">' + e.time + '</td><td class="center aligned"><a href="' + 'files/docs/' + e.doc_path + '" target="_blank">view</a></td><td class="center aligned">' + (e.processed ? moment(e.processed).format('DD MMMM YYYY HH:mm') : '{{ @depot.transactions.waiting }}')  + '</td></tr>'
                    }),
                    l.find("tbody").append(t)
                }
                l.initDataTable(10, [[6,"desc"],[3, "desc"],[4,"desc"]], !0, null, [$.extend(!0, {}, {
                        extend: "print",
                        autoPrint: !1,
                        title: "{{ @depot.transactions.printfor_title }}" + "{{ @USER.first_name.' '.@USER.last_name }}",
                        text: "<i class='print icon'></i> {{ @portfolio.positions.print }}",
                        exportOptions: {
                            columns: [":not(:nth-child(1)):not(:nth-child(6))"]
                        }
                    }
                    ), 
                    'pageLength'
                ])
            },
            error: handleAjaxError
        })
    }
    var l = $("#transactions-list"),
    w = $('#transactions-wrapper');
    u();
    $("#depot").on('click', function(){
        var x = $("#modal-depot"),
        y = $("#modal-depot .ui.dropdown");
        x.find('input[name="date"]').val(moment(new Date()).format('YYYY-MM-DD'));
        x.find('input[name="time"]').val(moment(new Date()).format('HH:mm'));
        y.dropdown();
        x.modal("show");
    });
    $("#modal-depot").form({
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
                url: "{{ @BASE }}/api/actions/depot/save",
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
    })
});
</script>
</check>