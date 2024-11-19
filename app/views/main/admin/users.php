<div class="ui container">
  <div class="ui stackable one column grid">
    <include if="{{ @ADSENSE.CLIENT_ID && @ADSENSE.SLOT_ID }}" href="{{ @tpl.adsense }}" />
    <div class="column">
    <div class="ui piled segment">
      <span class="ui {{ @SITE.MAIN_COLOR }} ribbon label"><i class="users icon"></i> {{ @title.users }}
      </span>
      </div>
      
    </div>
    <div class="right aligned column">
      <button id="add-user" class="ui right labeled icon button"><i class="users icon"></i> {{ @users.add.title }}</button>
      <div id="modal-add-user" class="ui small modal">
        <i class="close icon"></i>
        <div class="header">
          {{ @users.add.title }}
        </div>
        <div class="content">
          <form id="form-add-user" class="ui skip-submission-check form">
            <div class="ui error message"></div>
            <div class="ui result message"></div>
            <div class="field">
              <div class="ui left icon input">
                <i class="user icon"></i>
                <input type="text" name="first_name" placeholder="{{ @signup.form.first.name.placeholder }}">
              </div>
            </div>
            <div class="field">
              <div class="ui left icon input">
                <i class="user icon"></i>
                <input type="text" name="last_name" placeholder="{{ @signup.form.last.name.placeholder }}">
              </div>
            </div>
            <div class="field">
              <div class="ui left icon input">
                <i class="mail icon"></i>
                <input type="text" name="email" placeholder="{{ @signup.form.email.placeholder }}">
              </div>
            </div>
            <div class="field">
              <div class="ui left icon input">
                <i class="phone icon"></i>
                <input type="text" name="phone" placeholder="{{ @signup.form.phone.placeholder }}">
              </div>
            </div>
            <div class="field">
              <div class="ui left icon input">
                <i class="fax icon"></i>
                <input type="text" name="fax" value="" placeholder="{{ @signup.form.fax.placeholder }}">
              </div>
            </div>
            <div class="two fields">
                <div class="field">
                  <div class="ui left icon input">
                    <i class="envelope icon"></i>
                    <input type="text" name="street_nr" placeholder="{{ @signup.form.street_nr.placeholder }}">
                  </div>
                </div>
                <div class="field">
                  <div class="ui left icon input">
                    <i class="envelope icon"></i>
                    <input type="text" name="post_nr" placeholder="{{ @signup.form.post_nr.placeholder }}">
                  </div>
                </div>
            </div>
            <div class="field">
              <div class="ui left icon input">
                <i class="envelope icon"></i>
                <input type="text" name="town" placeholder="{{ @signup.form.town.placeholder }}">
              </div>
            </div>
            <div class="field">
              <div class="ui left icon right labeled input">
                <i class="euro icon"></i>
                <input type="text" name="balance" placeholder="{{ @users.add.balance.placeholder }}">
                <div class="ui label">{{ @TRADE.ACCOUNT_CURRENCY }}</div>
              </div>
            </div>
            <check if="{{ @ADMIN.GENERATE_ACCOUNT_NUMBER }}">
              <div class="field">
                <div class="ui left icon input">
                  <i class="folder outline icon"></i>
                  <input type="text" name="account_number" placeholder="{{ @users.add.account.placeholder }}">
                </div>
              </div>
            </check>
            <div class="field">
              <div class="ui checkbox">
                <input type="checkbox" tabindex="0" class="hidden" name="admin">
                <label>{{ @users.add.is_admin }}</label>
              </div>
            </div>
            <div class="field">
              <div class="ui checkbox">
                <input type="checkbox" tabindex="0" class="hidden" name="g2fa_enabled">
                <label>{{ @users.security.gtfa.title }}</label>
              </div>
            </div>
            <div class="field">
              <div class="ui checkbox">
                <input type="checkbox" tabindex="0" class="hidden" name="welcome_email">
                <label>{{ @users.add.notification }}</label>
              </div>
            </div>
            <div class="ui large {{ @SITE.MAIN_COLOR }} submit button">{{ @users.add.submit }}</div>
          </form>
        </div>
      </div>
      <div id="modal-edit-user" class="ui small action modal">
        <i class="close icon"></i>
        <div class="header">
          {{ @users.edit.title }}
        </div>
        <div class="content">
            <div id="account-details-menu" class="ui pointing {{ @SITE.BACKGROUND=='black'?'inverted':'' }} {{ @SITE.MAIN_COLOR }} menu">
                <a class="active item" data-tab="tab-details">{{ @users.tab.details }}</a>
                <a class="item" data-tab="tab-identity">{{ @users.tab.identify.notes }}</a>
            </div>
            <div id="tab-details" class="ui active tab" data-tab="tab-details">
              <form class="ui skip-submission-check form" data-action="edit">
                <div class="ui error message"></div>
                <div class="ui result message"></div>
                <input type="hidden" name="id" value="">
                <div class="field">
                  <div class="ui left icon input">
                    <i class="user icon"></i>
                    <input type="text" name="first_name" value="">
                  </div>
                </div>
                <div class="field">
                  <div class="ui left icon input">
                    <i class="user icon"></i>
                    <input type="text" name="last_name" value="">
                  </div>
                </div>
                <div class="field">
                  <div class="ui left icon input">
                    <i class="mail icon"></i>
                    <input type="email" name="email" value="">
                  </div>
                </div>
                <div class="field">
                  <div class="ui left icon input">
                    <i class="mobile alternate icon"></i>
                    <input type="text" name="phone" value="" placeholder="{{ @signup.form.phone.placeholder }}">
                  </div>
                </div>
                <div class="field">
                  <div class="ui left icon input">
                    <i class="phone icon"></i>
                    <input type="text" name="land_phone" value="" placeholder="{{ @signup.form.land_phone.placeholder }}">
                  </div>
                </div>
                <div class="field">
                  <div class="ui left icon input">
                    <i class="fax icon"></i>
                    <input type="text" name="fax" value="" placeholder="{{ @signup.form.fax.placeholder }}">
                  </div>
                </div>
                <div class="two fields">
                    <div class="field">
                      <div class="ui left icon input">
                        <i class="envelope icon"></i>
                        <input type="text" name="street_nr" placeholder="{{ @signup.form.street_nr.placeholder }}">
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui left icon input">
                        <i class="envelope icon"></i>
                        <input type="text" name="post_nr" placeholder="{{ @signup.form.post_nr.placeholder }}">
                      </div>
                    </div>
                </div>
                <div class="field">
                  <div class="ui left icon input">
                    <i class="envelope icon"></i>
                    <input type="text" name="town" placeholder="{{ @signup.form.town.placeholder }}">
                  </div>
                </div>
                <div class="field">
                  <div class="ui left icon input">
                    <i class="key icon"></i>
                    <input type="password" name="password" placeholder="{{ @users.edit.password.placeholder }}">
                  </div>
                </div>
                <div class="field">
                  <div class="ui checkbox blocked">
                    <input type="checkbox" tabindex="0" class="hidden" name="blocked" />
                    <label>{{ @users.edit.blocked.title }}</label>
                  </div>
                </div>
                <div class="field">
                  <div class="ui checkbox g2fa-enabled">
                    <input type="checkbox" tabindex="0" class="hidden" name="g2fa_enabled" />
                    <label>{{ @users.security.gtfa.title }}</label>
                  </div>
                </div>
                <div class="ui large {{ @SITE.MAIN_COLOR }} submit button">{{ @users.add.submit }}</div>
              </form>                
            </div>
            <div id="tab-identity" class="ui tab" data-tab="tab-identity">
                <div class="ui result message"></div>
                <div class="ui one column centered grid">
                    <form class="ui form identity-form row" data-action='approval'>
                        <div class="ui column identity-document center aligned">
                            <div class="column">
                                <a href="" title=""><img src="" width="400"></a>
                            </div>
                        </div>
                        <div class="ui column approval-buttons">
                            <div class="ui approve-button {{ @SITE.MAIN_COLOR }} right floated primary button" data-id="" data-status="valid">{{ @profile.identity.approve }}</div>
                            <div class="ui update-request-button {{ @SITE.MAIN_COLOR }} left floated orange button" data-id="" data-status="renew">{{ @profile.identity.request_update }}</div>
                        </div>
                        <div class="row approved-text">
                            <div class="column">{{ @profile.identity.approved }} <i class="check green icon"></i></div>
                        </div>
                    </form>
                    <div class="ui document-not-found centered column">
                        <div>
                            <h2><center>{{ @profile.identity.waiting_upload }}</center></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div id="modal-add-remove-funds" class="ui small action modal">
        <i class="close icon"></i>
        <div class="header">
          {{ @users.funds.title }}
        </div>
        <div class="content">
          <form class="ui skip-submission-check form" data-action="funds">
            <div class="ui error message"></div>
            <div class="ui result message"></div>
            <input type="hidden" name="id" value="">
            <div class="field">
              <div class="ui left icon right labeled input">
                <i class="euro icon"></i>
                <input type="text" name="amount" placeholder="0.00">
                <div class="ui label"></div>
              </div>
            </div>
            <div class="ui large {{ @SITE.MAIN_COLOR }} submit button">{{ @users.funds.submit }}</div>
          </form>
        </div>
      </div>
      <div id="modal-delete-user" class="ui small action modal">
        <i class="close icon"></i>
        <div class="header">
          {{ @users.delete.title }}
        </div>
        <div class="content">
          <p>{{ @users.delete.message }}</p>
          <form class="ui skip-submission-check form" data-action="delete">
            <div class="ui error message"></div>
            <div class="ui result message"></div>
            <input type="hidden" name="id" value="">
            <div class="ui large {{ @SITE.MAIN_COLOR }} submit button">{{ @users.delete.submit }}</div>
          </form>
        </div>
      </div>
    </div>
    <div class="column">
      <table id="users-list" class="ui selectable basic data table">
        <thead>
        <tr>
          <th></th>
          <th>{{ @users.list.name }}</th>
          <th>{{ @users.list.email }}</th>
          <th class="right aligned">{{ @users.list.balance }}</th>
          <th class="right aligned">{{ @users.list.trades_count }}</th>
          <th>{{ @users.list.created }}</th>
          <th>{{ @users.list.last_login }}</th>
          <th>{{ @users.list.ip }}</th>
        </tr>
        </thead>
        <tbody>
          <repeat group="{{ @vars.users }}" value="{{ @user }}">
            <tr class="{{ @user.blocked ? 'negative' : '' }}">
              <td class="users-actions">
                <div class="button-container">
                  <button class="ui basic circular icon edit-user button" data-id="{{ @user.id }}" data-first-name="{{ @user.first_name }}" data-last-name="{{ @user.last_name }}" data-email="{{ @user.email }}" data-phone="{{ @user.phone }}" data-land-phone="{{ @user.land_phone }}" data-fax="{{ @user.fax }}" data-streetnr="{{ @user.street_nr }}" data-postnr="{{ @user.post_nr }}" data-town="{{ @user.town }}" data-g2fa-enabled="{{ @user.g2fa_enabled }}" data-blocked="{{ @user.blocked }}" data-identity="{{ @user.identity_img }}" data-status="{{ @user.approved }}"><i class="pencil icon"></i></button>
                </div>
                <div class="button-container">
                  <button class="ui basic circular icon add-remove-funds button" data-id="{{ @user.id }}" data-balance="{{ intval(@user.balance) }}" data-currency="{{ @user.currency }}"><i class="money icon"></i></button>
                </div>
                <div class="button-container">
                  <button class="ui basic circular icon delete-user button" data-id="{{ @user.id }}"><i class="trash icon"></i></button>
                </div>
              </td>
              <td class="user-name" data-order="{{ @user.first_name.' '.@user.last_name }}">
                <div><img class="ui avatar image" src="{{ @user.avatar ? @BASE.'/files/avatars/'.@user.avatar : @BASE.'/assets/images/default_avatar.png' }}">
                    <b class="export-user-name">{{ @user.first_name.' '.@user.last_name }}</b>
                    <switch expr="{{ @user.approved }}">
                        <case value="{{ 0 }}" break="{{ TRUE }}">
                            &nbsp; <i class="exclamation circle icon" title="{{ @profile.identity.napproved_label }}"></i>
                        </case>
                        <case value="{{ 1 }}" break="{{ TRUE }}">
                            &nbsp; <i class="exclamation circle orange icon" title="{{ @profile.identity.awaiting_label }}"></i>
                        </case>
                        <case value="{{ 2 }}" break="{{ TRUE }}">
                            &nbsp; <i class="check circle green icon" title="{{ @profile.identity.approved_label }}"></i>
                        </case>
                    </switch>
                    <check if="{{ @user.is_admin }}">
                        <span class="ui small red label">{{ @users.list.admin }}</span>
                    </check>
                  
                </div>
                <div class="ui divider"></div>
                <div>
                  <i class="grey hashtag icon"></i>&nbsp; {{ @user.account_number ? @user.account_number : @users.list.empty.value }}
                </div>
                <div>
                  <i class="grey mobile alternate icon"></i>&nbsp; {{ @user.phone ? @user.phone : @users.list.empty.value }}
                </div>
                <div>
                  <i class="grey language icon"></i>&nbsp; {{ @user.language ? @user.language : @users.list.empty.value }}
                </div>
                <div>
                  <i class="grey world half icon"></i>&nbsp; {{ @user.timezone ? @user.timezone : @users.list.empty.value }}
                </div>
                <check if="{{ @SUBSCRIPTION.SUBSCRIPTION_ENABLED }}">
                  <div>
                    <i class="grey paypal icon"></i>&nbsp; {{ @users.list.subscription_paid_until }} {{ @user.subscription_paid_until }}
                  </div>
                </check>
              </td>
              <td><a href="mailto:{{ @user.email }}">{{ @user.email }}</a></td>
              <td data-order="{{ @user.balance,2 }}" class="right aligned">{{ Helper::formatNumber(@user.balance,2).' '.@user.currency }}</td>
              <td data-order="{{ @user.trades_count }}" class="right aligned">{{ Helper::formatNumber(@user.trades_count) }}</td>
              <td data-order="{{ strtotime(@user.created) }}">{{ @user.created }}</td>
              <td data-order="{{ strtotime(@user.last_login) }}">{{ @user.last_login }}</td>
              <td>{{ @user.ip }}</td>
            </tr>
          </repeat>
        </tbody>
      </table>
    </div>
  </div>
</div>