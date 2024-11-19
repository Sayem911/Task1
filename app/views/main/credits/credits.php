<div class="ui container">
  <div class="ui stackable one column grid">
    <include if="{{ @ADSENSE.CLIENT_ID && @ADSENSE.SLOT_ID }}" href="{{ @tpl.adsense }}" />
    <div class="column">
      <h2 class="ui {{ @SITE.MAIN_COLOR }} dividing header">{{ @title.credits }}</h2>
    </div>
    <div class="column">
      <check if="{{ @SESSION.message }}">
        <div class="ui {{ @SESSION.message.type }} message">
          <i class="close icon"></i>
          <p>{{ @SESSION.message.text|raw }}</p>
        </div>
      </check>
      <check if="{{ !empty(@CREDITS.RATES) }}">
        <true>
          <div class="ui stackable center aligned grid">
          <repeat group="{{ @CREDITS.RATES }}" key="{{ @i }}" value="{{ @rate }}">
            <div class="five wide center aligned column">
              <div class="ui piled segment">
                <div class="ui {{ @SITE.MAIN_COLOR }} small statistic">
                  <div class="value">
                    <i class="money icon"></i> {{ Helper::formatNumber(explode('=',@rate)[0]) }}
                  </div>
                  <div class="label">
                    {{ Helper::formatNumber(explode('=',@rate)[1], 2) }} {{ @CREDITS.CURRENCY }}
                  </div>
                </div>
                <form class="ui form" action="{{ @BASE }}/credits-process" method="post">
                  <input type="hidden" name="credit" value="{{ @i }}">
                  <div class="four wide paypal-quantity field">
                    <label>{{ @credits.form.quantity }}</label>
                    <input type="text" name="quantity" value="1">
                  </div>
                  <button class="ui {{ @SITE.MAIN_COLOR }} icon paypal-submit button">
                    <i class="paypal icon"></i> {{ @credits.button.purchase }}
                  </button>
                </form>
              </div>
            </div>
          </repeat>
        </true>
        <false>
          <div class="ui negative message">
            <i class="close icon"></i>
            <div class="header">
              {{ @credits.empty.header }}
            </div>
            <p>{{ @credits.empty.message }}</p>
          </div>
        </false>
      </check>
    </div>
  </div>
</div>