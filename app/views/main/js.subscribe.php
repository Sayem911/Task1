<script type="text/javascript">
  $(document).ready(function () {
    var validationRulesSubscription = {
      rules: [
        {
          type: 'empty'
        }
      ]
    };

    $('#form-subscription')
      .form({
        fields: {
          subscription: validationRulesSubscription
        }
      });

    $('.ui.dropdown').dropdown();
  });
</script>