<div class="ui container">
  <div class="ui stackable centered grid">
    <div class="twelve wide column">

    <div class="ui piled segment">
      <span class="ui {{ @SITE.MAIN_COLOR }} ribbon label">{{ @invite.title }}
      </span>
      </div>
      
      <div class="ui piled segment">
        <p>
          {{ @invite.message,Helper::formatNumber(@REFERRALS.REFERRER_BONUS),@TRADE.ACCOUNT_CURRENCY,Helper::formatNumber(@REFERRALS.REFERRAL_BONUS) | format }}
        </p>
        <div class="ui fluid action input">
          <input id="referral-link" type="text" disabled="disabled" value="{{ @vars.link }}">
          <button class="ui {{ @SITE.MAIN_COLOR }} right labeled icon button" onclick="copyToClipboard('#referral-link')">
            <i class="copy icon"></i>
            {{ @invite.button.copy }}
          </button>
        </div>
      </div>
    </div>
  </div>
</div>