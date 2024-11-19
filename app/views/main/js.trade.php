<script type="text/javascript">
  $(document).ready(function () {
    var HISTORICAL_DATA_ENDPOINT = '{{ @BASE }}/api/data/history/';
    var YQL_ENDPOINT = 'https://query.yahooapis.com/v1/public/yql?q={0}&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys';
    var NEWS_HEADLINES_URL = 'http://{{ @vars.yahoo_rss_lang_domain }}finance.yahoo.com/rss/headline?s=';
    var currentSymbol = $('#symbol-search input').val();
    var currentSymbolExchangeCode = $('#symbol-search input').data('exchange-code');
    var $newsContainer = $('#tab-news .items');
    var $chartContainer = $('#stock-chart');
    var $chartLoader = $('#stock-chart-loader');
    var $stockComparisonForm = $('#stock-comparison-form');
    var chart;
    var comparisonSymbols = [];
    var $tradeForm = $('#trade-form');
    var backgroundColor = $('body').css('backgroundColor');
    var primaryColor = $('#main-menu').css('backgroundColor');
    var secondaryColor = '#000';
    if (backgroundColor == 'rgb(0, 0, 0)') {
      primaryColor = '#fff';
      secondaryColor = '#fff';
    }

    var stockSearchOptions = {
      apiSettings: {
        url: '{{ @BASE }}/api/search/asset/{query}'
      },
      cache: false,
      error: {
        noResults: '{{ @trade.symbol.search.no_results }}'
      },
      type: 'stocks',
      templates: {
        stocks: formatSymbolSearchResult
      },
      onSelect: changeActiveSymbol,
      minCharacters: 2,
      maxResults: 25
    };

    var comparisonStockSearchOptions = {
      apiSettings: {
        url: '{{ @BASE }}/api/search/asset/{query}'
      },
      error: {
        noResults: '{{ @trade.symbol.search.no_results }}'
      },
      type: 'stocks',
      templates: {
        stocks: formatSymbolSearchResult
      },
      onSelect: chartAddComparison,
      minCharacters: 2,
      maxResults: 25
    };

    // initialize tabs
    var tab = $('#stock-tabs-menu .item').tab({
      // when tab is loaded (clicked)
      onLoad: function (clickedTabName) {
        // handle switching betwee tabs
        // don't do anything for the moment
      },
      // refresh sticky content, otherwise it may not properly work due to different inner height of tabs
      // See more: http://stackoverflow.com/questions/37748736/semantic-ui-sticky-tab-menu-bug
      onVisible: function() {
        $('.ui.sticky').sticky('refresh');
      }
    });

    $('.add-to-watchlist').on('click', function() {
      var $this = $(this);

      if (!$this.hasClass('disabled')) {
        var action = $this.hasClass('watching') ? 'remove' : 'add';
        $this.addClass('disabled loading');

        $.ajax({
          url: '{{ @BASE }}/api/actions/watchlist/'+action+'/'+currentSymbol,
          dataType: 'json',
          async: true,
          cache: false,
          success: function (response) {
            if (response && response.success) {
              if (action == 'add') {
                $this.removeClass('basic loading disabled').addClass('watching');
                $this.html('<i class="star icon"></i> '+"{{ @trade.symbol.watching }}");
              } else if (action == 'remove') {
                $this.removeClass('loading disabled watching').addClass('basic');
                $this.html('<i class="star icon"></i> '+"{{ @trade.symbol.watch }}");
              }
            } else {
              $this.removeClass('loading disabled');
            }
          },
          error: handleAjaxError
        });
      }
    });

    var chartOptions = {
      type: 'stock',

      categoryAxesSettings: {
        minPeriod: 'DD',
        color: secondaryColor,
        gridColor: primaryColor, // vertical grid color
        gridAlpha: 0.1,
        gridThickness: 1,
        equalSpacing: true // skip time gaps
      },

      dataSets: [{
        title: currentSymbol,
        fieldMappings: [{
          fromField: 'value',
          toField: 'value'
        }, {
          fromField: 'volume',
          toField: 'volume'
        }],
        categoryField: 'date'
      }],

      panelsSettings: {
        usePrefixes: true,
        creditsPosition: 'bottom-left'
      },

      panels: [{
        showCategoryAxis: true,
        title: '{{ @trade.chart.title.price }}',
        percentHeight: 70,
        precision: 2,
        drawingIconsEnabled: true,
        eraseAll: true,
        stockGraphs: [ {
          id: 'g1',
          type: 'smoothedLine',
          valueField: 'value',
          lineColor: primaryColor,
          fillAlphas: 0,
          lineThickness: 2,
          comparable: true,
          compareField: 'value',
          balloonText: '[[title]]: <b>[[value]]</b>',
          compareGraphBalloonText: '[[title]]: <b>[[value]]</b>',
          useDataSetColors: false
        }],
        stockLegend: {
          periodValueTextComparing: '[[percents.value.close]]%',
          periodValueTextRegular: '[[value.close]]',
          color: secondaryColor
        },
        valueAxes: [{
          position: 'right',
          color: secondaryColor, // color of values
          gridColor: primaryColor, //horizontal grid line color
          gridAlpha: 0.1,
          gridThickness: 1
        }]
      }, {
        title: '{{ @trade.chart.title.volume }}',
        percentHeight: 30,
        precision: 0,
        stockGraphs: [ {
          valueField: 'volume',
          type: 'column',
          showBalloon: false,
          lineColor: primaryColor,
          fillAlphas: 0.3,
          useDataSetColors: false
        } ],
        stockLegend: {
          periodValueTextRegular: '[[value.close]]'
        },
        valueAxes: [{
          position: 'right'
        }]
      }],

      chartScrollbarSettings: {
        graph: 'g1'
      },

      chartCursorSettings: {
        valueBalloonsEnabled: true,
        graphBulletSize: 1,
        valueLineBalloonEnabled: true,
        valueLineEnabled: true,
        valueLineAlpha: 1,
        categoryBalloonColor: primaryColor,
        categoryBalloonAlpha: 0.8,
        cursorColor: primaryColor,
        cursorAlpha: 0.8
      },

      periodSelector: {
        position: 'top',
        periodsText: '',
        inputFieldsEnabled: false, //disable dates input
        periods: [{
          period: 'MM',
          count: 1,
          label: '{{ @trade.chart.periods[0] }}',
          selected: true
        },{
          period: 'MM',
          count: 3,
          label: '{{ @trade.chart.periods[1] }}',
          selected: true
        },{
          period: 'MM',
          count: 6,
          label: '{{ @trade.chart.periods[2] }}',
          selected: true
        },{
          period: 'YTD',
          label: '{{ @trade.chart.periods[3] }}'
        },{
          period: 'YYYY',
          count: 1,
          label: '{{ @trade.chart.periods[4] }}'
        },{
          period: 'YYYY',
          count: 3,
          label: '{{ @trade.chart.periods[5] }}'
        }, {
          period: 'MAX',
          label: '{{ @trade.chart.periods[6] }}'
        }]
      },

      dataSetSelector: {
        position: '' // leave empty to hide the native dataSet selection control
      },

      comparedDataSets: [],

      export: {
        enabled: true
      }
    };

    // get market data for default symbol when page is loaded
    getLiveQuotes();
    // get data for all tabs
    getSymbolNews();
    initComparisonCheckboxes();
    initEmptyChart();
    getChart();

    // Main stock search dropdown
    $('#symbol-search').search(stockSearchOptions);
    $('#symbol-comparison-search').search(comparisonStockSearchOptions);

    // trade form validation
    $tradeForm
      .form({
        on: 'blur',
        fields: {
          quantity: {
            rules: [
              {
                type: 'empty',
                prompt: "{{ @trade.form.quantity.error }}"
              },{
                type: 'integer',
                prompt: "{{ @trade.form.quantity.error }}"
              }
            ]
          }
        }
      });

    // low balance notification modal
    setTimeout(function () {
      $('.ui.basic.modal').modal('show');
    }, 3000);

    $('button.trade').on('click', function () {
      var $this = $(this);

      // don't allow to click if request is already in progress
      if (!$this.hasClass('disabled') && $tradeForm.form('is valid')) {
        var $tradeButtons = $('button.trade');
        $tradeButtons.addClass('loading disabled');
        var action = $this.data('action');
        var quantity = parseInt($('#trade-quantity').val());
        var user = $('#user-search').data('user');

        $.ajax({
          url: '{{ @BASE }}/api/actions/trade',
          method: 'POST',
          data: {symbol: currentSymbol, quantity: quantity, action: action, user: user},
          dataType: 'json',
          async: true,
          cache: false,
          success: function (response) {
            log('trade', response);
            var $tradeResultMessage = $('#trade-result-message');
            $tradeResultMessage.find('p').text(response.message);
            if (response && response.success) {
              // update balance if not trading on behalf of some other user
              if (!user) $('#user-balance').text((response.balance).formatNumber()+' {{ @USER.currency }}').transition('flash');
              $tradeResultMessage.find('.header').text("{{ @trade.form.trade.success.title }}");
              $tradeResultMessage.removeClass('error').addClass('success');
            } else {
              $tradeResultMessage.find('.header').text("{{ @trade.form.trade.failure }}");
              $tradeResultMessage.removeClass('success').addClass('error');
            }
            $tradeButtons.removeClass('loading');
            $tradeResultMessage.transition('fade down');
            setTimeout(function () {
              $tradeButtons.removeClass('disabled');
              $tradeResultMessage.transition('fade up');
            }, 6000);
          },
          error: handleAjaxError
        });
      }
    });

    /**
     * Handle current stock symbol change
     */
    function changeActiveSymbol(result, response) {
      currentSymbol = result.symbol;
      currentSymbolExchangeCode = result.exchange_code;

      $('#stock-exchange-name').html('<i class="'+result.exchange_country_code+' flag"></i>'+result.exchange_name);
      $('.ui.statistic .live-data').text('');
      $('.live-data').not('.ui.statistic .live-data').html('<div class="ui active inline loader"></div>');

      // change symbol in all predefined containers
      $('.live-data.selected-symbol').each(function() {
        $(this).data('symbol', currentSymbol);
      });
      // save active symbol in user session
      saveActiveSymbol();

      // change watch button state
      if (result.watched>0) {
        $('.add-to-watchlist')
          .removeClass('basic loading disabled')
          .addClass('watching')
          .html('<i class="star icon"></i> '+"{{ @trade.symbol.watching }}");
      } else {
        $('.add-to-watchlist')
          .removeClass('loading disabled watching')
          .addClass('basic')
          .html('<i class="star icon"></i> '+"{{ @trade.symbol.watch }}");
      }

      // refresh data on all tabs
      getLiveQuotes();
      getSymbolNews();
      getChart();
    }

    /**
     * Save current symbol, so it can be retrieved on next page load
     */
    function saveActiveSymbol() {
      $.ajax({
        url: '{{ @BASE }}/api/actions/symbol/set/'+currentSymbol,
        dataType: 'json',
        async: true,
        cache: false
      });
    }

    // initialize checkboxes
    function initComparisonCheckboxes() {
      $('.ui.stock-comparison.checkbox').checkbox({
        onChecked: function () {
          var $input = $(this);
          addComparison($input.data('symbol'), $input.parent());
        },
        onUnchecked: function () {
          var $input = $(this);
          deleteComparison($input.data('symbol'));
        }
      });
    }

    function chartLoading() {
      $chartLoader.addClass('active');
    }

    function chartLoadingComplete() {
      $chartLoader.removeClass('active');
    }

    function chartAddComparison(result, response) {
      var symbol = result.symbol;
      var $symbolInput = $stockComparisonForm.find('.field input[data-symbol="'+symbol+'"]');
      // if such stock wasn't added to comparison already (checkbox with stock symbol doesn't exist), add a new checkbox
      if ($symbolInput.length==0) {
        var $checkbox = $stockComparisonForm.find('.inline.fields').append(
          '<div class="field">' +
            '<div class="ui stock-comparison checkbox">' +
            '<input type="checkbox" data-symbol="'+symbol+'" class="hidden">' +
            '<label>'+symbol+'</label>' +
            '</div>' +
          '</div>').find('.stock-comparison.checkbox').last();
        // Re-init checkboxes to apply callbacks to the new checkbox
        initComparisonCheckboxes();
      // otherwise just get existing checkbox
      } else {
        var $checkbox = $symbolInput.closest('.stock-comparison.checkbox');
      }
      $checkbox.checkbox('set checked');
      addComparison(symbol, $checkbox);
    }

    /**
     * Add stock comparison to chart
     */
    function addComparison(symbol, $checkbox) {
      if (typeof chart != 'undefined') {
        chartLoading();
        // if symbol is not added to comparison already (in which case the data would be already loaded)
        if ($.inArray(symbol, comparisonSymbols) == -1) {
          comparisonSymbols.push(symbol);

          // load historical data for given symbol
          $.getJSON(HISTORICAL_DATA_ENDPOINT + symbol, function (chartData) {
            log('chartData', chartData);
            if (chartData.length) {

              var dataSet = {
                title: symbol,
                compared: true,
                fieldMappings: [{
                  fromField: 'value',
                  toField: 'value'
                }, {
                  fromField: 'volume',
                  toField: 'volume'
                }
                ],
                dataProvider: chartData,
                categoryField: 'date'
              };

              chart.dataSets.push(dataSet);
              chart.comparedDataSets.push(dataSet);
              chart.validateData();
              chartLoadingComplete();
            } else {
              deleteFromArray(comparisonSymbols, symbol);
              setTimeout(function () {
                $checkbox.checkbox('set unchecked');
                chartLoadingComplete();
              }, 3000);
            }
          });
        // If data was already loaded before just add it to comparison
        } else {
          for (var i = 0; i < chart.dataSets.length; i++) {
            if (chart.dataSets[i].title == symbol) {
              chart.dataSets[i].compared = true;
            }
          }
          chart.validateData();
          chartLoadingComplete();
        }
      }
    }

    /**
     * Delete stock comparison
     */
    function deleteComparison(symbol) {
      // set compared property to false to hide the comparison, so it can be enabled again if the same comparison is added
      for (var i = 0; i < chart.dataSets.length; i++) {
        if (chart.dataSets[i].title == symbol) {
          chart.dataSets[i].compared = false;
        }
      }
      chart.validateData();
    }

    function initEmptyChart() {
      chart = AmCharts.makeChart($chartContainer.attr('id'), chartOptions);
    }

    // get chart data from server and add it to the already initialized chart
    function getChart() {
      // if chart for current symbol is not already initialized and loaded
      if (typeof chart.dataSets[0].dataProvider == 'undefined' || chart.dataSets[0].dataProvider.length == 0 || chart.dataSets[0].title != currentSymbol) {
        chartLoading();
        chart.dataSets[0].title = currentSymbol;

        $.getJSON(HISTORICAL_DATA_ENDPOINT + currentSymbol, function (chartData) {
          if (chartData.length) {
            log('chartData', chartData);
            chart.dataSets[0].dataProvider = chartData;
            chart.validateData();
            $stockComparisonForm.show();
          }
          chartLoadingComplete();
        });
      }
    }

    /**
     * Return HTML for stock symbol autocomplete dropdown
     */
    function formatSymbolSearchResult(response) {
      var result = '';
      if (typeof response.results != 'undefined' && response.results.length) {
        $.each(response.results, function(i, stock) {
          result += '<a class="result">' +
            '<div class="content">' +
            '<div class="price"><i class="'+stock.exchange_country_code+' flag"></i>'+stock.exchange_code+'</div>' +
            '<div class="title">'+stock.symbol+(parseInt(stock.watched)?' <i class="yellow star icon"></i>':'')+'</div>' +
            '<div class="description">'+stock.name+'</div>' +
            '</div>' +
            '</a>'
        });
      }
      return result;
    }

    /**
     * Get news headlines from API
     */
    function getSymbolNews() {
      var url = String.format(YQL_ENDPOINT, encodeURIComponent('SELECT * FROM feed WHERE url="'+NEWS_HEADLINES_URL+currentSymbol+'"'));
      $.ajax({
        url: url,
        dataType: 'json',
        async: true,
        cache: false,
        success: displaySymbolNews,
        error: handleAjaxError
      });
    }

    /**
     * Display news
     */
    function displaySymbolNews(response) {
      log('displaySymbolNews', response);
      var newsHtml = '';
      $newsContainer.empty();
      if (typeof response.query != 'undefined' && typeof response.query.count != 'undefined' && response.query.count>0 && response.query.results.item.length > 0) {
        $.each(response.query.results.item, function(i, news) {
          newsHtml += '<div class="item">' +
            '<div class="content">' +
            '<div class="meta">' + moment((news.pubDate).replace('GMT','+0000'), NEWS_DATE_TIME_FORMAT).tz(USER_TIMEZONE).format(DATE_TIME_FORMAT) + '</div>' +
            '<h3 class="header">' + news.title + '</h3>' +
            '<div class="description">' +
            '<p>' + (news.description!=null&&news.description.length > 10 ? news.description : '') + '</p> ' +
            '<a href="' + news.link + '" target="_blank">'+"{{ @trade.news.read.more }}"+'</a>' +
            '</div>' +
            '</div></div>';
        });
        $newsContainer.append(newsHtml);
      } else {
        $newsContainer.append("<h4>{{ @trade.news.empty }}</h4>");
      }
    }
  });
</script>