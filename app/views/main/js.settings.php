<script type="text/javascript">
  $(document).ready(function () {
    // fill timezone selection dropdown
    var $timezone = $('#timezone-dropdown');
    $.each(moment.tz.names(), function (i, timezone) {
      $timezone.append('<option value="' + timezone + '" ' + (timezone == '{{ @SITE.TIMEZONE }}' ? 'selected' : '') + '>' + timezone + '</option>');
    });

    $('#settings-tabs-menu .item').tab();
    $('.ui.dropdown').dropdown();
    $('.ui.toggle.checkbox').checkbox({
      // unset checkboxes are not POSTed, so adding a hidden input to post the checkbox field if it's disabled.
      onChecked: function() {
        $(this).val(1).parent().find('input[type=hidden]').prop('disabled', true);
        // enable conditional fields
        $(this).closest('.state-changing').closest('.fields-group').find('.field').not('.state-insensitive').removeClass('disabled');
      },
      onUnchecked: function() {
        $(this).val(0).parent().find('input[type=hidden]').prop('disabled', false);
        // disable conditional fields
        $(this).closest('.state-changing').closest('.fields-group').find('.field').not('.state-insensitive').addClass('disabled');
      }
    });

    $('.question.icon').popup();
  });
</script>