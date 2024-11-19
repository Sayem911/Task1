<div class="ui container">
  <div class="ui stackable one column grid">
    <include if="{{ @ADSENSE.CLIENT_ID && @ADSENSE.SLOT_ID }}" href="{{ @tpl.adsense }}" />
    <div class="column">
      <div class="ui piled segment">
        <span class="ui {{ @SITE.MAIN_COLOR }} ribbon label"><i class="travel icon"></i> {{ @title.cryptopayments }}</span>
      </div>
    </div>
    <div class="column">
        <div id="cryptopayments-menu" class="ui pointing {{ @SITE.BACKGROUND=='black'?'inverted':'' }} {{ @SITE.MAIN_COLOR }} menu">
            <a class="active item" data-tab="tab-payments">{{ @crypto.payments.tab_payments }}</a>
            <a class="item" data-tab="tab-paymentslist">{{ @crypto.payments.tab_paymentslist }}</a>
        </div>
        <div class="ui hidden divider"></div>
        <div id="tab-payments" class="ui active tab" data-tab="tab-payments">
            <div class="column">
            <check if="{{ @CRYPTO.BTC_WALLET || @CRYPTO.ETH_WALLET || @CRYPTO.USDT_WALLET || @CRYPTO.USDC_WALLET }}">
                <true>
                    <div class="ui piled segment">
            <div class="ui link cards centered">
                <check if="{{ @CRYPTO.BTC_WALLET }}">
                <true>
                    <div class="card btc-card">
                        <div class="image">
                            <img src="{{ @BASE }}/assets/images/bitcoin.png">
                        </div>
                        <div class="content">
                            <div class="header">{{ @crypto.cards.btc_title }}</div>
                            <div class="description">{{ @crypto.cards.btc_desc }}</div>
                        </div>
                    </div>
                    <form id="modal-btc-payment" class="ui skip-submission-check form payment-form tiny action modal">
                        <i class="close icon"></i>
                        <div class="header">
                          {{ @title.cryptopayments }}
                        </div>
                        <div class="content">
                            <div class="ui error message"></div>
                            <div class="ui result message"></div>
                            <div class="ui centered grid">
                                <div class="row">
                                    <div class="column">
                                        <div class="ui center aligned segment">
                                            <h2 class="ui header">Bitcoin (BTC)</h2>
                                            <p>
                                                <img class="ui centered small image" src="{{ @BASE }}/api/actions/qrcode/generate/{{ @CRYPTO.BTC_WALLET }}" />
                                            </p>
                                            <p>Diese Brieftaschenadresse unterstützt nur BTC Zahlungen. Es unterstützt nicht-fungibele Token.</p>
                                            <div class="ui labeled button" tabindex="0">
                                              <div class="ui {{ @SITE.MAIN_COLOR }} button">
                                                <i class="bitcoin icon"></i> Wallet
                                            </div>
                                              <a class="ui basic {{ @SITE.MAIN_COLOR }} left pointing label">{{ @CRYPTO.BTC_WALLET }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ui piled segment">
                                <div class="ui stackable two column grid">
                                    <div class="column">
                                        <div class="item"><span class=" value live-data selected-symbol" data-symbol="BTC-EUR" data-field="quoteType" data-format="fmtString"></span><span class="dot"></span><span class="symbol value">{{ @vars.symbol }}</span></div>
                                        <div class="item header"><span class="short-name live-data selected-symbol" data-symbol="BTC-EUR" data-field="shortName"></span></div>
                                        <div class="item"><span class="stock-exchange-name ui header"><i class="bitcoin icon"></i>{{ @vars.asset.exchange_name }}</span></div>
                                    </div>
                                    <div class="column right aligned">
                                        <div class="item"><span class="live-data selected-symbol" data-symbol="BTC-EUR" data-format="fmtDate" data-field="regularMarketTime"></span></div>
                                        <div class="item header"><span class="current-price value live-data selected-symbol" data-symbol="BTC-EUR" data-field="regularMarketPrice" data-format="fmtDecimal" data-callback="clbEnableDisableTrading" data-check-trading="true"></span>&nbsp;<span class=" value live-data selected-symbol" data-symbol="BTC-EUR" data-field="currency" data-format="fmtString"></span></div>
                                        <div class="item"><span class=" value live-data selected-symbol" data-symbol="BTC-EUR" data-field="regularMarketChangePercent" data-format="fmtUpDownIndicatorWithPercent" data-format-args="regularMarketChange,regularMarketChangePercent"></span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="ui hidden divider"></div>
                            <div class="ui form">
                                <div class="two fields">
                                    <div class="field">
                                        <div class="ui fluid icon input">
                                            <input type="text" name="amount" class="amount" placeholder="{{ @crypto.payment.amount.placeholder }}" />
                                            <i class="euro icon"></i>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="ui fluid icon input">
                                            <input type="text" name="total" class="total" placeholder="{{ @crypto.payment.amount.placeholder }} (BTC)" disabled />
                                            <i class="bitcoin icon"></i>
                                        </div>
                                    </div>
                                    <input type="hidden" name="wallet" value="{{ @CRYPTO.ETH_WALLET }}" />
                                    <input type="hidden" name="symbol" value="BTC" />

                                </div>
                            </div>

                        </div>
                        <div class="actions">
                            <div class="ui {{ @SITE.MAIN_COLOR }} submit button">{{ @crypto.payment.edit.save.button }}</i></div>
                        </div>
                    </form>
                    
                </true>
                </check>
                <check if="{{ @CRYPTO.ETH_WALLET }}">
                <true>
                    <div class="card eth-card">
                        <div class="image">
                            <img src="{{ @BASE }}/assets/images/ethereum.png" >
                        </div>
                        <div class="content">
                            <div class="header">{{ @crypto.cards.eth_title }}</div>
                            <div class="description">{{ @crypto.cards.eth_desc }}</div>
                        </div>
                    </div>
                    <form id="modal-eth-payment" class="ui skip-submission-check form payment-form tiny action modal">
                        <i class="close icon"></i>
                        <div class="header">
                          {{ @title.cryptopayments }}
                        </div>
                        <div class="content">
                            <div class="ui error message"></div>
                            <div class="ui result message"></div>
                            <div class="ui centered grid">
                                <div class="row">
                                    <div class="column">
                                        <div class="ui center aligned segment">
                                            <h2 class="ui header">Ethereum (ETH)</h2>
                                            <p>
                                                <img class="ui centered small image" src="{{ @BASE }}/api/actions/qrcode/generate/{{ @CRYPTO.ETH_WALLET }}" />
                                            </p>
                                            <p>Diese Brieftaschenadresse unterstützt nur ETH Zahlungen. Es unterstützt nicht-fungibele Token.</p>
                                            <div class="ui labeled button" tabindex="0">
                                              <div class="ui {{ @SITE.MAIN_COLOR }} button">
                                                <i class="bitcoin icon"></i> Wallet
                                            </div>
                                              <a class="ui basic {{ @SITE.MAIN_COLOR }} left pointing label">{{ @CRYPTO.ETH_WALLET }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ui piled segment">
                                <div class="ui stackable two column grid">
                                    <div class="column">
                                        <div class="item"><span class="value live-data selected-symbol" data-symbol="ETH-EUR" data-field="quoteType" data-format="fmtString"></span><span class="dot"></span><span class="symbol value">{{ @vars.symbol }}</span></div>
                                        <div class="item header"><span class="short-name live-data selected-symbol" data-symbol="ETH-EUR" data-field="shortName"></span></div>
                                        <div class="item"><span class="stock-exchange-name ui header"><i class="ethereum icon"></i>{{ @vars.asset.exchange_name }}</span></div>
                                    </div>
                                    <div class="column right aligned">
                                        <div class="item"><span class="live-data selected-symbol" data-symbol="ETH-EUR" data-format="fmtDate" data-field="regularMarketTime"></span></div>
                                        <div class="item header"><span class="current-price value live-data selected-symbol" data-symbol="ETH-EUR" data-field="regularMarketPrice" data-format="fmtDecimal" data-callback="clbEnableDisableTrading" data-check-trading="true"></span>&nbsp;<span class=" value live-data selected-symbol" data-symbol="ETH-EUR" data-field="currency" data-format="fmtString"></span></div>
                                        <div class="item"><span class="value live-data selected-symbol" data-symbol="ETH-EUR" data-field="regularMarketChangePercent" data-format="fmtUpDownIndicatorWithPercent" data-format-args="regularMarketChange,regularMarketChangePercent"></span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="ui hidden divider"></div>
                            <div class="ui form">
                                <div class="two fields">
                                    <div class="field">
                                        <div class="ui fluid icon input">
                                            <input type="text" name="amount" class="amount" placeholder="{{ @crypto.payment.amount.placeholder }}" />
                                            <i class="euro icon"></i>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="ui fluid icon input">
                                            <input type="text" name="total" class="total" placeholder="{{ @crypto.payment.amount.placeholder }} (ETH)" disabled />
                                            <i class="ethereum icon"></i>
                                        </div>
                                    </div>
                                    <input type="hidden" name="wallet" value="{{ @CRYPTO.ETH_WALLET }}" />
                                    <input type="hidden" name="symbol" value="ETH" />

                                </div>
                            </div>
                        </div>
                        <div class="actions">
                            <div id="add-payment" class="ui {{ @SITE.MAIN_COLOR }} submit button">{{ @crypto.payment.edit.save.button }}</i></div>
                        </div>
                    </form>
                    
                </true>
                </check>
                <check if="{{ @CRYPTO.USDT_WALLET }}">
                <true>
                    <div class="card usdt-card">
                        <div class="image">
                            <img src="{{ @BASE }}/assets/images/tether-usdt.png">
                        </div>
                        <div class="content">
                            <div class="header">{{ @crypto.cards.usdt_title }}</div>
                            <div class="description">{{ @crypto.cards.usdt_desc }}</div>
                        </div>
                    </div>
                    <form id="modal-usdt-payment" class="ui skip-submission-check form payment-form tiny action modal">
                        <i class="close icon"></i>
                        <div class="header">
                          {{ @title.cryptopayments }}
                        </div>
                        <div class="content">
                            <div class="ui error message"></div>
                            <div class="ui result message"></div>
                            <div class="ui centered grid">
                                <div class="row">
                                    <div class="column">
                                        <div class="ui center aligned segment">
                                            <h2 class="ui header">Tether USD (USDT)</h2>
                                            <p>
                                                <img class="ui centered small image" src="{{ @BASE }}/api/actions/qrcode/generate/{{ @CRYPTO.USDT_WALLET }}" />
                                            </p>
                                            <p>Diese Brieftaschenadresse unterstützt nur USDT Zahlungen. Es unterstützt nicht-fungibele Token.</p>
                                            <div class="ui labeled button" tabindex="0">
                                              <div class="ui {{ @SITE.MAIN_COLOR }} button">
                                                <i class="bitcoin icon"></i> Wallet
                                            </div>
                                              <a class="ui basic {{ @SITE.MAIN_COLOR }} left pointing label">{{ @CRYPTO.USDT_WALLET }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ui piled segment">
                                <div class="ui stackable two column grid">
                                    <div class="column">
                                        <div class="item"><span class=" value live-data selected-symbol" data-symbol="USDT-EUR" data-field="quoteType" data-format="fmtString"></span><span class="dot"></span><span class="symbol value">{{ @vars.symbol }}</span></div>
                                        <div class="item header"><span class="short-name live-data selected-symbol" data-symbol="USDT-EUR" data-field="shortName"></span></div>
                                        <div class="item"><span class="stock-exchange-name ui header"><i class="usd icon"></i>{{ @vars.asset.exchange_name }}</span></div>
                                    </div>
                                    <div class="column right aligned">
                                        <div class="item"><span class="live-data selected-symbol" data-symbol="USDT-EUR" data-format="fmtDate" data-field="regularMarketTime"></span></div>
                                        <div class="item header"><span class="current-price value live-data selected-symbol" data-symbol="USDT-EUR" data-field="regularMarketPrice" data-format="fmtDecimal" data-callback="clbEnableDisableTrading" data-check-trading="true"></span>&nbsp;<span class=" value live-data selected-symbol" data-symbol="USDT-EUR" data-field="currency" data-format="fmtString"></span></div>
                                        <div class="item"><span class=" value live-data selected-symbol" data-symbol="USDT-EUR" data-field="regularMarketChangePercent" data-format="fmtUpDownIndicatorWithPercent" data-format-args="regularMarketChange,regularMarketChangePercent"></span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="ui hidden divider"></div>
                            <div class="ui form">
                                <div class="two fields">
                                    <div class="field">
                                        <div class="ui fluid icon input">
                                            <input type="text" name="amount" class="amount" placeholder="{{ @crypto.payment.amount.placeholder }}" />
                                            <i class="euro icon"></i>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="ui fluid icon input">
                                            <input type="text" name="total" class="total" placeholder="{{ @crypto.payment.amount.placeholder }} (USDT)" disabled />
                                            <i class="usd icon"></i>
                                        </div>
                                    </div>
                                    <input type="hidden" name="wallet" value="{{ @CRYPTO.USDT_WALLET }}" />
                                    <input type="hidden" name="symbol" value="USDT" />

                                </div>
                            </div>
                        </div>
                        <div class="actions">
                            <div class="ui {{ @SITE.MAIN_COLOR }} submit button">{{ @crypto.payment.edit.save.button }}</i></div>
                        </div>
                    </form>
                </true>
                </check>
                <check if="{{ @CRYPTO.USDC_WALLET }}">
                <true>
                    <div class="card usdc-card">
                        <div class="image">
                            <img src="{{ @BASE }}/assets/images/usd-coin-usdc.png">
                        </div>
                        <div class="content">
                            <div class="header">{{ @crypto.cards.usdc_title }}</div>
                            <div class="description">{{ @crypto.cards.usdc_desc }}</div>
                        </div>
                    </div>
                    <form id="modal-usdc-payment" class="ui skip-submission-check form payment-form tiny action modal">
                        <i class="close icon"></i>
                        <div class="header">
                          {{ @title.cryptopayments }}
                        </div>
                        <div class="content">
                            <div class="ui error message"></div>
                            <div class="ui result message"></div>
                            <div class="ui centered grid">
                                <div class="row">
                                    <div class="column">
                                        <div class="ui center aligned segment">
                                            <h2 class="ui header">Tether USD (USDC)</h2>
                                            <p>
                                                <img class="ui centered small image" src="{{ @BASE }}/api/actions/qrcode/generate/{{ @CRYPTO.USDC_WALLET }}" />
                                            </p>
                                            <p>Diese Brieftaschenadresse unterstützt nur USDC Zahlungen. Es unterstützt nicht-fungibele Token.</p>
                                            <div class="ui labeled button" tabindex="0">
                                              <div class="ui {{ @SITE.MAIN_COLOR }} button">
                                                <i class="bitcoin icon"></i> Wallet
                                            </div>
                                              <a class="ui basic {{ @SITE.MAIN_COLOR }} left pointing label">{{ @CRYPTO.USDC_WALLET }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ui piled segment">
                                <div class="ui stackable two column grid">
                                    <div class="column">
                                        <div class="item"><span class=" value live-data selected-symbol" data-symbol="USDC-EUR" data-field="quoteType" data-format="fmtString"></span><span class="dot"></span><span class="symbol value">{{ @vars.symbol }}</span></div>
                                        <div class="item header"><span class="short-name live-data selected-symbol" data-symbol="USDC-EUR" data-field="shortName"></span></div>
                                        <div class="item"><span class="stock-exchange-name ui header"><i class="usd icon"></i>{{ @vars.asset.exchange_name }}</span></div>
                                    </div>
                                    <div class="column right aligned">
                                        <div class="item"><span class="live-data selected-symbol" data-symbol="USDC-EUR" data-format="fmtDate" data-field="regularMarketTime"></span></div>
                                        <div class="item header"><span class="current-price value live-data selected-symbol" data-symbol="USDC-EUR" data-field="regularMarketPrice" data-format="fmtDecimal" data-callback="clbEnableDisableTrading" data-check-trading="true"></span>&nbsp;<span class=" value live-data selected-symbol" data-symbol="USDC-EUR" data-field="currency" data-format="fmtString"></span></div>
                                        <div class="item"><span class=" value live-data selected-symbol" data-symbol="USDC-EUR" data-field="regularMarketChangePercent" data-format="fmtUpDownIndicatorWithPercent" data-format-args="regularMarketChange,regularMarketChangePercent"></span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="ui hidden divider"></div>
                            <div class="ui form">
                                <div class="two fields">
                                    <div class="field">
                                        <div class="ui fluid icon input">
                                            <input type="text" name="amount" class="amount" placeholder="{{ @crypto.payment.amount.placeholder }}" />
                                            <i class="euro icon"></i>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="ui fluid icon input">
                                            <input type="text" name="total" class="total" placeholder="{{ @crypto.payment.amount.placeholder }} (USDC)" disabled />
                                            <i class="usd icon"></i>
                                        </div>
                                    </div>
                                    <input type="hidden" name="wallet" value="{{ @CRYPTO.USDC_WALLET }}" />
                                    <input type="hidden" name="symbol" value="USDC" />

                                </div>
                            </div>
                        </div>
                        <div class="actions">
                            <div class="ui {{ @SITE.MAIN_COLOR }} submit button">{{ @crypto.payment.edit.save.button }}</i></div>
                        </div>
                    </form>
                </true>
                </check>
            </div>
            </div>
                </true>
            </check>
            <div class="ui hidden divider"></div>
            <div class="ui piled segment">
            <div class="ui three column grid">
                <div class="column">
                    <div class="ui fluid card">
                        <div class="content">
                            <p class="header">
                                <div class="tradingview-widget-container">
                                    <div class="tradingview-widget-container__widget"></div>
                                    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js" async>
                                    {
                                        "symbol": "BINANCE:BTCEUR",
                                        "width": "100%",
                                        "colorTheme": "light",
                                        "isTransparent": false,
                                        "locale": "de_DE"
                                    }
                                    </script>
                                </div>
                            </p>
                        </div>
                    </div>
                    
                </div>
                <div class="column">
                    <div class="ui fluid card">
                        <div class="content">
                        <p class="header">
                            <div class="tradingview-widget-container">
                                <div class="tradingview-widget-container__widget"></div>
                                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js" async>
                                {
                                    "symbol": "BINANCE:ETHEUR",
                                    "width": "100%",
                                    "colorTheme": "light",
                                    "isTransparent": false,
                                    "locale": "de_DE"
                                }
                                </script>
                            </div>
                        </p>
                        </div>
                    </div>
                    
                </div>

                <div class="column">
                    <div class="ui fluid card">
                        <div class="content">
                            <p class="header">
                                <div class="tradingview-widget-container">
                                <div class="tradingview-widget-container__widget"></div>
                                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js" async>
                                {
                                    "symbol": "BINANCE:EURUSDT",
                                    "width": "100%",
                                    "colorTheme": "light",
                                    "isTransparent": false,
                                    "locale": "de_DE"
                                }
                                </script>
                                </div>
                            </p>
                        </div>
                    </div>
                    
                </div>
            </div>
            </div>
            <div class="ui hidden divider"></div>
            <div class="ui piled segment">
            <div class="tradingview-widget-container">
                <div class="tradingview-widget-container__widget"></div>
                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-screener.js" async>
                {
                    "width": "1098",
                    "height": "600",
                    "defaultColumn": "overview",
                    "screener_type": "crypto_mkt",
                    "displayCurrency": "USD",
                    "colorTheme": "light",
                    "locale": "de_DE"
                }
                </script>
            </div>
        </div>
        </div> </div>
        <div id="tab-paymentslist" class="ui tab" data-tab="tab-paymentslist">
            <check if="{{ @USER.is_admin }}">
                <div class="ui stackable grid">
                    <div class="four column left row">
                        <div class="column">
                            <div class="ui fluid user search" data-callback="refreshPaymentsList" data-user="{{ @USER.id }}">
                                <div class="ui icon input">
                                <input class="prompt" type="text" value="{{ @USER.first_name.' '.@USER.last_name }}" >
                                <i class="user icon"></i>
                                </div>
                                <div class="results"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ui hidden divider"></div>
                <form id="modal-edit-payment" class="ui skip-submission-check form small action modal" method="post">
                    <i class="close icon"></i>
                    <div class="header">
                      {{ @crypto.payment.edit.title }}
                    </div>
                    <div class="content">
                        <div class="ui error message"></div>
                        <div class="ui result message"></div>
                        <input type="hidden" name="payment_id" value="">
                        <input type="hidden" name="user_id" value="">
                        <div class="field">
                          <div class="ui left labeled input">
                            <div class="ui label">{{ @crypto.payment.edit.wallet }}</div>
                            <input type="text" name="wallet" value="" placeholder="{{ @crypto.payment.edit.wallet }}" disabled />
                          </div>
                        </div>
                        <div class="field">
                          <div class="ui left labeled input right input">
                            <div class="ui label">{{ @crypto.payment.edit.symbol }}</div>
                            <input type="text" name="symbol" value="" placeholder="{{ @crypto.payment.edit.symbol }}" disabled />
                          </div>
                        </div>
                        <div class="field">
                          <div class="ui left labeled input right icon">
                            <div class="ui label">{{ @crypto.payment.edit.amount }}</div>
                            <input type="text" name="amount" value="" placeholder="{{ @crypto.payment.edit.amount }}" />
                            <i class="euro icon"></i>
                          </div>
                        </div>
                        <div class="field">
                          <div class="ui left labeled input right icon">
                            <div class="ui label">{{ @crypto.payment.edit.current }}</div>
                            <input type="text" name="current" value="" placeholder="{{ @crypto.payment.edit.current }}" />
                            <i class="angle right icon"></i>
                          </div>
                        </div>
                        <div class="field">
                          <div class="ui left labeled input right icon">
                            <div class="ui label">{{ @crypto.payment.edit.total }}</div>
                            <input type="text" name="total" value="" placeholder="{{ @crypto.payment.edit.total }}" />
                            <i class="bitcoin icon"></i>
                          </div>
                        </div>
                    </div>
                    <div class="actions">
                        <div class="ui large {{ @SITE.MAIN_COLOR }} right labeled icon submit button">{{ @crypto.payment.edit.save.button }} <i class="checkmark icon"></i></div>
                    </div>
                </form>
                <form id="modal-payment-delete" class="ui skip-submission-check form small action modal" data-action="delete">
                    <input type="hidden" name="id" value="">
                    <i class="close icon"></i>
                    <div class="header">
                      {{ @crypto.payment.delete.title }}
                    </div>
                    <div class="content">
                        <div class="ui error message"></div>
                        <div class="ui result message"></div>
                        <p>{{ @crypto.payment.delete.message }}</p>
                    </div>
                    <div class="actions">
                        <div class="ui large {{ @SITE.MAIN_COLOR }} right labeled icon submit button">{{ @crypto.payment.delete.button }} <i class="checkmark icon"></i></div>
                    </div>
                </form>            
            </check>            
            <table id="payments-list" class="ui sortable celled {{ @SITE.MAIN_COLOR }} table">
                <thead><tr>
                    <check if="{{ @USER.is_admin }}">
                    <th class="left aligned">{{ @crypto.payments.list_name }}</th>
                    </check>
                    <th class="center aligned">{{ @crypto.payments.list_symbol }}</th>
                    <th class="center aligned">{{ @crypto.payments.list_wallet }}</th>
                    <th class="center aligned">{{ @crypto.payments.list_amount }}</th>
                    <th class="center aligned">{{ @crypto.payments.list_current }}</th>
                    <th class="center aligned">{{ @crypto.payments.list_total }}</th>
                    <th class="center aligned">{{ @crypto.payments.list_date }}</th>
                    <check if="{{ @USER.is_admin }}">
                    <th class="center aligned"></th>
                    </check>
                </tr></thead>
                <tbody>
                </tbody>
            </table>
        </div>
  </div>
</div>

