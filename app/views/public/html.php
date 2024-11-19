<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta property="og:title" content="{{ @website.title }}" />
  <meta property="og:description" content="{{ @website.slogan }}. {{ @website.slogan2 }}." />
  <meta property="og:url" content="{{ Helper::baseUrl() }}" />
  <meta property="og:type" content="website" />
  <meta property="og:image" content="{{ Helper::baseUrl() }}assets/images/background-header.png" />

  <title>{{ @website.title . ' | ' . @vars.title }}</title>

  <link rel="manifest" href="{{ @BASE }}/assets/images/icons/manifest.json">
  <link rel="mask-icon" href="{{ @BASE }}/assets/images/icons/safari-pinned-tab.svg" color="#5bbad5">
  <link rel="shortcut icon" href="{{ @BASE }}/assets/images/icons/favicon.ico">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Exo:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="msapplication-config" content="{{ @BASE }}/assets/images/icons/browserconfig.xml">
  <meta name="theme-color" content="#ffffff">

  <link rel="stylesheet" type="text/css" href="{{@BASE}}/assets/vendor/semantic/2.4.1/semantic.min.css">
  <link rel="stylesheet" type="text/css" href="{{@BASE}}/assets/fontawesome-5.13.1/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="{{@BASE}}/assets/css/app.css">
  <script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
  <script src="{{@BASE}}/assets/vendor/semantic/2.4.1/semantic.min.js"></script>
  <script src="{{@BASE}}/assets/vendor/moment/moment.min.js"></script>
  <script src="{{@BASE}}/assets/vendor/moment/moment-timezone-with-data-2012-2022.min.js"></script>
  <script src="{{@BASE}}/assets/fontawesome-5.13.1/js/all.min.js"></script>
  <script src="{{@BASE}}/assets/js/app{{ @MINIFIED_JS?'.min':'' }}.js"></script>
 
  <include href="{{ @MINIFIED_JS ? @tpl.min.js.const : @tpl.js.const }}" />
 
  <link rel="stylesheet" type="text/css" href="{{@BASE}}/assets/vendor/amstock/plugins/export/export.css">
  <script src="{{@BASE}}/assets/vendor/amstock/amcharts.js"></script>
  <script src="{{@BASE}}/assets/vendor/amstock/serial.js"></script>
  <script src="{{@BASE}}/assets/vendor/amstock/amstock.js"></script>
  <script src="{{@BASE}}/assets/vendor/amstock/plugins/export/export.min.js"></script>
  <include href="{{ @MINIFIED_JS ? @tpl.min.js.trade : @tpl.js.trade }}" />
    
  <include href="{{ @tpl.analytics }}" />

</head>
    <div id="main-menu" >
        <div class="ui grid">
            <div class="column">
                <div class="ui {{ @SITE.MAIN_COLOR }} inverted secondary menu">
                    <div id="content-container" class="ui container">
                    <div class="item" id="menu-logo"><img src="{{ @BASE }}/assets/images/logo-white.png"></div>
                    <div class="item"><h2 class="ui white">{{ @website.title }}</h2></div>
                    
                    <div class="right item">
                        
                        <div class="item">
                            <a href="{{ @BASE }}/login"><div class="ui animated fade button" tabindex="0">
                             <div class="visible content">{{ @signup.form.login }}</div>
                              <div class="hidden content">
                                  <i class="right arrow icon"></i>
                              </div></a>
                            </div>
                        </div>
                    </div>
                    
                    </div>
                     </div>
                </div>
            </div>
        </div>
    </div>
    <div id="content-container" class="ui container">
      <div class="ui stackable one column grid">
        <include if="{{ @ADSENSE.CLIENT_ID && @ADSENSE.SLOT_ID }}" href="{{ @tpl.adsense }}" />
        <div class="column">
          <div class="ui stackable centered grid">
            <div class="six wide center aligned column">
              <div id="symbol-search" class="ui big search">
                <div class="ui icon input">
                  <input class="prompt" type="text" placeholder="{{ @trade.symbol.search.placeholder }}" value="{{ @vars.symbol }}" data-exchange-code="{{ @vars.asset.exchange_code }}">
                  <i class="search icon"></i>
                </div>
                <div class="results"></div>
              </div>
            </div>
            <div class="center aligned sixteen wide column">
              <h2 id="stock-name-header" class="ui header live-data selected-symbol" data-symbol="{{ @vars.symbol }}" data-field="shortName"></h2>
              <h4 id="stock-exchange-name" class="ui header"><i class="{{ @vars.asset.exchange_country_code }} flag"></i>{{ @vars.asset.exchange_name }}</h4>
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
          </div>
    
        <div id="stock-tabs" class="ui stackable one column grid">
            <div class="column">
          <div id="stock-tabs-menu" class="ui pointing {{ @SITE.BACKGROUND=='black'?'inverted':'' }} {{ @SITE.MAIN_COLOR }} menu">
            <a class="active item" data-tab="tab-market-data">{{ @trade.menu.marketdata }}</a>
          </div>
    
              <div class="ui active tab" data-tab="tab-market-data">
                <table id="stock-market-data" class="ui striped selectable fixed table stackable">
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
    </div>

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

<div class="ui inverted vertical footer segment">
    <div class="ui center aligned container">
        <div class="ui inverted section divider"></div>
        <div class="tablet-and-below-center column"><h4 class="ui inverted header"><img src="{{@BASE}}/assets/images/footer.png" class="ui tinyup image">
        {{ @website.title }}. {{ @footer.text }}
      <div class="ui inverted section divider"></div>
    </div>

<include href="{{ @tpl.analytics }}" />
</body>
</html>