<script type="text/javascript">
  $(document).ready(function () {
    var currentTab;
    var chart;
    var $balanceHistoryChartContainer = $('#balance-history-chart');
    var $positionsListTable = $('#positions-list');
    var $tradesListTable = $('#trades-list');
    var tradesPerPage = parseInt('{{ @PORTFOLIO.TRADES_PER_PAGE }}', 10);
    var positionsPerPage = parseInt('{{ @PORTFOLIO.POSITIONS_PER_PAGE }}', 10);
    var userCurrency = '{{ @USER.currency }}';
    var backgroundColor = $('body').css('backgroundColor');
    var primaryColor = $('#main-menu').css('backgroundColor');
    var secondaryColor = '#000';
    if (backgroundColor == 'rgb(0, 0, 0)') {
      primaryColor = '#fff';
      secondaryColor = '#fff';
    }

    getPositionsList();

    // define it as a global function, so it can be accessed by callbacks
    refreshTradesList = function() {
      getTradesList();
    };

    // define it as a global function, so it can be accessed by callbacks
    refreshPositionsList = function() {
      getPositionsList();
    };

    function getPositionsList() {
      var $form = $('#tab-positions').find('.ui.user.search');
      var user = $form.data('user');
      var balance = $form.data('balance') ? floatVal($form.data('balance')) : floatVal('{{ @USER.balance }}');
      $('#total-cash')
        .text(balance.formatNumber())
        .data('value', balance);

      $.ajax({
        url: '{{ @BASE }}/api/data/positions' + (user ? '/'+user : ''),
        method: 'GET',
        dataType: 'json',
        async: true,
        cache: false,
        success: function(response) {
          log('displayPositions', response);
          // datatable needs to be destroyed before modifying underlying rows
          $positionsListTable.destroyDataTable();
          $positionsListTable.find('tbody').empty();
          if (response && response.length) {
            var rows = '';
            $.each(response, function (i, position) {
              rows += '<tr>' +
                '<td>' + (position.direction>0 ? '<span class="ui tiny green label">{{ @portfolio.positions.long }}</span>' : '<span class="ui tiny red label">{{ @portfolio.positions.short }}</span>') + '</td>' +
                '<td><h5 class="ui header"><a href="{{ @BASE }}/trade?s=' + position.symbol + '">' + position.symbol + '</a></h5><div>' + position.name + '</div></td>' +
                '<td class="right aligned" data-order="' + position.quantity + '">' + position.quantity.formatNumber(0) + '</td>' +
                '<td class="right aligned live-data" data-symbol="' + position.symbol +'" data-field="regularMarketPrice" data-format="fmtDecimal"></td>' +
                '<td class="center aligned">' + position.currency + '</td>' +
                (position.currency!=userCurrency ? '<td class="right aligned currency-' + position.currency + userCurrency + ' live-data" data-symbol="' + position.currency + userCurrency + '=X" data-field="regularMarketPrice" data-format="fmtLongDecimal"></td>' : '<td class="right aligned">' + (1).formatNumber(4) + '</td>') +
                '<td class="right aligned historical-cost" data-order="' + position.historical_cost + '">' + position.historical_cost.formatNumber() + '</td>' +
                '<td class="right aligned live-data market-value" data-symbol="' + position.symbol + '" data-field="regularMarketPrice" data-format="fmtMarketValue" data-format-args="' + ['regularMarketPrice',position.quantity,position.currency,userCurrency,position.nominal].join(',') + '"></td>' +
                '<td class="right aligned live-data unrealized-pnl" data-symbol="' + position.symbol + '" data-field="regularMarketPrice" data-format="fmtUnrealizedPnL" data-format-args="' + ['regularMarketPrice',position.quantity,position.currency,userCurrency,position.historical_cost,position.nominal,'abs'].join(',') + '"></td>' +
                '<td class="right aligned live-data unrealized-pnl-pct" data-symbol="' + position.symbol + '" data-field="regularMarketPrice" data-format="fmtUnrealizedPnL" data-format-args="' + ['regularMarketPrice',position.quantity,position.currency,userCurrency,position.historical_cost,position.nominal,'pct'].join(',') + '"></td>' +
                '</tr>';
            });
            $positionsListTable.find('tbody').append(rows);
            getLiveQuotes(function () {
              $positionsListTable.initDataTable(positionsPerPage, [[9,'desc']], false, calculatePositionsTotals);
            });
          } else {
            // init datatable even if it's empty (to display "empty" message)
            $positionsListTable.initDataTable(positionsPerPage, [[9, 'desc']], false, calculatePositionsTotals);
          }
        },
        error: handleAjaxError
      });
    }

    function getTradesList() {
      var user = $('#tab-trades').find('.ui.user.search').data('user');
      $.ajax({
        url: '{{ @BASE }}/api/data/trades' + (user ? '/'+user : ''),
        method: 'GET',
        dataType: 'json',
        async: true,
        cache: false,
        success: function(response) {
          log('displayTradesHistory', response);
          // datatable needs to be destroyed before modifying underlying rows
          $tradesListTable.destroyDataTable();
          $tradesListTable.find('tbody').empty();
          if (response && response.length) {
            var rows = '';
            $.each(response, function (i, trade) {
              rows += '<tr class="'+(trade.direction>0?'positive':'negative')+'">' +
                '<td><a href="{{ @BASE }}/trade?s=' + trade.symbol + '">' + trade.symbol + '</a></td>' +
                '<td>' + trade.name + '<div class="trade-exchange"><i class="' + trade.exchange_country_code + ' flag"></i>' + trade.exchange_name + '</div></td>' +
                '<td>' + (trade.direction>0?"{{ @portfolio.trades.buy }}":"{{ @portfolio.trades.sell }}") + '</td>' +
                '<td class="right aligned" data-order="' + trade.quantity + '">' + trade.quantity.formatNumber(0) + '</td>' +
                '<td class="right aligned" data-order="' + trade.price + '">' + trade.price.formatNumber() + '</td>' +
                '<td class="right aligned" data-order="' + trade.fx_rate + '">' + trade.fx_rate.formatNumber(4) + '</td>' +
                '<td class="right aligned" data-order="' + trade.total + '">' + trade.total.formatNumber() + '</td>' +
                '<td class="right aligned" data-order="' + trade.commission + '">' + trade.commission.formatNumber(2) + '</td>' +
                '<td class="right aligned" data-order="' + trade.balance + '">' + trade.balance.formatNumber() + '</td>' +
                '<td class="trades-date">' + moment.tz(trade.created, SERVER_TIMEZONE).tz(USER_TIMEZONE).format(DATE_TIME_FORMAT) + '</td>' +
                '</tr>';
            });
            $tradesListTable.find('tbody').append(rows);
          }
          // init datatable even if it's empty (to display "empty" message)
          $tradesListTable.initDataTable(tradesPerPage, [[9,'desc']], true);
        },
        error: handleAjaxError
      });
    }

    // tabs initialization
    $('#portfolio-menu .item').tab({
      // when tab is loaded (clicked)
      onLoad: function (clickedTabName) {
        currentTab = clickedTabName;
        // if data for given tab is not yet received call respective function
        if (currentTab == 'tab-trades' && $tradesListTable.find('tbody').children().length == 0) {
          getTradesList();
        } else if (currentTab == 'tab-balance-history' && $balanceHistoryChartContainer.children().length == 0) {
          $.getJSON('{{ @BASE }}/api/data/balance-history', function (chartData) {
            log('balanceHistory', chartData);
            if (chartData.length>1) {
              displayChart(chartData);
            } else {
              $balanceHistoryChartContainer.append('<div class="ui message">' +
                '<div class="content">' +
                  '<div class="header">' + "{{ @portfolio.balance.empty.header }}" + '</div>' +
                  '<p>' + "{{ @portfolio.balance.empty.message }}" + '</p>' +
                '</div>' +
                '</div>');
            }
          });
        }
      },
      onVisible: function() {
        $('.ui.sticky').sticky('refresh');
      }
    });

    // calculate total market value, total pnl etc
    function calculatePositionsTotals(row, data, start, end, display) {
      var api = this.api();
      var totals = {};
      var columns = {
        6: '#total-historical-cost',
        7: '#total-market-value',
        8: '#total-unrealized-pnl'
      };

      $.each(columns, function(columnIndex, columnId) {
        var total = api
          .column(columnIndex)
          .data()
          .reduce(function (a, b) {
            return floatVal(a) + floatVal(b);
          }, 0);
        totals[columnIndex] = total;
        $(columnId).text(total.formatNumber());
      });

      $('#net-assets').text(($('#total-cash').data('value')+totals[7]).formatNumber());
    }

    function displayChart(chartData) {
      chart = AmCharts.makeChart($balanceHistoryChartContainer.attr('id'), {
        type: 'serial',
        dataProvider: chartData,
        dataDateFormat: 'YYYY-MM-DD JJ:NN:SS',
        mouseWheelZoomEnabled: true,
        creditsPosition: 'bottom-left',
        categoryField: 'date',
        categoryAxis: {
          parseDates: true,
          minPeriod: 'mm',
          equalSpacing: true,
          axisAlpha: 0.5,
          minHorizontalGap: 60,
          color: secondaryColor,
          gridColor: secondaryColor,
          gridThickness: 1,
          gridAlpha: 0.1
        },
        valueAxes: [{
          id: 'val',
          title: '{{ @portfolio.balance.balance }}, {{ @USER.currency }}',
          color: secondaryColor,
          gridColor: primaryColor, //horizontal grid line color
          gridAlpha: 0.1,
          gridThickness: 1
        }],
        graphs: [{
          useNegativeColorIfDown: true,
          balloonFunction: function(item, graph) {
            var balance = item.values.value.formatNumber();
            return item.index>0 ? // first item?
              '<div><b>'+moment.tz(item.dataContext.date, SERVER_TIMEZONE).tz(USER_TIMEZONE).format(DATE_TIME_FORMAT)+'</b></div><div>'+item.dataContext.action+'</div><div>'+"{{ @portfolio.balance.balance }}"+' <i class="arrow '+(item.isNegative?'down':'up')+' icon"></i>'+balance+' {{ @USER.currency }}</div>' :
              '<div><b>'+moment.tz(item.dataContext.date, SERVER_TIMEZONE).tz(USER_TIMEZONE).format(DATE_TIME_FORMAT)+'</b></div><div>'+"{{ @portfolio.balance.balance }}"+' '+balance+' {{ @USER.currency }}</div>';
          },
          bullet: 'round',
          bulletBorderAlpha: 1,
          bulletBorderColor: '#FFFFFF',
          hideBulletsCount: 50,
          lineThickness: 2,
          lineColor: '#21ba45',
          negativeLineColor: '#db2828',
          valueField: 'balance'
        }],
        chartScrollbar: {
          scrollbarHeight: 5,
          backgroundColor: primaryColor,
          backgroundAlpha: 0.2,
          selectedBackgroundColor: primaryColor,
          selectedBackgroundAlpha: 1
        },
        chartCursor: {
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
        export: {
          enabled: true
        }
      });

      if (chart.zoomToIndexes) {
        chart.zoomToIndexes(chartData.length - 15, chartData.length - 1);
      }
    }
  });
</script>