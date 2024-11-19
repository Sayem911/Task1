<div class="ui container">
  <div class="ui stackable one column grid">
    <include if="{{ @ADSENSE.CLIENT_ID && @ADSENSE.SLOT_ID }}" href="{{ @tpl.adsense }}" />
    <div class="column">
      <h2 class="ui {{ @SITE.MAIN_COLOR }} dividing header">{{ @title.subscription }}</h2>
    </div>
    <div class="column">
      <div class="ui icon {{ @SITE.MAIN_COLOR }} message">
        <i class="payment icon"></i>
        <div class="content">
          <check if="{{ @vars.subscribed }}">
            <true>
              <check if="{{ @vars.subscription_status=='TrialPeriod' }}">
                <div class="header">
                  {{ @subscription.trial.title }}
                </div>
                <p>{{ @subscription.trial.message, @vars.subscription_paid_until | format }}</p>
              </check>
              <check if="{{ @vars.subscription_status=='ActiveProfile' }}">
                <div class="header">
                  {{ @subscription.subscribed.title }}
                </div>
                <p>{{ @subscription.subscribed.message, @vars.subscription_paid_until | format }}</p>
              </check>
              <check if="{{ @vars.subscription_status=='PendingProfile' }}">
                <div class="header">
                  {{ @subscription.pending.title }}
                </div>
                <p>{{ @subscription.pending.message }}</p>
              </check>
              <check if="{{ @vars.subscription_status=='CancelledProfile' }}">
                <div class="header">
                  {{ @subscription.cancelled.title }}
                </div>
                <p>{{ @subscription.cancelled.message }}</p>
              </check>
            </true>
            <false>
              <div class="header">
                {{ @subscription.not_subscribed.title }}
              </div>
              <p>{{ @subscription.not_subscribed.message }}</p>
            </false>
          </check>
        </div>
      </div>
      <check if="{{ !@vars.subscribed || @vars.subscribed && @vars.subscription_status=='CancelledProfile' }}">
        <form id="form-subscription" class="ui form" method="POST" action="{{ @BASE }}/subscribe-process">
          <div class="fields">
            <div class="four wide field">
              <div class="ui fluid selection dropdown">
                <input type="hidden" name="subscription">
                <i class="dropdown icon"></i>
                <div class="default text">{{ @subscription.options.title }}</div>
                <div class="menu">
                  <check if="{{ @SUBSCRIPTION.BILLING_DAILY_AMOUNT }}">
                    <div class="item" data-value="daily">{{ @SUBSCRIPTION.BILLING_DAILY_AMOUNT }} {{ @SUBSCRIPTION.BILLING_CURRENCY }} {{ @subscription.option.daily }}</div>
                  </check>
                  <check if="{{ @SUBSCRIPTION.BILLING_WEEKLY_AMOUNT }}">
                    <div class="item" data-value="weekly">{{ @SUBSCRIPTION.BILLING_WEEKLY_AMOUNT }} {{ @SUBSCRIPTION.BILLING_CURRENCY }} {{ @subscription.option.weekly }}</div>
                  </check>
                  <check if="{{ @SUBSCRIPTION.BILLING_MONTHLY_AMOUNT }}">
                    <div class="item" data-value="monthly">{{ @SUBSCRIPTION.BILLING_MONTHLY_AMOUNT }} {{ @SUBSCRIPTION.BILLING_CURRENCY }} {{ @subscription.option.monthly }}</div>
                  </check>
                  <check if="{{ @SUBSCRIPTION.BILLING_ANNUAL_AMOUNT }}">
                    <div class="item" data-value="annual">{{ @SUBSCRIPTION.BILLING_ANNUAL_AMOUNT }} {{ @SUBSCRIPTION.BILLING_CURRENCY }} {{ @subscription.option.annual }}</div>
                  </check>
                </div>
              </div>
            </div>
            <input type="submit" class="ui {{ @SITE.MAIN_COLOR }} button" value="{{ @subscription.form.submit }}">
          </div>
        </form>
      </check>
      <check if="{{ @vars.subscribed && @vars.subscription_status=='PendingProfile' }}">
        <a href="{{ @BASE }}{{ @PATH }}" class="ui {{ @SITE.MAIN_COLOR }} button">{{ @subscription.form.refresh }}</a>
      </check>
    </div>
  </div>
</div>