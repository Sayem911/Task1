<script type="text/javascript">
  $(document).ready(function () {
    var YQL_ENDPOINT = 'https://query.yahooapis.com/v1/public/yql?q={0}&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys';
    var NEWS_FEED_URL = '{{ @MARKETS.NEWS_FEED_URL }}';
    var $watchlistTable = $('table#watchlist');

    // set clocks
    $('#clock1').jClocksGMT({dst: true, offset: '{{ @MARKETS.CLOCK1_OFFSET }}', skin: 4, date: true, dateformat: 'DD MMM'});
    $('#clock2').jClocksGMT({dst: true, offset: '{{ @MARKETS.CLOCK2_OFFSET }}', skin: 4, date: true, dateformat: 'DD MMM'});
    $('#clock3').jClocksGMT({dst: true, offset: '{{ @MARKETS.CLOCK3_OFFSET }}', skin: 4, date: true, dateformat: 'DD MMM'});
    $('#clock4').jClocksGMT({dst: true, offset: '{{ @MARKETS.CLOCK4_OFFSET }}', skin: 4, date: true, dateformat: 'DD MMM'});

    getNews();
    getLiveQuotes(function() {
      $('table#watchlist').initDataTable();
      $('table#most-active').initDataTable(10, [[5,'desc']]);
      // table is hidden by default, display it after initialization
      $watchlistTable.show();
    });

    /**
     * Get news headlines from API
     */
    function getNews() {
      var url = String.format(YQL_ENDPOINT, encodeURIComponent('SELECT * FROM feed WHERE url="'+NEWS_FEED_URL+'"'));
      $.ajax({
        url: url,
        dataType: 'json',
        async: true,
        cache: false,
        success: displayNews,
        error: handleAjaxError
      });
    }

    $watchlistTable.on('click', '.remove-from-watchlist', function() {
      var $this = $(this);
      var symbol = $this.data('symbol');
      $this.addClass('disabled');
      $.ajax({
        url: '{{ @BASE }}/api/actions/watchlist/remove/' + symbol,
        dataType: 'json',
        async: true,
        cache: false,
        success: function (response) {
          log('watchlist', response);
          if (response && response.success) {
            $this.closest('tr').remove();
            if ($watchlistTable.find('tbody tr').length == 0) {
              $watchlistTable.after("<p>{{ @markets.watchlist.empty }}</p>");
              $watchlistTable.remove();
            }
          }
        },
        error: handleAjaxError
      });
    });

    /**
     * Display and rotate news, the following plugin is used: http://aamirafridi.com/jquery/jquery-marquee-plugin
     * @param response
     */
    function displayNews(response) {
      log('displayNews', response);
      var newsHtml = '';

      if (typeof response.query != 'undefined' && typeof response.query.count != 'undefined' && response.query.count>0 && response.query.results.item.length > 0) {
        $.each(response.query.results.item, function(i, news) {
          newsHtml += '<span class="ui header"><a href="'+news.origLink+'" target="_blank">' + news.title + '</a></span>';
        });
        $('#news-ticker')
          .append(newsHtml)
          .marquee({
            duplicated: true,
            duration: 25000,
            pauseOnHover: true,
            startVisible: true
          });
      }
    }
  });
</script>