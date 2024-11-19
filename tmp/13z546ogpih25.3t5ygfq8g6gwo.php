<div class="ui container">
  <div class="left aligned sixteen wide column">
    <div class="column">
      <?php if ($SESSION['message']): ?>
        <div class="ui <?php echo $SESSION['message']['type']; ?> message">
          <i class="close icon"></i>
          <p><?php echo $this->raw($SESSION['message']['text']); ?></p>
        </div>
      <?php endif; ?>
      
      <div class="ui piled segment">
      <span class="ui <?php echo $SITE['MAIN_COLOR']; ?> ribbon label"><i class="settings icon"></i> <?php echo $settings['title']; ?>

      </span>
      </div>
      
        <div class="ui piled segment">
        <form class="ui form" method="POST" action="<?php echo $BASE; ?><?php echo $PATH; ?>">
          <div class="ui stackable grid">
            <div class="four wide column">
              <div id="settings-tabs-menu" class="ui secondary pointing stackable fluid vertical <?php echo $SITE['BACKGROUND']=='black'?'inverted':''; ?> <?php echo $SITE['MAIN_COLOR']; ?> menu">
                <a class="active item" data-tab="tab-general"><?php echo $settings['menu']['general']; ?></a>
                <a class="item" data-tab="tab-markets"><?php echo $settings['menu']['markets']; ?></a>
                <a class="item" data-tab="tab-trade"><?php echo $settings['menu']['trade']; ?></a>
                <a class="item" data-tab="tab-portfolio"><?php echo $settings['menu']['portfolio']; ?></a>
                <a class="item" data-tab="tab-paypal"><?php echo $settings['menu']['paypal']; ?></a>
                <a class="item" data-tab="tab-crypto"><?php echo $settings['menu']['crypto']; ?></a>
                <a class="item" data-tab="tab-subscription"><?php echo $settings['menu']['subscription']; ?></a>
                <a class="item" data-tab="tab-credits"><?php echo $settings['menu']['credits']; ?></a>
                <a class="item" data-tab="tab-referrals"><?php echo $settings['menu']['referrals']; ?></a>
                <a class="item" data-tab="tab-social"><?php echo $settings['menu']['social']; ?></a>
                <a class="item" data-tab="tab-analytics"><?php echo $settings['menu']['analytics']; ?></a>
                <a class="item" data-tab="tab-adsense"><?php echo $settings['menu']['adsense']; ?></a>
                <a class="item" data-tab="tab-mailchimp"><?php echo $settings['menu']['mailchimp']; ?></a>
                <a class="item" data-tab="tab-security"><?php echo $settings['menu']['security']; ?></a>
                <a class="item" data-tab="tab-smtp"><?php echo $settings['menu']['smtp']; ?></a>
                <a class="item" data-tab="tab-debug"><?php echo $settings['menu']['debug']; ?></a>
              </div>
            </div>

            <div class="twelve wide column">
              <div class="ui active tab" data-tab="tab-general">
                <div class="field">
                  <label><?php echo $settings['general']['color']['title']; ?></label>
                  <div class="ui fluid selection dropdown">
                    <input type="hidden" name="SITE#MAIN_COLOR" value="<?php echo $SITE['MAIN_COLOR']; ?>">
                    <i class="dropdown icon"></i>
                    <div class="default text"><?php echo $settings['general']['color']['dropdown']; ?></div>
                    <div class="menu">
                      <?php foreach ((['red' => $settings['general']['color']['red'], 'orange' => $settings['general']['color']['orange'], 'yellow' => $settings['general']['color']['yellow'], 'olive' => $settings['general']['color']['olive'], 'green' => $settings['general']['color']['green'], 'teal' => $settings['general']['color']['teal'], 'blue' => $settings['general']['color']['blue'], 'violet' => $settings['general']['color']['violet'], 'purple' => $settings['general']['color']['purple'], 'pink' => $settings['general']['color']['pink'], 'brown' => $settings['general']['color']['brown'], 'grey' => $settings['general']['color']['grey'], 'black' => $settings['general']['color']['black']]?:array()) as $color_code=>$color_name): ?>
                        <div class="item" data-value="<?php echo $color_code; ?>"><i class="stop <?php echo $color_code; ?> icon"></i><?php echo $color_name; ?></div>
                      <?php endforeach; ?>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <label><?php echo $settings['general']['background']['title']; ?></label>
                  <div class="ui fluid selection dropdown">
                    <input type="hidden" name="SITE#BACKGROUND" value="<?php echo $SITE['BACKGROUND']; ?>">
                    <i class="dropdown icon"></i>
                    <div class="default text"><?php echo $settings['general']['background']['dropdown']; ?></div>
                    <div class="menu">
                      <?php foreach ((['white' => $settings['general']['background']['color']['white'], 'black' => $settings['general']['background']['color']['black']]?:array()) as $color_code=>$color_name): ?>
                        <div class="item" data-value="<?php echo $color_code; ?>"><?php echo $color_name; ?></div>
                      <?php endforeach; ?>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <label><?php echo $settings['general']['language']['title']; ?></label>
                  <div class="ui fluid selection dropdown">
                    <input type="hidden" name="SITE#LANGUAGE" value="<?php echo $SITE['LANGUAGE']; ?>">
                    <i class="dropdown icon"></i>
                    <div class="default text"><?php echo $settings['general']['language']['dropdown']; ?></div>
                    <div class="menu">
                      <?php foreach (($vars['languages']?:array()) as $language): ?>
                        <div class="item" data-value="<?php echo $language; ?>"><i class="<?php echo str_replace('en','us',$language); ?> flag"></i><?php echo $language; ?></div>
                      <?php endforeach; ?>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <label><?php echo $settings['general']['timezone']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['general']['timezone']['hint']; ?>"></i></label>
                  <select id="timezone-dropdown" class="ui search selection dropdown" name="SITE#TIMEZONE"></select>
                </div>
                <div class="field">
                  <label><?php echo $settings['general']['email']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['general']['email']['hint']; ?>"></i></label>
                  <input type="text" name="SITE#EMAIL" value="<?php echo $SITE['EMAIL']; ?>">
                </div>
                <div class="field">
                  <div class="ui toggle checkbox">
                    <label><?php echo $settings['general']['verification']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['general']['verification']['hint']; ?>"></i></label>
                    <input type="checkbox" <?php echo $SITE['EMAIL_VERIFICATION']==1?'checked="checked"':''; ?> name="SITE#EMAIL_VERIFICATION" value="<?php echo $SITE['EMAIL_VERIFICATION']; ?>">
                    <input type="hidden" name="SITE#EMAIL_VERIFICATION" value="0" <?php echo $SITE['EMAIL_VERIFICATION']==1?'disabled':''; ?>>
                  </div>
                </div>
              </div>

              <div class="ui tab" data-tab="tab-markets">
                <div class="field">
                  <label><?php echo $settings['markets']['clock1']['title']; ?></label>
                  <input type="text" name="MARKETS#CLOCK1_NAME" value="<?php echo $MARKETS['CLOCK1_NAME']; ?>">
                </div>
                <div class="field">
                  <label><?php echo $settings['markets']['clock1']['offset']; ?></label>
                  <input type="text" name="MARKETS#CLOCK1_OFFSET" value="<?php echo $MARKETS['CLOCK1_OFFSET']; ?>">
                </div>
                <div class="field">
                  <label><?php echo $settings['markets']['clock2']['title']; ?></label>
                  <input type="text" name="MARKETS#CLOCK2_NAME" value="<?php echo $MARKETS['CLOCK2_NAME']; ?>">
                </div>
                <div class="field">
                  <label><?php echo $settings['markets']['clock2']['offset']; ?></label>
                  <input type="text" name="MARKETS#CLOCK2_OFFSET" value="<?php echo $MARKETS['CLOCK2_OFFSET']; ?>">
                </div>
                <div class="field">
                  <label><?php echo $settings['markets']['clock3']['title']; ?></label>
                  <input type="text" name="MARKETS#CLOCK3_NAME" value="<?php echo $MARKETS['CLOCK3_NAME']; ?>">
                </div>
                <div class="field">
                  <label><?php echo $settings['markets']['clock3']['offset']; ?></label>
                  <input type="text" name="MARKETS#CLOCK3_OFFSET" value="<?php echo $MARKETS['CLOCK3_OFFSET']; ?>">
                </div>
                <div class="field">
                  <label><?php echo $settings['markets']['clock4']['title']; ?></label>
                  <input type="text" name="MARKETS#CLOCK4_NAME" value="<?php echo $MARKETS['CLOCK4_NAME']; ?>">
                </div>
                <div class="field">
                  <label><?php echo $settings['markets']['clock4']['offset']; ?></label>
                  <input type="text" name="MARKETS#CLOCK4_OFFSET" value="<?php echo $MARKETS['CLOCK4_OFFSET']; ?>">
                </div>
                <div class="field">
                  <label><?php echo $settings['markets']['indexes']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['markets']['indexes']['hint']; ?>"></i></label>
                  <input type="text" name="MARKETS#STOCK_INDEXES" value="<?php echo implode(',',$MARKETS['STOCK_INDEXES']); ?>">
                </div>
                <div class="field">
                  <label><?php echo $settings['markets']['currencies']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['markets']['currencies']['hint']; ?>"></i></label>
                  <input type="text" name="MARKETS#CURRENCIES" value="<?php echo implode(',',$MARKETS['CURRENCIES']); ?>">
                </div>
                <div class="field">
                  <label><?php echo $settings['markets']['newsfeed']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['markets']['newsfeed']['hint']; ?>"></i></label>
                  <input type="text" name="MARKETS#NEWS_FEED_URL" value="<?php echo $MARKETS['NEWS_FEED_URL']; ?>">
                </div>
                <div class="field">
                  <label><?php echo $settings['markets']['watchlist']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['markets']['watchlist']['hint']; ?>"></i></label>
                  <input type="text" name="MARKETS#DEFAULT_WATCHLIST" value="<?php echo implode(',',$MARKETS['DEFAULT_WATCHLIST']); ?>">
                </div>
              </div>

              <div class="ui tab" data-tab="tab-trade">
                <div class="field">
                  <label><?php echo $settings['trade']['symbol']['title']; ?></label>
                  <input type="text" name="TRADE#DEFAULT_SYMBOL" value="<?php echo $TRADE['DEFAULT_SYMBOL']; ?>">
                </div>
                <div class="field">
                  <label><?php echo $settings['trade']['balance']['title']; ?></label>
                  <input type="text" name="TRADE#INITIAL_BALANCE" value="<?php echo $TRADE['INITIAL_BALANCE']; ?>">
                </div>
                <div class="field">
                  <label><?php echo $settings['trade']['commission']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['trade']['commission']['hint']; ?>"></i></label>
                  <input type="text" name="TRADE#COMMISSION" value="<?php echo $TRADE['COMMISSION']; ?>">
                </div>
                <div class="field">
                  <label><?php echo $settings['trade']['currency']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['trade']['currency']['hint']; ?>"></i></label>
                  <div class="ui fluid selection dropdown">
                    <input type="hidden" name="TRADE#ACCOUNT_CURRENCY" value="<?php echo $TRADE['ACCOUNT_CURRENCY']; ?>">
                    <i class="dropdown icon"></i>
                    <div class="default text"><?php echo $settings['trade']['currency']['dropdown']; ?></div>
                    <div class="menu">
                      <?php foreach ((['USD' => 'us', 'GBP' => 'gb', 'EUR' => 'eu', 'CHF' => 'ch', 'CAD' => 'ca', 'AUD' => 'au', 'SEK' => 'se', 'DKK' => 'dk', 'INR' => 'in', 'BRL' => 'br', 'JPY' => 'jp']?:array()) as $ccy=>$country): ?>
                        <div class="item" data-value="<?php echo $ccy; ?>"><i class="<?php echo $country; ?> flag"></i><?php echo $ccy; ?></div>
                      <?php endforeach; ?>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <div class="ui toggle checkbox">
                    <label><?php echo $settings['trade']['short_sale']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['trade']['short_sale']['hint']; ?>"></i></label>
                    <input type="checkbox" <?php echo $TRADE['SHORT_TRADING']==1?'checked="checked"':''; ?> name="TRADE#SHORT_TRADING" value="<?php echo $TRADE['SHORT_TRADING']; ?>">
                    <input type="hidden" name="TRADE#SHORT_TRADING" value="0" <?php echo $TRADE['SHORT_TRADING']==1?'disabled':''; ?>>
                  </div>
                </div>
              </div>

              <div class="ui tab" data-tab="tab-portfolio">
                <div class="field">
                  <label><?php echo $settings['portfolio']['positionsnumber']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['portfolio']['positionsnumber']['hint']; ?>"></i></label>
                  <input type="text" name="PORTFOLIO#POSITIONS_PER_PAGE" value="<?php echo $PORTFOLIO['POSITIONS_PER_PAGE']; ?>">
                </div>
                <div class="field">
                  <label><?php echo $settings['portfolio']['tradesnumber']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['portfolio']['tradesnumber']['hint']; ?>"></i></label>
                  <input type="text" name="PORTFOLIO#TRADES_PER_PAGE" value="<?php echo $PORTFOLIO['TRADES_PER_PAGE']; ?>">
                </div>
              </div>

              <div class="ui tab" data-tab="tab-paypal">
                <div class="ui info message">
                  <div class="header"><?php echo $settings['paypal']['info']['header']; ?></div>
                  <p><?php echo $settings['paypal']['info']['message']; ?></p>
                </div>
                <div class="field">
                  <label><?php echo $settings['paypal']['paypal_mode']['title']; ?></label>
                  <div class="ui fluid selection dropdown">
                    <input type="hidden" name="PAYPAL#PAYPAL_MODE" value="<?php echo $PAYPAL['PAYPAL_MODE']; ?>">
                    <i class="dropdown icon"></i>
                    <div class="default text"><?php echo $settings['paypal']['paypal_mode']['title']; ?></div>
                    <div class="menu">
                      <div class="item" data-value="sandbox"><?php echo $settings['paypal']['paypal_mode']['sandbox']; ?></div>
                      <div class="item" data-value="live"><?php echo $settings['paypal']['paypal_mode']['live']; ?></div>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <label><?php echo $settings['paypal']['paypal_user']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['paypal']['paypal_user']['hint']; ?>"></i></label>
                  <input type="text" name="PAYPAL#PAYPAL_USER" value="<?php echo $PAYPAL['PAYPAL_USER']; ?>">
                </div>
                <div class="field">
                  <label><?php echo $settings['paypal']['paypal_password']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['paypal']['paypal_password']['hint']; ?>"></i></label>
                  <input type="text" name="PAYPAL#PAYPAL_PASSWORD" value="<?php echo $PAYPAL['PAYPAL_PASSWORD']; ?>">
                </div>
                <div class="field">
                  <label><?php echo $settings['paypal']['paypal_signature']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['paypal']['paypal_signature']['hint']; ?>"></i></label>
                  <input type="text" name="PAYPAL#PAYPAL_SIGNATURE" value="<?php echo $PAYPAL['PAYPAL_SIGNATURE']; ?>">
                </div>
              </div>

              <div class="ui tab" data-tab="tab-crypto">
                <div class="ui info message">
                  <div class="header"><?php echo $settings['crypto']['info']['header']; ?></div>
                  <p><?php echo $settings['crypto']['info']['message']; ?></p>
                </div>
                <div class="field">
                  <label><?php echo $settings['crypto']['btc']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['crypto']['btc']['hint']; ?>"></i></label>
                  <input type="text" name="CRYPTO#BTC_WALLET" value="<?php echo $CRYPTO['BTC_WALLET']; ?>">
                </div>
                <div class="field">
                  <label><?php echo $settings['crypto']['eth']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['crypto']['eth']['hint']; ?>"></i></label>
                  <input type="text" name="CRYPTO#ETH_WALLET" value="<?php echo $CRYPTO['ETH_WALLET']; ?>">
                </div>
                <div class="field">
                  <label><?php echo $settings['crypto']['usdt']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['crypto']['usdt']['hint']; ?>"></i></label>
                  <input type="text" name="CRYPTO#USDT_WALLET" value="<?php echo $CRYPTO['USDT_WALLET']; ?>">
                </div>
                <div class="field">
                  <label><?php echo $settings['crypto']['usdc']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['crypto']['usdc']['hint']; ?>"></i></label>
                  <input type="text" name="CRYPTO#USDC_WALLET" value="<?php echo $CRYPTO['USDC_WALLET']; ?>">
                </div>
              </div>
              
              <div class="ui tab" data-tab="tab-subscription">
                <div class="ui info message">
                  <div class="header"><?php echo $settings['paypal']['info']['header']; ?></div>
                  <p><?php echo $settings['paypal']['info']['message']; ?></p>
                </div>
                <div class="fields-group">
                  <div class="state-insensitive field">
                    <div class="ui toggle state-changing checkbox">
                      <label><?php echo $settings['subscription']['enabled']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['subscription']['enabled']['hint']; ?>"></i></label>
                      <input type="checkbox" <?php echo $SUBSCRIPTION['SUBSCRIPTION_ENABLED']==1?'checked="checked"':''; ?> name="SUBSCRIPTION#SUBSCRIPTION_ENABLED" value="<?php echo $SUBSCRIPTION['SUBSCRIPTION_ENABLED']; ?>">
                      <input type="hidden" name="SUBSCRIPTION#SUBSCRIPTION_ENABLED" value="0" <?php echo $SUBSCRIPTION['SUBSCRIPTION_ENABLED']==1?'disabled':''; ?>>
                    </div>
                  </div>
                  <div class="<?php echo $SUBSCRIPTION['SUBSCRIPTION_ENABLED']!=1?'disabled':''; ?> field">
                    <label><?php echo $settings['subscription']['trial']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['subscription']['trial']['hint']; ?>"></i></label>
                    <input type="text" name="SUBSCRIPTION#FREE_TRIAL_PERIOD" value="<?php echo $SUBSCRIPTION['FREE_TRIAL_PERIOD']; ?>">
                  </div>
                  <div class="fields">
                    <div class="<?php echo $SUBSCRIPTION['SUBSCRIPTION_ENABLED']!=1?'disabled':''; ?> field">
                      <label><?php echo $settings['subscription']['daily_amount']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['subscription']['daily_amount']['hint']; ?>"></i></label>
                      <input type="text" name="SUBSCRIPTION#BILLING_DAILY_AMOUNT" value="<?php echo $SUBSCRIPTION['BILLING_DAILY_AMOUNT']; ?>">
                    </div>
                    <div class="<?php echo $SUBSCRIPTION['SUBSCRIPTION_ENABLED']!=1?'disabled':''; ?> field">
                      <label><?php echo $settings['subscription']['weekly_amount']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['subscription']['weekly_amount']['hint']; ?>"></i></label>
                      <input type="text" name="SUBSCRIPTION#BILLING_WEEKLY_AMOUNT" value="<?php echo $SUBSCRIPTION['BILLING_WEEKLY_AMOUNT']; ?>">
                    </div>
                    <div class="<?php echo $SUBSCRIPTION['SUBSCRIPTION_ENABLED']!=1?'disabled':''; ?> field">
                      <label><?php echo $settings['subscription']['monthly_amount']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['subscription']['monthly_amount']['hint']; ?>"></i></label>
                      <input type="text" name="SUBSCRIPTION#BILLING_MONTHLY_AMOUNT" value="<?php echo $SUBSCRIPTION['BILLING_MONTHLY_AMOUNT']; ?>">
                    </div>
                    <div class="<?php echo $SUBSCRIPTION['SUBSCRIPTION_ENABLED']!=1?'disabled':''; ?> field">
                      <label><?php echo $settings['subscription']['annual_amount']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['subscription']['annual_amount']['hint']; ?>"></i></label>
                      <input type="text" name="SUBSCRIPTION#BILLING_ANNUAL_AMOUNT" value="<?php echo $SUBSCRIPTION['BILLING_ANNUAL_AMOUNT']; ?>">
                    </div>
                  </div>
                  <div class="<?php echo $SUBSCRIPTION['SUBSCRIPTION_ENABLED']!=1?'disabled':''; ?> field">
                    <label><?php echo $settings['subscription']['currency']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['subscription']['currency']['hint']; ?>"></i></label>
                    <div class="ui fluid selection dropdown">
                      <input type="hidden" name="SUBSCRIPTION#BILLING_CURRENCY" value="<?php echo $SUBSCRIPTION['BILLING_CURRENCY']; ?>">
                      <i class="dropdown icon"></i>
                      <div class="default text"><?php echo $settings['subscription']['currency']['dropdown']; ?></div>
                      <div class="menu">
                        <?php foreach ((['USD' => 'us', 'GBP' => 'gb', 'EUR' => 'eu', 'CHF' => 'ch', 'CAD' => 'ca', 'AUD' => 'au', 'SEK' => 'se', 'DKK' => 'dk', 'BRL' => 'br', 'JPY' => 'jp']?:array()) as $ccy=>$country): ?>
                          <div class="item" data-value="<?php echo $ccy; ?>"><i class="<?php echo $country; ?> flag"></i><?php echo $ccy; ?></div>
                        <?php endforeach; ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="ui tab" data-tab="tab-credits">
                <div class="ui info message">
                  <div class="header"><?php echo $settings['paypal']['info']['header']; ?></div>
                  <p><?php echo $settings['paypal']['info']['message']; ?></p>
                </div>
                <div class="fields-group">
                  <div class="state-insensitive field">
                    <div class="ui toggle state-changing checkbox">
                      <label><?php echo $settings['credits']['enabled']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['credits']['enabled']['hint']; ?>"></i></label>
                      <input type="checkbox" <?php echo $CREDITS['ENABLED']==1?'checked="checked"':''; ?> name="CREDITS#ENABLED" value="<?php echo $CREDITS['ENABLED']; ?>">
                      <input type="hidden" name="CREDITS#ENABLED" value="0" <?php echo $CREDITS['ENABLED']==1?'disabled':''; ?>>
                    </div>
                  </div>
                  <div class="<?php echo $CREDITS['ENABLED']!=1?'disabled':''; ?> field">
                    <label><?php echo $settings['credits']['rates']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['credits']['rates']['hint']; ?>"></i></label>
                    <input type="text" name="CREDITS#RATES" value="<?php echo implode(',',$CREDITS['RATES']); ?>">
                  </div>
                  <div class="<?php echo $CREDITS['ENABLED']!=1?'disabled':''; ?> field">
                    <label><?php echo $settings['credits']['currency']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['credits']['currency']['hint']; ?>"></i></label>
                    <div class="ui fluid selection dropdown">
                      <input type="hidden" name="CREDITS#CURRENCY" value="<?php echo $CREDITS['CURRENCY']; ?>">
                      <i class="dropdown icon"></i>
                      <div class="default text"><?php echo $settings['credits']['currency']['dropdown']; ?></div>
                      <div class="menu">
                        <?php foreach ((['USD' => 'us', 'GBP' => 'gb', 'EUR' => 'eu', 'CHF' => 'ch', 'CAD' => 'ca', 'AUD' => 'au', 'SEK' => 'se', 'DKK' => 'dk', 'BRL' => 'br', 'JPY' => 'jp']?:array()) as $ccy=>$country): ?>
                          <div class="item" data-value="<?php echo $ccy; ?>"><i class="<?php echo $country; ?> flag"></i><?php echo $ccy; ?></div>
                        <?php endforeach; ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="ui tab" data-tab="tab-referrals">
                <div class="fields-group">
                  <div class="state-insensitive field">
                    <div class="ui toggle state-changing checkbox">
                      <label><?php echo $settings['referrals']['enabled']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['referrals']['enabled']['hint']; ?>"></i></label>
                      <input type="checkbox" <?php echo $REFERRALS['ENABLED']==1?'checked="checked"':''; ?> name="REFERRALS#ENABLED" value="<?php echo $REFERRALS['ENABLED']; ?>">
                      <input type="hidden" name="REFERRALS#ENABLED" value="0" <?php echo $REFERRALS['ENABLED']==1?'disabled':''; ?>>
                    </div>
                  </div>
                  <div class="<?php echo $REFERRALS['ENABLED']!=1?'disabled':''; ?> field">
                    <label><?php echo $settings['referrals']['referral']['bonus']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['referrals']['referral']['bonus']['hint']; ?>"></i></label>
                    <input type="text" name="REFERRALS#REFERRAL_BONUS" value="<?php echo $REFERRALS['REFERRAL_BONUS']; ?>">
                  </div>
                  <div class="<?php echo $REFERRALS['ENABLED']!=1?'disabled':''; ?> field">
                    <label><?php echo $settings['referrals']['referrer']['bonus']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['referrals']['referrer']['bonus']['title']; ?>"></i></label>
                    <input type="text" name="REFERRALS#REFERRER_BONUS" value="<?php echo $REFERRALS['REFERRER_BONUS']; ?>">
                  </div>
                </div>
              </div>

              <div class="ui tab" data-tab="tab-social">
                <div class="field">
                  <label><?php echo $settings['social']['buttons']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['social']['buttons']['hint']; ?>"></i></label>
                  <div class="ui fluid multiple selection dropdown">
                    <input type="hidden" name="SOCIAL#SHARE_BUTTONS" value="<?php echo implode(',',$SOCIAL['SHARE_BUTTONS']); ?>">
                    <i class="dropdown icon"></i>
                    <div class="default text"><?php echo $settings['social']['buttons']['dropdown']; ?></div>
                    <div class="menu">
                      <?php foreach ((['facebook' => ['icon' => 'facebook', 'color' => 'violet', 'name' => 'Facebook'], 'googleplus' => ['icon' => 'google plus', 'color' => 'red', 'name' => 'Google Plus'], 'twitter' => ['icon' => 'twitter', 'color' => 'blue', 'name' => 'Twitter'], 'linkedin' => ['icon' => 'linkedin', 'color' => 'blue', 'name' => 'LinkedIn'], 'email' => ['icon' => 'mail outline', 'color' => 'black', 'name' => 'Email']]?:array()) as $button_code=>$button): ?>
                        <div class="item" data-value="<?php echo $button_code; ?>"><i class="<?php echo $button['color']; ?> <?php echo $button['icon']; ?> icon"></i><?php echo $button['name']; ?></div>
                      <?php endforeach; ?>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <label><?php echo $settings['social']['buttons']['position']['title']; ?></label>
                  <div class="ui fluid selection dropdown">
                    <input type="hidden" name="SOCIAL#SHARE_BUTTONS_POSITION" value="<?php echo $SOCIAL['SHARE_BUTTONS_POSITION']; ?>">
                    <i class="dropdown icon"></i>
                    <div class="default text"><?php echo $settings['social']['buttons']['position']['dropdown']; ?></div>
                    <div class="menu">
                      <div class="item" data-value="left"><?php echo $settings['social']['buttons']['position']['left']; ?></div>
                      <div class="item" data-value="right"><?php echo $settings['social']['buttons']['position']['right']; ?></div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="ui tab" data-tab="tab-analytics">
                <div class="field">
                  <label><?php echo $settings['analytics']['google']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['analytics']['google']['hint']; ?>"></i></label>
                  <input type="text" name="ANALYTICS#GOOGLE_ANALYTICS" value="<?php echo $ANALYTICS['GOOGLE_ANALYTICS']; ?>">
                </div>
                <div class="field">
                  <label><?php echo $settings['analytics']['yandex']['title']; ?></label>
                  <input type="text" name="ANALYTICS#YANDEX_METRICS" value="<?php echo $ANALYTICS['YANDEX_METRICS']; ?>">
                </div>
              </div>

              <div class="ui tab" data-tab="tab-adsense">
                <div class="field">
                  <label><?php echo $settings['adsense']['client']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['adsense']['client']['hint']; ?>"></i></label>
                  <input type="text" name="ADSENSE#CLIENT_ID" value="<?php echo $ADSENSE['CLIENT_ID']; ?>">
                </div>
                <div class="field">
                  <label><?php echo $settings['adsense']['slot']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['adsense']['slot']['hint']; ?>"></i></label>
                  <input type="text" name="ADSENSE#SLOT_ID" value="<?php echo $ADSENSE['SLOT_ID']; ?>">
                </div>
              </div>

                <div class="ui tab" data-tab="tab-mailchimp">
                    <div class="field">
                        <label><?php echo $settings['mailchimp']['key']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['mailchimp']['key']['hint']; ?>"></i></label>
                        <input type="text" name="MAILCHIMP#API_KEY" value="<?php echo $MAILCHIMP['API_KEY']; ?>">
                    </div>
                    <div class="field">
                        <label><?php echo $settings['mailchimp']['list']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['mailchimp']['list']['hint']; ?>"></i></label>
                        <input type="text" name="MAILCHIMP#SIGNUP_LIST_ID" value="<?php echo $MAILCHIMP['SIGNUP_LIST_ID']; ?>">
                    </div>
                </div>

                <div class="ui tab" data-tab="tab-security">
                    <div class="fields-group">
                        <div class="state-insensitive field">
                            <div class="ui toggle state-changing checkbox">
                                <label><?php echo $settings['security']['gtfa']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['security']['gtfa']['hint']; ?>"></i></label>
                                <input type="checkbox" <?php echo $SECURITY['GTFA_ENABLED']==1?'checked="checked"':''; ?> name="SECURITY#GTFA_ENABLED" value="<?php echo $SECURITY['GTFA_ENABLED']; ?>">
                                <input type="hidden" name="SECURITY#GTFA_ENABLED" value="0" <?php echo $SECURITY['GTFA_ENABLED']==1?'disabled':''; ?>>
                            </div>
                        </div>
                    </div>

                    <div class="ui hidden divider"></div>

                    <div class="fields-group">
                      <div class="state-insensitive field">
                        <div class="ui toggle state-changing checkbox">
                          <label><?php echo $settings['security']['tfa']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['security']['tfa']['hint']; ?>"></i></label>
                          <input type="checkbox" <?php echo $SECURITY['TFA_ENABLED']==1?'checked="checked"':''; ?> name="SECURITY#TFA_ENABLED" value="<?php echo $SECURITY['TFA_ENABLED']; ?>">
                          <input type="hidden" name="SECURITY#TFA_ENABLED" value="0" <?php echo $SECURITY['TFA_ENABLED']==1?'disabled':''; ?>>
                        </div>
                      </div>
                      <div class="<?php echo $SECURITY['TFA_ENABLED']!=1?'disabled':''; ?> field">
                        <label><?php echo $settings['security']['clickatell']['api']['title']; ?></label>
                        <input type="text" name="SECURITY#CLICKATELL_API_ID" value="<?php echo $SECURITY['CLICKATELL_API_ID']; ?>">
                      </div>
                    </div>
    
                    <div class="ui hidden divider"></div>
    
                    <div class="fields-group">
                        <div class="state-insensitive field">
                            <div class="ui toggle state-changing checkbox">
                              <label><?php echo $settings['security']['recaptcha']['flag']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['security']['recaptcha']['flag']['hint']; ?>"></i></label>
                              <input type="checkbox" <?php echo $SECURITY['RECAPTCHA_ENABLED']==1?'checked="checked"':''; ?> name="SECURITY#RECAPTCHA_ENABLED" value="<?php echo $SECURITY['RECAPTCHA_ENABLED']; ?>">
                              <input type="hidden" name="SECURITY#RECAPTCHA_ENABLED" value="0" <?php echo $SECURITY['RECAPTCHA_ENABLED']==1?'disabled':''; ?>>
                            </div>
                        </div>
                        <div class="<?php echo $SECURITY['RECAPTCHA_ENABLED']!=1?'disabled':''; ?> field">
                            <label><?php echo $settings['security']['recaptcha']['public']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['security']['recaptcha']['keys']['hint']; ?>"></i></label>
                            <input type="text" name="SECURITY#RECAPTCHA_PUBLIC_KEY" value="<?php echo $SECURITY['RECAPTCHA_PUBLIC_KEY']; ?>">
                        </div>
                        <div class="<?php echo $SECURITY['RECAPTCHA_ENABLED']!=1?'disabled':''; ?> field">
                            <label><?php echo $settings['security']['recaptcha']['private']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['security']['recaptcha']['keys']['hint']; ?>"></i></label>
                            <input type="text" name="SECURITY#RECAPTCHA_PRIVATE_KEY" value="<?php echo $SECURITY['RECAPTCHA_PRIVATE_KEY']; ?>">
                        </div>
                    </div>
                </div>
              <div class="ui tab" data-tab="tab-smtp">
                <div class="field">
                  <label><?php echo $settings['smtp']['host']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['smtp']['host']['hint']; ?>"></i></label>
                  <input type="text" name="SMTP#HOST" value="<?php echo $SMTP['HOST']; ?>">
                </div>
                <div class="field">
                  <label><?php echo $settings['smtp']['port']['title']; ?></label>
                  <input type="text" name="SMTP#PORT" value="<?php echo $SMTP['PORT']; ?>">
                </div>
                <div class="field">
                  <label><?php echo $settings['smtp']['user']['title']; ?></label>
                  <input type="text" name="SMTP#USER" value="<?php echo $SMTP['USER']; ?>">
                </div>
                <div class="field">
                  <label><?php echo $settings['smtp']['password']['title']; ?></label>
                  <input type="text" name="SMTP#PASSWORD" value="<?php echo $SMTP['PASSWORD']; ?>">
                </div>
              </div>

              <div class="ui tab" data-tab="tab-debug">
                <div class="field">
                  <div class="ui toggle checkbox">
                    <label><?php echo $settings['debug']['jslogging']['title']; ?> <i class="question circular icon link" data-content="<?php echo $settings['debug']['jslogging']['hint']; ?>"></i></label>
                    <input type="checkbox" <?php echo $APPDEBUG['JS_LOGGING']==1?'checked="checked"':''; ?> name="APPDEBUG#JS_LOGGING" value="<?php echo $APPDEBUG['JS_LOGGING']; ?>">
                    <input type="hidden" name="APPDEBUG#JS_LOGGING" value="0" <?php echo $APPDEBUG['JS_LOGGING']==1?'disabled':''; ?>>
                  </div>
                </div>
              </div>

              <div class="ui hidden divider"></div>
              <button class="ui submit <?php echo $SITE['MAIN_COLOR']; ?> right floated button" type="submit"><?php echo $settings['form']['save']; ?></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>