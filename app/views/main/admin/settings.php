<div class="ui container">
  <div class="left aligned sixteen wide column">
    <div class="column">
      <check if="{{ @SESSION.message }}">
        <div class="ui {{ @SESSION.message.type }} message">
          <i class="close icon"></i>
          <p>{{ @SESSION.message.text|raw }}</p>
        </div>
      </check>
      
      <div class="ui piled segment">
      <span class="ui {{ @SITE.MAIN_COLOR }} ribbon label"><i class="settings icon"></i> {{ @settings.title }}
      </span>
      </div>
      
        <div class="ui piled segment">
        <form class="ui form" method="POST" action="{{ @BASE }}{{ @PATH }}">
          <div class="ui stackable grid">
            <div class="four wide column">
              <div id="settings-tabs-menu" class="ui secondary pointing stackable fluid vertical {{ @SITE.BACKGROUND=='black'?'inverted':'' }} {{ @SITE.MAIN_COLOR }} menu">
                <a class="active item" data-tab="tab-general">{{ @settings.menu.general }}</a>
                <a class="item" data-tab="tab-markets">{{ @settings.menu.markets }}</a>
                <a class="item" data-tab="tab-trade">{{ @settings.menu.trade }}</a>
                <a class="item" data-tab="tab-portfolio">{{ @settings.menu.portfolio }}</a>
                <a class="item" data-tab="tab-paypal">{{ @settings.menu.paypal }}</a>
                <a class="item" data-tab="tab-crypto">{{ @settings.menu.crypto }}</a>
                <a class="item" data-tab="tab-subscription">{{ @settings.menu.subscription }}</a>
                <a class="item" data-tab="tab-credits">{{ @settings.menu.credits }}</a>
                <a class="item" data-tab="tab-referrals">{{ @settings.menu.referrals }}</a>
                <a class="item" data-tab="tab-social">{{ @settings.menu.social }}</a>
                <a class="item" data-tab="tab-analytics">{{ @settings.menu.analytics }}</a>
                <a class="item" data-tab="tab-adsense">{{ @settings.menu.adsense }}</a>
                <a class="item" data-tab="tab-mailchimp">{{ @settings.menu.mailchimp }}</a>
                <a class="item" data-tab="tab-security">{{ @settings.menu.security }}</a>
                <a class="item" data-tab="tab-smtp">{{ @settings.menu.smtp }}</a>
                <a class="item" data-tab="tab-debug">{{ @settings.menu.debug }}</a>
              </div>
            </div>

            <div class="twelve wide column">
              <div class="ui active tab" data-tab="tab-general">
                <div class="field">
                  <label>{{ @settings.general.color.title }}</label>
                  <div class="ui fluid selection dropdown">
                    <input type="hidden" name="SITE#MAIN_COLOR" value="{{ @SITE.MAIN_COLOR }}">
                    <i class="dropdown icon"></i>
                    <div class="default text">{{ @settings.general.color.dropdown }}</div>
                    <div class="menu">
                      <repeat group="{{ ['red' => @settings.general.color.red, 'orange' => @settings.general.color.orange, 'yellow' => @settings.general.color.yellow, 'olive' => @settings.general.color.olive, 'green' => @settings.general.color.green, 'teal' => @settings.general.color.teal, 'blue' => @settings.general.color.blue, 'violet' => @settings.general.color.violet, 'purple' => @settings.general.color.purple, 'pink' => @settings.general.color.pink, 'brown' => @settings.general.color.brown, 'grey' => @settings.general.color.grey, 'black' => @settings.general.color.black] }}" key="{{ @color_code }}" value="{{ @color_name }}">
                        <div class="item" data-value="{{ @color_code }}"><i class="stop {{ @color_code }} icon"></i>{{ @color_name }}</div>
                      </repeat>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <label>{{ @settings.general.background.title }}</label>
                  <div class="ui fluid selection dropdown">
                    <input type="hidden" name="SITE#BACKGROUND" value="{{ @SITE.BACKGROUND }}">
                    <i class="dropdown icon"></i>
                    <div class="default text">{{ @settings.general.background.dropdown }}</div>
                    <div class="menu">
                      <repeat group="{{ ['white' => @settings.general.background.color.white, 'black' => @settings.general.background.color.black] }}" key="{{ @color_code }}" value="{{ @color_name }}">
                        <div class="item" data-value="{{ @color_code }}">{{ @color_name }}</div>
                      </repeat>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <label>{{ @settings.general.language.title }}</label>
                  <div class="ui fluid selection dropdown">
                    <input type="hidden" name="SITE#LANGUAGE" value="{{ @SITE.LANGUAGE }}">
                    <i class="dropdown icon"></i>
                    <div class="default text">{{ @settings.general.language.dropdown }}</div>
                    <div class="menu">
                      <repeat group="{{ @vars.languages }}" value="{{ @language }}">
                        <div class="item" data-value="{{ @language }}"><i class="{{ str_replace('en','us',@language) }} flag"></i>{{ @language }}</div>
                      </repeat>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <label>{{ @settings.general.timezone.title }} <i class="question circular icon link" data-content="{{ @settings.general.timezone.hint }}"></i></label>
                  <select id="timezone-dropdown" class="ui search selection dropdown" name="SITE#TIMEZONE"></select>
                </div>
                <div class="field">
                  <label>{{ @settings.general.email.title }} <i class="question circular icon link" data-content="{{ @settings.general.email.hint }}"></i></label>
                  <input type="text" name="SITE#EMAIL" value="{{ @SITE.EMAIL }}">
                </div>
                <div class="field">
                  <div class="ui toggle checkbox">
                    <label>{{ @settings.general.verification.title }} <i class="question circular icon link" data-content="{{ @settings.general.verification.hint }}"></i></label>
                    <input type="checkbox" {{ @SITE.EMAIL_VERIFICATION==1?'checked="checked"':'' }} name="SITE#EMAIL_VERIFICATION" value="{{ @SITE.EMAIL_VERIFICATION }}">
                    <input type="hidden" name="SITE#EMAIL_VERIFICATION" value="0" {{ @SITE.EMAIL_VERIFICATION==1?'disabled':'' }}>
                  </div>
                </div>
              </div>

              <div class="ui tab" data-tab="tab-markets">
                <div class="field">
                  <label>{{ @settings.markets.clock1.title }}</label>
                  <input type="text" name="MARKETS#CLOCK1_NAME" value="{{ @MARKETS.CLOCK1_NAME }}">
                </div>
                <div class="field">
                  <label>{{ @settings.markets.clock1.offset }}</label>
                  <input type="text" name="MARKETS#CLOCK1_OFFSET" value="{{ @MARKETS.CLOCK1_OFFSET }}">
                </div>
                <div class="field">
                  <label>{{ @settings.markets.clock2.title }}</label>
                  <input type="text" name="MARKETS#CLOCK2_NAME" value="{{ @MARKETS.CLOCK2_NAME }}">
                </div>
                <div class="field">
                  <label>{{ @settings.markets.clock2.offset }}</label>
                  <input type="text" name="MARKETS#CLOCK2_OFFSET" value="{{ @MARKETS.CLOCK2_OFFSET }}">
                </div>
                <div class="field">
                  <label>{{ @settings.markets.clock3.title }}</label>
                  <input type="text" name="MARKETS#CLOCK3_NAME" value="{{ @MARKETS.CLOCK3_NAME }}">
                </div>
                <div class="field">
                  <label>{{ @settings.markets.clock3.offset }}</label>
                  <input type="text" name="MARKETS#CLOCK3_OFFSET" value="{{ @MARKETS.CLOCK3_OFFSET }}">
                </div>
                <div class="field">
                  <label>{{ @settings.markets.clock4.title }}</label>
                  <input type="text" name="MARKETS#CLOCK4_NAME" value="{{ @MARKETS.CLOCK4_NAME }}">
                </div>
                <div class="field">
                  <label>{{ @settings.markets.clock4.offset }}</label>
                  <input type="text" name="MARKETS#CLOCK4_OFFSET" value="{{ @MARKETS.CLOCK4_OFFSET }}">
                </div>
                <div class="field">
                  <label>{{ @settings.markets.indexes.title }} <i class="question circular icon link" data-content="{{ @settings.markets.indexes.hint }}"></i></label>
                  <input type="text" name="MARKETS#STOCK_INDEXES" value="{{ implode(',',@MARKETS.STOCK_INDEXES) }}">
                </div>
                <div class="field">
                  <label>{{ @settings.markets.currencies.title }} <i class="question circular icon link" data-content="{{ @settings.markets.currencies.hint }}"></i></label>
                  <input type="text" name="MARKETS#CURRENCIES" value="{{ implode(',',@MARKETS.CURRENCIES) }}">
                </div>
                <div class="field">
                  <label>{{ @settings.markets.newsfeed.title }} <i class="question circular icon link" data-content="{{ @settings.markets.newsfeed.hint }}"></i></label>
                  <input type="text" name="MARKETS#NEWS_FEED_URL" value="{{ @MARKETS.NEWS_FEED_URL }}">
                </div>
                <div class="field">
                  <label>{{ @settings.markets.watchlist.title }} <i class="question circular icon link" data-content="{{ @settings.markets.watchlist.hint }}"></i></label>
                  <input type="text" name="MARKETS#DEFAULT_WATCHLIST" value="{{ implode(',',@MARKETS.DEFAULT_WATCHLIST) }}">
                </div>
              </div>

              <div class="ui tab" data-tab="tab-trade">
                <div class="field">
                  <label>{{ @settings.trade.symbol.title }}</label>
                  <input type="text" name="TRADE#DEFAULT_SYMBOL" value="{{ @TRADE.DEFAULT_SYMBOL }}">
                </div>
                <div class="field">
                  <label>{{ @settings.trade.balance.title }}</label>
                  <input type="text" name="TRADE#INITIAL_BALANCE" value="{{ @TRADE.INITIAL_BALANCE }}">
                </div>
                <div class="field">
                  <label>{{ @settings.trade.commission.title }} <i class="question circular icon link" data-content="{{ @settings.trade.commission.hint }}"></i></label>
                  <input type="text" name="TRADE#COMMISSION" value="{{ @TRADE.COMMISSION }}">
                </div>
                <div class="field">
                  <label>{{ @settings.trade.currency.title }} <i class="question circular icon link" data-content="{{ @settings.trade.currency.hint }}"></i></label>
                  <div class="ui fluid selection dropdown">
                    <input type="hidden" name="TRADE#ACCOUNT_CURRENCY" value="{{ @TRADE.ACCOUNT_CURRENCY }}">
                    <i class="dropdown icon"></i>
                    <div class="default text">{{ @settings.trade.currency.dropdown }}</div>
                    <div class="menu">
                      <repeat group="{{ ['USD' => 'us', 'GBP' => 'gb', 'EUR' => 'eu', 'CHF' => 'ch', 'CAD' => 'ca', 'AUD' => 'au', 'SEK' => 'se', 'DKK' => 'dk', 'INR' => 'in', 'BRL' => 'br', 'JPY' => 'jp'] }}" key="{{ @ccy }}" value="{{ @country }}">
                        <div class="item" data-value="{{ @ccy }}"><i class="{{ @country }} flag"></i>{{ @ccy }}</div>
                      </repeat>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <div class="ui toggle checkbox">
                    <label>{{ @settings.trade.short_sale.title }} <i class="question circular icon link" data-content="{{ @settings.trade.short_sale.hint }}"></i></label>
                    <input type="checkbox" {{ @TRADE.SHORT_TRADING==1?'checked="checked"':'' }} name="TRADE#SHORT_TRADING" value="{{ @TRADE.SHORT_TRADING }}">
                    <input type="hidden" name="TRADE#SHORT_TRADING" value="0" {{ @TRADE.SHORT_TRADING==1?'disabled':'' }}>
                  </div>
                </div>
              </div>

              <div class="ui tab" data-tab="tab-portfolio">
                <div class="field">
                  <label>{{ @settings.portfolio.positionsnumber.title }} <i class="question circular icon link" data-content="{{ @settings.portfolio.positionsnumber.hint }}"></i></label>
                  <input type="text" name="PORTFOLIO#POSITIONS_PER_PAGE" value="{{ @PORTFOLIO.POSITIONS_PER_PAGE }}">
                </div>
                <div class="field">
                  <label>{{ @settings.portfolio.tradesnumber.title }} <i class="question circular icon link" data-content="{{ @settings.portfolio.tradesnumber.hint }}"></i></label>
                  <input type="text" name="PORTFOLIO#TRADES_PER_PAGE" value="{{ @PORTFOLIO.TRADES_PER_PAGE }}">
                </div>
              </div>

              <div class="ui tab" data-tab="tab-paypal">
                <div class="ui info message">
                  <div class="header">{{ @settings.paypal.info.header }}</div>
                  <p>{{ @settings.paypal.info.message }}</p>
                </div>
                <div class="field">
                  <label>{{ @settings.paypal.paypal_mode.title }}</label>
                  <div class="ui fluid selection dropdown">
                    <input type="hidden" name="PAYPAL#PAYPAL_MODE" value="{{ @PAYPAL.PAYPAL_MODE }}">
                    <i class="dropdown icon"></i>
                    <div class="default text">{{ @settings.paypal.paypal_mode.title }}</div>
                    <div class="menu">
                      <div class="item" data-value="sandbox">{{ @settings.paypal.paypal_mode.sandbox }}</div>
                      <div class="item" data-value="live">{{ @settings.paypal.paypal_mode.live }}</div>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <label>{{ @settings.paypal.paypal_user.title }} <i class="question circular icon link" data-content="{{ @settings.paypal.paypal_user.hint }}"></i></label>
                  <input type="text" name="PAYPAL#PAYPAL_USER" value="{{ @PAYPAL.PAYPAL_USER }}">
                </div>
                <div class="field">
                  <label>{{ @settings.paypal.paypal_password.title }} <i class="question circular icon link" data-content="{{ @settings.paypal.paypal_password.hint }}"></i></label>
                  <input type="text" name="PAYPAL#PAYPAL_PASSWORD" value="{{ @PAYPAL.PAYPAL_PASSWORD }}">
                </div>
                <div class="field">
                  <label>{{ @settings.paypal.paypal_signature.title }} <i class="question circular icon link" data-content="{{ @settings.paypal.paypal_signature.hint }}"></i></label>
                  <input type="text" name="PAYPAL#PAYPAL_SIGNATURE" value="{{ @PAYPAL.PAYPAL_SIGNATURE }}">
                </div>
              </div>

              <div class="ui tab" data-tab="tab-crypto">
                <div class="ui info message">
                  <div class="header">{{ @settings.crypto.info.header }}</div>
                  <p>{{ @settings.crypto.info.message }}</p>
                </div>
                <div class="field">
                  <label>{{ @settings.crypto.btc.title }} <i class="question circular icon link" data-content="{{ @settings.crypto.btc.hint }}"></i></label>
                  <input type="text" name="CRYPTO#BTC_WALLET" value="{{ @CRYPTO.BTC_WALLET }}">
                </div>
                <div class="field">
                  <label>{{ @settings.crypto.eth.title }} <i class="question circular icon link" data-content="{{ @settings.crypto.eth.hint }}"></i></label>
                  <input type="text" name="CRYPTO#ETH_WALLET" value="{{ @CRYPTO.ETH_WALLET }}">
                </div>
                <div class="field">
                  <label>{{ @settings.crypto.usdt.title }} <i class="question circular icon link" data-content="{{ @settings.crypto.usdt.hint }}"></i></label>
                  <input type="text" name="CRYPTO#USDT_WALLET" value="{{ @CRYPTO.USDT_WALLET }}">
                </div>
                <div class="field">
                  <label>{{ @settings.crypto.usdc.title }} <i class="question circular icon link" data-content="{{ @settings.crypto.usdc.hint }}"></i></label>
                  <input type="text" name="CRYPTO#USDC_WALLET" value="{{ @CRYPTO.USDC_WALLET }}">
                </div>
              </div>
              
              <div class="ui tab" data-tab="tab-subscription">
                <div class="ui info message">
                  <div class="header">{{ @settings.paypal.info.header }}</div>
                  <p>{{ @settings.paypal.info.message }}</p>
                </div>
                <div class="fields-group">
                  <div class="state-insensitive field">
                    <div class="ui toggle state-changing checkbox">
                      <label>{{ @settings.subscription.enabled.title }} <i class="question circular icon link" data-content="{{ @settings.subscription.enabled.hint }}"></i></label>
                      <input type="checkbox" {{ @SUBSCRIPTION.SUBSCRIPTION_ENABLED==1?'checked="checked"':'' }} name="SUBSCRIPTION#SUBSCRIPTION_ENABLED" value="{{ @SUBSCRIPTION.SUBSCRIPTION_ENABLED }}">
                      <input type="hidden" name="SUBSCRIPTION#SUBSCRIPTION_ENABLED" value="0" {{ @SUBSCRIPTION.SUBSCRIPTION_ENABLED==1?'disabled':'' }}>
                    </div>
                  </div>
                  <div class="{{ @SUBSCRIPTION.SUBSCRIPTION_ENABLED!=1?'disabled':'' }} field">
                    <label>{{ @settings.subscription.trial.title }} <i class="question circular icon link" data-content="{{ @settings.subscription.trial.hint }}"></i></label>
                    <input type="text" name="SUBSCRIPTION#FREE_TRIAL_PERIOD" value="{{ @SUBSCRIPTION.FREE_TRIAL_PERIOD }}">
                  </div>
                  <div class="fields">
                    <div class="{{ @SUBSCRIPTION.SUBSCRIPTION_ENABLED!=1?'disabled':'' }} field">
                      <label>{{ @settings.subscription.daily_amount.title }} <i class="question circular icon link" data-content="{{ @settings.subscription.daily_amount.hint }}"></i></label>
                      <input type="text" name="SUBSCRIPTION#BILLING_DAILY_AMOUNT" value="{{ @SUBSCRIPTION.BILLING_DAILY_AMOUNT }}">
                    </div>
                    <div class="{{ @SUBSCRIPTION.SUBSCRIPTION_ENABLED!=1?'disabled':'' }} field">
                      <label>{{ @settings.subscription.weekly_amount.title }} <i class="question circular icon link" data-content="{{ @settings.subscription.weekly_amount.hint }}"></i></label>
                      <input type="text" name="SUBSCRIPTION#BILLING_WEEKLY_AMOUNT" value="{{ @SUBSCRIPTION.BILLING_WEEKLY_AMOUNT }}">
                    </div>
                    <div class="{{ @SUBSCRIPTION.SUBSCRIPTION_ENABLED!=1?'disabled':'' }} field">
                      <label>{{ @settings.subscription.monthly_amount.title }} <i class="question circular icon link" data-content="{{ @settings.subscription.monthly_amount.hint }}"></i></label>
                      <input type="text" name="SUBSCRIPTION#BILLING_MONTHLY_AMOUNT" value="{{ @SUBSCRIPTION.BILLING_MONTHLY_AMOUNT }}">
                    </div>
                    <div class="{{ @SUBSCRIPTION.SUBSCRIPTION_ENABLED!=1?'disabled':'' }} field">
                      <label>{{ @settings.subscription.annual_amount.title }} <i class="question circular icon link" data-content="{{ @settings.subscription.annual_amount.hint }}"></i></label>
                      <input type="text" name="SUBSCRIPTION#BILLING_ANNUAL_AMOUNT" value="{{ @SUBSCRIPTION.BILLING_ANNUAL_AMOUNT }}">
                    </div>
                  </div>
                  <div class="{{ @SUBSCRIPTION.SUBSCRIPTION_ENABLED!=1?'disabled':'' }} field">
                    <label>{{ @settings.subscription.currency.title }} <i class="question circular icon link" data-content="{{ @settings.subscription.currency.hint }}"></i></label>
                    <div class="ui fluid selection dropdown">
                      <input type="hidden" name="SUBSCRIPTION#BILLING_CURRENCY" value="{{ @SUBSCRIPTION.BILLING_CURRENCY }}">
                      <i class="dropdown icon"></i>
                      <div class="default text">{{ @settings.subscription.currency.dropdown }}</div>
                      <div class="menu">
                        <repeat group="{{ ['USD' => 'us', 'GBP' => 'gb', 'EUR' => 'eu', 'CHF' => 'ch', 'CAD' => 'ca', 'AUD' => 'au', 'SEK' => 'se', 'DKK' => 'dk', 'BRL' => 'br', 'JPY' => 'jp'] }}" key="{{ @ccy }}" value="{{ @country }}">
                          <div class="item" data-value="{{ @ccy }}"><i class="{{ @country }} flag"></i>{{ @ccy }}</div>
                        </repeat>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="ui tab" data-tab="tab-credits">
                <div class="ui info message">
                  <div class="header">{{ @settings.paypal.info.header }}</div>
                  <p>{{ @settings.paypal.info.message }}</p>
                </div>
                <div class="fields-group">
                  <div class="state-insensitive field">
                    <div class="ui toggle state-changing checkbox">
                      <label>{{ @settings.credits.enabled.title }} <i class="question circular icon link" data-content="{{ @settings.credits.enabled.hint }}"></i></label>
                      <input type="checkbox" {{ @CREDITS.ENABLED==1?'checked="checked"':'' }} name="CREDITS#ENABLED" value="{{ @CREDITS.ENABLED }}">
                      <input type="hidden" name="CREDITS#ENABLED" value="0" {{ @CREDITS.ENABLED==1?'disabled':'' }}>
                    </div>
                  </div>
                  <div class="{{ @CREDITS.ENABLED!=1?'disabled':'' }} field">
                    <label>{{ @settings.credits.rates.title }} <i class="question circular icon link" data-content="{{ @settings.credits.rates.hint }}"></i></label>
                    <input type="text" name="CREDITS#RATES" value="{{ implode(',',@CREDITS.RATES) }}">
                  </div>
                  <div class="{{ @CREDITS.ENABLED!=1?'disabled':'' }} field">
                    <label>{{ @settings.credits.currency.title }} <i class="question circular icon link" data-content="{{ @settings.credits.currency.hint }}"></i></label>
                    <div class="ui fluid selection dropdown">
                      <input type="hidden" name="CREDITS#CURRENCY" value="{{ @CREDITS.CURRENCY }}">
                      <i class="dropdown icon"></i>
                      <div class="default text">{{ @settings.credits.currency.dropdown }}</div>
                      <div class="menu">
                        <repeat group="{{ ['USD' => 'us', 'GBP' => 'gb', 'EUR' => 'eu', 'CHF' => 'ch', 'CAD' => 'ca', 'AUD' => 'au', 'SEK' => 'se', 'DKK' => 'dk', 'BRL' => 'br', 'JPY' => 'jp'] }}" key="{{ @ccy }}" value="{{ @country }}">
                          <div class="item" data-value="{{ @ccy }}"><i class="{{ @country }} flag"></i>{{ @ccy }}</div>
                        </repeat>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="ui tab" data-tab="tab-referrals">
                <div class="fields-group">
                  <div class="state-insensitive field">
                    <div class="ui toggle state-changing checkbox">
                      <label>{{ @settings.referrals.enabled.title }} <i class="question circular icon link" data-content="{{ @settings.referrals.enabled.hint }}"></i></label>
                      <input type="checkbox" {{ @REFERRALS.ENABLED==1?'checked="checked"':'' }} name="REFERRALS#ENABLED" value="{{ @REFERRALS.ENABLED }}">
                      <input type="hidden" name="REFERRALS#ENABLED" value="0" {{ @REFERRALS.ENABLED==1?'disabled':'' }}>
                    </div>
                  </div>
                  <div class="{{ @REFERRALS.ENABLED!=1?'disabled':'' }} field">
                    <label>{{ @settings.referrals.referral.bonus.title }} <i class="question circular icon link" data-content="{{ @settings.referrals.referral.bonus.hint }}"></i></label>
                    <input type="text" name="REFERRALS#REFERRAL_BONUS" value="{{ @REFERRALS.REFERRAL_BONUS }}">
                  </div>
                  <div class="{{ @REFERRALS.ENABLED!=1?'disabled':'' }} field">
                    <label>{{ @settings.referrals.referrer.bonus.title }} <i class="question circular icon link" data-content="{{ @settings.referrals.referrer.bonus.title }}"></i></label>
                    <input type="text" name="REFERRALS#REFERRER_BONUS" value="{{ @REFERRALS.REFERRER_BONUS }}">
                  </div>
                </div>
              </div>

              <div class="ui tab" data-tab="tab-social">
                <div class="field">
                  <label>{{ @settings.social.buttons.title }} <i class="question circular icon link" data-content="{{ @settings.social.buttons.hint }}"></i></label>
                  <div class="ui fluid multiple selection dropdown">
                    <input type="hidden" name="SOCIAL#SHARE_BUTTONS" value="{{ implode(',',@SOCIAL.SHARE_BUTTONS) }}">
                    <i class="dropdown icon"></i>
                    <div class="default text">{{ @settings.social.buttons.dropdown }}</div>
                    <div class="menu">
                      <repeat group="{{ ['facebook' => ['icon' => 'facebook', 'color' => 'violet', 'name' => 'Facebook'], 'googleplus' => ['icon' => 'google plus', 'color' => 'red', 'name' => 'Google Plus'], 'twitter' => ['icon' => 'twitter', 'color' => 'blue', 'name' => 'Twitter'], 'linkedin' => ['icon' => 'linkedin', 'color' => 'blue', 'name' => 'LinkedIn'], 'email' => ['icon' => 'mail outline', 'color' => 'black', 'name' => 'Email']] }}" key="{{ @button_code }}" value="{{ @button }}">
                        <div class="item" data-value="{{ @button_code }}"><i class="{{ @button.color }} {{ @button.icon }} icon"></i>{{ @button.name }}</div>
                      </repeat>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <label>{{ @settings.social.buttons.position.title }}</label>
                  <div class="ui fluid selection dropdown">
                    <input type="hidden" name="SOCIAL#SHARE_BUTTONS_POSITION" value="{{ @SOCIAL.SHARE_BUTTONS_POSITION }}">
                    <i class="dropdown icon"></i>
                    <div class="default text">{{ @settings.social.buttons.position.dropdown }}</div>
                    <div class="menu">
                      <div class="item" data-value="left">{{ @settings.social.buttons.position.left }}</div>
                      <div class="item" data-value="right">{{ @settings.social.buttons.position.right }}</div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="ui tab" data-tab="tab-analytics">
                <div class="field">
                  <label>{{ @settings.analytics.google.title }} <i class="question circular icon link" data-content="{{ @settings.analytics.google.hint }}"></i></label>
                  <input type="text" name="ANALYTICS#GOOGLE_ANALYTICS" value="{{ @ANALYTICS.GOOGLE_ANALYTICS }}">
                </div>
                <div class="field">
                  <label>{{ @settings.analytics.yandex.title }}</label>
                  <input type="text" name="ANALYTICS#YANDEX_METRICS" value="{{ @ANALYTICS.YANDEX_METRICS }}">
                </div>
              </div>

              <div class="ui tab" data-tab="tab-adsense">
                <div class="field">
                  <label>{{ @settings.adsense.client.title }} <i class="question circular icon link" data-content="{{ @settings.adsense.client.hint }}"></i></label>
                  <input type="text" name="ADSENSE#CLIENT_ID" value="{{ @ADSENSE.CLIENT_ID }}">
                </div>
                <div class="field">
                  <label>{{ @settings.adsense.slot.title }} <i class="question circular icon link" data-content="{{ @settings.adsense.slot.hint }}"></i></label>
                  <input type="text" name="ADSENSE#SLOT_ID" value="{{ @ADSENSE.SLOT_ID }}">
                </div>
              </div>

                <div class="ui tab" data-tab="tab-mailchimp">
                    <div class="field">
                        <label>{{ @settings.mailchimp.key.title }} <i class="question circular icon link" data-content="{{ @settings.mailchimp.key.hint }}"></i></label>
                        <input type="text" name="MAILCHIMP#API_KEY" value="{{ @MAILCHIMP.API_KEY }}">
                    </div>
                    <div class="field">
                        <label>{{ @settings.mailchimp.list.title }} <i class="question circular icon link" data-content="{{ @settings.mailchimp.list.hint }}"></i></label>
                        <input type="text" name="MAILCHIMP#SIGNUP_LIST_ID" value="{{ @MAILCHIMP.SIGNUP_LIST_ID }}">
                    </div>
                </div>

                <div class="ui tab" data-tab="tab-security">
                    <div class="fields-group">
                        <div class="state-insensitive field">
                            <div class="ui toggle state-changing checkbox">
                                <label>{{ @settings.security.gtfa.title }} <i class="question circular icon link" data-content="{{ @settings.security.gtfa.hint }}"></i></label>
                                <input type="checkbox" {{ @SECURITY.GTFA_ENABLED==1?'checked="checked"':'' }} name="SECURITY#GTFA_ENABLED" value="{{ @SECURITY.GTFA_ENABLED }}">
                                <input type="hidden" name="SECURITY#GTFA_ENABLED" value="0" {{ @SECURITY.GTFA_ENABLED==1?'disabled':'' }}>
                            </div>
                        </div>
                    </div>

                    <div class="ui hidden divider"></div>

                    <div class="fields-group">
                      <div class="state-insensitive field">
                        <div class="ui toggle state-changing checkbox">
                          <label>{{ @settings.security.tfa.title }} <i class="question circular icon link" data-content="{{ @settings.security.tfa.hint }}"></i></label>
                          <input type="checkbox" {{ @SECURITY.TFA_ENABLED==1?'checked="checked"':'' }} name="SECURITY#TFA_ENABLED" value="{{ @SECURITY.TFA_ENABLED }}">
                          <input type="hidden" name="SECURITY#TFA_ENABLED" value="0" {{ @SECURITY.TFA_ENABLED==1?'disabled':'' }}>
                        </div>
                      </div>
                      <div class="{{ @SECURITY.TFA_ENABLED!=1?'disabled':'' }} field">
                        <label>{{ @settings.security.clickatell.api.title }}</label>
                        <input type="text" name="SECURITY#CLICKATELL_API_ID" value="{{ @SECURITY.CLICKATELL_API_ID }}">
                      </div>
                    </div>
    
                    <div class="ui hidden divider"></div>
    
                    <div class="fields-group">
                        <div class="state-insensitive field">
                            <div class="ui toggle state-changing checkbox">
                              <label>{{ @settings.security.recaptcha.flag.title }} <i class="question circular icon link" data-content="{{ @settings.security.recaptcha.flag.hint }}"></i></label>
                              <input type="checkbox" {{ @SECURITY.RECAPTCHA_ENABLED==1?'checked="checked"':'' }} name="SECURITY#RECAPTCHA_ENABLED" value="{{ @SECURITY.RECAPTCHA_ENABLED }}">
                              <input type="hidden" name="SECURITY#RECAPTCHA_ENABLED" value="0" {{ @SECURITY.RECAPTCHA_ENABLED==1?'disabled':'' }}>
                            </div>
                        </div>
                        <div class="{{ @SECURITY.RECAPTCHA_ENABLED!=1?'disabled':'' }} field">
                            <label>{{ @settings.security.recaptcha.public.title }} <i class="question circular icon link" data-content="{{ @settings.security.recaptcha.keys.hint }}"></i></label>
                            <input type="text" name="SECURITY#RECAPTCHA_PUBLIC_KEY" value="{{ @SECURITY.RECAPTCHA_PUBLIC_KEY }}">
                        </div>
                        <div class="{{ @SECURITY.RECAPTCHA_ENABLED!=1?'disabled':'' }} field">
                            <label>{{ @settings.security.recaptcha.private.title }} <i class="question circular icon link" data-content="{{ @settings.security.recaptcha.keys.hint }}"></i></label>
                            <input type="text" name="SECURITY#RECAPTCHA_PRIVATE_KEY" value="{{ @SECURITY.RECAPTCHA_PRIVATE_KEY }}">
                        </div>
                    </div>
                </div>
              <div class="ui tab" data-tab="tab-smtp">
                <div class="field">
                  <label>{{ @settings.smtp.host.title }} <i class="question circular icon link" data-content="{{ @settings.smtp.host.hint }}"></i></label>
                  <input type="text" name="SMTP#HOST" value="{{ @SMTP.HOST }}">
                </div>
                <div class="field">
                  <label>{{ @settings.smtp.port.title }}</label>
                  <input type="text" name="SMTP#PORT" value="{{ @SMTP.PORT }}">
                </div>
                <div class="field">
                  <label>{{ @settings.smtp.user.title }}</label>
                  <input type="text" name="SMTP#USER" value="{{ @SMTP.USER }}">
                </div>
                <div class="field">
                  <label>{{ @settings.smtp.password.title }}</label>
                  <input type="text" name="SMTP#PASSWORD" value="{{ @SMTP.PASSWORD }}">
                </div>
              </div>

              <div class="ui tab" data-tab="tab-debug">
                <div class="field">
                  <div class="ui toggle checkbox">
                    <label>{{ @settings.debug.jslogging.title }} <i class="question circular icon link" data-content="{{ @settings.debug.jslogging.hint }}"></i></label>
                    <input type="checkbox" {{ @APPDEBUG.JS_LOGGING==1?'checked="checked"':'' }} name="APPDEBUG#JS_LOGGING" value="{{ @APPDEBUG.JS_LOGGING }}">
                    <input type="hidden" name="APPDEBUG#JS_LOGGING" value="0" {{ @APPDEBUG.JS_LOGGING==1?'disabled':'' }}>
                  </div>
                </div>
              </div>

              <div class="ui hidden divider"></div>
              <button class="ui submit {{ @SITE.MAIN_COLOR }} right floated button" type="submit">{{ @settings.form.save }}</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>