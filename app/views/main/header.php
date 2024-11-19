<div id="main-menu" class="ui {{ @SITE.MAIN_COLOR }} borderless blue inverted secondary menu">
  <div class="ui container">
    <a class="{{ @PATH=='/markets' ? 'active' : '' }} item" href="{{ @BASE }}/markets"><i class="line chart icon"></i>{{ @website.menu.markets }}</a>
    <a class="{{ @PATH=='/trade' ? 'active' : '' }} item" href="{{ @BASE }}/trade"><i class="money icon"></i>{{ @website.menu.trade }}</a>
    <a class="{{ @PATH=='/portfolio' ? 'active' : '' }} item" href="{{ @BASE }}/portfolio"><i class="travel icon"></i>{{ @website.menu.portfolio }}</a>
    <a class="{{ @PATH=='/offers' ? 'active' : '' }} item" href="{{ @BASE }}/offers"><i class="bell icon"></i>{{ @website.menu.offers }}</a>
    <?php /*
    <a class="{{ @PATH=='/transactions' ? 'active' : '' }} item" href="{{ @BASE }}/transactions">
        <i class="exchange icon"></i>
        {{ @website.menu.transactions }}
        <check if="{{ @USER.is_admin }}">
            <div class="ui red circular label unprocessed-depot-count">
                {{ @SESSION.unprocessedDepotCount }}
            </div>
        </check>
    </a>
    <a class="{{ @PATH=='/signals' ? 'active' : '' }} item" href="{{ @BASE }}/signals"><i class="bell icon"></i>{{ @website.menu.signals }}</a>
    <a class="{{ @PATH=='/cryptopayments' ? 'active' : '' }} item" href="{{ @BASE }}/cryptopayments"><i class="bitcoin icon"></i>{{ @website.menu.cryptopay }}</a>
    */ ?>
            <div class="right menu">
              <div class="ui inline top right secondary dropdown">
                <div class="item">
                 <div class="ui sub header">
                  <div class="ui large celled list">
                 <div class="ui left labeled button" tabindex="0">
                      <span class="ui basic label">
                        {{ @USER.first_name }} {{ @USER.last_name }}
                      </span>
                      <div class="ui icon button">
                        <i class="angle double down icon"></i>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="menu">
            
            <div class="avatar-image">
          <check if="{{ @USER.avatar }}">
            <true>
              <center><img class="ui small bordered image" src="{{ @BASE }}/files/avatars/{{ @USER.avatar }}"></center>
            </true>
            <false>
              <center><img class="ui small bordered image" src="{{ @BASE }}/assets/images/default_avatar.png"></center>
            </false>
          </check>
        </div>

          <check if="{{ @ADMIN.GENERATE_ACCOUNT_NUMBER && @USER.account_number }}">
            <div class="header">
                <div class="ui buttons">
                  <button class="ui {{ @SITE.MAIN_COLOR }} button">{{ @profile.account_number.title }}</button>
                  <button class="ui grey button">{{ @USER.account_number }}</button>
                </div>
            </div>
          </check>

          <check if="{{ @ADMIN.GENERATE_ACCOUNT_NUMBER && @USER.account_number }}">
            <div class="header">
                <div class="ui labeled button" tabindex="0">
                  <div class="ui {{ @SITE.MAIN_COLOR }} button">
                    {{ @portfolio.trades.balance }}
                  </div>
                  <a class="ui basic {{ @SITE.MAIN_COLOR }} left pointing label">
                    {{ Helper::formatNumber(@USER.balance,2) }} {{ @USER.currency }}
                  </a>
                </div>
            </div>
          </check>
          <a class="item" href="{{ @BASE }}/profile">
            <i class="user icon"></i>{{ @website.menu.profile }}
          </a>
          <check if="{{ @SUBSCRIPTION.SUBSCRIPTION_ENABLED && !@USER.is_admin }}">
            <a class="item" href="{{ @BASE }}/subscribe">
              <i class="payment icon"></i>{{ @website.menu.subscription }}
            </a>
          </check>
          <check if="{{ @CREDITS.ENABLED }}">
            <a class="item" href="{{ @BASE }}/credits">
              <i class="shop icon"></i>{{ @website.menu.credits }}
            </a>
          </check>
          <check if="{{ @REFERRALS.ENABLED }}">
            <a class="item" href="{{ @BASE }}/invite">
              <i class="send outline icon"></i>{{ @website.menu.invite }}
            </a>
          </check>
          <check if="{{ @USER.is_admin }}">
            <a class="item" href="{{ @BASE }}/admin/settings">
              <i class="settings icon"></i>{{ @website.menu.settings }}
            </a>
            <a class="item" href="{{ @BASE }}/admin/users">
              <i class="users icon"></i>{{ @website.menu.users }}
            </a>
          </check>
          <a class="item" href="{{ @BASE }}/password-update">
            <i class="key icon"></i>{{ @website.menu.password }}
          </a>
          <a class="item" href="{{ @BASE }}/logout">
            <i class="sign out icon"></i>{{ @website.menu.logout }}
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
