<script type="text/javascript"> 
$(document).ready(function () {
        var e = $("#users-list"),
        a = parseInt("<?php echo $ADMIN['USERS_PER_PAGE']; ?>", 10),
        t = {
            rules: [{
                    type: "empty",
                    prompt: "<?php echo $signup['form']['validation']['first_name']; ?>"
                }
            ]
        },
        s = {
            rules: [{
                    type: "empty",
                    prompt: "<?php echo $signup['form']['validation']['last_name']; ?>"
                }
            ]
        },
        i = {
            rules: [{
                    type: "empty",
                    prompt: "<?php echo $login['form']['validation']['empty_email']; ?>"
                }, {
                    type: "email",
                    prompt: "<?php echo $login['form']['validation']['valid_email']; ?>"
                }
            ]
        },
        n = {
            rules: [{
                    type: "number",
                    prompt: "<?php echo $users['funds']['validation']; ?>"
                }
            ]
        };
        e.initDataTable(a, [[5, "desc"]], !0, !1, [$.extend(!0, {}, {
            exportOptions: {
                format: {
                    body: function (e, a, t, s) {
                        return 0 === t ? $(e).find(".export-user-name").text() : 1 === t ? $(e).text() : e
                    }
                }
            }
        }, {
                extend: "print",
                title: "<?php echo $users['print']['title']; ?>",
                text: "<?php echo $users['print']['text']; ?>",
                exportOptions: {
                    columns: [":not(:first-child)"]
                }
            }
            ), 'pageLength']),
        $("#form-add-user").form({
            on: "blur",
            fields: {
                first_name: t,
                last_name: s,
                email: i,
                balance: n
            }
        }).on("submit", function (e) {
            e.preventDefault();
            var a = $(this);
            if (a.form("is valid") && !a.hasClass("submitting")) {
                a.addClass("submitting");
                var t = a.find(".ui.result.message"),
                s = {};
                t.hide(),
                a.find(".submit.button").addClass("disabled loading"),
                a.find("input").each(function (e, t) {
                    var i = a.form("get value", t.name);
                    s[t.name] = "boolean" != typeof i || i ? i : ""
                }),
                $.ajax({
                    url: "<?php echo $BASE; ?>/api/actions/users/add",
                    method: "POST",
                    data: s,
                    dataType: "json",
                    async: !0,
                    cache: !1,
                    success: function (e) {
                        e && e.success ? (t.text(e.message).removeClass("negative").addClass("positive").show(), a[0].reset()) : t.text(e.message).removeClass("positive").addClass("negative").show(),
                        $(".submit.button").removeClass("disabled loading"),
                        setTimeout(function () {
                            t.hide("slow")
                        }, 3e3),
                        a.removeClass("submitting")
                    },
                    error: handleAjaxError
                })
            }
        }),
        $(".ui.action.modal form").form({
            on: "blur",
            fields: {
                first_name: t,
                last_name: s,
                email: i,
                balance: n
            }
        }).on("submit", function (e) {
            e.preventDefault();
            var a = $(this),
            t = a.data("action");
            if (a.form("is valid") && !a.hasClass("submitting")) {
                a.addClass("submitting");
                var s = a.find(".ui.result.message"),
                i = {};
                s.hide(),
                a.find(".submit.button").addClass("disabled loading"),
                a.find("input").each(function (e, t) {
                    var s = a.form("get value", t.name);
                    i[t.name] = "boolean" != typeof s || s ? s : ""
                }),
                $.ajax({
                    url: "<?php echo $BASE; ?>/api/actions/users/" + t,
                    method: "POST",
                    data: i,
                    dataType: "json",
                    async: !0,
                    cache: !1,
                    success: function (e) {
                        e && e.success ? s.text(e.message).removeClass("negative").addClass("positive").show() : s.text(e.message).removeClass("positive").addClass("negative").show(),
                        $(".submit.button").removeClass("disabled loading"),
                        setTimeout(function () {
                            s.hide("slow")
                        }, 3e3),
                        a.removeClass("submitting")
                    },
                    error: handleAjaxError
                })
            }
        }),
        $("#tab-identity").find('.button').on('click', function(e){
            var a = $('#tab-identity form'),
            b = $(e.target);
            t = a.data('action'),
            s = a.find('.ui.result.message'),
            i = b.data('id'),
            u = b.data('status'),
            f = {};
            f['status'] = u;
            f['id'] = i;
            b.addClass("disabled loading"),
            $.ajax({
                url: "<?php echo $BASE; ?>/api/actions/users/identity/" + t,
                method: "POST",
                data: f,
                dataType: "json",
                async: !0,
                cache: !1,
                success: function (e) {
                    e && e.success ? s.text(e.message).removeClass("negative").addClass("positive").show() : s.text(e.message).removeClass("positive").addClass("negative").show(),
                    b.removeClass("disabled loading"),
                    setTimeout(function () {
                        s.hide("slow")
                    }, 4e3)
                },
                error: handleAjaxError
            })
        })
        $("#modal-add-user").modal("attach events", "#add-user"),
        $("#modal-add-user, .ui.action.modal").modal({
            onHide: function () {
                location.reload()
            }
        }),
        $("#modal-edit-user, .ui.action.modal").modal({
            onHide: function () {
                location.reload()
            }
        }),
        $("#modal-add-remove-funds, .ui.action.modal").modal({
            onHide: function () {
                location.reload()
            }
        }),
        $(".ui.checkbox").checkbox(),
        $("#users-list").on("click", "button.edit-user", function () {
            var e = $(this),
            a = $("#modal-edit-user");
            console.log(e);
            a.modal("show"),
            a.find('input[name="id"]').val(e.data("id")),
            a.find('input[name="first_name"]').val(e.data("first-name")),
            a.find('input[name="last_name"]').val(e.data("last-name")),
            a.find('input[name="email"]').val(e.data("email")),
            a.find('input[name="phone"]').val(e.data("phone")),
            a.find('input[name="land_phone"]').val(e.data("land-phone")),
            a.find('input[name="fax"]').val(e.data("fax")),
            a.find('input[name="street_nr"]').val(e.data("streetnr")),
            a.find('input[name="post_nr"]').val(e.data("postnr")),
            a.find('input[name="town"]').val(e.data("town")),
            a.find('input[name="password"]').val(""),
            a.find('.ui.approve-button').data('id', e.data('id')),
            a.find('.ui.update-request-button').data('id', e.data('id')),
            a.find('.identity-document a').attr('href', '/files/ids/'+e.data("identity")),
            a.find('.identity-document a').attr('title', e.data("first-name") + ' ' + e.data("last-name")),
            a.find('.identity-document a img').attr('title', e.data("first-name") + ' ' + e.data("last-name")),
            a.find('.identity-document a img').attr('src', '/files/ids/'+e.data("identity"));
            
            if(e.data("identity") == '' || (e.data("identity") != '' && e.data("status") == 0)){
                a.find('.identity-document').hide(),
                a.find('.approved-text').hide(),
                a.find('.approval-buttons').hide(),
                a.find('.document-not-found').show()
            }else if(e.data("status") == 1){
                a.find('.document-not-found').hide(),
                a.find('.approved-text').hide(),
                a.find('.identity-document').show(),
                a.find('.approval-buttons').show(),
                a.find('.identity-document a').attr('href', '/files/ids/'+e.data("identity")),
                a.find('.identity-document a img').attr('src', '/files/ids/'+e.data("identity"))
            }else if(e.data("status") == 2) {
                a.find('.document-not-found').hide(),
                a.find('.identity-document').show(),
                a.find('.approval-buttons').hide(),
                a.find('.approved-text').show()
            }
            e.data("blocked") ? a.find(".blocked").checkbox("set checked") : a.find(".blocked").checkbox("set unchecked"),
            e.data("g2fa-enabled") ? a.find(".g2fa-enabled").checkbox("set checked") : a.find(".g2fa-enabled").checkbox("set unchecked"),
            $(".identity-document a").fancybox({
              helpers: {
                  title : {
                      type : 'float'
                  }
              }
            });  
        }),
        $("#users-list").on("click", "button.add-remove-funds", function () {
            var e = $(this),
            a = $("#modal-add-remove-funds");
            a.modal("show"),
            a.find('input[name="id"]').val(e.data("id")),
            a.find(".labeled.input .label").text(e.data("currency"))
        }),
        $("#users-list").on("click", "button.delete-user", function () {
            var e = $(this),
            a = $("#modal-delete-user");
            a.modal("show"),
            a.find('input[name="id"]').val(e.data("id"))
        }),
        $("#account-details-menu .item").tab()
    });
</script>