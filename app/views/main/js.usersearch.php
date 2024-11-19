<script type="text/javascript">
  $(document).ready(function () {
    var userSearchOptions = {
      apiSettings: {
        url: '{{ @BASE }}/api/search/user/{query}'
      },
      cache: false,
      error: {
        noResults: "{{ @trade.user.search.no_results }}"
      },
      type: 'users',
      templates: {
        users: formatUserSearchResult
      },
      onSelect: function(result, response) {
        var $form = $(this);
        $form.data('user', result.id);
        $form.data('balance', result.balance);
        var callbackFunctionName = $form.data('callback');
        if (callbackFunctionName) {
          var callbackFunction = window[callbackFunctionName];
          callbackFunction();
        }
      },
      onResultsClose: function(result) {
        var $this = $(this);
        var $search = $this.closest('.ui.user.search');
        if (!$search.find('input').val()) {
          $search.data('user', '');
        }
      },
      minCharacters: 2
    };

    // Init user search dropdown
    $('.ui.user.search').search(userSearchOptions);

    /**
     * Return HTML for stock symbol autocomplete dropdown
     */
    function formatUserSearchResult(response) {
      var result = '';
      if (typeof response.results != 'undefined' && response.results.length) {
        $.each(response.results, function(i, user) {
          var avatar_url = user.avatar ? '{{ @BASE }}/files/avatars/'+user.avatar : '{{ @BASE }}/assets/images/default_avatar.png';
          result += '<a class="result">' +
            '<div class="content">' +
            '<div class="price"><img src="'+avatar_url+'" class="ui avatar image"></div>' +
            '<div class="title">'+user.first_name+' '+user.last_name+'</div>' +
            '<div class="description">'+user.balance.formatNumber()+' '+user.currency+'</div>' +
            '</div>' +
            '</a>'
        });
      }
      return result;
    }
  });
</script>