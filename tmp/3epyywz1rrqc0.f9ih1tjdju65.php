<script type="text/javascript"> 
$(document).ready(function () {
    var o = $("#timezone-dropdown");
    $.each(moment.tz.names(), function (n, e) {
        o.append('<option value="' + e + '" ' + ("<?php echo $USER['timezone']; ?>" == e ? "selected" : "") + ">" + e + "</option>")
    }),
    $(".ui.dropdown").dropdown();
    
    $(".ui.identity-form").form({
        on: "blur"
    }).on("submit", function (e) {
            e.preventDefault();
            var a = $(this),
            b = $(".ui.identity-upload");
            d = new FormData(this),
            t = a.data("action");
            if (a.form("is valid") && !a.hasClass("submitting")) {
                a.addClass("submitting");
                var s = a.find(".ui.result.message");
                s.hide(),
                a.find(".submit.button").addClass("disabled loading"),
                $.ajax({
                    url: "<?php echo $BASE; ?>/api/actions/users/identity/" + t,
                    method: "POST",
                    data: d,
                    dataType: "json",
                    contentType: !1,
                    processData: !1,
                    async: !0,
                    cache: !1,
                    success: function (e) {
                        console.log(e);
                        e && e.success ? s.text(e.message).removeClass("negative").addClass("positive").show() : s.text(e.message).removeClass("positive").addClass("negative").show(),
                        $(".submit.button").removeClass("disabled loading"),
                        setTimeout(function () {
                            s.hide("slow"),
                            e && e.success ? setTimeout(()=>{ location.reload() }, 5e2) : null
                        }, 5e3),
                        a.removeClass("submitting")
                    },
                    error: handleAjaxError
                })
            }
        })
});
</script>