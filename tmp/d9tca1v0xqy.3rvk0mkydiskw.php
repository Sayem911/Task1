<script type="text/javascript"> 
$(document).ready(function () {
    function a(a) {
        var s = "";
        return "undefined" != typeof a.results && a.results.length && $.each(a.results, function (a, e) {
            var r = e.avatar ? "<?php echo $BASE; ?>/files/avatars/" + e.avatar : "<?php echo $BASE; ?>/assets/images/default_avatar.png";
            s += '<a class="result"><div class="content"><div class="price"><img src="' + r + '" class="ui avatar image"></div><div class="title">' + e.first_name + " " + e.last_name + '</div><div class="description">' + e.balance.formatNumber() + " " + e.currency + "</div></div></a>"
        }),
        s
    }
    var s = {
        apiSettings: {
            url: "<?php echo $BASE; ?>/api/search/user/{query}"
        },
        cache: !1,
        error: {
            noResults: "<?php echo $trade['user']['search']['no_results']; ?>"
        },
        type: "users",
        templates: {
            users: a
        },
        onSelect: function (a, s) {
            var e = $(this);
            e.data("user", a.id),
            e.data("balance", a.balance);
            var r = e.data("callback");
            if (r) {
                var t = window[r];
                t()
            }
        },
        onResultsClose: function (a) {
            var s = $(this),
            e = s.closest(".ui.user.search");
            e.find("input").val() || e.data("user", "")
        },
        minCharacters: 2
    };
    $(".ui.user.search").search(s)
});
</script>