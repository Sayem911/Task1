<script type="text/javascript">
  $(document).ready(function () {
    var $usersListTable = $('#users-list');
    var usersPerPage = parseInt('{{ @ADMIN.USERS_PER_PAGE }}', 10);
    var validationRulesFirstName = {
      rules: [
        {
          type: 'empty',
          prompt: '{{ @signup.form.validation.first_name }}'
        }
      ]
    };

    var validationRulesLastName = {
      rules: [
        {
          type: 'empty',
          prompt: '{{ @signup.form.validation.last_name }}'
        }
      ]
    };

    var validationRulesEmail = {
      rules: [
        {
          type: 'empty',
          prompt: '{{ @login.form.validation.empty_email }}'
        },
        {
          type: 'email',
          prompt: '{{ @login.form.validation.valid_email }}'
        }
      ]
    };

    var validationRulesBalance = {
      rules: [
        {
          type: 'number',
          prompt: '{{ @users.funds.validation }}'
        }
      ]
    };

    $usersListTable.initDataTable(usersPerPage, [[5,'desc']], true, false, [
      $.extend(true, {}, {
        exportOptions: {
          format: {
            body: function ( data, row, column, node ) {
              if (column === 0) {
                return $(data).find('.export-user-name').text();
              } else if (column === 1) {
                return $(data).text();
              }
              return data;
            }
          }
        }
      }, {
        extend: 'csvHtml5',
        title: 'users-export',
        text: '{{ @users.export.csv }}',
        exportOptions: {
          columns: [ ':not(:first-child)' ]
        }
      })
    ]);

    $('#form-add-user')
      .form({
        on: 'blur',
        fields: {
          first_name: validationRulesFirstName,
          last_name: validationRulesLastName,
          email: validationRulesEmail,
          balance: validationRulesBalance
        }
      })
      .on('submit', function(e) {
        e.preventDefault();
        var $form = $(this);
        if ($form.form('is valid') && !$form.hasClass('submitting')) {
          $form.addClass('submitting');
          var $message = $form.find('.ui.result.message');
          var userData = {};
          $message.hide();
          $form.find('.submit.button').addClass('disabled loading');
          // fill POST params
          $form.find('input').each(function (i, element) {
            var value = $form.form('get value', element.name);
            userData[element.name] = typeof value == 'boolean' && !value ? '' : value;
          });

          $.ajax({
            url: '{{ @BASE }}/api/actions/users/add',
            method: 'POST',
            data: userData,
            dataType: 'json',
            async: true,
            cache: false,
            success: function (response) {
              if (response && response.success) {
                $message.text(response.message).removeClass('negative').addClass('positive').show();
                $form[0].reset();
              } else {
                $message.text(response.message).removeClass('positive').addClass('negative').show();
              }
              $('.submit.button').removeClass('disabled loading');
              setTimeout(function () {
                $message.hide('slow');
              }, 3000);
              $form.removeClass('submitting');
            },
            error: handleAjaxError
          });
        }
      });

    $('.ui.action.modal form')
      .form({
        on: 'blur',
        fields: {
          first_name: validationRulesFirstName,
          last_name: validationRulesLastName,
          email: validationRulesEmail,
          balance: validationRulesBalance
        }
      })
      // send POST request to server
      .on('submit', function(e) {
        e.preventDefault();
        var $form = $(this);
        var action = $form.data('action');
        // additional check to prevent double submissions
        if ($form.form('is valid') && !$form.hasClass('submitting')) {
          $form.addClass('submitting');
          var $message = $form.find('.ui.result.message');
          var userData = {};
          $message.hide();
          $form.find('.submit.button').addClass('disabled loading');
          // fill POST params
          $form.find('input').each(function (i, element) {
            var value = $form.form('get value', element.name);
            userData[element.name] = typeof value == 'boolean' && !value ? '' : value;
          });

          $.ajax({
            url: '{{ @BASE }}/api/actions/users/'+action,
            method: 'POST',
            data: userData,
            dataType: 'json',
            async: true,
            cache: false,
            success: function (response) {
              if (response && response.success) {
                $message.text(response.message).removeClass('negative').addClass('positive').show();
              } else {
                $message.text(response.message).removeClass('positive').addClass('negative').show();
              }
              $('.submit.button').removeClass('disabled loading');
              setTimeout(function () {
                $message.hide('slow');
              }, 3000);
              $form.removeClass('submitting');
            },
            error: handleAjaxError
          });
        }
      });

    $('#modal-add-user').modal('attach events', '#add-user');
    $('#modal-add-user, .ui.action.modal').modal({
      // refresh user data after modal is closed
      onHide: function () {
//        getUsersList(usersListCurrentPage);
      }
    });
    $('.ui.checkbox').checkbox();

    $('#users-list').on('click', 'button.edit-user', function () {
      var $button = $(this);
      var $modal = $('#modal-edit-user');
      $modal.modal('show');
      $modal.find('input[name="id"]').val($button.data('id'));
      $modal.find('input[name="first_name"]').val($button.data('first-name'));
      $modal.find('input[name="last_name"]').val($button.data('last-name'));
      $modal.find('input[name="email"]').val($button.data('email'));
      $modal.find('input[name="phone"]').val($button.data('phone'));
      $modal.find('input[name="password"]').val('');
      if ($button.data('blocked')) {
        $modal.find('.blocked').checkbox('set checked');
      } else {
        $modal.find('.blocked').checkbox('set unchecked');
      }
      if ($button.data('g2fa-enabled')) {
        $modal.find('.g2fa-enabled"').checkbox('set checked');
      } else {
        $modal.find('.g2fa-enabled"').checkbox('set unchecked');
      }
    });

    $('#users-list').on('click', 'button.add-remove-funds', function () {
      var $button = $(this);
      var $modal = $('#modal-add-remove-funds');
      $modal.modal('show');
      $modal.find('input[name="id"]').val($button.data('id'));
      $modal.find('.labeled.input .label').text($button.data('currency'));
    });

    $('#users-list').on('click', 'button.delete-user', function () {
      var $button = $(this);
      var $modal = $('#modal-delete-user');
      $modal.modal('show');
      $modal.find('input[name="id"]').val($button.data('id'));
    });
  });
</script>