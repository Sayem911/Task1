<div id="markets" class="ui container">
  <div class="ui stackable one column grid">
    <include if="{{ @ADSENSE.CLIENT_ID && @ADSENSE.SLOT_ID }}" href="{{ @tpl.adsense }}" />
    
    <div class="left aligned sixteen wide column">
        <div class="column">
            <div class="ui piled segment">
              <span class="ui {{ @SITE.MAIN_COLOR }} ribbon label"><i class="line chart icon"></i> {{ @website.menu.markets }}</span>
              <span>{{ @portfolio.markets.title1 }}</span>
              <p><!-- TradingView Widget BEGIN -->
<div class="tradingview-widget-container">
  <div class="tradingview-widget-container__widget"></div>
  <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
  {
  "symbols": [
    {
      "proName": "FOREXCOM:SPXUSD",
      "title": "SP 500"
    },
    {
      "proName": "FOREXCOM:NSXUSD",
      "title": "US 100"
    },
    {
      "proName": "FX_IDC:EURUSD",
      "title": "EUR/USD"
    },
    {
      "proName": "BITSTAMP:BTCUSD",
      "title": "Bitcoin"
    },
    {
      "proName": "BITSTAMP:ETHUSD",
      "title": "Ethereum"
    }
  ],
  "showSymbolLogo": true,
  "colorTheme": "light",
  "isTransparent": false,
  "displayMode": "adaptive",
  "locale": "de_DE"
}
  </script>
</div>
<!-- TradingView Widget END --></p>
            </div>
          </div>
        </div>

    
    <div class="left aligned sixteen wide column">
        <div class="column">
            <div class="ui piled segment">
              <span class="ui {{ @SITE.MAIN_COLOR }} ribbon label"><i class="line chart icon"></i> {{ @website.menu.markets }}</span>
              <span>{{ @portfolio.markets.title1 }}</span>
              <p><!-- TradingView Widget BEGIN -->
<div class="tradingview-widget-container">
  <div id="tradingview_6bef0"></div>
  <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
  <script type="text/javascript">
  new TradingView.widget(
  {
  "width": "100%",
  "height": 610,
  "symbol": "XETR:BAYN",
  "interval": "D",
  "timezone": "Etc/UTC",
  "theme": "light",
  "style": "1",
  "locale": "de_DE",
  "toolbar_bg": "#f1f3f6",
  "enable_publishing": false,
  "allow_symbol_change": true,
  "container_id": "tradingview_47ae6"
}
  );
  </script>
</div>
<!-- TradingView Widget END --></p>
            </div>
          </div>
        </div>
    <div class="left aligned sixteen wide column">
        <div class="column">
            <div class="ui piled segment">
              <span class="ui {{ @SITE.MAIN_COLOR }} ribbon label">{{ @website.menu.markets }}</span>
              <span>{{ @portfolio.markets.title1 }}</span>
              <p><!-- TradingView Widget BEGIN -->
<div class="tradingview-widget-container">
  <div class="tradingview-widget-container__widget"></div>
  <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-market-quotes.js" async>
  {
  "width": "1100",
  "height": "350",
  "symbolsGroups": [
    {
      "name": "Indizes",
      "originalName": "Indices",
      "symbols": [
        {
          "name": "FOREXCOM:SPXUSD",
          "displayName": "S&P 500"
        },
        {
          "name": "FOREXCOM:NSXUSD",
          "displayName": "US 100"
        },
        {
          "name": "FOREXCOM:DJI",
          "displayName": "Dow 30"
        },
        {
          "name": "INDEX:NKY",
          "displayName": "Nikkei 225"
        },
        {
          "name": "INDEX:DEU40",
          "displayName": "DAX Index"
        },
        {
          "name": "FOREXCOM:UKXGBP",
          "displayName": "UK 100"
        }
      ]
    },
    {
      "name": "Futures",
      "originalName": "Futures",
      "symbols": [
        {
          "name": "CME_MINI:ES1!",
          "displayName": "S&P 500"
        },
        {
          "name": "CME:6E1!",
          "displayName": "Euro"
        },
        {
          "name": "COMEX:GC1!",
          "displayName": "Gold"
        },
        {
          "name": "NYMEX:CL1!",
          "displayName": "Crude Oil"
        },
        {
          "name": "NYMEX:NG1!",
          "displayName": "Natural Gas"
        },
        {
          "name": "CBOT:ZC1!",
          "displayName": "Corn"
        }
      ]
    },
    {
      "name": "Anleihen",
      "originalName": "Bonds",
      "symbols": [
        {
          "name": "CME:GE1!",
          "displayName": "Eurodollar"
        },
        {
          "name": "CBOT:ZB1!",
          "displayName": "T-Bond"
        },
        {
          "name": "CBOT:UB1!",
          "displayName": "Ultra T-Bond"
        },
        {
          "name": "EUREX:FGBL1!",
          "displayName": "Euro Bund"
        },
        {
          "name": "EUREX:FBTP1!",
          "displayName": "Euro BTP"
        },
        {
          "name": "EUREX:FGBM1!",
          "displayName": "Euro BOBL"
        }
      ]
    },
    {
      "name": "Devisen",
      "originalName": "Forex",
      "symbols": [
        {
          "name": "FX:EURUSD",
          "displayName": "EUR/USD"
        },
        {
          "name": "FX:GBPUSD",
          "displayName": "GBP/USD"
        },
        {
          "name": "FX:USDJPY",
          "displayName": "USD/JPY"
        },
        {
          "name": "FX:USDCHF",
          "displayName": "USD/CHF"
        },
        {
          "name": "FX:AUDUSD",
          "displayName": "AUD/USD"
        },
        {
          "name": "FX:USDCAD",
          "displayName": "USD/CAD"
        }
      ]
    }
  ],
  "showSymbolLogo": true,
  "colorTheme": "light",
  "isTransparent": false,
  "locale": "de_DE"
}
  </script>
</div>
<!-- TradingView Widget END --></p>
            </div>
          </div>
        </div>






</div>