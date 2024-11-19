<script type='text/javascript'>
  $(document).ready(function () {

    var validationRulesPassword = {
      rules: [
        {
          type: 'empty',
          prompt: '{{ @login.form.validation.empty_password }}'
        },
        {
          type: 'minLength[6]',
          prompt: '{{ @login.form.validation.valid_password }}'
        }
      ]
    };

    var validationRulesPassword2 = {
      rules: [
        {
          type   : 'match[new_password]',
          prompt : '{{ @password.reset.form.passwords.not.equal }}'
        }
      ]
    };

    $('.form').form({
      on: 'blur',
      fields: {
        old_password: validationRulesPassword,
        new_password: validationRulesPassword,
        new_password2: validationRulesPassword2
      }
    });
  });
</script>