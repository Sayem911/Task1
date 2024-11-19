<div class="ui container">
  <div class="ui stackable one column grid">
    <include if="{{ @ADSENSE.CLIENT_ID && @ADSENSE.SLOT_ID }}" href="{{ @tpl.adsense }}" />
    <div class="column">
    <div class="ui piled segment">
      <span class="ui {{ @SITE.MAIN_COLOR }} ribbon label"><i class="money icon"></i> {{ @title.trade }}</span>
      </span>
      </div>
      
    </div>
    <div class="column">
      <div class="ui stackable grid">
        <div class="eight wide column">
            <form id="modal-limit-order" name="limit-order-form" class="ui limit-order-form skip-submission-check tiny form action modal" data-action="add">
                <i class="close icon"></i>
                <div class="header">
                  {{ @signals.add.title }}
                </div>
                <div class="ui piled segment">
                    <div class="ui stackable two column grid">
                        <div class="column">
                            <div class="item"><span class=" value live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-field="quoteType" data-format="fmtString"></span><span class="dot"></span><span class="symbol value">{{ @vars.symbol }}</span></div>
                            <div class="item header"><span class="short-name live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-field="shortName"></span></div>
                            <div class="item"><span class="stock-exchange-name ui header"><i class="{{ @vars.asset.exchange_country_code }} flag"></i>{{ @vars.asset.exchange_name }}</span></div>
                        </div>
                        <div class="column right aligned">
                            <div class="item"><span class="live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtDate" data-field="regularMarketTime"></span></div>
                            <div class="item header"><span class="current-price value live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-field="regularMarketPrice" data-format="fmtDecimal" data-callback="clbEnableDisableTrading" data-check-trading="true"></span>&nbsp;<span class=" value live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-field="currency" data-format="fmtString"></span></div>
                            <div class="item"><span class=" value live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-field="regularMarketChangePercent" data-format="fmtUpDownIndicatorWithPercent" data-format-args="regularMarketChange,regularMarketChangePercent"></span></div>
                        </div>
                    </div>
                </div>
                <div class="content">
                    <div class="ui error message"></div>
                    <div class="ui result message"></div>
                    <input type="hidden" name="user" value="{{  @USER.id }}" />
                    <div class="two fields">
                        <div class="field">
                            <div class="ui input select">
                        		<input class="buy" type="radio" id="type-buy" name="order_type" value="buy" checked tabindex="0"/>
                        		<label class="buy" for="type-buy">{{ @signals.add.buy }}</label>
                        		<input class="sell" type="radio" id="type-sell" name="order_type" value="sell" />
                        		<label class="sell" for="type-sell">{{ @signals.add.sell }}</label>
                            </div>                 
                        </div>
                        <div class="required field">
                          <div class="ui input">
                            <div class="ui ordertime-type fluid selection dropdown" tabindex="0">
                                <input type="hidden" name="ordertime_type">
                                <i class="dropdown icon"></i>
                                <div class="default text">{{ @signals.ordertime_type.title }}</div>
                                <div class="menu">
                                    <div class="item" data-value="d">{{ @signals.ordertime_type.forday }}</div>
                                    <div class="item" data-value="u">{{ @signals.ordertime_type.unlimited }}</div>
                                </div>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="two fields">
                        <div class="required field">
                          <div class="ui input">
                            <div class="ui limit-type fluid selection dropdown" tabindex="0">
                                <input type="hidden" name="limit_type" value="0" />
                                <i class="dropdown icon"></i>
                                <div class="default text"></div>
                                <div class="menu">
                                    <div class="item" data-value="0">{{ @signals.limit_price.title }}</div>
                                    <div class="item" data-value="1">{{ @signals.market_price.title }}</div>
                                    <div class="item" data-value="2">{{ @signals.stop_loss.title }}</div>
                                    <div class="item" data-value="3">{{ @signals.stop_limit.title }}</div>
                                </div>
                            </div>
                          </div>
                        </div>
                        <div class="limit-entries required field">
                          <div class="ui limit-price input right icon">
                            <input type="text" tabindex="0" name="limit_price" value="" placeholder="{{ @signals.limit_price.placeholder }}" />
                            <i class="euro icon"></i>
                          </div>
                          <div class="ui stop-price input right icon">
                            <input type="text" tabindex="0" name="stop_price" value="" placeholder="{{ @signals.stop_price.placeholder }}" />
                            <i class="euro icon"></i>
                          </div>
                          <div class="ui market-amount input">
                            <input type="text" tabindex="0" name="market_amount" value="" placeholder="{{ @signals.amount.placeholder }}" />
                          </div>
                        </div>
                    </div>
                    <div class="two fields">
                        <div class="required field">
                          <div class="ui limit-amount input">
                            <input type="text" tabindex="0" name="limit_amount" value="" placeholder="{{ @signals.amount.placeholder }}" />
                          </div>
                        </div>
                        <div class="required field">
                          <div class="ui total input right icon">
                            <input type="text" tabindex="0" name="total" value="" placeholder="{{ @signals.total.placeholder }}" />
                            <i class="euro icon"></i>
                          </div>
                        </div>
                    </div>
                    <div class="field">
                        <p><b>Hinweis</b> Für jedes Wertpapier in Ihrem Depotbestand können Sie hier Kurslimits setzen. Wird eines der Limits erreicht, benachrichtigen wir Sie per E-Mail.</p>
                    </div>
                </div>
                <div class="actions">
                    <div class="ui large left labeled icon cancel button left floated"><i class="cancel icon"></i> {{ @settings.form.cancel }} </i></div>
                    <div class="ui large {{ @SITE.MAIN_COLOR }} right labeled icon submit button ">{{ @settings.form.save }} <i class="checkmark icon"></i></div>
                </div>
            </form>
            <div id="symbol-search" class="ui search">
                <div class="ui icon input">
                  <input class="prompt" type="text" placeholder="{{ @trade.symbol.search.placeholder }}" value="{{ @vars.symbol }}" data-exchange-code="{{ @vars.asset.exchange_code }}">
                  <i class="search icon"></i>
                </div>
                <div class="results"></div>
            </div>
            
        </div>
        <div class="eight wide right aligned column">
            <check if="{{ @USER.is_admin }}">
                    <div class="ui stock-op blue floating dropdown icon button">
                        <div class="text">{{ @trade.assets.options }} &nbsp;</div>
                        <i class="angle down icon"></i>
                        <div class="ui menu">
                          <div class="item stock-add"><i class="add icon"></i> {{ @trade.assets.add }}</div>
                          <div class="item stock-edit"><i class="pencil icon"></i> {{ @trade.assets.edit }}</div>
                          <div class="item stock-delete"><i class="trash icon"></i> {{ @trade.assets.delete }}</div>
                        </div>
                    </div>
            </check>
        </div>
        <div class="center aligned sixteen wide column">
          <h2 id="stock-name-header" class="ui header live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-field="shortName"></h2>
          <h4 id="stock-exchange-name" class="ui header"><i class="{{ @vars.asset.exchange_country_code }} flag"></i>{{ @vars.asset.exchange_name }}</h4>
          <check if="{{ Helper::isDateTimeBetweenAndWorking(@vars.asset.trading_start, @vars.asset.trading_end, @vars.asset.exchange_timezone) }}">
            <true>
              <span class="positive ui button">{{ @markets.exchange.open }}</span>
            </true>
            <false>
              <span class="negative ui button">{{ @markets.exchange.closed }}</span>
            </false>
          </check>
          <div>
            <div id="symbol-last-trade-price" class="ui statistic">
              <div class="value live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-field="regularMarketPrice" data-format="fmtDecimal" data-callback="clbEnableDisableTrading" data-check-trading="true"></div>
              <div class="label live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-field="c4"></div>
            </div>
            <div class="ui tiny statistic">
              <div class="value live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-field="regularMarketChange" data-format="fmtGreenRedFont" data-format-args="regularMarketChange,regularMarketChange"></div>
            </div>
            <div class="ui tiny statistic">
              <div class="value live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-field="regularMarketChangePercent" data-format="fmtGreenRedFontWithBraces" data-format-args="regularMarketChange,regularMarketChangePercent"></div>
            </div>
          </div>
        </div>
        <div class="center aligned sixteen wide column">
          <div id="market-closed">
            <div class="ui icon {{ @SITE.MAIN_COLOR }} message">
              <i class="notched circle loading icon"></i>
              <div class="content">
                <div class="header">
                  {{ @trade.symbol.disabled.header }}
                </div>
                <p>{{ @trade.symbol.disabled.message }}</p>
              </div>
            </div>
          </div>
          <div id="trade-form" class="ui form">
            <div class="fields">
              <div class="two wide trade-quantity field">
                <input id="trade-quantity" name="quantity" placeholder="{{ @trade.symbol.qty.placeholder }}" type="text">
              </div>
            </div>
            <div class="ui big buttons">
              <button class="ui positive left labeled icon trade button" data-action="buy"><i class="money icon"></i> {{ @trade.symbol.buy }}</button>
              <div class="or"></div>
              <button class="ui negative trade button" data-action="sell">{{ @trade.symbol.sell }}</button>
              <div class="or"></div>
              <button class="ui blue right labeled icon limit-order button">{{ @trade.limit_order.button }}<i class="bell icon"></i></button>

            </div>
          </div>
        </div>
        <check if="{{ @USER.is_admin }}">
          <div class="four column centered row">
          <div class="column">
            <div id="user-search" class="ui fluid user search">
              <div class="ui icon input">
                <input class="prompt" type="text" placeholder="{{ @trade.user.search.placeholder }}">
                <i class="user icon"></i>
              </div>
              <div class="results"></div>
            </div>
          </div>
            </div>
        </check>
        <div class="eight wide centered center aligned column">
          <div id="trade-result-message" class="ui message">
            <div class="header"></div>
            <p></p>
          </div>
        </div>
      </div>

          <div id="stock-tabs" class="ui stackable one column grid">
            <div class="column">
          <div id="stock-tabs-menu" class="ui pointing {{ @SITE.BACKGROUND=='black'?'inverted':'' }} {{ @SITE.MAIN_COLOR }} menu">
            <a class="active item" data-tab="tab-market-data">{{ @trade.menu.marketdata }}</a>
          </div>

          <div class="ui active tab" data-tab="tab-market-data">
            <table id="stock-market-data" class="ui sortable celled blue {{ @SITE.MAIN_COLOR }} table">
              <tbody>
                <tr>
                  <td>{{ @trade.marketdata.td01 }}</td><td class="right aligned live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtDecimal" data-field="bid"></td>
                  <td>{{ @trade.marketdata.td02 }}</td><td class="right aligned live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtInteger" data-field="sharesOutstanding"></td>
                </tr>
                <tr>
                  <td>{{ @trade.marketdata.td03 }}</td><td class="right aligned live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtDecimal" data-field="ask"></td>
                  <td>{{ @trade.marketdata.td04 }}</td><td class="right aligned live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtDecimal" data-field="marketCap"></td>
                </tr>
                <tr>
                  <td>{{ @trade.marketdata.td09 }}</td><td class="right aligned live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtDecimal" data-field="regularMarketPrice"></td>
                  <td>{{ @trade.marketdata.td08 }}</td><td class="right aligned live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtDecimal" data-field="bookValue"></td>
                </tr>
                <tr>
                  <td>{{ @trade.marketdata.td07 }}</td><td class="right aligned"><span class="live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtDecimal" data-field="regularMarketDayLow"></span> - <span class="right aligned live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtDecimal" data-field="regularMarketDayHigh"></span></td>
                  <td>{{ @trade.marketdata.td10 }}</td><td class="right aligned live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtDecimal" data-field="ebitda"></td>
                </tr>
                <tr>
                  <td>{{ @trade.marketdata.td06 }}</td><td class="right aligned"><span class="live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtDecimal" data-field="fiftyTwoWeekLow"></span> - <span class="right aligned live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtDecimal" data-field="fiftyTwoWeekHigh"></span></td>
                  <td>{{ @trade.marketdata.td12 }}</td><td class="right aligned live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtDate" data-field="exDividendDate"></td>
                </tr>
                <tr>
                  <td>{{ @trade.marketdata.td23 }}</td><td class="right aligned"><span class="live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtDecimal" data-field="fiftyTwoWeekLowChange"></span> (<span class="right aligned live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtDecimalPct" data-field="fiftyTwoWeekLowChangePercent"></span>)</td>
                  <td>{{ @trade.marketdata.td14 }}</td><td class="right aligned live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtDecimal" data-field="dividendRate"></td>
                </tr>
                <tr>
                  <td>{{ @trade.marketdata.td24 }}</td><td class="right aligned"><span class="live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtDecimal" data-field="fiftyTwoWeekHighChange"></span> (<span class="right aligned live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtDecimalPct" data-field="fiftyTwoWeekHighChangePercent"></span>)</td>
                  <td>{{ @trade.marketdata.td13 }}</td><td class="right aligned live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtDecimal" data-field="dividendYield"></td>
                </tr>
                <tr>
                  <td>{{ @trade.marketdata.td05 }}</td><td class="right aligned live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtDecimal" data-field="regularMarketOpen"></td>
                  <td>{{ @trade.marketdata.td29 }}</td><td class="right aligned live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtInteger" data-field="totalCash"></td>
                </tr>
                <tr>
                  <td>{{ @trade.marketdata.td11 }}</td><td class="right aligned live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtDecimal" data-field="regularMarketPreviousClose"></td>
                  <td>{{ @trade.marketdata.td18 }}</td><td class="right aligned live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtDecimal" data-field="fiftyDayAverage"></td>
                </tr>
                <tr>
                  <td>{{ @trade.marketdata.td15 }}</td><td class="right aligned live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtInteger" data-field="regularMarketVolume"></td>
                  <td>{{ @trade.marketdata.td25 }}</td><td class="right aligned live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtDecimal" data-field="fiftyDayAverageChange"></td>
                </tr>
                <tr>
                  <td>{{ @trade.marketdata.td30 }}</td><td class="right aligned live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtInteger" data-field="averageDailyVolume3Month"></td>
                  <td>{{ @trade.marketdata.td26 }}</td><td class="right aligned live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtDecimalPct" data-field="fiftyDayAverageChangePercent"></td>
                </tr>
                <tr>
                  <td>{{ @trade.marketdata.td31 }}</td><td class="right aligned live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtDecimal" data-field="beta"></td>
                  <td>{{ @trade.marketdata.td20 }}</td><td class="right aligned live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtDecimal" data-field="twoHundredDayAverage"></td>
                </tr>
                <tr>
                  <td>{{ @trade.marketdata.td19 }}</td><td class="right aligned live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtDecimal" data-field="trailingPE"></td>
                  <td>{{ @trade.marketdata.td27 }}</td><td class="right aligned live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtDecimal" data-field="twoHundredDayAverageChange"></td>
                </tr>
                <tr>
                  <td>{{ @trade.marketdata.td21 }}</td><td class="right aligned live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtDecimal" data-field="pegRatio"></td>
                  <td>{{ @trade.marketdata.td28 }}</td><td class="right aligned live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-format="fmtDecimalPct" data-field="twoHundredDayAverageChangePercent"></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
    </div>
  </div>
</div>
<check if="{{ @USER.is_admin }}">
    <form id="modal-stock-add" name="stock-form" class="ui stock-form skip-submission-check form small action modal" method="post">
        <i class="close icon"></i>
        <div class="header">
          {{ @trade.assets.add_title }}
        </div>
        <div class="content">
            <div class="ui error message"></div>
            <div class="ui result message"></div>
            <div class="required field">
              <div class="ui left labeled input right input">
                <div class="ui label">{{ @trade.assets.market_name }}</div>
                    <div class="ui market-name fluid search selection dropdown" tabindex="-1">
                        <input type="hidden" name="market" />
                        <i class="dropdown icon"></i>
                        <div class="default text">{{ @trade.assets.market_name_placeholder }}</div>
                        <div class="menu"></div>
                    </div>
              </div>
            </div>
            <div class="required field">
              <div class="ui left labeled input right input">
                <div class="ui label">{{ @trade.assets.asset_symbol }}</div>
                <input type="text" tabindex="0" name="symbol" value="" placeholder="{{ @trade.assets.asset_symbol_placeholder }}" />
              </div>
            </div>
            <div class="required field">
              <div class="ui left labeled input right icon">
                <div class="ui label">{{ @trade.assets.asset_name }}</div>
                <input type="text" name="name" value="" placeholder="{{ @trade.assets.asset_name_placeholder }}" />
              </div>
            </div>
            <div class="field">
              <div class="ui left labeled input right icon focus">
                <div class="ui label">{{ @trade.assets.asset_currency }}</div>
                <input type="text" name="currency" value="" placeholder="{{ @trade.assets.asset_currency_placeholder }}" />
                <i class="money bill alternate outline icon"></i>
              </div>
            </div>
            <div class="field">
              <div class="ui left labeled input right focus">
                <div class="ui label">{{ @trade.assets.asset_nominal }}</div>
                <input type="text" name="nominal" value="" placeholder="{{ @trade.assets.asset_nominal_placeholder }}" />
              </div>
            </div>
        </div>
        <div class="actions">
            <div class="ui large {{ @SITE.MAIN_COLOR }} right labeled icon submit button">{{ @settings.form.save }} <i class="checkmark icon"></i></div>
        </div>
    </form>
    <form id="modal-stock-edit" name="stock-form" class="ui stock-form skip-submission-check form small action modal" post="/api/actions/stock/edit" method="post">
        <i class="close icon"></i>
        <div class="header">
          {{ @trade.assets.edit_title }}
        </div>
        <div class="content">
            <div class="ui error message"></div>
            <div class="ui result message"></div>
            <input type="hidden" name="id" />
            <div class="required field">
              <div class="ui left labeled input right input">
                <div class="ui label">{{ @trade.assets.market_name }}</div>
                    <div class="ui market-name fluid search selection dropdown" tabindex="-1">
                        <input type="hidden" name="market" />
                        <i class="dropdown icon"></i>
                        <div class="default text">{{ @trade.assets.market_name_placeholder }}</div>
                        <div class="menu"></div>
                    </div>
              </div>
            </div>
            <div class="required field">
              <div class="ui left labeled input right input">
                <div class="ui label">{{ @trade.assets.asset_symbol }}</div>
                <input type="text" tabindex="0" name="symbol" value="" placeholder="{{ @trade.assets.asset_symbol_placeholder }}" />
              </div>
            </div>
            <div class="required field">
              <div class="ui left labeled input right icon">
                <div class="ui label">{{ @trade.assets.asset_name }}</div>
                <input type="text" name="name" value="" placeholder="{{ @trade.assets.asset_name_placeholder }}" />
              </div>
            </div>
            <div class="field">
              <div class="ui left labeled input right icon focus">
                <div class="ui label">{{ @trade.assets.asset_currency }}</div>
                <input type="text" name="currency" value="" placeholder="{{ @trade.assets.asset_currency_placeholder }}" />
                <i class="money bill alternate outline icon"></i>
              </div>
            </div>
            <div class="field">
              <div class="ui left labeled input right focus">
                <div class="ui label">{{ @trade.assets.asset_nominal }}</div>
                <input type="text" name="nominal" value="" placeholder="{{ @trade.assets.asset_nominal_placeholder }}" />
              </div>
            </div>
        </div>
        <div class="actions">
            <div class="ui large {{ @SITE.MAIN_COLOR }} right labeled icon submit button">{{ @settings.form.save }} <i class="checkmark icon"></i></div>
        </div>
    </form>
    <form id="modal-stock-delete" class="ui skip-submission-check form small action modal" data-action="delete">
        <input type="hidden" name="symbol" value="">
        <i class="close icon"></i>
        <div class="header">
          {{ @trade.assets.delete_title }}
        </div>
        <div class="content">
            <div class="ui error message"></div>
            <div class="ui result message"></div>
            <p>{{ @trade.assets.delete_description }}</p>
        </div>
        <div class="actions">
            <div class="ui large {{ @SITE.MAIN_COLOR }} right labeled icon submit button">{{ @portfolio.anleihen.delete_button }} <i class="checkmark icon"></i></div>
        </div>
    </form>
</check>
<check if="{{ @CREDITS.ENABLED && @vars.low_credit_notification }}">
  <div id="credit-notification" class="ui basic modal">
    <div class="ui icon header">
      <i class="red battery low icon"></i>
      {{ @trade.credits.notification.header }}
    </div>
    <div class="content">
      <p>{{ @trade.credits.notification.message }}</p>
    </div>
    <div class="actions">
      <div class="ui red cancel inverted button">
        <i class="remove icon"></i>
        {{ @trade.credits.button.no }}
      </div>
      <a class="ui green ok inverted button" href="{{ @BASE }}/credits">
        <i class="checkmark icon"></i>
        {{ @trade.credits.button.yes }}
      </a>
    </div>
  </div>
</check>